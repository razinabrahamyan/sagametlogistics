<?php

namespace App\Http\Controllers\Core;

use App\Classes\Constants\RolesConstants;
use App\Http\Controllers\Controller;
use App\Models\ManagersPlan;
use App\Models\ManagersPlanCalendar;
use App\Models\Query;
use App\Models\User;
use Illuminate\Http\Request;

class ManagerPlanController extends Controller
{
    public function index()
    {
        return view('content.pages.statistics.managers.managersPlan', [
            'managers' => User::where('role_id', 3)->whereNotIn('id', [3, 36, 37])->get(),
        ]);
    }

    public function getManagersData()
    {
        $managers = [];
        $request = request()->all();
        $managersCalendar = ManagersPlanCalendar::where('plan_date', $request['year'] . '-' . $request['month'])->first() ?? [];

        if (!empty($managersCalendar)) {
            $betweenDate = [
                date('Y-m-d', strtotime($request['year'] . '-' . $request['month'])),
                date('Y-m-t', strtotime($request['year'] . '-' . ($request['month']))),
            ];

            foreach ($managersCalendar->managers_ids as $managerId) {
                $singleManager = Query::with('manager')->withTrashed()->where('user_id', $managerId)
                                      ->whereBetween('created_at', $betweenDate)->get();

                $managerName = $singleManager->first()->manager->name ?? 'Не найдено';

                if (!empty($singleManager)) {
                    //Количество заявок
                    $count = $singleManager->count();
                    //Количество отправленных заявок
                    $sent = $singleManager->where('status', 2)->count();
                    //Количество удаленных заявок
                    $deleted = $singleManager->whereNotNull('deleted_at')->count();
                    //Количество заявок с постоянными клиентами
                    $regularClients = $singleManager->where('regular_client', 1)->count();
                }

                //План менеджера
                $plan = ManagersPlan::where('managers_calendar_id', $managersCalendar->id)->where('manager_id', $managerId)->first();
                $allCallsPlanPercent = ($plan && ($plan->outgoing_calls_plan > 0 || $plan->incoming_calls_plan > 0)) ? floor(($plan->outgoing_calls + $plan->incoming_calls) / ($plan->outgoing_calls_plan + $plan->incoming_calls_plan) * 100) : 0;
                $outgoingCallsPlanPercent = ($plan && $plan->outgoing_calls_plan > 0) ? floor(($plan->outgoing_calls) / $plan->outgoing_calls_plan * 100) : 0;
                $incomingPlanPercent = ($plan && $plan->incoming_calls_plan > 0) ? floor(($plan->incoming_calls) / $plan->incoming_calls_plan * 100) : 0;

                $managers[$managerId] = [
                    'id'                   => $managerId,
                    'managers_calendar_id' => $managersCalendar->id,
                    'name'                 => $managerName,
                    'count'                => $count ?? 0,
                    'sent'                 => $sent ?? 0,
                    'deleted'              => $deleted ?? 0,
                    'regularClients'       => $regularClients ?? 0,
                    'plan'                 => [
                        'id'                          => $plan->id ?? null,
                        'all_calls_plan'              => $plan->all_calls_plan ?? 0,
                        'all_calls_plan_percent'      => $allCallsPlanPercent,
                        'outgoing_calls_plan'         => $plan->outgoing_calls_plan ?? 0,
                        'outgoing_calls_plan_percent' => $outgoingCallsPlanPercent,
                        'incoming_calls_plan'         => $plan->incoming_calls_plan ?? 0,
                        'incoming_calls_plan_percent' => $incomingPlanPercent,
                        'outgoing_calls'              => $plan->outgoing_calls ?? 0,
                        'incoming_calls'              => $plan->incoming_calls ?? 0,
                    ],
                ];
            }
        }

        return [
            'managers' => $managers,
        ];
    }

    public function saveManagerPlan()
    {
        $request = request()->all();

        $saveData = array_merge($request['plan'], $request);
        unset($saveData['plan']);

        ManagersPlan::updateOrCreate(['id' => $request['plan']['id']], $saveData);
    }
}
