<?php

namespace Tests\Feature\Api\Dashboard;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FollowerPageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function follow_response_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $response = $this->postJson('api/dashboard/follow', [
            'user_follower_id' => 2
        ]);
        $response->assertSee("follow success")->assertStatus(200);
    }
    /**
     * @test
     */
    public function unfollow_response_success()
    {
        User::factory()->count(2)->create();
        Follower::factory()->create();
        $this->actingAs(User::find(1), 'api');
        $response = $this->deleteJson('api/dashboard/unfollow/2');
        $response->assertSee("unfollow success")->assertStatus(200);
    }
}
