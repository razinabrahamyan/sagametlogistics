<?php

namespace App\Services\Contracts;

interface DriversServiceContract
{
    public function update($request);

    public function store($request);

    public function getAllDrivers();

    public function getOneDriver($id);
}