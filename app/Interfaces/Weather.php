<?php

namespace App\Interfaces;

interface Weather
{
    public function getByCityName(string $name): array;

    public function getByCoordinates(float $lat, float $len): array;
}