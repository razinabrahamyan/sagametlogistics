<?php

namespace App\Classes\Pusher\Triggers;

use App\Classes\Pusher\Constants;
use App\Classes\Pusher\PusherHandler;

class FrontTriggers
{
    /**
     * @param string $alertMessage
     */
    public static function newQueryNotify($alertMessage = Constants::NEW_QUERY_MSG)
    {
        (new PusherHandler())->frontNotifyEvent([
            'alertMessage' => $alertMessage,
            'alertTimeout' => 0,
        ]);
    }
}