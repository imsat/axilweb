<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PreOrderItem>
 */
class PreOrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pre_order_id' => mt_rand(1, 50),
            'product_id' => mt_rand(1, 20),
            'quantity' => mt_rand(1, 10)
        ];
    }
}
