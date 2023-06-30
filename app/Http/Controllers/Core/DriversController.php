<?php

namespace App\Http\Controllers\Core;

use App\Classes\ControllersHandlers\Drivers\DriverHandler;
use App\Classes\FortMonitor\FortMonitorHelpers;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Machine;
use App\Services\DriversService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class DriversController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('content.pages.drivers_list', [
            "drivers" => (new DriversService())->getAllDrivers(),
        ]);
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        return view('content.pages.driver_edit', [
            "driver" => Driver::with('machineType')
                              ->find($id),
            "machines" => Machine::all(),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        return redirect()->back()->with((new DriversService())->update($request));
    }

    public function create(Request $request)
    {
        return view('content.pages.driver_create', [
            "machines" => Machine::all(),
        ]);
    }

    public function store(Request $request)
    {
        (new DriversService())->store($request);
        return redirect()->route('drivers');
    }

    public function destroy(Request $request)
    {
        Driver::find($request->id)->delete();
        return [
            'alertMessage' => "Водитель удален",
        ];
    }

    /**
     * @return string
     */
    public function getPoints(): string
    {
        return json_encode(FortMonitorHelpers::getCarsInfo());
    }
}
