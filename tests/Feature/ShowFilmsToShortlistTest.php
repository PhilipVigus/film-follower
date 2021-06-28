<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\ToShortlist;
use App\Models\Priority;
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
        $firstFilm = Film::factory()->create();
        $secondFilm = Film::factory()->create();
        $shortlistedFilm = Film::factory()->create();

        $user = User::factory()->create();

        $user->films()->updateExistingPivot($shortlistedFilm, ['status' => Film::SHORTLISTED]);

        $response = Livewire::actingAs($user)->test(ToShortlist::class);

        $this->assertCount(2, $response->films);
        $this->assertEquals($response->films[0]->id, $firstFilm->id);
        $this->assertEquals($response->films[1]->id, $secondFilm->id);
    }

    /** @test */
    public function you_can_shortlist_a_film()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(ToShortlist::class)
            ->call('shortlist', $film, Priority::HIGH, 'A comment')
        ;

        $this->assertEmpty($user->filmsToShortlist);
        $this->assertCount(1, $user->shortlistedFilms);
    }

    /** @test */
    public function shortlisting_a_film_gives_it_a_priority()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(ToShortlist::class)
            ->call('shortlist', $film, Priority::HIGH, 'A comment')
        ;

        $this->assertEmpty($user->filmsToShortlist);
        $this->assertCount(1, $user->priorities);

        $priority = $user->priorities->first();
        $this->assertEquals($film->id, $priority->film_id);
        $this->assertEquals(Priority::HIGH, $priority->priority);
        $this->assertEquals('A comment', $priority->comment);
    }

    /** @test */
    public function shortlisting_a_film_opens_the_modal_dialog_with_that_film()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();
        
        $response = Livewire::actingAs($user)
            ->test(ToShortlist::class)
            ->call('openPriorityDetailsDialog', $film)
        ;

        $this->assertEquals($film->id, $response->payload['effects']['emits'][0]['params'][1]['film']['id']);
    }

    /** @test */
    public function shortlisting_a_film_that_has_already_been_prioritised_opens_the_modal_dialog_with_the_existing_priority()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        $priority = Priority::create(['user_id' => $user->id, 'film_id' => $film->id, 'priority' => Priority::HIGH, 'comment' => 'A comment']);
        
        $response = Livewire::actingAs($user)
            ->test(ToShortlist::class)
            ->call('openPriorityDetailsDialog', $film)
        ;

        $this->assertEquals($priority->id, $response->payload['effects']['emits'][0]['params'][1]['priority']['id']);
    }
}
