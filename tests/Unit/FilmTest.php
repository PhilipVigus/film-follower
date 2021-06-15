<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Film;
use App\Models\Trailer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilmTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_movies_table_has_the_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('films', [
                'id', 'guid', 'title', 'slug',
            ])
        );
    }

    /** @test */
    public function a_film_can_have_trailers()
    {
        $film = Film::factory()->create();
        Trailer::factory()->create(['film_id' => $film->id]);
        Trailer::factory()->create(['film_id' => $film->id]);

        $this->assertCount(2, $film->trailers);
    }

    /** @test */
    public function a_film_can_have_no_trailers()
    {
        $film = Film::factory()->create();

        $this->assertEmpty($film->trailers);
    }
}
