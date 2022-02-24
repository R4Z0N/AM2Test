<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Apartment>
 */
class ApartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'price' => $this->faker->randomNumber(2),
            'currency' => $this->faker->currencyCode(),
            'description' => $this->faker->paragraph(),
            'properties'    =>  [
                'balcon_size'   =>  $this->faker->numberBetween(2,8),
                'location'  =>  $this->faker->city(),
            ],
            'category_id' => Category::factory(),
        ];
    }
}
