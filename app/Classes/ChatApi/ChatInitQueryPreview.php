<?php

namespace App\Classes\ChatApi;

use App\Classes\Constants\AlertMessages;
use App\Classes\Constants\StatusesConstants;
use App\Classes\Helpers\GF;
use App\Classes\Mail\PersonalAlerts;
use App\Classes\Su\Webhooks\QuerySent;
use App\Models\Driver;
use App\Models\Query;
use App\Models\QuerySendedMachines;
use Exception;

class ChatInitQueryPreview implements ChatInitInterface
{
    private $driverInfo;
    private $query;

    /**
     * Инициирует отправку на WhatsApp
     * @return array
     */
    public function run()
    {
        $success = true;
        $query = $this->getQuery();
//        if (in_array($query->status, StatusesConstants::CAN_SEND_WA_MESSAGE)) {
        try {
            $whatsApp = new Api();
            $waStatus = $whatsApp->status();
            $driversInfo = $this->getDriverInfo();
            $previewLink = route('previewQuery', [$query["id"], $query["access_token"]]);

            if (sizeof($driversInfo) > 0) {
                foreach ($driversInfo as $phone) {
                    $sendLink = $whatsApp->setBody($previewLink)
                                         ->setDescription('Сагамет Логистикс упрощает коммуникацию внутри компании')
                                         ->setText("Для обработки заявки перейдите по ссылке \n $previewLink")
                                         ->setPhone($phone)
                                         ->sendLink();

                    if (empty($sendLink)) {
                        $success = false;
                        PersonalAlerts::alertArtur('Ошибка при отправке сообщений в WhatsApp', 'Пришел пустой массив - посмотрите логи');
                    }
                }

            } else {
                $success = false;
            }
        } catch (Exception $exception) {
            $success = false;
            PersonalAlerts::alertArtur('Ошибка при отправке сообщений в WhatsApp', $exception->getMessage());
        }
        if ($success) {
            $query->status = StatusesConstants::SENDED;
            $query->update();
            $alertMessage = AlertMessages::WHATS_APP_SUCCESS_SEND;

            //Отправим данные в складской учет
            (new QuerySent())->queryDriversData($query["id"]);
        } else {
            $alertMessage = AlertMessages::WHATS_APP_ERROR_SEND;
        }
//        } else {
//            $alertMessage = AlertMessages::WHATS_APP_ERROR_STATUS;
//        }


        if (!empty($waStatus) && $waStatus['statusData']['substatus'] != "normal") {
            $alertMessage .= "<br>".$waStatus['statusData']['msg'];
            PersonalAlerts::alertArtur('WhatsApp Error', $waStatus['statusData']['msg']);
            PersonalAlerts::alertEduard('WhatsApp Error', $waStatus['statusData']['msg']);
        }

        return [
            "alertMessage" => $alertMessage,
        ];
    }

    /**
     * @param Query $query
     * @return $this
     */
    public function prepareData(Query $query)
    {
        $this->setQuery($query);
        $driversIds = [];
        $machines = $query->machines;

        foreach ($machines as $machine) {
            if (!empty($machine->drivers)) {
                foreach ($machine->drivers as $driverId) {
                    $driversIds[] = $driverId;
                }
            }
        }

        // Получаем номера телефонов для отправки
        $driversInfo = Driver::findMany($driversIds);
        $driverData = QuerySendedMachines::where('query_id', $query->id)->first()->drivers_data ?? [];
        $driverData = collect($driverData)->keyBy('driver_id');

        foreach ($driversInfo as $driver) {
            $driversPhone[] = (!empty($driverData[$driver->id]) && !empty($driverData[$driver->id]->phone)) ? $driverData[$driver->id]->phone : $driver->phone;
        }

        $this->setDriverInfo($driversPhone);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDriverInfo()
    {
        return $this->driverInfo;
    }

    /**
     * @param mixed $driverInfo
     * @return ChatInitQueryPreview
     */
    public function setDriverInfo($driverInfo)
    {
        $this->driverInfo = $driverInfo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     * @return ChatInitQueryPreview
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }
}