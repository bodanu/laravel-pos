<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArbitraryTest extends TestCase
{
    public function test_orders()
    {
        $user = User::first();
        $this->actingAs($user)
        ->post('/api/clear');

        $response = $this->actingAs($user)
        ->post('/api/scan', ['code' => "C"]);

        $response->assertStatus(200);
        // $response->dump();
        $response->assertJson([
            'total' => [
                'total' => 1.38
            ],
        ]);

    }
}
