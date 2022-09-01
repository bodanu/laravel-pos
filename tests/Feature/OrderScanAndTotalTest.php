<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderScanAndTotalTest extends TestCase
{

    public function test_order_scan_and_price()
    {
        $user = User::first();

        $response = $this->actingAs($user)
                        ->post('/api/scan', ['code' => "C"]);

        // $response->dump();
        $response->assertStatus(200);
        $response->assertJsonStructure([
                'id',
                'user_id',
                'status',
                'created_at',
                'updated_at',
                'total' => [],
                'items' => []
        ]);

        $this->actingAs($user)
        ->post('/api/clear');
    }
}
