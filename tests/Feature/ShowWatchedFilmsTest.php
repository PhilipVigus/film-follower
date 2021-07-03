<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use App\Models\Review;
use Livewire\Livewire;
use App\Http\Livewire\Watched;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowWatchedFilmsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_logged_in_user_can_view_the_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('watched'));

        $response->assertSuccessful();
        $response->assertViewIs('watched');
    }

    /** @test */
    public function a_guest_user_is_redirected_to_the_login_page()
    {
        $response = $this->get(route('watched'));

        $response->assertRedirect('login');
    }

    /** @test */
    public function the_list_includes_all_films_the_user_has_watched()
    {
        Film::factory()->create();
        $watchedFilm = Film::factory()->create();

        $user = User::factory()->create();

        $user->films()->updateExistingPivot($watchedFilm, ['status' => Film::WATCHED]);
        $user->reviews()->create(['film_id' => $watchedFilm->id, 'rating' => 2]);

        $response = Livewire::actingAs($user)->test(Watched::class);

        $this->assertCount(1, $response->films);
        $this->assertEquals($response->films[0]->id, $watchedFilm->id);
    }

    /** @test */
    public function a_user_can_removing_a_review()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        Review::create([
            'user_id' => $user->id,
            'film_id' => $film->id,
            'rating' => 3,
            'comment' => 'A comment',
        ]);

        $user->films()->updateExistingPivot($film, ['status' => Film::WATCHED]);

        $response = Livewire::actingAs($user)
            ->test(Watched::class)
            ->call('removeReview', $film, true)
        ;

        $this->assertEmpty($user->watchedFilms);
    }

    /** @test */
    public function a_user_can_delete_review_details_when_removing_a_review()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        Review::create([
            'user_id' => $user->id,
            'film_id' => $film->id,
            'rating' => 3,
            'comment' => 'A comment',
        ]);

        $user->films()->updateExistingPivot($film, ['status' => Film::WATCHED]);

        $response = Livewire::actingAs($user)
            ->test(Watched::class)
            ->call('removeReview', $film, true)
        ;

        $this->assertEmpty($user->reviews);
    }

    /** @test */
    public function a_user_can_keep_review_details_when_removing_a_review()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        Review::create([
            'user_id' => $user->id,
            'film_id' => $film->id,
            'rating' => 3,
            'comment' => 'A comment',
        ]);

        $user->films()->updateExistingPivot($film, ['status' => Film::WATCHED]);

        $response = Livewire::actingAs($user)
            ->test(Watched::class)
            ->call('removeReview', $film, false)
        ;

        $this->assertCount(1, $user->reviews);
    }

    /** @test */
    public function removing_a_review_opens_the_modal_dialog_with_that_review()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        $response = Livewire::actingAs($user)
            ->test(Watched::class)
            ->call('openRemoveReviewDialog', $film)
        ;

        $this->assertEquals($film->id, $response->payload['effects']['emits'][0]['params'][1]['film']['id']);
    }
}
