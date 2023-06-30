<?php

namespace App\Classes\Constants;

class StatusesConstants
{
    const NEW = 1;
    const SENDED = 2;
    const HOLD = 3;
    const PROCESSED = 4;
    const IMMEDIATE = 5;
    const CANCELED = 6;

    const ALLOWED_TO_CHANGE = [self::HOLD, self::PROCESSED, self::IMMEDIATE, self::CANCELED];
    const CAN_SEND_WA_MESSAGE = [self::NEW, self::CANCELED, self::IMMEDIATE, self::HOLD];
    const CAN_SAVE_QUERY = [self::NEW, self::SENDED, self::IMMEDIATE, self::HOLD];
}