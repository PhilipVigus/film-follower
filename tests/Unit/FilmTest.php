<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use App\Models\Trailer;
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
}
