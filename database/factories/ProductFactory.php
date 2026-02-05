<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
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
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(),
            // 'image' => "https://picsum.photos/800/600?random={$this->faker->numberBetween(1, 100)}",
            'description' => $this->faker->realText(2000),
            'price' => $this->faker->randomFloat(2, 1, 2),
            // 'created_by' => now(),
            // 'updated_by' => now(),
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 1,
            'updated_by' => 1,
            // 'deleted_at' => null,
            // 'deleted_by' => 1,
        ];
    }
    // public function configure()
    // {
    //     return $this->afterCreating(function (Product $product) {
    //         ProductImage::factory()->create([
    //             'product_id' => $product->id,
    //             'path' => '', // You might not need this
    //             'url' => "https://picsum.photos/800/600?random={$this->faker->numberBetween(1, 100)}",
    //             'mime' => 'image/jpeg', // Or use a random mime type
    //             'size' => $this->faker->numberBetween(1000, 500000), // Random size
    //             'position' => 1,
    //         ]);
    //     });
    // }
}
