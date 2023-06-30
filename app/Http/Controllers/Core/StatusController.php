<?php

namespace App\Http\Controllers\Core;

use App\Classes\Constants\AlertMessages;
use App\Classes\ControllersHandlers\Statuses\QueryStatusHandler;
use App\Http\Controllers\Controller;
use App\Models\Query;
use App\Services\QueryStatusService;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function update(Request $request)
    {
        return (new QueryStatusService())->update($request);
    }
}
