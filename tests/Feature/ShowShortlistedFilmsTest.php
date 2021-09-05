<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Shortlist;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowShortlistedFilmsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_logged_in_user_can_view_the_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('shortlist'));

        $response->assertSuccessful();
        $response->assertViewIs('shortlist');
    }

    /** @test */
    public function a_guest_user_is_redirected_to_the_login_page()
    {
        $response = $this->get(route('shortlist'));

        $response->assertRedirect('login');
    }

    /** @test */
    public function the_list_includes_all_films_the_user_has_shortlisted()
    {
        Film::factory()->create();
        $shortlistedFilm = Film::factory()->hasTrailers(2)->create();

        $user = User::factory()->create();

        $user->films()->updateExistingPivot($shortlistedFilm, ['status' => Film::SHORTLISTED]);
        $user->priorities()->create(['film_id' => $shortlistedFilm->id, 'rating' => 3]);

        $response = Livewire::actingAs($user)->test(Shortlist::class);

        $this->assertCount(1, $response->films);
        $this->assertEquals($response->films[0]->id, $shortlistedFilm->id);
    }

    /** @test */
    public function the_list_is_order_from_highest_to_lowest_rating()
    {
        $fiveStarFilm = Film::factory()->hasTrailers(2)->create();
        $fourStarFilm = Film::factory()->hasTrailers(2)->create();
        $threeStarFilm = Film::factory()->hasTrailers(2)->create();

        $user = User::factory()->create();

        $user->films()->updateExistingPivot($fiveStarFilm, ['status' => Film::SHORTLISTED]);
        $user->priorities()->create(['film_id' => $fiveStarFilm->id, 'rating' => 5]);

        $user->films()->updateExistingPivot($threeStarFilm, ['status' => Film::SHORTLISTED]);
        $user->priorities()->create(['film_id' => $threeStarFilm->id, 'rating' => 3]);

        $user->films()->updateExistingPivot($fourStarFilm, ['status' => Film::SHORTLISTED]);
        $user->priorities()->create(['film_id' => $fourStarFilm->id, 'rating' => 4]);

        $response = Livewire::actingAs($user)->test(Shortlist::class);

        $this->assertCount(3, $response->films);
        $this->assertEquals($response->films[0]->id, $fiveStarFilm->id);
        $this->assertEquals($response->films[1]->id, $fourStarFilm->id);
        $this->assertEquals($response->films[2]->id, $threeStarFilm->id);
    }

    /** @test */
    public function the_highlighted_film_displays_first_in_the_list()
    {
        $firstFilm = Film::factory()->hasTrailers()->create();
        $secondFilm = Film::factory()->hasTrailers()->create();
        $highlightedFilm = Film::factory()->hasTrailers()->create();

        $user = User::factory()->create();

        $user->films()->updateExistingPivot($firstFilm, ['status' => Film::SHORTLISTED]);
        $user->priorities()->create(['film_id' => $firstFilm->id, 'rating' => 5]);

        $user->films()->updateExistingPivot($secondFilm, ['status' => Film::SHORTLISTED]);
        $user->priorities()->create(['film_id' => $secondFilm->id, 'rating' => 5]);

        $user->films()->updateExistingPivot($highlightedFilm, ['status' => Film::SHORTLISTED]);
        $user->priorities()->create(['film_id' => $highlightedFilm->id, 'rating' => 5]);

        $response = Livewire::actingAs($user)->withQueryParams(['film' => $highlightedFilm->id])
            ->test(Shortlist::class)
        ;

        $this->assertEquals($highlightedFilm->id, $response->films->first()->id);
    }
}
