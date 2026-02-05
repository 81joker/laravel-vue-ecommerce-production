<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductImageSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')
            ->chunkById(50, function ($products) {
                $mapped = $products->map(function ($p) {
                    return [
                        'product_id' => $p->id,
                        'path' => '',
                        'url' => $p->image,
                        'mime' => $p->image_mime ?? 'mage/jpeg',
                        'size' => $p->image_size ?? 0, 
                        'position' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                });

                // Insert into product_images table
                DB::table('product_images')->insert($mapped->toArray());
            });
    }
}
