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
    public function definition(): array
    {
        return [
            'name' =>  fake()->randomElement([
            'Books',
            'Electronics',
            'Clothing',
            'Food',
            'Toys',
            'Furniture',
        ]),
            'slug' => fake()->slug(),
            'active' => fake()->boolean(),
            'parent_id' => null,
            'created_by' => \App\Models\User::factory(),
            'updated_by' => \App\Models\User::factory(),
            // 'deleted_by' => \App\Models\User::factory()->nullable(), // Uncomment if you want to use deleted_by
        ];
    }
}
