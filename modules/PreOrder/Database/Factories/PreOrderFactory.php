<?php

namespace Modules\PreOrder\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\PreOrder\Models\PreOrder;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\PreOrder\Models\PreOrder>
 */
class PreOrderFactory extends Factory
{
    protected $model = PreOrder::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => mt_rand(1, 100),
            'total' => mt_rand(1, 20),
            'delivery_address' => $this->faker->address(),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'fulfilled', 'canceled']),
        ];
    }
}
