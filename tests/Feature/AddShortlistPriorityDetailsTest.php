<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Priority;
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
            ->call('shortlist', $film, Priority::HIGH, 'A comment')
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
            ->call('shortlist', $film, Priority::HIGH, 'A comment')
        ;

        $this->assertCount(1, $user->priorities);

        $priority = $user->priorities->first();

        $this->assertEquals($film->id, $priority->film_id);
        $this->assertEquals(Priority::HIGH, $priority->level);
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
                'level' => PRIORITY::LOW,
                'comment' => 'First comment',
            ])
        ;

        Livewire::actingAs($user)
            ->test(PriorityDetails::class, ['data' => ['film' => $film->toArray()]])
            ->assertSet('priority', $user->priorities->first())
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
                'level' => PRIORITY::LOW,
                'comment' => 'First comment',
            ])
        ;

        Livewire::actingAs($user)
            ->test(PriorityDetails::class, ['data' => ['film' => $film->toArray()]])
            ->call('shortlist', $film, Priority::HIGH, 'Second comment')
        ;

        $this->assertCount(1, $user->priorities);

        $priority = $user->priorities->first();

        $this->assertEquals($film->id, $priority->film_id);
        $this->assertEquals(Priority::HIGH, $priority->level);
        $this->assertEquals('Second comment', $priority->comment);
    }
}
