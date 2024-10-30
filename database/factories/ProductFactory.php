<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->word(2, true)),
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),
//            'thumbnail' => '',
            'thumbnail' => $this->faker->imageCustomFaker('images/products'),
            'price' => $this->faker->numberBetween(1000, 100000),
            'on_home_page' => $this->faker->boolean(),
            'sorting' => $this->faker->numberBetween(1, 999),
        ];
    }
}
