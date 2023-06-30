<?php

namespace App\Http\Controllers\Core;

use App\Classes\ControllersHandlers\Statistics\StatisticsHandler;
use App\Http\Controllers\Controller;
use App\Models\MetalType;
use App\Models\Status;
use App\Models\User;
use App\Services\StatisticService;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('content.pages.statistics.statistic', [
            'managers' => User::withTrashed()->where('role_id', 3)->whereNotIn('id', [3, 36, 37])->get(),
            'metalTypes' => MetalType::all(),
        ]);
    }

    public function getStatus(Request $request)
    {
        return response()->json(Status::find($request->id));
    }

    public function getAll()
    {
        return (new StatisticService())->getAll();
    }
}
