<?php

namespace App\Classes\Convertors;

use App\Classes\Convertors\Drivers\DriverInterface;

interface ConvertFileInterface
{
    public function convertFile();
}