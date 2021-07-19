<?php

namespace Tests\Unit;

use PDOException;
use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use App\Models\Review;
use App\Models\Priority;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_reviews_table_has_the_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('reviews', [
                'id', 'user_id', 'film_id', 'rating', 'comment',
            ])
        );
    }

    /** @test */
    public function a_review_relates_to_a_film()
    {
        $review = Review::factory()->create();

        $this->assertInstanceOf(Film::class, $review->film);
    }

    /** @test */
    public function a_review_must_relate_to_a_film()
    {
        $this->expectException(PDOException::class);

        Review::factory()->create(['film_id' => null]);
    }

    /** @test */
    public function a_review_belongs_to_a_user()
    {
        $review = Review::factory()->create();

        $this->assertInstanceOf(User::class, $review->user);
    }

    /** @test */
    public function a_priority_must_belong_to_a_user()
    {
        $this->expectException(PDOException::class);

        Priority::factory()->create(['user_id' => null]);
    }

    /** @test */
    public function two_reviews_must_not_have_the_same_user_and_film()
    {
        $user = User::factory()->create();
        $film = Film::factory()->create();

        Review::factory()->create(['user_id' => $user->id, 'film_id' => $film->id]);

        $this->expectException(PDOException::class);

        Review::factory()->create(['user_id' => $user->id, 'film_id' => $film->id]);
    }
}
