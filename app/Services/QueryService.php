<?php

namespace App\Services;

use App\Classes\Constants\AlertMessages;
use App\Classes\Constants\StatusesConstants as StatusesConstants;

use App\Classes\Pusher\Constants;
use App\Classes\Pusher\PusherHandler;
use App\Classes\Su\Webhooks\QuerySent;
use App\Models\Base;
use App\Models\Driver;
use App\Models\Machine;
use App\Models\MetalType;
use App\Models\Query;
use App\Models\QuerySendedMachines;
use App\Models\Status;
use App\Services\Contracts\QueryServiceContract;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class QueryService implements QueryServiceContract
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $showSentQueries = (request()->sent || Gate::check('showResponsibleForDrivers'));

        return view('content.pages.queries_list')->with([
            'sentQueries' => ($showSentQueries) ? 1 : 0,
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fileDelete(Request $request)
    {
        $data = $request->all();
        return (new QueryCrudService())->deleteFileByName($data['queryId'], $data['file'], $data['type']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('content.pages.new_query', [
            'machines' => Machine::with('drivers')->get(),
            'metals' => MetalType::all(),
            'bases' => Base::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        (new QueryCrudService())->createNewQuery(request());

        return redirect()->route('home')->with([
            "alertMessage" => AlertMessages::QUERY_CREATED,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param $queryId
     * @return Response
     */
    public function show($queryId)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $queryId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($queryId)
    {
        return view('content.pages.query_edit', [
            'query' => Query::with([
                'map' => function ($query) {
                    return $query->with(['mapStatus', 'mapUser'])->orderBy('id', 'DESC');
                }
            ])->find($queryId),
            'machines' => Machine::with('drivers')->get(),
            'drivers' => QuerySendedMachines::where('query_id', $queryId)->first(),
            'metals' => MetalType::all(),
            'bases' => Base::all(),
            'statuses' => Status::whereIn('id', StatusesConstants::ALLOWED_TO_CHANGE)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $queryId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($queryId)
    {
        $query = Query::find($queryId);
        (new QueryCrudService())->setQuery($query)
                                ->updateQuery(request());

        return redirect()->back()->with([
            "alertMessage" => AlertMessages::QUERY_UPDATED,
        ]);
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        Query::find($request->get('queryId'))->delete();
        return response()->json([
            "alertMessage" => AlertMessages::QUERY_DELETED,
        ]);
    }

    public function recovery()
    {
        return view('content.pages.queryRecovery');
    }

    public function acceptQuery($request)
    {
        $queryDriverUsers = [];
        $data = $request->all();
        $query = Query::find($data['queryId']);
        $query->update([
            'status' => StatusesConstants::SENDED,
        ]);

        if ($query->driversData) {
            $driversData = $query->driversData->drivers_data;

            $queryDriverUsers = array_map(function ($value) {
                return Driver::find($value->driver_id)->user_id;
            }, $driversData);

            $queryDriversDevices = array_map(function ($value) {
                return Driver::find($value->driver_id)->user->device->device_id ?? '';
            }, $driversData);
        }

        $result = [
            'users' => $queryDriverUsers,
            'devices' => $queryDriversDevices,
        ];

        //Отправляем Push-уведомления на мобильные приложения
        $this->sendEventToMobileDevice($queryDriversDevices, "Вам поступила новая заявка! #" . $data['queryId']);

        //Отправим данные в складской учет
        (new QuerySent())->queryDriversData($query["id"]);

        return $result;
    }

    public function sendEventToMobileDevice(array $deviceIds, $message)
    {
        if (!empty($deviceIds)) {
            $data = [
                'notification' => [
                    'title' => 'M1-Logistics',
                    'body' => $message,
                    'priority' => 'high',
                    'color' => '#6495ED',
                    'sound' => 'default',
                ],
                'registration_ids' => $deviceIds,
            ];

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data, JSON_UNESCAPED_UNICODE),
                CURLOPT_HTTPHEADER => [
                    'Authorization: key=AAAATvE52q4:APA91bHVBNGjWYVdgDMnbWQ4oAZARJCyxhLPYf15xeaGe0ZgocTzxx-WeNldrFw39KQLSmIieFtQeiI1p4C-dFzK5YLuccSPICZTErMutWgKX95b_nP16VjQz-iyBwVjTiX15r43rLdC',
                    'Content-Type: application/json'
                ],
            ));

            $response = curl_exec($curl);

            curl_close($curl);
//        echo $response;
        }
    }
}