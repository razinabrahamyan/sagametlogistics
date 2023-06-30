<?php

namespace App\Services;

use App\Classes\ChatApi\Api;
use App\Classes\Constants\AlertMessages;
use App\Classes\Constants\RolesConstants;
use App\Classes\Constants\StatusesConstants;
use App\Classes\Constants\WhatsAppConstants;
use App\Classes\Helpers\GF;
use App\Models\Driver;
use App\Models\User;
use App\Services\Contracts\DriversServiceContract;

class DriversService implements DriversServiceContract
{
    public function update($request)
    {
        try {
            $driver = Driver::find($request->get('id'));
            $driver->full_name = $request->get("full_name");
            $driver->phone = $request->get("phone");
            $driver->email = $request->get("email");
            $driver->car_numbers = $request->get("car_numbers");
            $driver->type_id = $request->get("type_id");
            $driver->save();
            $alertMessage = AlertMessages::DRIVER_INFO_CHANGE_SUCCESS;
        } catch (\Exception $e) {
            $alertMessage = $e->getMessage();
        }

        return [
            "alertMessage" => $alertMessage,
        ];
    }

    public function store($request)
    {
        try {
            $user = new User();
            $user->name = $request->get("full_name");
            $user->email = $request->get("email");
            $user->phone = GF::clearPhoneNumber($request->get("phone"));
            $user->password = bcrypt($request->get("password"));
            $user->role_id = RolesConstants::LOGISTIC_PERSONNEL;
            $user->save();

            $driver = new Driver();
            $driver->status = 7;
            $driver->full_name = $request->get("full_name");
            $driver->phone = GF::clearPhoneNumber($request->get("phone"));
            $driver->email = $request->get("email");
            $driver->car_numbers = $request->get("car_numbers");
            $driver->type_id = $request->get("type_id");
            $driver->user_id = $user->id;
            $driver->save();

            $message = "Водитель - " . $request->get("full_name") . "\n";
            $message .= "Почта - " . $request->get("email") . "\n";
            $message .= "Телефон - " . GF::clearPhoneNumber($request->get("phone")) . "\n";
            $message .= "Пароль - " . $request->get("password");

            foreach (WhatsAppConstants::NEW_DRIVER as $phone) {
                (new Api())->setBody($message)
                           ->setPhone($phone)
                           ->sendMessage();
            }

            $alertMessage = AlertMessages::DRIVER_STORE_SUCCESS;
        } catch (\Exception $e) {
            $alertMessage = $e->getMessage();
        }

        return [
            "alertMessage" => $alertMessage,
        ];
    }

    public function getAllDrivers()
    {
        return Driver::with('machineType')
                     ->get();
    }

    public function getOneDriver($id)
    {
        return Driver::with('machineType', 'allDrivers')
                     ->find($id);
    }
}