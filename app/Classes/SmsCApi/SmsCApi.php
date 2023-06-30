<?php

namespace App\Classes\SmsCApi;

class SmsCApi
{
    const SOURCE = 'https://smsc.ru/sys/send.php';
    const LOGIN = 'sagametsaga';
    const PASSWORD = 'Alfa123698745';

    public function sendHLR($phones, $smsPing = false)
    {
        $result = [];
        foreach ($phones as $phone) {
            $hlr = $this->get([
                'login' => self::LOGIN,
                'psw' => self::PASSWORD,
                'phones' => $phone['phone'],
                'hlr' => 1,
            ]);

            $isAvailable = (strpos($hlr, 'OK') !== false);
            if (!$isAvailable && $smsPing) {
                $smsPing = $this->smsPing($phone['phone']);
                $isAvailable = (strpos($smsPing, 'OK') !== false);
            }

            $result[$phone['id']] = [
                'id' => $phone['id'],
                'isAvailable' => $isAvailable,
                'phone' => $phone['phone'],
            ];
        }

        return $result;
    }

    public function smsPing($phone)
    {
        return file_get_contents("https://smsc.ru/sys/send.php?login=" . self::LOGIN . "&psw=" . self::PASSWORD . "&phones=$phone&ping=1");
    }

    public function balance()
    {
        return file_get_contents("https://smsc.ru/sys/balance.php?login=" . self::LOGIN . "&psw=" . self::PASSWORD . "");
    }

    public function get(array $params = [])
    {
        $url = self::SOURCE;
        $url .= '?' . http_build_query($params);

        return file_get_contents($url);
    }

}