<?php

namespace Tests\Unit;

use Exception;
use Tests\TestCase;
use App\Models\Film;
use App\Models\Trailer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrailerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_trailers_table_has_the_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('trailers', [
                'id', 'guid', 'title', 'slug', 'type', 'image', 'link', 'uploaded_at',
            ])
        );
    }

    /** @test */
    public function a_trailer_is_from_a_film()
    {
        $film = Film::factory()->create();
        $trailer = Trailer::factory()->create(['film_id' => $film->id]);

        $this->assertEquals($film->id, $trailer->film->id);
    }

    /** @test */
    public function a_trailer_must_be_from_a_film()
    {
        $this->expectException(Exception::class);

        Trailer::factory()->create(['film_id' => null]);
    }
}
