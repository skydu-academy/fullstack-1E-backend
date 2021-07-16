<?php

namespace Tests\Feature\Api\Dashboard;

use App\Models\Follower;
use App\Models\LikePost;
use App\Models\Post;
use App\Models\User;
use Database\Factories\LikePostFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikePostPageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function like_post_response_success()
    {
        $user = User::factory()->create();
        Post::factory()->create();
        $this->actingAs($user, 'api');
        $response = $this->postJson('api/dashboard/like', [
            'post_id' => 1
        ]);
        $response->assertSee("like post success")->assertStatus(200);
    }
    /**
     * @test
     */
    public function unlike_response_success()
    {
        User::factory()->create();
        Post::factory()->create();
        LikePost::factory()->create();
        $this->actingAs(User::find(1), 'api');
        $response = $this->deleteJson('api/dashboard/unlike/1');
        $response->assertSee("Unliked post success")->assertStatus(200);
    }
}
