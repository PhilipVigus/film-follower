<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowUserProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_normal_logged_in_user_can_view_the_page()
    {
        $user = User::factory()->create(['type' => User::TYPE_NORMAL]);

        $response = $this->actingAs($user)->get(route('profile.show'));

        $response->assertSuccessful();
    }

    /** @test */
    public function a_guest_logged_in_user_cannot_view_the_page()
    {
        $user = User::factory()->create(['type' => User::TYPE_GUEST]);

        $response = $this->actingAs($user)->get(route('profile.show'));

        $response->assertUnauthorized();
    }

    /** @test */
    public function a_non_logged_in_user_cannot_view_the_page()
    {
        $user = User::factory()->create(['type' => User::TYPE_GUEST]);

        $response = $this->followingRedirects()->get(route('profile.show'));

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }
}
