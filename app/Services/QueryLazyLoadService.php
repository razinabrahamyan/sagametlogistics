<?php

namespace App\Services;

use App\Classes\Constants\StatusesConstants;
use App\Models\Machine;
use App\Models\Query;
use App\Services\Contracts\QueryLazyLoadServiceContract;
use Carbon\Carbon;

class QueryLazyLoadService implements QueryLazyLoadServiceContract
{
    private $params;
    private $preparedQueries;
    private $totalRecord = 0;
    private $machines;

    /**
     * @param $request
     * @return $this
     */
    public function prepareTableParams($request)
    {
        $order = $request->query('order', [0, 'desc']);
        $sortColumns = [
            0 => "id",
            1 => "machines_title",
//            2 => "status",
            2 => "departure_date",
            3 => "weight",
            5 => "user_id",
        ];

        $sortValue = $sortColumns[$order[0]['column']];
        $sortDirection = $order[0]['dir'];

        $this->params = collect([
            "search" => $request->query('search', ['value' => '', 'regex' => false]),
            "draw" => $request->query('draw', 0),
            "start" => $request->query('start', 0),
            "length" => $request->query('length', 25),
            "order" => $request->query('order', [0, 'desc']),
            "startDate" => $request->post('start_date'),
            "endDate" => $request->post('end_date'),
            "sortValue" => $sortValue,
            "sortDirection" => $sortDirection,
            "fastDateFilter" => $request->post('fast_date_filter'),
            "sentQueries" => $request->post('sent_queries'),
        ]);

        return $this;
    }

    /**
     * @return $this
     */
    public function prepareQueries()
    {
        $tableParams = $this->getParams();
        $queries = Query::with(['manager', 'currentStatus'])->whereHas('manager');

        //Ограничения просмотра заявок
        if (in_array(auth()->id(), [36])) {
            $queries->where('user_id', auth()->id());
        }

        if ($tableParams->get('sentQueries')) {
            $queries->whereIn('status', [StatusesConstants::SENDED]);
        } else {
            $queries->whereNotIn('status', [StatusesConstants::SENDED]);
        }
        $this->setMachines(Machine::all());

        if (!empty($tableParams->get('fastDateFilter'))) {
            if ($tableParams->get('fastDateFilter') == 'today') {
                $queries->where('departure_date', '>=', Carbon::today());
                $queries->where('departure_date', '<=', Carbon::tomorrow());
            } elseif ($tableParams->get('fastDateFilter') == 'tomorrow') {
                $queries->where('departure_date', '>=', Carbon::tomorrow());
                $queries->where('departure_date', '<=', Carbon::tomorrow()->addDay());
            }
        }

//        if (!in_array(AuthorizedUser::getRoleId(), [RolesConstants::ADMIN, RolesConstants::LOGIST])) {
//            $queries->where('user_id', AuthorizedUser::getUserId());
//        }

        if (!empty($tableParams->get("startDate")) && !empty($tableParams->get("endDate"))) {
            $queries->whereBetween('created_at', [
                Carbon::createFromTimestamp(strtotime($tableParams->get("startDate"))),
                Carbon::createFromTimestamp(strtotime($tableParams->get("endDate")) + 3600 * 24) //Делаем + 24 часа
            ]);
        }

        $filter = trim($tableParams->get("search")['value']);
        $queries->when($filter, function ($queries, $filter) {
            $queries->where(function ($queries) use ($filter) {
                $queries->orWhereHas('currentStatus', function ($queries) use ($filter) {
                    return $queries->where('title', 'like', "%$filter%");
                })
                        ->orWhereHas('manager', function ($queries) use ($filter) {
                            return $queries->where('name', 'like', "%$filter%");
                        })
                        ->orWhere('weight', 'like', "%$filter%")
                        ->orWhere('machines_title', 'like', "%$filter%")
                        ->orWhere('address', 'like', "%$filter%");
            });
        });

        $this->setTotalRecord($queries->count());

        $queries->orderBy($tableParams->get("sortValue"), $tableParams->get("sortDirection"))
                ->take($tableParams->get("length"))
                ->skip($tableParams->get("start"));

        $this->setPreparedQueries($queries->get());
        return $this;
    }

    /**
     * @return array
     */
    public function initLazyLoad(): array
    {
        $preparedQueries = $this->getPreparedQueries();
        $tableParams = $this->getParams();

        $json = array(
            'draw' => $tableParams->get("draw"),
            'recordsTotal' => $this->getTotalRecord(),
            'recordsFiltered' => $this->getTotalRecord(),
            'data' => [],
        );

        foreach ($preparedQueries as $query) {
            $render = new TableComponentsRenderService($query);

            $json['data'][] = [
                "<div class='qt-a' data-id='$query->id'>$query->id</div>",
                implode("<br>", explode(',', $query->machines_title)),
//                $render->renderStatusController(),
                date('m-d H:i', strtotime($query->departure_date)),
                $query->weight_from . ($query->weight_to ? '-' . $query->weight_to : ''),
                "<span class='max-w-150'>" . $query->address . "</span>",
                $query->manager->name,
                $render->renderImages(),
                $render->renderAction(),
            ];
        }

        return $json;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return int
     */
    public function getTotalRecord(): int
    {
        return $this->totalRecord;
    }

    /**
     * @param int $totalRecord
     * @return QueryLazyLoadService
     */
    public function setTotalRecord(int $totalRecord): QueryLazyLoadService
    {
        $this->totalRecord = $totalRecord;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPreparedQueries()
    {
        return $this->preparedQueries;
    }

    /**
     * @param mixed $preparedQueries
     * @return QueryLazyLoadService
     */
    public function setPreparedQueries($preparedQueries)
    {
        $this->preparedQueries = $preparedQueries;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMachines()
    {
        return $this->machines;
    }

    /**
     * @param mixed $machines
     * @return QueryLazyLoadService
     */
    public function setMachines($machines)
    {
        $this->machines = $machines;
        return $this;
    }
}