<?php

namespace Database\Factories;

use Domain\Catalog\Models\Brand;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;
    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->word(2, true)),
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),
            'thumbnail' => $this->faker->imageCustomFaker(base_path('resources/images/products'), 'images/products'),
//            'thumbnail' => $this->faker->imageCustomFaker('images/products'),
            'price' => $this->faker->numberBetween(1000, 1000000),
            'on_home_page' => $this->faker->boolean(),
            'quantity' => $this->faker->numberBetween(0, 20),
            'sorting' => $this->faker->numberBetween(1, 999),
            'text' => $this->faker->realText(),
        ];
    }
}
