<?php

namespace Tests\Feature;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Tag as LivewireTag;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTagFilmsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_logged_in_user_can_view_the_page()
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->create();

        $response = $this->actingAs($user)->get(route('tag', ['tag' => $tag]));

        $response->assertSuccessful();
        $response->assertViewIs('tag');
    }

    /** @test */
    public function a_guest_user_is_redirected_to_the_login_page()
    {
        $tag = Tag::factory()->create();

        $response = $this->get(route('tag', ['tag' => $tag]));

        $response->assertRedirect('login');
    }

    /** @test */
    public function the_list_includes_all_films_that_have_the_tags()
    {
        $untaggedFilm = Film::factory()->create();
        $taggedFilm = Film::factory()->create();
        $tag = Tag::factory()->create();

        $taggedFilm->tags()->attach($tag);

        $user = User::factory()->create();

        $response = Livewire::actingAs($user)->test(LivewireTag::class, ['tag' => $tag]);

        $this->assertCount(1, $response->tag->films);
        $this->assertEquals($response->tag->films[0]->id, $taggedFilm->id);
    }
}
