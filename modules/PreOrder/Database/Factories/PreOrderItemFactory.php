<?php

namespace Modules\PreOrder\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\PreOrder\Models\PreOrderItem;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\PreOrder\Models\PreOrderItem>
 */
class PreOrderItemFactory extends Factory
{
    protected $model = PreOrderItem::class;
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
            'quantity' => mt_rand(1, 10),
            'price' => $this->faker->randomFloat(2, 2, 8),
        ];
    }
}
