<?php

namespace App\Http\Controllers\Core;

use App\Classes\SmsCApi\SmsCApi;
use App\Http\Controllers\Controller;
use App\Models\HlrPhone;
use App\Services\HLRequsetService;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class HLRequsetController extends Controller
{
    public function index()
    {
        return view('content.pages.hlr.hlr_list', [
            'phones' => HlrPhone::orderBy('id', 'DESC')->get(),
            'balance' => (new SmsCApi())->balance(),
        ]);
    }

    public function checkPhonesHLR()
    {
        return (new HLRequsetService())->checkPhonesHLR(request());
    }

    public function edit()
    {
        return view('content.pages.hlr.hlr_edit_list', [
            'phones' => HlrPhone::orderBy('id', 'DESC')->get()->toJson(),
        ]);
    }

    public function saveEdit()
    {
        $request = request()->all();
        HlrPhone::find($request['id'])->update([
            'phone' => $request['phone']
        ]);

        return [
            'message' => 'Сохранено',
        ];
    }

    public function store()
    {
        $message = 'Добавлено';
        try {
            $request = request()->all();
            HlrPhone::create([
                'phone' => $request['phone'],
            ]);
        } catch (\Exception $exception) {
            $message = 'Что то пошло не так';
        }

        return [
            'message' => $message,
            'phones' => HlrPhone::orderBy('id', 'DESC')->get()->toJson(),
        ];
    }

    public function destroy()
    {
        $message = 'Удалено';
        try {
            HlrPhone::find(request()->all()['id'])->delete();
        } catch (\Exception $exception) {
            $message = 'Что то пошло не так';
        }

        return [
            'message' => $message,
            'phones' => HlrPhone::orderBy('id', 'DESC')->get()->toJson(),
        ];
    }
}
