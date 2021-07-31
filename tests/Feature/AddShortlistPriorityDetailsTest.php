<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Modals\PriorityDetails;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddShortlistPriorityDetailsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function you_can_shortlist_a_film()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(PriorityDetails::class, ['data' => ['film' => $film->toArray()]])
            ->call('shortlist', $film, 5, 'A comment')
        ;

        $this->assertEmpty($user->filmsToShortlist);
        $this->assertCount(1, $user->shortlistedFilms);
    }

    /** @test */
    public function shortlisting_a_film_gives_it_a_priority_and_comment()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(PriorityDetails::class, ['data' => ['film' => $film->toArray()]])
            ->call('shortlist', $film, 5, 'A comment')
        ;

        $this->assertCount(1, $user->priorities);

        $priority = $user->priorities->first();

        $this->assertEquals($film->id, $priority->film_id);
        $this->assertEquals(5, $priority->rating);
        $this->assertEquals('A comment', $priority->comment);
    }

    /** @test */
    public function the_modal_retrieves_a_films_existing_shortlist_priority_details()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        $user->priorities()
            ->create([
                'film_id' => $film->id,
                'rating' => 1,
                'comment' => 'First comment',
            ])
        ;

        Livewire::actingAs($user)
            ->test(PriorityDetails::class, ['data' => ['film' => $film->toArray()]])
            ->assertSet('rating', 1)
            ->assertSet('comment', 'First comment')
        ;
    }

    /** @test */
    public function shortlisting_a_film__with_an_existing_priority_replaces_those_details()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        $user->priorities()
            ->create([
                'film_id' => $film->id,
                'rating' => 1,
                'comment' => 'First comment',
            ])
        ;

        Livewire::actingAs($user)
            ->test(PriorityDetails::class, ['data' => ['film' => $film->toArray()]])
            ->call('shortlist', $film, 5, 'Second comment')
        ;

        $this->assertCount(1, $user->priorities);

        $priority = $user->priorities->first();

        $this->assertEquals($film->id, $priority->film_id);
        $this->assertEquals(5, $priority->rating);
        $this->assertEquals('Second comment', $priority->comment);
    }
}
