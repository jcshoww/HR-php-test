<?php
namespace App\Libs\Base;

use Exception;

abstract class WeatherApi
{
    static protected $errors = [
        301 => 'Moved permanently',
        400 => 'Bad request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not found',
        500 => 'Internal server error',
        502 => 'Bad gateway',
        503 => 'Service unavailable',
    ];

    static protected $responseFields = [
        'temperature', 'pressure', 'wind', 'humidity'
    ];

    public function isResponseFilled(array $response)
    {
        foreach(self::$responseFields as $field) {
            if(!array_key_exists($field, $response)) {
                throw new Exception('Missing required response field: ' . $field . ' in weather API response');
            }
        }
        return true;
    }

    protected function _sendRequest(string $url, string $method = 'GET', array $params = []): string
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        if($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, true);
            if(!empty($params)) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            }
        }
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $code = (int)$code;
        try
        {
            if ($code != 200 && $code != 204) {
                throw new \Exception(isset(self::$errors[$code]) ? self::$errors[$code] : 'Undescribed error', $code);
            }

        } catch (Exception $e) {
            die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }

        return $result;
    }
}