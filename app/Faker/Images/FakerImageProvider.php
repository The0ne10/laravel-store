<?php

namespace App\Faker\Images;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FakerImageProvider extends Base
{
    public function imageCustomFaker(string $dir = '', int $width = 500, int $height = 500): string
    {
        $url = 'https://dummyjson.com/image/'.$width.'x'.$height;

        $name = $dir . '/' . Str::random(8) . '.jpg';

        Storage::put(
            $name,
            Http::get($url)->body()
        );

        return '/storage/' . $name;
    }
}
