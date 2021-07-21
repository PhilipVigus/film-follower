<?php

namespace Tests\Unit;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use App\Models\Review;
use App\Models\Trailer;
use App\Models\Priority;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilmTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_movies_table_has_the_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('films', [
                'id', 'guid', 'title', 'slug',
            ])
        );
    }

    /** @test */
    public function a_film_can_have_trailers()
    {
        $film = Film::factory()->create();
        Trailer::factory(2)->create(['film_id' => $film->id]);

        $this->assertCount(2, $film->trailers);
    }

    /** @test */
    public function a_film_can_have_no_trailers()
    {
        $film = Film::factory()->create();

        $this->assertEmpty($film->trailers);
    }

    /** @test */
    public function a_film_can_have_many_followers()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $film = Film::factory()->create();

        $film->followers()->attach($userA);
        $film->followers()->attach($userB);

        $this->assertCount(2, $film->followers);
    }

    /** @test */
    public function a_film_can_have_no_followers()
    {
        $film = Film::factory()->create();

        $this->assertEmpty($film->followers);
    }

    /** @test */
    public function a_film_cannot_have_duplicate_followers()
    {
        $user = User::factory()->create();
        $film = Film::factory()->create();

        $film->followers()->attach($user);

        $this->expectException(QueryException::class);

        $film->followers()->attach($user);
    }

    /** @test */
    public function a_follower_added_to_a_film_is_given_the_to_shortlist_status_by_default()
    {
        $user = User::factory()->create();
        $film = Film::factory()->create();

        $film->followers()->attach($user);

        $this->assertCount(1, $film->followers()->wherePivot('status', Film::TO_SHORTLIST)->get());
    }

    /** @test */
    public function a_film_can_be_prioritised_by_many_users()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $film = Film::factory()->create();

        $userA->priorities()->save(new Priority(['film_id' => $film->id, 'level' => Priority::MEDIUM]));
        $userB->priorities()->save(new Priority(['film_id' => $film->id, 'level' => Priority::MEDIUM]));

        $this->assertCount(2, $film->priorities);
    }

    /** @test */
    public function a_film_can_be_prioritised_by_no_users()
    {
        $film = Film::factory()->create();

        $this->assertEmpty($film->priorities);
    }

    /** @test */
    public function a_film_can_be_reviewed_by_many_users()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $film = Film::factory()->create();

        $userA->reviews()->save(new Review(['film_id' => $film->id, 'rating' => 2]));
        $userB->reviews()->save(new Review(['film_id' => $film->id, 'rating' => 2]));

        $this->assertCount(2, $film->reviews);
    }

    /** @test */
    public function a_film_can_be_reviewed_by_no_users()
    {
        $film = Film::factory()->create();

        $this->assertEmpty($film->reviews);
    }

    /** @test */
    public function a_film_can_have_many_tags()
    {
        $tagA = Tag::factory()->create();
        $tagB = Tag::factory()->create();
        $film = Film::factory()->create();

        $film->tags()->attach($tagA);
        $film->tags()->attach($tagB);

        $this->assertCount(2, $film->tags);
    }

    /** @test */
    public function a_film_can_have_no_tags()
    {
        $film = Film::factory()->create();

        $this->assertEmpty($film->tags);
    }

    /** @test */
    public function you_can_get_all_films_without_ignored_tags()
    {
        $film = Film::factory()->create();

        $ignoredFilmA = Film::factory()->create();
        $ignoredFilmB = Film::factory()->create();

        $user = User::factory()->create();

        $tagA = Tag::factory()->create();
        $tagB = Tag::factory()->create();

        $ignoredTagA = Tag::factory()->create();
        $ignoredTagB = Tag::factory()->create();

        $film->tags()->attach($tagA);
        $film->tags()->attach($tagB);

        $ignoredFilmA->tags()->attach($ignoredTagA);
        $ignoredFilmB->tags()->attach($ignoredTagB);
        $ignoredFilmB->tags()->attach($tagA);

        $user->ignoredFilmTags()->attach($ignoredTagA);
        $user->ignoredFilmTags()->attach($ignoredTagB);

        $films = Film::withoutIgnoredTags($user)->get();

        $this->assertCount(1, $films);
        $this->assertEquals($film->id, $films->first()->id);
    }
}
