<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductAttribute>
 */
class ProductAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id' => $this->faker->numberBetween(1, 12),
            'user_id' => $this->faker->numberBetween(1, 12),
            'sku' => $this->faker->numberBetween(1, 99),
            'colors' => $this->faker->numberBetween(1, 99),
            'real_prices' => $this->faker->numberBetween(1, 99),
            'sale_prices' => $this->faker->numberBetween(1, 99),
            'sizes' => 'sm',
            'real_prices' => $this->faker->numberBetween(1, 99),
            'sale_prices' => $this->faker->numberBetween(1, 99),
        ];
    }
}
