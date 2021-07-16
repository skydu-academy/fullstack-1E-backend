<?php

namespace Tests\Feature\Api\Dashboard;

use App\Models\CommentPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentPostPageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function store_comment_post_response_success()
    {
        $user = User::factory()->create();
        Post::factory()->create();
        $this->actingAs($user, 'api');
        $response = $this->postJson(route('comment-post.store'),[
            'comment'=> 'ini aku di post',
            'post_id'=> 1,
        ]);

        $response->assertSee('Comment Post success insert in db')->assertStatus(200);
    }

    /**
     * @test
     */
    public function update_comment_post_response_success()
    {
        $user = User::factory()->create();
        Post::factory()->create();
        CommentPost::factory()->create();
        $this->actingAs($user, 'api');
        $response = $this->patchJson(route('comment-post.update',['comment_post'=>1]),[
            'comment'=> 'this is comment 2',
        ]);

        $response->assertSee('Update post comment success')->assertStatus(200);
    }

    /**
     * @test
     */
    public function destroy_comment_post_response_success()
    {
        $user = User::factory()->create();
        Post::factory()->create();
        CommentPost::factory()->create();
        $this->actingAs($user, 'api');
        $response = $this->deleteJson(route('comment-post.destroy',[1]));

        $response->assertSee('delete post comment success')->assertStatus(200);
    }
}
