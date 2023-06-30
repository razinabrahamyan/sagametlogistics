<?php

namespace App\Services\Contracts;

interface RecoveryQueryLazyLoadServiceContract
{
    public function prepareTableParams($request);

    public function prepareQueries();

    public function initLazyLoad();

    public function recover($request);
}