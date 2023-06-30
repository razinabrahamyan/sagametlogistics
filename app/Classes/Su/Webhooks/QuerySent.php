<?php

namespace App\Classes\Su\Webhooks;

use App\Classes\Constants\StatusesConstants;
use App\Classes\Mail\PersonalAlerts;
use App\Models\Driver;
use App\Models\Machine;
use App\Models\Query;
use App\Models\QuerySendedMachines;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PHPMailer\PHPMailer\Exception;

class QuerySent
{
    const SOURCE = 'https://m1-su.ru/api/save-query';
    const API_KEY = '$2a$12$euZt82F86CvDfunkCiReluLBhSa5KKO5BeZVp1mpEN0Sgj.rXdmEu';

    public function queryDriversData($queryId)
    {
        try {
            $query = Query::findOrFail($queryId);

            if ($query->status == StatusesConstants::SENDED) {
                if (!empty($query->driversData)) {
                    $driversData = $query->driversData->drivers_data;
                } else {
                    $machinesTypes = Machine::all();
                    foreach ($machinesTypes as $machinesType) {
                        $type = $machinesType["title_en"];

                        $queryMachines = collect($query->machines)->toArray();

                        $machinesDrivers[$type] = [
                            "count" => $queryMachines[$type]->count ?? 0,
                            "drivers" => $queryMachines[$type]->drivers ?? [],
                        ];

                        //Формируем массив с данными водителей
                        foreach ($machinesDrivers[$type]['drivers'] as $driver) {
                            $driverData = Driver::find($driver);
                            if ($driverData) {
                                $driversChangedData = $query->driversData ?? [];
                                $driversFullData[] = [
                                    'driver_id' => $driverData->id,
                                    'driver_name' => ($driversChangedData[$driver]['name']) ?? $driverData->full_name,
                                    'phone' => ($driversChangedData[$driver]['phone']) ?? $driverData->phone,
                                    'car_number' => $driverData->car_numbers,
                                    'type' => $machinesType["title"],
                                ];
                            }
                        }
                    }

                    $driversData = $driversFullData ?? [];
                }

                if (!empty($driversData)) {
                    $data = [
                        'json' => [
                            'magic' => self::API_KEY,
                            'query_id' => $queryId,
                            'drivers_data' => $driversData,
                            'loaders' => $query->loaders_count,
                            'oxygen' => $query->oxygen_count,
                            'cutters' => $query->cutters_count,
                            'departure_data' => $query->departure_date,
                            'status' => (!empty($query->driversData) && !empty($query->driversData->su_status)) ? $query->driversData->su_status : 1,
                        ]
                    ];

                    try {
                        $sendToSu = $this->request($data, 'POST');
                        if (!empty($sendToSu) && !empty($sendToSu->status) && $sendToSu->status == 200) {
                            $querySendedMachines = QuerySendedMachines::where('query_id', $queryId)->first();
                            if (!empty($querySendedMachines)) {
                                $querySendedMachines->update([
                                    'su_status' => 2,
                                    'updated_at' => now(),
                                ]);
                            }
                        }

                        return $sendToSu->status ?? 500;
                    } catch (Exception $exception) {
                        PersonalAlerts::alertArtur('SU exception - Ошибка отправки', $exception->getMessage());
                    }
                } else {
                    return 500;
                }
            }
        } catch (Exception $exception) {
            PersonalAlerts::alertArtur('SU exception - Не нашли заявку', $exception->getMessage());
            return 500;
        }

        return 500;
    }

    public function request($params, string $requestMethod = 'GET')
    {
        $response = "";
        try {
            $result = (new Client())->request($requestMethod, self::SOURCE, ($requestMethod === 'GET') ? ['query' => $params] : $params);
            $response = $result->getBody()->getContents();
        } catch (GuzzleException $e) {
            $e->getMessage();
        }

        return json_decode($response);
    }
}