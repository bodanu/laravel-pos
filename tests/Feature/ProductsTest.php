<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    public function test_products()
    {
        $user = User::first();

        $response = $this->actingAs($user)
                        ->get('/api/products');

        $response->assertStatus(200);

        $response->assertJson([
            'products' => []
        ]);

    }
}
