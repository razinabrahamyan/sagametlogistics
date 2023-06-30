<?php

namespace App\Services;

use App\Classes\Constants\RolesConstants;
use App\Models\Query;
use App\Services\Contracts\StatisticServiceContract;

class StatisticService implements StatisticServiceContract
{
    public function getAll()
    {
        $params = request()->all();
        $result = [
            'totals'     => [
                'totalCount'    => 0,
                'sent'          => 0,
                'deleted'       => 0,
                'metalAVGprice' => 0,
            ],
            'manager_id' => [],
        ];

        $metalAVGData = [
            'price' => 0,
            'count' => 0,
        ];

        //Даннные фильтра
        $startDate = !empty($params['start_date']) ? date('Y-m-d', strtotime($params['start_date'])) : null;
        $endDate = !empty($params['end_date']) ? date('Y-m-d', strtotime($params['end_date'] . "+1 day")) : date('Y-m-d', strtotime($params['start_date'] . "+1 day"));

        $managers = Query::with('manager')->withTrashed()
                         ->orWhereHas('manager', function ($query) use ($params) {
                             return $query->whereIn('role_id', [RolesConstants::MANAGER, RolesConstants::LOGIST])
                                          ->when($params['manager_ids'], function ($query) use ($params) {
                                              $query->whereIn('id', $params['manager_ids']);
                                          })
                                          ->whereNotIn('id', [3, 36, 37]);
                         })
                         ->when(!empty($startDate), function ($query) use ($startDate, $endDate) {
                             $query->whereBetween('created_at', [$startDate, $endDate]);
                         })
                         ->when($params['metal_type'], function ($query) use ($params) {
                             $query->where('type_of_metal', $params['metal_type']);
                         })
                         ->get()->groupBy('manager.id');

        if (!empty($managers)) {
            foreach ($managers as $manager) {
                $managerId = $manager->first()->manager->id ?? 0;
                $managerName = $manager->first()->manager->name ?? 0;

                //Количество заявок
                $count = $manager->count();
                //Количество отправленных заявок
                $sent = $manager->where('status', 2)->count();
                //Количество удаленных заявок
                $deleted = $manager->whereNotNull('deleted_at')->count();
                //Количество заявок с постоянными клиентами
                $regularClients = $manager->where('regular_client', 1)->count();

                //Не удлаенные завяки + начиная с определенной даты
                $queriesFilteredByCustomDate = $manager->whereNull('deleted_at')->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('04.05.2022')));
                //Находим среднее значение цены
                $metalAVGPrice = floor($queriesFilteredByCustomDate->avg('price'));
                //Минимальный предполагаемый вес
                $weightFrom = floor($queriesFilteredByCustomDate->sum('weight_from'));
                //Максимальный предполагаемый вес
                $weightTo = floor($queriesFilteredByCustomDate->sum('weight_to'));

                //Запись общей статистики
                $result['totals']['totalCount'] += $count;
                $result['totals']['sent'] += $sent;
                $result['totals']['deleted'] += $deleted;

                if ($metalAVGPrice > 0) {
                    $metalAVGData['price'] += $metalAVGPrice;
                    $metalAVGData['count']++;
                }

                //Запись статистики относительно менеджера
                if (empty($result['managers'][$managerId])) {
                    $result['managers'][$managerId]['manager_name'] = $managerName;
                    $result['managers'][$managerId]['created_queries'] = $count;
                    $result['managers'][$managerId]['sent_queries'] = $sent;
                    $result['managers'][$managerId]['deleted_queries'] = $deleted;
                    $result['managers'][$managerId]['regular_clients_queries'] = $regularClients;
                    $result['managers'][$managerId]['metal_avg_price'] = $metalAVGPrice;
                    $result['managers'][$managerId]['weight_from'] = $weightFrom;
                    $result['managers'][$managerId]['weight_to'] = $weightTo;
                }
            }
        }

        //Запись общей статистики средней цены металла
        if ($metalAVGData['price'] && $metalAVGData['count']) {
            $result['totals']['metalAVGprice'] = floor($metalAVGData['price'] / $metalAVGData['count']);
        }

        return $result;
    }
}