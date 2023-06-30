<?php

namespace App\Classes\Notifications\Types\WhatsApp;

use App\Classes\ChatApi\Api;
use App\Classes\Constants\StatusesConstants;
use App\Classes\Notifications\Types\Interfaces\SendMessage;

class NewQueryCreated implements SendMessage
{
    const NOTIFY_PHONES = [
        '79653681165', //Grisha
        '79854818143', //Edo
        '79990033033', //Mher
    ];
    private $query;

    /**
     * NewQuery constructor.
     * @param $query
     */
    public function __construct($query)
    {
        $this->query = $query;
    }

    public function sendMessage()
    {
        if ($this->query->status == StatusesConstants::NEW && App()->environment() === 'production') {
            $message = "Создана новая заявка в https://www.m1-logistics.ru/ \nОт " . $this->query->manager->name . "";

            foreach (self::NOTIFY_PHONES as $phone) {
                (new Api())->setBody($message)
                           ->setPhone($phone)
                           ->sendMessage();
            }
        }
    }
}