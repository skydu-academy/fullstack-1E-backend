<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function home_with_not_login()
    {
        $response = $this->getJson('/api/home');
        $response->assertUnauthorized();
    }
    /** @test */
    public function home_response_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $response = $this->getJson('/api/home');
        $response->assertStatus(200);
    }
}
