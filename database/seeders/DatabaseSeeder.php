<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Cashier',
            'email' => 'cashier@pos.com',
            'password' => bcrypt('password'),
        ]);
        \App\Models\Order::create([
            'user_id' => 1,
        ]);
        \App\Models\Products::create([
            'title' => "A",
            'code' => "A",
            'price' => 2.0
        ]);
        \App\Models\Products::create([
            'title' => "B",
            'code' => "B",
            'price' => 10.0
        ]);
        \App\Models\Products::create([
            'title' => "C",
            'code' => "C",
            'price' => 1.25
        ]);
        \App\Models\Products::create([
            'title' => "D",
            'code' => "D",
            'price' => 0.15
        ]);
        \App\Models\Products::create([
            'title' => "E",
            'code' => "E",
            'price' => 2
        ]);

        \App\Models\Discounts::create([
            'type' => "bogo",
            'applies_to' => 'B',
            'bogo_gets' => 'E',
            'bogo_limit' => 1
        ]);

        \App\Models\Discounts::create([
            'type' => "pack",
            'applies_to' => 'A',
            'pack_size' => 5,
            'pack_value' => 9,
        ]);

        \App\Models\Discounts::create([
            'type' => "pack",
            'applies_to' => 'C',
            'pack_size' => 6,
            'pack_value' => 6,
        ]);
    }
}


