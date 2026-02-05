<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::factory()->create(); // Create a user
        return [
            'user_id' => $user->id, // Assign the user's ID to customer's user_id
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'phone' => $this->faker->phoneNumber(),
            'status' => $this->faker->randomElement(['active']),
            // 'status' => $this->faker->randomElement(['active', 'inactive', 'pending']),
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
        ];
    }
}