<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Shortlist;
use App\Models\Priority;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

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
        $this->withoutExceptionHandling();
        Film::factory()->create();
        $shortlistedFilm = Film::factory()->create();

        $user = User::factory()->create();

        $user->films()->updateExistingPivot($shortlistedFilm, ['status' => Film::SHORTLISTED]);
        $user->priorities()->create(['film_id' => $shortlistedFilm->id, 'level' => Priority::MEDIUM]);

        $response = Livewire::actingAs($user)->test(Shortlist::class);

        $this->assertCount(1, $response->films);
        $this->assertEquals($response->films[0]->id, $shortlistedFilm->id);
    }

    /** @test */
    public function you_can_unshortlist_a_film()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Shortlist::class)
            ->call('unshortlist', $film)
        ;

        $this->assertEmpty($user->shortlistedFilms);
        $this->assertCount(1, $user->filmsToShortlist);
    }

    /** @test */
    public function editing_a_shortlisted_film_opens_the_modal_dialog_with_that_film()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();
        
        $response = Livewire::actingAs($user)
            ->test(Shortlist::class)
            ->call('openPriorityDetailsDialog', $film)
        ;

        $this->assertEquals($film->id, $response->payload['effects']['emits'][0]['params'][1]['film']['id']);
    }

    /** @test */
    public function editing_a_shortlisted_film_that_has_already_been_prioritised_opens_the_modal_dialog_with_the_existing_priority()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        $priority = Priority::create(['user_id' => $user->id, 'film_id' => $film->id, 'level' => Priority::HIGH, 'comment' => 'A comment']);
        
        $response = Livewire::actingAs($user)
            ->test(Shortlist::class)
            ->call('openPriorityDetailsDialog', $film)
        ;

        $this->assertEquals($priority->id, $response->payload['effects']['emits'][0]['params'][1]['priority']['id']);
    }

    /** @test */
    public function a_user_can_delete_priority_details_when_removing_a_film_from_their_shortlist()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        Priority::create(['user_id' => $user->id, 'film_id' => $film->id, 'level' => Priority::HIGH, 'comment' => 'A comment']);
        
        $user->films()->updateExistingPivot($film, ['status' => Film::SHORTLISTED]);

        $response = Livewire::actingAs($user)
            ->test(Shortlist::class)
            ->call('removeFromShortlist', $film, true)
        ;

        $this->assertEmpty($user->priorities);
    }

    /** @test */
    public function a_user_can_keep_priority_details_when_removing_a_film_from_their_shortlist()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        Priority::create(['user_id' => $user->id, 'film_id' => $film->id, 'level' => Priority::HIGH, 'comment' => 'A comment']);
        
        $user->films()->updateExistingPivot($film, ['status' => Film::SHORTLISTED]);

        $response = Livewire::actingAs($user)
            ->test(Shortlist::class)
            ->call('removeFromShortlist', $film, false)
        ;

        $this->assertCount(1, $user->priorities);
    }
}
