<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function logout_with_not_login()
    {
        $response = $this->postJson('api/logout');
        $response->assertUnauthorized();
    }
    /** @test */
    public function logout_response_success()
    {
        self::markTestIncomplete("TO DO Belum Selesai masih Error di Testing");
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        dump($user);
        $response = $this->postJson('api/logout');
        $response->assertJson(200);
    }
}
