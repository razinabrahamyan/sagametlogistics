<?php

namespace App\Classes\FortMonitor;

class FortMonitorHelpers
{
    public static function getCookiesFromGuzzleResponse($cookiesArray, $pattern)
    {
        $result = "";
        foreach ($cookiesArray as $cookie) {
            preg_match("/$pattern/", $cookie, $matches);
            if (!empty($matches)) {
                $result = $matches;
                break;
            }
        }
        return $result;
    }

    public static function getSGUID($cookiesArray)
    {
        return self::getCookiesFromGuzzleResponse($cookiesArray, 'SGUID=(.*?)&')[1];
    }

    public static function getCarsInfo() : array
    {
        $carsInfo = [];
        $tree = (new FortMonitorApi())->getTree();
        if (!empty($tree['body']) && $tree['body']['result'] == "Ok") {
            $carsInfo = $tree['body']['children'][0]['children'][0]['children'];
        }
        return $carsInfo;
    }
}