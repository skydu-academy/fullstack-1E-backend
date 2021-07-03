<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegisterPageTest extends TestCase
{
    use RefreshDatabase;

    // REGISTER WITH EMAIL
    /** @test */
    public function register_success()
    {
        $user = User::factory()->make()->only('name','email');
        $user['password'] = 'password';
        $user['password_confirmation'] = 'password';
        $response = $this->postJson('api/register', $user);
        Mail::fake();
        $response->assertStatus(200)->assertSee(__('message.user_register_success'));
    }

    /** @test */
    public function register_with_email_use_empty_data()
    {
        $user = [];
        $response = $this->postJson('api/register', $user);
        $response->assertStatus(422);
    }

    /** @test */
    public function register_with_email_use_the_same_email()
    {
        $data_user = User::factory()->create();
        $user = [
            'name' => 'user test',
            'email' => $data_user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $response = $this->postJson('api/register', $user);
        $response->assertStatus(401)->assertSee(__('message.user_registered'));

    }

    // Register With PROVIDER [Google | FB]
    /** @test */
    public function register_with_provider_use_empty_data()
    {
        $user = [];
        $response = $this->postJson('api/register/google', $user);
        $response->assertStatus(401);
    }
    /** @test */
    public function register_with_provider_use_invalid_token()
    {
        $user = [
            'email' => 'wrong@email.test',
            'token' => 'token'
        ];
        $response = $this->postJson('api/register/google', $user);
        $response->assertStatus(401)->assertSee(__('message.token_invalid'));
    }
}
