<?php

namespace App\Classes\CronTab;

use App\Classes\FortMonitor\FortMonitorHelpers;
use App\Classes\Mail\PersonalAlerts;
use App\Models\Driver;

class CronHandler
{
    /**
     * @return array
     */
    public static function checkNewDriversFromFortMonitor(): array
    {
        $all = $result = [];
        $curDrivers = Driver::all('car_numbers')->pluck('car_numbers')->toArray();
        $cartFromFort = FortMonitorHelpers::getCarsInfo();

        foreach ($cartFromFort as $car) {
            foreach ($curDrivers as $driver) {
                preg_match('/' . explode(' ', $car["name"])[1] . '/', $driver, $matches);
                if (!empty($matches)) {
                    $all[] = $car["name"];
                }
            }
        }

        foreach (collect($cartFromFort)->pluck('name')->toArray() as $a) {
            if (!in_array($a, $all)) {
                $result[] = $a;
            }
        }

        if (!empty($result)) {
            PersonalAlerts::alertEduard('Новые водители для Логистики', implode(', ', $result));
        }

        return $result;
    }
}