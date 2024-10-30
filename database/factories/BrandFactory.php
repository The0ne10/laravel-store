<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->company(),
//            'thumbnail' => '',
            'on_home_page' => $this->faker->boolean(),
            'sorting' => $this->faker->numberBetween(1, 999),
            'thumbnail' => $this->faker->imageCustomFaker('images/brands'),
        ];
    }
}
