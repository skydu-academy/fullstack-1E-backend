<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use ResponseHelper;
use Tests\TestCase;

class ProfilPageTest extends TestCase
{
    use RefreshDatabase;

    // Show Profile
    /**
     * @test
     */
    public function show_profil_with_not_login()
    {
        $response = $this->getJson('/api/dashboard/profil/1');
        $response->assertStatus(401);
    }
    /**
     * @test
     */
    public function show_profil_response_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $response = $this->getJson('/api/dashboard/profil/1');
        $response->assertStatus(200);
    }

    // Profil Update
    /**
     * @test
     */
    public function update_profil_with_not_login()
    {
        $response = $this->postJson('/api/dashboard/profil-update/1');
        $response->assertStatus(401);
    }
    /**
     * @test
     */
    public function update_profil_with_login_but_data_empty()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $response = $this->postJson('/api/dashboard/profil-update/1');
        $response->assertStatus(422);
    }
    /**
     * @test
     */
    public function update_profil_response_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $data_update = [
                        'name'      => 'user test',
                        'email'     => 'user@test.com',
                        'image'     => UploadedFile::fake()->image('photo1.jpg'),
                        'deskripsi' => 'ini deskripsi'
                    ];
        $response = $this->postJson('/api/dashboard/profil-update/1', $data_update);
        $response->assertStatus(200)->assertSee(__('message.updated_user_success'));
    }
}


