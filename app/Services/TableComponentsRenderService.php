<?php

namespace App\Services;

use App\Models\Driver;
use App\Models\Status;
use App\Services\Contracts\TableComponentsRenderServiceInterface;

class TableComponentsRenderService implements TableComponentsRenderServiceInterface
{
    private $query;

    /**
     * TableComponentsRenderService constructor.
     * @param $query
     */
    public function __construct($query)
    {
        $this->query = $query;
    }

    public function renderAction()
    {
        $driversList = Driver::select('drivers.*', 'machines.title', 'machines.title_en')
                             ->join('machines', 'machines.id', '=', 'drivers.type_id')
                             ->get()
                             ->keyBy('id');

        return view('content.query.dataTable.actions', [
            'query'       => $this->getQuery(),
            'driversList' => $driversList,
        ])->render();
    }

    public function renderStatusController()
    {
        return view('content.query.dataTable.query_status_controller', [
            'query'    => $this->getQuery(),
            'statuses' => Status::all(),
        ])->render();
    }

    public function renderImages()
    {
        return view('content.query.dataTable.query_row_images', [
            'query'    => $this->getQuery(),
            'statuses' => Status::all(),
        ])->render();
    }

    public function renderActionForDriver()
    {
        return view('content.query.dataTable.query_driver_actions', [
            'query'    => $this->getQuery(),
            'statuses' => Status::all(),
        ])->render();
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }
}