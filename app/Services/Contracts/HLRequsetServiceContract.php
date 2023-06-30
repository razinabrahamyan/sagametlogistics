<?php

namespace App\Services\Contracts;

interface HLRequsetServiceContract
{
    public function index();

    public function checkPhonesHLR($request);
}