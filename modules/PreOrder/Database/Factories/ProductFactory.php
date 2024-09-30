<?php

namespace Modules\PreOrder\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\PreOrder\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\PreOrder\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(mt_rand(2, 4)),
        ];
    }
}
