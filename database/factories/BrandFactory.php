<?php

namespace Database\Factories;

use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;


class BrandFactory extends Factory
{
    protected $model = Brand::class;
    public function definition(): array
    {
        return [
            'title' => $this->faker->company(),
//            'thumbnail' => '',
            'on_home_page' => $this->faker->boolean(),
            'sorting' => $this->faker->numberBetween(1, 999),
//            'thumbnail' => $this->faker->imageCustomFaker('images/brands'),
            'thumbnail' => $this->faker->imageCustomFaker(base_path('resources/images/brands'), 'images/brands'),
        ];
    }
}
