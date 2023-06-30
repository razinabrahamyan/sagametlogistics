<?php

namespace App\Services;

use App\Classes\SmsCApi\SmsCApi;
use App\Models\HlrPhone;

class HLRequsetService
{
    public function checkPhonesHLR($request)
    {
        $checkedPhones = [];
        $alertMessage = 'Не удалось отправить сообщение';

        if (!empty($request->phones)) {
            $checkedPhones = (new SmsCApi())->sendHLR($request->phones, filter_var($request->smsPing, FILTER_VALIDATE_BOOLEAN));
            $alertMessage = 'Проверка завершена';
        }

        return [
            'checkedPhones' => $checkedPhones,
            'alertMessage' => $alertMessage,
        ];
    }
}