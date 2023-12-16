<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "reference" => $this->faker->regexify("[A-Z]{3}-[0-9]{3}-[A-Z]{2}"),
            "user_id" => $this->faker->numberBetween(1, 10),
            "latitude" => $this->faker->latitude,
            "longitude" => $this->faker->longitude,
            "speed" => $this->faker->numberBetween(0, 100),
        ];
    }
}
