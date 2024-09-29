<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PreOrder>
 */
class PreOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => mt_rand(1, 100),
            'total' => mt_rand(1, 20),
            'delivery_address' => $this->faker->address(),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'fulfilled', 'canceled']),
        ];
    }
}
