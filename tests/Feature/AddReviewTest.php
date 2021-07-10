<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Modals\ReviewDetails;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddReviewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function you_can_add_a_film_review()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(ReviewDetails::class, ['data' => ['film' => $film->toArray()]])
            ->call('addReview', $film, 1, 'A comment')
        ;

        $this->assertEmpty($user->filmsToShortlist);
        $this->assertCount(1, $user->watchedFilms);
    }

    /** @test */
    public function adding_a_review_gives_it_a_rating_and_comment()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(ReviewDetails::class, ['data' => ['film' => $film->toArray()]])
            ->call('addReview', $film, 1, 'A comment')
        ;

        $this->assertCount(1, $user->reviews);

        $review = $user->reviews->first();

        $this->assertEquals($film->id, $review->film_id);
        $this->assertEquals(1, $review->rating);
        $this->assertEquals('A comment', $review->comment);
    }

    /** @test */
    public function the_modal_retrieves_a_films_existing_review_details()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        $user->reviews()
            ->create([
                'film_id' => $film->id,
                'rating' => 1,
                'comment' => 'First comment',
            ])
        ;

        Livewire::actingAs($user)
            ->test(ReviewDetails::class, ['data' => ['film' => $film->toArray()]])
            ->assertSet('review', $user->reviews->first())
        ;
    }

    /** @test */
    public function reviewing_a_film__with_an_existing_review_replaces_those_details()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        $user->reviews()
            ->create([
                'film_id' => $film->id,
                'rating' => 1,
                'comment' => 'First comment',
            ])
        ;

        Livewire::actingAs($user)
            ->test(ReviewDetails::class, ['data' => ['film' => $film->toArray()]])
            ->call('addReview', $film, 5, 'Second comment')
        ;

        $this->assertCount(1, $user->reviews);

        $review = $user->reviews->first();

        $this->assertEquals($film->id, $review->film_id);
        $this->assertEquals(5, $review->rating);
        $this->assertEquals('Second comment', $review->comment);
    }
}
