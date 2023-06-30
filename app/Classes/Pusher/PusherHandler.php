<?php

namespace App\Classes\Pusher;

use Exception;
use Pusher\Pusher;

class PusherHandler
{
    private $pusher;

    /**
     * PusherHandler constructor.
     */
    public function __construct()
    {
        try {
            $this->setPusher((new Pusher(
                Constants::AUTH_KEY,
                Constants::SECRET,
                Constants::APP_ID,
                [
                    'cluster' => Constants::CLUSTER,
                    'useTLS' => Constants::USE_TLS,
                ]
            )));
        } catch (Exception $exception) {
//            $exception->getMessage();
        }
    }

    /**
     * Отправка сообщений на фронт для оповещений
     * @param $data
     */
    public function frontNotifyEvent($data)
    {
        $this->getPusher()
             ->trigger(Constants::BASE_CHANNEL, Constants::FRONT_NOTIFY_EVENT, $data);
    }

    /**
     * Отправка PUSH уведомления о подтверждении заявки
     * @param $data
     */
    public function queryAcceptEvent($data)
    {
        $this->getPusher()
             ->trigger(Constants::BASE_CHANNEL, Constants::QUERY_ACCEPTED, $data);
    }

    /**
     * @return mixed
     */
    public function getPusher()
    {
        return $this->pusher;
    }

    /**
     * @param mixed $pusher
     * @return PusherHandler
     */
    public function setPusher($pusher)
    {
        $this->pusher = $pusher;
        return $this;
    }
}