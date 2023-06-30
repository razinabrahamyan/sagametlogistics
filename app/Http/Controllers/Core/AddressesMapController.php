<?php

namespace App\Http\Controllers\Core;

use App\Classes\ChatApi\Api;
use App\Classes\Constants\WhatsAppConstants;
use App\Http\Controllers\Controller;
use App\Models\Query;
use App\Services\AddressesMapService;
use Carbon\Carbon;

class AddressesMapController extends Controller
{
    public function index()
    {
        return (new AddressesMapService())->index();
    }

    public function filterAddressesMaps()
    {
        return (new AddressesMapService())->filterAddressesMaps(request());
    }

    public function sendAddressToWA()
    {
        return (new AddressesMapService())->sendAddressToWA(request());
    }
}
