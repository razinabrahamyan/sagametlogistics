<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\ManagersPlanCalendar;
use Illuminate\Http\Request;

class ManagersPlanCalendarController extends Controller
{
    public function updateCalendarSettings()
    {
        $request = request()->all();
        $dateFormatted = $request['year'] . '-' . $request['month'];

        ManagersPlanCalendar::updateOrCreate(
            ['plan_date' => $dateFormatted],
            ['plan_date' => $dateFormatted, 'managers_ids' => $request['managers']]
        );
    }

    public function getSettingsData()
    {
        $request = request()->all();
        $managers = ManagersPlanCalendar::where('plan_date', $request['year'] . '-' . $request['month'])->first()->managers_ids ?? [];
        return [
            'managers' => $managers,
        ];
    }
}
