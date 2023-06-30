<?php

namespace App\Classes\FortMonitor;

use App\Classes\Helpers\GF;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\GuzzleException;

class FortMonitorApi
{
    const SOURCE = 'https://web.fort-monitor.ru/api/integration/v1/';
    const LOGIN = 'paradox26@rambler.ru';
    const PASSWORD = 'GabsasSSSS111213';
    const LANG = 'ru-ru';
    const TIMEZONE = '3';

    private $sguid = "";
    private $cookies = [];

    /**
     * FortMonitorApi constructor.
     */
    public function __construct()
    {
        $connection = $this->connect();
        $this->setCookies($connection['cookies']);
    }

    public function connect()
    {
        $connection = $this->request('connect', [
            "login"    => self::LOGIN,
            "password" => self::PASSWORD,
            "lang"     => self::LANG,
            "timezone" => self::TIMEZONE,
        ]);
        return $connection;
    }

    public function getTree()
    {
        return $this->request('gettree', [
            'all' => 'true'
        ]);
    }

    /**
     * Базовый запрос к API
     * @param string $apiMethod
     * @param array $params
     * @param string $requestMethod
     * @return mixed|string
     */
    public function request(string $apiMethod, array $params = [], string $requestMethod = 'GET')
    {
        $url = self::SOURCE.$apiMethod;
        $error = "";
        $resultBody = [];

        try {
            if ($requestMethod === 'GET') {
                $resultParams = [
                    "query" => $params
                ];
            } else {
                $resultParams = [
                    'form_params' => $params,
                ];
            }

            $cookies = $this->getCookies();
            if (!empty($cookies[1])) {
                $resultParams['headers'] = [
                    'Cookie' => $cookies[1],
                ];
            }

            $client = new Client();
            $result = $client->request($requestMethod, $url, $resultParams);
            $resultBody = GF::jsonDecode($result->getBody()->getContents());
        } catch (GuzzleException $e) {
            $error = $e->getMessage();
            dump($error);
        }
//
//        $this->log([
//            "request"  => $params,
//            "response" => $resultBody,
//            "method"   => $apiMethod,
//            "error"    => $error,
//            "phone"    => $this->getPhone(),
//        ]);

        return [
            "body"    => $resultBody,
            "cookies" => $result->getHeaders()['Set-Cookie'] ?? [],
        ];
    }

    /**
     * @return string
     */
    public function getSguid() : string
    {
        return $this->sguid;
    }

    /**
     * @param string $sguid
     * @return FortMonitorApi
     */
    public function setSguid(string $sguid) : FortMonitorApi
    {
        $this->sguid = $sguid;
        return $this;
    }

    /**
     * @return array
     */
    public function getCookies() : array
    {
        return $this->cookies;
    }

    /**
     * @param array $cookies
     * @return FortMonitorApi
     */
    public function setCookies(array $cookies) : FortMonitorApi
    {
        $this->cookies = $cookies;
        return $this;
    }
}