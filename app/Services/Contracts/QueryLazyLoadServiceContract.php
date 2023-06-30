<?php

namespace App\Services\Contracts;


use App\Services\QueryLazyLoadService;

interface QueryLazyLoadServiceContract
{
    public function prepareTableParams($request);

    public function prepareQueries();

    public function initLazyLoad(): array;

    public function getParams();

    public function getTotalRecord(): int;

    public function setTotalRecord(int $totalRecord): QueryLazyLoadService;

    public function getPreparedQueries();

    public function setPreparedQueries($preparedQueries);

    public function getMachines();

    public function setMachines($machines);
}