<?php

namespace App\Faker\Images;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FakerImageProviderFromResource extends Base
{
    public function imageCustomFaker(string $dirImages, string $dir = ''): string
    {
        $topImages = array_filter(scandir($dirImages), function ($item) use ($dirImages) {
            return $item !== '.' && $item !== '..' && is_file($dirImages . '/' . $item);
        });

        $name = $dir . '/' . Str::random(8) . '.jpg';

        $randomFile = self::randomElement($topImages);
        $image = file_get_contents($dirImages . '/' . $randomFile);

        Storage::put($name, $image);

        return '/storage/' . $name;
    }
}
