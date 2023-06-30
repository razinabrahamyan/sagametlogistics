<?php

namespace App\Services\Contracts;

interface QueryStatusServiceContract
{
    public function update($request);

    public function updateQueryStatus($request);

    public function getQueryStatusAlertMessage();

    public function setQueryStatusAlertMessage($queryStatusAlertMessage);
}