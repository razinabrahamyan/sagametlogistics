<?php

namespace App\Services;

use App\Models\Driver;
use App\Models\Query;
use App\Models\QueryMap;
use App\Services\Contracts\ModalServiceContract;

class ModalsService implements ModalServiceContract
{
    /**
     * @param $queryId
     * @param $mapId
     * @return array
     */
    public static function prepareQueryMapParams($queryId, $mapId) : array
    {
        return [
            'queryCurrentMap'  => QueryMap::with('mapStatus')
                                          ->where('id', $mapId)
                                          ->first(),
            'queryPreviousMap' => QueryMap::with('mapStatus')
                                          ->where('id', '<', $mapId)
                                          ->where('query_id', $queryId)
                                          ->orderBy('id', 'DESC')
                                          ->first(),
        ];
    }

    /**
     * @param $queryId
     * @return array
     */
    public static function prepareQueryParams($queryId) : array
    {
        return [
            'query'       => Query::with(["currentStatus"])->find($queryId),
            'driversList' => Driver::with(["machineType"])->get()->keyBy('id'),
        ];
    }
}