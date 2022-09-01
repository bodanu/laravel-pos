<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{

    public function test_orders()
    {
        $user = User::first();

        $response = $this->actingAs($user)
                        ->get('/api/collect');

        $response->assertStatus(200);
        // $response->dump();
        $response->assertJsonStructure([
            'order' => [
                'id',
                'user_id',
                'status',
                'created_at',
                'updated_at',
                'total' => [],
                'items' => []
            ]
        ]);

    }
}
