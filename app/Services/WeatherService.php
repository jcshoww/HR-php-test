<?php

namespace App\Services;

use App\Interfaces\Weather;

class WeatherService
{
    protected $_client;

    public function __construct(Weather $client)
    {
        $this->_client = $client;
    }

    public function getByCityName(string $name): array
    {
        return $this->_client->getByCityName($name);
    }
}
