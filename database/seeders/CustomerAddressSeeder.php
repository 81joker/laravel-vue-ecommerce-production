<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample data for customer addresses
        $addresses = [
            [
                'type' => 'billing',
                'address1' => '123 Main St',
                'address2' => 'Apt 4B',
                'city' => 'New York',
                'zipcode' => '10001',
                'country_code' => 'USA', // Assuming 'USA' is a valid country code in your countries table
                'customer_id' => 1,
            ],
            [
                'type' => 'shipping',
                'address1' => '456 Elm St',
                'address2' => '',
                'city' => 'Los Angeles',
                'zipcode' => '90001',
                'country_code' => 'USA',
                'customer_id' => 1,
            ],
            [
                'type' => 'billing',
                'address1' => '789 Maple Ave',
                'address2' => '',
                'city' => 'Chicago',
                'zipcode' => '60601',
                'country_code' => 'USA',
                'customer_id' => 2,
            ],
            // Add more addresses as needed
        ];

        // Insert data into the customer_addresses table
        DB::table('customer_addresses')->insert($addresses);
    }
}
