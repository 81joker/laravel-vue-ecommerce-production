<?php

namespace Database\Factories;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $twoMonthsAgo = Carbon::now()->subMonths(2);
        $randomDate = $this->faker->dateTimeBetween($twoMonthsAgo, 'now');

        return [
            'total_price' => $this->faker->randomFloat(2, 10, 1000), // Random price between 10 and 1000
            'status' => $this->faker->randomElement(['paid', 'unpaid']),
            // 'status' => $this->faker->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
            'created_by' => Customer::factory(),
            'updated_by' => Customer::factory(),
            'created_at' => $randomDate,
            'updated_at' => $randomDate,
        ];
    }
}
