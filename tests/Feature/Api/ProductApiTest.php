<?php

namespace Tests\Feature\Api;

use App\Models\Api\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    // Security Tests for Product API
    public function test_guest_cannot_access_products_api()
    {
        $response = $this->getJson('/api/products');
        $response->assertStatus(401);
    }

    public function test_non_admin_cannot_access_products_api()
    {
        $user = User::factory()->createOne([
            'is_admin' => false,
        ]);
        if ($user) {
            return $user;
        }

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/products');

        $response->assertStatus(403);
    }

    // Index Tests for Product API
    public function test_admin_can_list_products()
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['is_admin' => true]);
        // Product::factory()->count(5)->create();
        Product::factory()
            ->count(5)
            ->create([
                'created_by' => $admin->id,
            ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->getJson('/api/products?per_page=5');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);
    }
}
