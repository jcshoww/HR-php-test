<?php

namespace App\Http\Controllers;

use App\Libs\Api\Openweather;
use App\Services\WeatherService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function weather(Request $request)
    {
        $request = new Request([
            'city' => 'Брянск'
        ]);
        $validated = $this->validate($request, ['city' => 'required|string|max:80']);

        $api = new Openweather();
        $service = new WeatherService($api);
        $weather = $service->getByCityName($validated['city']);
        return view('weather', compact('weather'));
    }
}
