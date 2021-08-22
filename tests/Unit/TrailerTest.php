<?php

namespace Tests\Unit;

use Exception;
use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use App\Models\Trailer;
use Illuminate\Support\Facades\Schema;
use App\Models\IgnoredTrailerTitlePhrase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrailerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_trailers_table_has_the_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('trailers', [
                'id', 'guid', 'title', 'type', 'image', 'link', 'uploaded_at',
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

    /** @test */
    public function you_can_get_all_trailers_without_ignored_title_phrases()
    {
        $trailer = Trailer::factory()->create(['type' => 'This one is interesting']);

        $ignoredTrailerA = Trailer::factory()->create(['type' => 'This is ignored']);
        $ignoredTrailerB = Trailer::factory()->create(['type' => 'Unimportant type']);

        $user = User::factory()->create();

        IgnoredTrailerTitlePhrase::factory()->create(['user_id' => $user->id, 'phrase' => 'ignored']);
        IgnoredTrailerTitlePhrase::factory()->create(['user_id' => $user->id, 'phrase' => 'unimportant']);

        $trailers = Trailer::withoutIgnoredPhrases($user)->get();

        $this->assertCount(1, $trailers);
        $this->assertEquals($trailer->id, $trailers->first()->id);
    }
}
