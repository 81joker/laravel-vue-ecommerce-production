<?php

namespace Database\Factories\Api;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Api\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $categories = \App\Models\Category::factory()->count(2)->create();

        return [
            'title' => $this->faker->sentence(3),
            'slug' => $this->faker->slug(),
            // 'image' => [$image],
            // 'image_mime' => null,
            // 'image_size' => null,
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'quantity' => $this->faker->numberBetween(1, 100),
            // 'categories' => $categories->pluck('id')->toArray(),
            'published' => $this->faker->boolean(),
            'created_by' => \App\Models\User::factory(),
            'updated_by' => \App\Models\User::factory(),
        ];
    }
}
