<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' =>$name= $this->faker->name,
            'slug' => str_slug($name),
            'show_in_menu' => $this->faker->boolean,
            'image'=>'defaults.png',
            'parent_id'=>$this->faker->numberBetween(0,20),
            'status'=>$this->faker->boolean(),
        ];
    }
}
