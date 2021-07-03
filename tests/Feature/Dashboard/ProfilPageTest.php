<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfilPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function example()
    {
        $user = [
            'name' => 'da',
            'email' => 'da@akdad.com',
            'password' => '123123',
            'password_confirmation' => '123123',
        ];
        $response = $this->postJson('api/register', $user);
        $response->assertStatus(200);
    }
}
