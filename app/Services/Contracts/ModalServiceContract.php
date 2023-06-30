<?php

namespace App\Services\Contracts;

interface ModalServiceContract
{
    public static function prepareQueryMapParams($queryId, $mapId) : array;
    public static function prepareQueryParams($queryId) : array;
}