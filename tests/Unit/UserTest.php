<?php

namespace Tests\Unit;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use App\Models\Review;
use App\Models\Priority;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_have_many_films()
    {
        $user = User::factory()->create();
        $filmA = Film::factory()->create();
        $filmB = Film::factory()->create();

        $user->films()->attach($filmA);
        $user->films()->attach($filmB);

        $this->assertCount(2, $user->films);
    }

    /** @test */
    public function a_user_can_have_no_films()
    {
        $user = User::factory()->create();

        $this->assertEmpty($user->films);
    }

    /** @test */
    public function a_user_cannot_have_duplicate_films()
    {
        $user = User::factory()->create();
        $film = Film::factory()->create();

        $user->films()->attach($film);

        $this->expectException(QueryException::class);

        $user->films()->attach($film);
    }

    /** @test */
    public function a_film_added_to_a_user_is_given_the_to_shortlist_status_by_default()
    {
        $user = User::factory()->create();
        $film = Film::factory()->create();

        $user->films()->attach($film);

        $this->assertCount(1, $user->films()->wherePivot('status', Film::TO_SHORTLIST)->get());
    }

    /** @test */
    public function you_can_get_all_films_to_shortlist_by_a_user()
    {
        $user = User::factory()->create();
        $shortlistedFilm = Film::factory()->create();
        $filmToShortlist = Film::factory()->create();

        $user->films()->attach($shortlistedFilm);
        $user->films()->attach($filmToShortlist);
        $user->films()->updateExistingPivot($shortlistedFilm, ['status' => Film::SHORTLISTED]);

        $filmsToShortlist = $user->filmsToShortlist()->get();

        $this->assertCount(1, $filmsToShortlist);
        $this->assertEquals($filmToShortlist->id, $filmsToShortlist->first()->id);
    }

    /** @test */
    public function you_can_get_all_films_shortlisted_by_a_user()
    {
        $user = User::factory()->create();
        $shortlistedFilm = Film::factory()->create();
        $filmToShortlist = Film::factory()->create();

        $user->films()->attach($shortlistedFilm);
        $user->films()->attach($filmToShortlist);
        $user->films()->updateExistingPivot($shortlistedFilm, ['status' => Film::SHORTLISTED]);

        $shortlistedFilms = $user->shortlistedFilms()->get();

        $this->assertCount(1, $shortlistedFilms);
        $this->assertEquals($shortlistedFilm->id, $shortlistedFilms->first()->id);
    }

    /** @test */
    public function you_can_get_all_films_ignored_by_a_user()
    {
        $user = User::factory()->create();
        $ignoredFilm = Film::factory()->create();
        $filmToShortlist = Film::factory()->create();

        $user->films()->attach($ignoredFilm);
        $user->films()->attach($filmToShortlist);
        $user->films()->updateExistingPivot($ignoredFilm, ['status' => Film::IGNORED]);

        $ignoredFilms = $user->ignoredFilms()->get();

        $this->assertCount(1, $ignoredFilms);
        $this->assertEquals($ignoredFilm->id, $ignoredFilms->first()->id);
    }

    /** @test */
    public function a_new_user_has_all_existing_films_added_to_their_films()
    {
        Film::factory(5)->create();
        $user = User::factory()->create();

        $this->assertCount(5, $user->films);
    }

    /** @test */
    public function a_user_can_have_prioritised_films()
    {
        $user = User::factory()->create();

        $filmA = Film::factory()->create();
        $filmB = Film::factory()->create();

        $filmA->priorities()->save(new Priority(['user_id' => $user->id, 'level' => Priority::MEDIUM]));
        $filmB->priorities()->save(new Priority(['user_id' => $user->id, 'level' => Priority::MEDIUM]));

        $this->assertCount(2, $user->priorities);
    }

    /** @test */
    public function a_user_can_have_no_prioritised_films()
    {
        $user = User::factory()->create();

        $this->assertEmpty($user->priorities);
    }

    /** @test */
    public function a_user_can_have_reviewed_films()
    {
        $user = User::factory()->create();

        $filmA = Film::factory()->create();
        $filmB = Film::factory()->create();

        $filmA->reviews()->save(new Review(['user_id' => $user->id, 'rating' => 2]));
        $filmB->reviews()->save(new Review(['user_id' => $user->id, 'rating' => 2]));

        $this->assertCount(2, $user->reviews);
    }

    /** @test */
    public function a_user_can_have_no_reviewed_films()
    {
        $user = User::factory()->create();

        $this->assertEmpty($user->reviews);
    }

    /** @test */
    public function a_user_can_have_ignored_film_tags()
    {
        $user = User::factory()->create();

        $tagA = Tag::factory()->create();
        $tagB = Tag::factory()->create();

        $user->ignoredFilmTags()->attach($tagA);
        $user->ignoredFilmTags()->attach($tagB);

        $this->assertCount(2, $user->ignoredFilmTags);
    }

    /** @test */
    public function a_user_can_have_no_ignored_films_tags()
    {
        $user = User::factory()->create();

        $this->assertEmpty($user->ignoredFilmTags);
    }

    /** @test */
    public function a_user_can_have_ignored_trailer_tags()
    {
        $user = User::factory()->create();

        $tagA = Tag::factory()->create();
        $tagB = Tag::factory()->create();

        $user->ignoredTrailerTags()->attach($tagA);
        $user->ignoredTrailerTags()->attach($tagB);

        $this->assertCount(2, $user->ignoredTrailerTags);
    }

    /** @test */
    public function a_user_can_have_no_ignored_trailer_tags()
    {
        $user = User::factory()->create();

        $this->assertEmpty($user->ignoredTrailerTags);
    }
}
