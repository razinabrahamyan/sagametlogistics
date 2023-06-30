<?php

namespace App\Services\Contracts;

interface AddressesMapServiceContract
{
    public function index();

    public function filterAddressesMaps($request);

    public function sendAddressToWA($request);
}