<?php

namespace App\Classes\ChatApi;

use App\Classes\Helpers\GF;
use App\Models\WhatsAppLog;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Api
{
    const SOURCE = 'https://api.chat-api.com/';
    const INSTANCE_ID = '257761';
    const TOKEN = 'z04it2nvmsqnwz71';

    private $phone = "";
    private $body = "";
    private $preview;
    private $title = "Sagamet Logistics";
    private $description = "";
    private $text = "";
    private $log = true;

    /**
     * Отправка ссылки с описанием
     * @return mixed|string
     * @link https://api.chat-api.com/docs#sendLink
     */
    public function sendLink()
    {
        $base64Format = 'data:image/jpeg;charset=utf-8;base64,';
        $imageConverted = base64_encode(file_get_contents(public_path('images/whatsApp/logistics.jpg')));

        $params = [
            "body"          => $this->getBody(),
            "previewBase64" => $this->getPreview() ?? $base64Format.$imageConverted,
            "title"         => $this->getTitle(),
            "description"   => $this->getDescription(),
            "text"          => $this->getText(),
            "phone"         => $this->getPhone()
        ];
        return $this->request("sendLink", $params, "POST");
    }

    /**
     * Отправка обычного сообщения
     * @param ["body"  => 'Сообщение',"phone" => '79645172000']
     * @return mixed|string
     * @link https://app.chat-api.com/docs#sendMessage
     */
    public function sendMessage()
    {
        $params = [
            "body"  => $this->getBody(),
            "phone" => $this->getPhone(),
        ];
        return $this->request("sendMessage", $params, "POST");
    }

    /**
     * @return mixed|string
     */
    public function status()
    {
        return $this->request("status", [
            'full' => true,
        ]);
    }

    /**
     * Логирование
     * @param $params
     * @return void
     */
    public function log($params) : void
    {
        if ($this->isLog()) {
            WhatsAppLog::insert([
                "request"    => GF::jsonEncode($params["request"]),
                "response"   => GF::jsonEncode($params["response"]),
                "method"     => $params["method"],
                "error"      => $params["error"],
                "phone"      => $params["phone"],
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }
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
        $url = self::SOURCE.'instance'.self::INSTANCE_ID.'/'.$apiMethod.'?token='.self::TOKEN;
        $error = "";
        $resultBody = [];

        try {
            if ($requestMethod === 'GET') {
                $resultParams = [];
                $url .= '&'.http_build_query($params);
            } else {
                $resultParams = [
                    'form_params' => $params,
                ];
            }

            $result = (new Client())->request($requestMethod, $url, $resultParams);
            $resultBody = GF::jsonDecode($result->getBody()->getContents());
        } catch (GuzzleException $e) {
            $error = $e->getMessage();
        }

        $this->log([
            "request"  => $params,
            "response" => $resultBody,
            "method"   => $apiMethod,
            "error"    => $error,
            "phone"    => $this->getPhone(),
        ]);

        return $resultBody;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return Api
     */
    public function setPhone($phone) : Api
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return Api
     */
    public function setBody($body) : Api
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPreview()
    {
        return $this->preview;
    }

    /**
     * @param mixed $preview
     * @return Api
     */
    public function setPreview($preview) : Api
    {
        $this->preview = $preview;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Api
     */
    public function setTitle($title) : Api
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Api
     */
    public function setDescription($description) : Api
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     * @return Api
     */
    public function setText($text) : Api
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return bool
     */
    public function isLog() : bool
    {
        return $this->log;
    }

    /**
     * @param bool $log
     * @return Api
     */
    public function setLog(bool $log) : Api
    {
        $this->log = $log;
        return $this;
    }
}