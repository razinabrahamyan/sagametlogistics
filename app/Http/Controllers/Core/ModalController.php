<?php

namespace App\Http\Controllers\Core;

use App\Classes\ControllersHandlers\Modals\ModalsContent;
use App\Http\Controllers\Controller;
use App\Services\ModalsService;
use Illuminate\Http\Request;

class ModalController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function queryModalContent(Request $request) : string
    {
        return view('content.modals.elements.queryInfo.modal_content')
            ->with(ModalsService::prepareQueryParams($request->queryId))
            ->render();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function queryMapModalContent(Request $request) : string
    {
        return view('content.modals.elements.queryMap.modal_content')
            ->with(ModalsService::prepareQueryMapParams($request->queryId, $request->mapId))
            ->render();
    }
}

