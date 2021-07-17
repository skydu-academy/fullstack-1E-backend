<?php

namespace Tests\Feature\Api\Dashboard;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostPageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function post_with_not_login()
    {
        $response = $this->postJson(route('post.store'));
        $response->assertUnauthorized();
    }
    /**
     * @test
     */
    public function post_with_data_empty()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $response = $this->postJson(route('post.store'),[]);
        $response->assertStatus(422);
    }
    /**
     * @test
     */
    public function post_with_image_wrong()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $response = $this->postJson(route('post.store'), ['image' => UploadedFile::fake()->image('photo1.giv')]);

        $response->assertStatus(422);
    }
    /**
     * @test
     */
    public function post_response_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $response = $this->postJson(route('post.store'),['image'=>UploadedFile::fake()->image('photo1.jpg')]);

        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function destroy_post_response_success()
    {
        $this->withExceptionHandling();
        $user = User::factory()->create();
        Post::factory()->create();
        $this->actingAs($user, 'api');
        $response = $this->deleteJson(route('post.destroy',['post'=>1]));

        $response->assertStatus(200);
    }


}
