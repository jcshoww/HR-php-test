<?php

namespace App\Libs\Api;

use App\Interfaces\Weather;
use App\Libs\Base\WeatherApi;

class Openweather extends WeatherApi implements Weather
{
    private $_baseUrl = 'https://api.openweathermap.org/data/2.5/weather';
    private $_units = 'metric';
    private $_apiKey = '9aee50a200dbd53d6e9b4fe86fc6ee43';

    public function getByCityName(string $name): array
    {
        $response = json_decode($this->_sendRequest(
            $this->_baseUrl . '/?q=' . $name . '&units=' . $this->_units . '&APPID=' . $this->_apiKey
        ), true);
        $result = [
            'temperature' => sprintf("%+d", $response['main']['temp']), 'pressure' => $response['main']['pressure'], 
            'humidity' => $response['main']['humidity'], 'wind' => $response['wind']['speed']
        ];
        if(!$this->isResponseFilled($result)) {
            return false;
        }
        return $result;
    }

    public function getByCoordinates(float $lat, float $len): array
    {
        //realization
        return [];
    }
}
