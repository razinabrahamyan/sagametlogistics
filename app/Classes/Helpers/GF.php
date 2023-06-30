<?php

namespace App\Classes\Helpers;

class GF
{
    public static function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public static function jsonDecode($json, $assoc = true)
    {
        return json_decode($json, $assoc);
    }

    public static function jsonEncode($json)
    {
        return json_encode($json);
    }

    public static function clearPhoneNumber($phone)
    {
        if($phone){
            $phone = preg_replace('/[^0-9]/', '', $phone);
        }
        return $phone;
    }

    public static function normalizeOnePhone($phone)
    {

        $phone = trim($phone);
        $phoneItem = self::clearPhoneNumber($phone);

        if(!empty($phoneItem)){

            //предусматриваем ситуацию с ошибочной нормализацией из внешнего источника 789243822255
            if(strlen($phoneItem) == 12 && strpos($phoneItem, '789') === 0) $phoneItem = substr($phoneItem, 1);
            if(strlen($phoneItem) == 12 && strpos($phoneItem, '989') === 0) $phoneItem = substr($phoneItem, 1);

            //Предполагаем что номер записан через 8
            if($phoneItem[0] == 8 && strlen($phoneItem) == 11) $phoneItem[0] = 7;
            if($phoneItem[0] == 9 && strlen($phoneItem) == 11) $phoneItem[0] = 7;

            //Предполагаем что не хватает первой цифры
            if(strlen($phoneItem) == 10) $phoneItem = '7'.$phoneItem;

            if(strlen($phoneItem) > 11 && $phoneItem[0] == 7) $phoneItem = substr($phoneItem, 0, 11);
        }

        return $phoneItem;
    }

    public static function phoneToStr($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if(strlen($phone) == 11 && preg_match("|^[\d]+$|", $phone))
            $phone = "+".substr($phone, 0, 1)."(".substr($phone, 1, 3).")".substr($phone, 4, 3)."-".substr($phone, 7, 2)."-".substr($phone, 9, 2);

        return $phone;
    }

    public static function clearArray($array)
    {
        if(is_array($array) && count($array)){
            foreach($array as $k => $el){
                if(!is_array($el) && trim($el) == ''){
                    unset($array[$k]);
                }
            }
            if(count($array))
                return $array;
        }
        return array ();
    }


    public static function deNormalizeOnePhone($phone)
    {
        //Сохраним исходную версию
        $phones = [$phone];

        $phone = trim($phone);
        $phoneItem = self::clearPhoneNumber($phone);
        //Сохраним очищенную версию
        $phones[] = $phone;
        //Сохраним нормализованную версию
        $phones[] = self::normalizeOnePhone($phone);
        //Сохраним строковую стандартную версию написания телефона с маской
        $phones[] = self::phoneToStr(self::normalizeOnePhone($phone));

        if(!empty($phoneItem)){
            //Предполагаем что номер записан не через 8
            if($phoneItem[0] == 7 && strlen($phoneItem) == 11){
                $phoneTmp = $phoneItem;
                $phoneTmp[0] = 8;
                $phones[] = $phoneTmp;
            }
            //сделаем номер без первой цифры
            if(strlen($phoneItem) == 11) $phones[] = substr($phoneItem, 1);
        }

        return self::clearArray(array_unique($phones));
    }
}