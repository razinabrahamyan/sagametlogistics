<?php

namespace App\Http\Controllers\Core;

use App\Classes\ChatApi\Api as ChatApi;
use App\Classes\ChatApi\ChatInitQueryPreview;
use App\Classes\Constants\AlertMessages;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Query;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LogisticPersonnel extends Controller
{
    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function showQuery($id, $token)
    {
        $driversList = Driver::select('drivers.*', 'machines.title', 'machines.title_en')
                             ->join('machines', 'machines.id', '=', 'drivers.type_id')
                             ->get()
                             ->keyBy('id');

        $query = Query::find($id);

        if($query->access_token == $token){
            return view('content.pages.simple_preview', [
                'query'       => $query,
                'driversList' => $driversList,
            ]);
        }else{
            return abort(404);
        }
    }

    public function sendToWhatsApp(Request $request)
    {
        $query = Query::find($request->all()["queryId"]);
        $chatInit = (new ChatInitQueryPreview())->prepareData($query)
                                                ->run();

        return response()->json([
            "alertMessage" => $chatInit["alertMessage"],
        ]);
    }
}
