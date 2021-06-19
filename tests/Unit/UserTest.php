<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
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
    public function a_film_added_to_a_user_is_given_the_to_shortlist_status_by_default()
    {
        $user = User::factory()->create();
        $film = Film::factory()->create();

        $user->films()->attach($film);

        $this->assertCount(1, $user->films()->wherePivot('status', Film::TO_SHORTLIST)->get());
    }
}