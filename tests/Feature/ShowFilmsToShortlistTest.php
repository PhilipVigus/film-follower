<?php

namespace Tests\Feature;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\ToShortlist;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowFilmsToShortlistTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_logged_in_user_can_view_the_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('to-shortlist'));

        $response->assertSuccessful();
        $response->assertViewIs('to-shortlist');
    }

    /** @test */
    public function a_guest_user_is_redirected_to_the_login_page()
    {
        $response = $this->get(route('to-shortlist'));

        $response->assertRedirect('login');
    }

    /** @test */
    public function the_list_includes_all_films_the_user_has_to_shortlist()
    {
        $firstFilm = Film::factory()->hasTrailers(1)->create();
        $secondFilm = Film::factory()->hasTrailers(1)->create();
        $shortlistedFilm = Film::factory()->create();

        $user = User::factory()->create();

        $user->films()->updateExistingPivot($shortlistedFilm, ['status' => Film::SHORTLISTED]);

        $response = Livewire::actingAs($user)->test(ToShortlist::class);

        $this->assertCount(2, $response->films);
        $this->assertEquals($response->films[0]->id, $firstFilm->id);
        $this->assertEquals($response->films[1]->id, $secondFilm->id);
    }

    /** @test */
    public function the_list_does_not_include_films_with_no_trailers()
    {
        $filmWithTrailer = Film::factory()->hasTrailers(1)->create();
        $filmWithoutTrailer = Film::factory()->create();

        $user = User::factory()->create();

        $response = Livewire::actingAs($user)->test(ToShortlist::class);

        $this->assertCount(1, $response->films);
        $this->assertEquals($response->films[0]->id, $filmWithTrailer->id);
    }

    /** @test */
    public function the_list_does_not_include_films_with_tags_the_user_is_ignoring()
    {
        $filmWithTrailer = Film::factory()->hasTrailers(1)->create();
        $filmWithIgnoredTag = Film::factory()->create();

        $ignoredFilmTag = Tag::factory()->create();

        $user = User::factory()->create();

        $filmWithIgnoredTag->tags()->attach($ignoredFilmTag);

        $user->ignoredFilmTags()->attach($ignoredFilmTag);

        $response = Livewire::actingAs($user)->test(ToShortlist::class);

        $this->assertCount(1, $response->films);
        $this->assertEquals($response->films[0]->id, $filmWithTrailer->id);
    }

    /** @test */
    public function you_can_ignore_a_film()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(ToShortlist::class)
            ->call('ignoreFilm', $film)
        ;

        $this->assertEmpty($user->filmsToShortlist);
        $this->assertCount(1, $user->ignoredFilms);
    }
}
