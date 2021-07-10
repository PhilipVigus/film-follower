<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Priority;
use App\Http\Livewire\Modals\RemoveFromShortlist;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RemoveFromShortlistTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function you_can_remove_a_film_from_your_shortlist()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        $user->films()
            ->updateExistingPivot(
                $film,
                ['status' => Film::SHORTLISTED]
            )
        ;

        $user->priorities()
            ->create([
                'film_id' => $film->id,
                'level' => PRIORITY::LOW,
                'comment' => 'First comment',
            ])
        ;

        Livewire::actingAs($user)
            ->test(RemoveFromShortlist::class, ['data' => ['film' => $film->toArray()]])
            ->call('removeFromShortlist', $film, true)
        ;

        $this->assertEmpty($user->shortlistedFilms);
        $this->assertCount(1, $user->filmsToShortlist);
    }

    /** @test */
    public function you_can_delete_a_films_shortlist_priority_details_when_you_remove_it()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        $user->films()
            ->updateExistingPivot(
                $film,
                ['status' => Film::SHORTLISTED]
            )
        ;

        $user->priorities()
            ->create([
                'film_id' => $film->id,
                'level' => PRIORITY::LOW,
                'comment' => 'First comment',
            ])
        ;

        Livewire::actingAs($user)
            ->test(RemoveFromShortlist::class, ['data' => ['film' => $film->toArray()]])
            ->call('removeFromShortlist', $film, true)
        ;

        $this->assertEmpty($user->priorities);
    }

    /** @test */
    public function you_can_choose_not_to_delete_a_films_shortlist_priority_details_when_you_remove_it()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        $user->films()
            ->updateExistingPivot(
                $film,
                ['status' => Film::SHORTLISTED]
            )
        ;

        $user->priorities()
            ->create([
                'film_id' => $film->id,
                'level' => PRIORITY::LOW,
                'comment' => 'First comment',
            ])
        ;

        Livewire::actingAs($user)
            ->test(RemoveFromShortlist::class, ['data' => ['film' => $film->toArray()]])
            ->call('removeFromShortlist', $film, false)
        ;

        $this->assertCount(1, $user->priorities);
    }
}
