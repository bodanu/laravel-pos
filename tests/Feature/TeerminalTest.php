<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Terminal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeerminalTest extends TestCase
{

    public $terminal;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::first();

        $this->terminal = $this->app->make(Terminal::class);

        $this->actingAs($user)->terminal->scan("B");
        $this->actingAs($user)->terminal->scan("C");
        $this->actingAs($user)->terminal->scan("D");
        $this->actingAs($user)->terminal->scan("A");
        $this->actingAs($user)->terminal->scan("B");
        $this->actingAs($user)->terminal->scan("E");
        $this->actingAs($user)->terminal->scan("A");
        $this->actingAs($user)->terminal->scan("A");
        $this->actingAs($user)->terminal->scan("A");

    }

    public function test_case_1(){
        var_dump($this->terminal);
    }
}
