<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name_np' => $this->faker->name,
            'slug'=>str_slug($this->faker->name),
            'short_description'=>$this->faker->text(),
            'quantity'=>$this->faker->numberBetween(1,99),
            'short_description'=>$this->faker->text(),
            // 'brand_id'=>1,
        ];
    }
}
