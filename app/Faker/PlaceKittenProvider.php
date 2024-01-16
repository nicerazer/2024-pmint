<?php

namespace App\Faker;

class PlaceKittenProvider
{
    public function imageUrl($width = 640, $height = 480)
    {
        return sprintf('https://placekitten.com/%d/%d', $width, $height);
    }
}
