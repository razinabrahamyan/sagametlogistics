<?php

namespace App\Services;

use App\Classes\ChatApi\Api;
use App\Classes\Constants\WhatsAppConstants;
use App\Models\Query;
use App\Services\Contracts\AddressesMapServiceContract;
use Carbon\Carbon;

class AddressesMapService implements AddressesMapServiceContract
{
    public function index()
    {
        return view('content.pages.addresses_map');
    }

    public function filterAddressesMaps($request)
    {
        $sentArddessesQuery = Query::query();
        if (!empty($request->get('fast_date_filter'))) {
            if ($request->get('fast_date_filter') == 'today') {
                $sentArddessesQuery->where('departure_date', '>=', Carbon::today());
                $sentArddessesQuery->where('departure_date', '<=', Carbon::tomorrow());
            } elseif ($request->get('fast_date_filter') == 'tomorrow') {
                $sentArddessesQuery->where('departure_date', '>=', Carbon::tomorrow());
                $sentArddessesQuery->where('departure_date', '<=', Carbon::tomorrow()->addDay());
            }
        }
        $result = $sentArddessesQuery->get();

        return [
            'sentAddresses' => $result
        ];
    }

    public function sendAddressToWA($request)
    {
        $alertMessage = 'Не удалось отправить сообщение';
        if (!empty($request->address)) {
            $message = '' . $request->address;
            foreach (WhatsAppConstants::ADDRESS_MAP_PHONES as $phone) {
                (new Api())->setBody($request->address)
                           ->setPhone($phone)
                           ->sendMessage();
            }

            $alertMessage = 'Сообщение отправлено';
        }

        return [
            'alertMessage' => $alertMessage,
        ];
    }
}