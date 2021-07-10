<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Modals\RemoveReview;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RemoveReviewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function you_can_remove_a_film_from_your_reviews()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        $user->films()
            ->updateExistingPivot(
                $film,
                ['status' => Film::WATCHED]
            )
        ;

        $user->reviews()
            ->create([
                'film_id' => $film->id,
                'rating' => 1,
                'comment' => 'First comment',
            ])
        ;

        Livewire::actingAs($user)
            ->test(RemoveReview::class, ['data' => ['film' => $film->toArray()]])
            ->call('removeReview', $film, true)
        ;

        $this->assertEmpty($user->watchedFilms);
        $this->assertCount(1, $user->shortlistedFilms);
    }

    /** @test */
    public function you_can_delete_a_films_review_details_when_you_remove_it()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        $user->films()
            ->updateExistingPivot(
                $film,
                ['status' => Film::WATCHED]
            )
        ;

        $user->reviews()
            ->create([
                'film_id' => $film->id,
                'rating' => 1,
                'comment' => 'First comment',
            ])
        ;

        Livewire::actingAs($user)
            ->test(RemoveReview::class, ['data' => ['film' => $film->toArray()]])
            ->call('removeReview', $film, true)
        ;

        $this->assertEmpty($user->reviews);
    }

    /** @test */
    public function you_can_choose_not_to_delete_a_films_review_details_when_you_remove_it()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        $user->films()
            ->updateExistingPivot(
                $film,
                ['status' => Film::WATCHED]
            )
        ;

        $user->reviews()
            ->create([
                'film_id' => $film->id,
                'rating' => 1,
                'comment' => 'First comment',
            ])
        ;

        Livewire::actingAs($user)
            ->test(RemoveReview::class, ['data' => ['film' => $film->toArray()]])
            ->call('removeReview', $film, false)
        ;

        $this->assertCount(1, $user->reviews);
    }
}
