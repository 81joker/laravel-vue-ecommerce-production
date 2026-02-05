<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            AdminUserSeeder::class,
            ProductSeeder::class,
            CountrySeeder::class,
            // OrderSeeder::class,
            CustomerSeeder::class,
            CategorySeeder::class,
            // ProductImageSeeder::class
            // CustomerAddressSeeder::class
        ]);
        User::factory()->create([
            'name' => 'Tim',
            'email' => 'tim26618@gmail.com',
        ]);
    }
}
