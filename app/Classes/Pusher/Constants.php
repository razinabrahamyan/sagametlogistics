<?php

namespace App\Classes\Pusher;

class Constants
{
    //APP OPTIONS
    const CLUSTER = 'eu';
    const USE_TLS = true;
    const AUTH_KEY = '36f1803c4b375570c839';
    const SECRET = 'b8cd37d280f490a6372b';
    const APP_ID = '1197250';

    //EVENTS AND CHANNELS
    const BASE_CHANNEL = 'base-channel';
    const FRONT_NOTIFY_EVENT = 'new-query-event';
    const QUERY_ACCEPTED = 'query-accept';

    //DEFAULT MESSAGES
    const NEW_QUERY_MSG = 'Поступила новая заявка';

}