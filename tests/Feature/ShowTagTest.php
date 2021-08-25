<?php

namespace Tests\Feature;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Tag as LivewireTag;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTagTest extends TestCase
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
    public function it_shows_all_films_to_shortlist_with_the_specified_tag()
    {
        $film = Film::factory()->hasTrailers()->create();
        $tag = Tag::factory()->create();

        $film->tags()->attach($tag);

        $user = User::factory()->create();

        $response = Livewire::actingAs($user)
            ->test(LivewireTag::class, ['tag' => $tag])
        ;

        $this->assertCount(1, $response->filmsToShortlist);
        $this->assertEquals($film->id, $response->filmsToShortlist->first()->id);
    }

    /** @test */
    public function it_shows_all_shortlisted_films_with_the_specified_tag()
    {
        $film = Film::factory()->hasTrailers()->create();
        $tag = Tag::factory()->create();

        $film->tags()->attach($tag);

        $user = User::factory()->create();

        $user->films()->updateExistingPivot($film, ['status' => Film::SHORTLISTED]);
        $user->priorities()->create(['film_id' => $film->id, 'rating' => 3]);

        $response = Livewire::actingAs($user)
            ->test(LivewireTag::class, ['tag' => $tag])
        ;

        $this->assertCount(1, $response->shortlistedFilms);
        $this->assertEquals($film->id, $response->shortlistedFilms->first()->id);
    }

    /** @test */
    public function it_shows_all_watched_films_with_the_specified_tag()
    {
        $film = Film::factory()->hasTrailers()->create();
        $tag = Tag::factory()->create();

        $film->tags()->attach($tag);

        $user = User::factory()->create();

        $user->films()->updateExistingPivot($film, ['status' => Film::WATCHED]);
        $user->priorities()->create(['film_id' => $film->id, 'rating' => 2]);
        $user->reviews()->create(['film_id' => $film->id, 'rating' => 2]);

        $response = Livewire::actingAs($user)
            ->test(LivewireTag::class, ['tag' => $tag])
        ;

        $this->assertCount(1, $response->watchedFilms);
        $this->assertEquals($film->id, $response->watchedFilms->first()->id);
    }
}
