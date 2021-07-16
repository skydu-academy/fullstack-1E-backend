<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EmailPageTest extends TestCase
{
    use RefreshDatabase;

    // Email Verification
    /** @test */
    public function verify_email_with_data_wrong()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $id = 1;
        $hash = 'e06d627afba246356d83de4f341ab3963a33ec89';
        $response = $this->getJson("api/email/handle-verify/$id/$hash");
        $response->assertUnauthorized();
    }
    /** @test */
    public function verify_email_with_no_login()
    {
        $id = 1;
        $hash = 'e06d627afba246356d83de4f341ab3963a33ec89';
        $response = $this->getJson("api/email/handle-verify/$id/$hash");
        $response->assertStatus(401)->assertJson(['message' => "Unauthenticated."]);
    }

    //Email Notice
    /** @test */
    public function email_notice_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $response = $this->getJson(route('verification.notice'));
        $response->assertStatus(200)->assertJson(['message' => "please verify email first"]);
    }
    /** @test */
    public function email_notice_failde_with_not_login()
    {
        $response = $this->getJson(route('verification.notice'));
        $response->assertUnauthorized();
    }

    // Send Verify
    /** @test */
    public function email_send_verify_response_success()
    {
        $id = 1;
        $hash = 'e06d627afba246356d83de4f341ab3963a33ec89';
        $localhost = "http://localhost:3000/$id/$hash";
        $response = $this->getJson(route('verification.verify', ['id' => $id, 'hash' => $hash]));
        $response->assertRedirect($localhost);
    }

    // Resend Email
    /** @test */
    public function resend_email_response_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $response = $this->getJson(route('verification.send'));
        Mail::fake();
        $response->assertSee(__('message.verification_link_sent'));
    }
    /** @test */
    public function resend_email_with_not_login()
    {
        $response = $this->getJson(route('verification.send'));
        $response->assertUnauthorized();
    }

}
