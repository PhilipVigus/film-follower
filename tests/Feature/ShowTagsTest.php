<?php

namespace Tests\Feature;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTagsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_logged_in_user_can_view_the_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tags'));

        $response->assertSuccessful();
        $response->assertViewIs('tags');
    }

    /** @test */
    public function a_guest_user_is_redirected_to_the_login_page()
    {
        $tag = Tag::factory()->create();

        $response = $this->get(route('tag', ['tag' => $tag]));

        $response->assertRedirect('login');
    }
}
