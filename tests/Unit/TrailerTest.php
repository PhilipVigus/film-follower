<?php

namespace Tests\Unit;

use Exception;
use App\Models\Tag;
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
    public function a_trailer_can_have_many_tags()
    {
        $tagA = Tag::factory()->create();
        $tagB = Tag::factory()->create();
        $trailer = Trailer::factory()->create();

        $trailer->tags()->attach($tagA);
        $trailer->tags()->attach($tagB);

        $this->assertCount(2, $trailer->tags);
    }

    /** @test */
    public function a_trailer_can_have_no_tags()
    {
        $trailer = Trailer::factory()->create();

        $this->assertEmpty($trailer->tags);
    }

    /** @test */
    public function you_can_get_all_trailers_without_ignored_tags()
    {
        $trailer = Trailer::factory()->create();

        $ignoredTrailerA = Trailer::factory()->create();
        $ignoredTrailerB = Trailer::factory()->create();

        $user = User::factory()->create();

        $tagA = Tag::factory()->create();
        $tagB = Tag::factory()->create();

        $ignoredTagA = Tag::factory()->create();
        $ignoredTagB = Tag::factory()->create();

        $trailer->tags()->attach($tagA);
        $trailer->tags()->attach($tagB);

        $ignoredTrailerA->tags()->attach($ignoredTagA);
        $ignoredTrailerB->tags()->attach($ignoredTagB);
        $ignoredTrailerB->tags()->attach($tagA);

        $user->ignoredTrailerTags()->attach($ignoredTagA);
        $user->ignoredTrailerTags()->attach($ignoredTagB);

        $trailers = Trailer::withoutIgnoredTags($user)->get();

        $this->assertCount(1, $trailers);
        $this->assertEquals($trailer->id, $trailers->first()->id);
    }

    /** @test */
    public function trailers_without_ignored_tags_includes_trailers_with_no_tags()
    {
        $trailer = Trailer::factory()->create();

        $ignoredTrailerA = Trailer::factory()->create();
        $ignoredTrailerB = Trailer::factory()->create();

        $user = User::factory()->create();

        $tagA = Tag::factory()->create();

        $ignoredTagA = Tag::factory()->create();
        $ignoredTagB = Tag::factory()->create();

        $ignoredTrailerA->tags()->attach($ignoredTagA);
        $ignoredTrailerB->tags()->attach($ignoredTagB);
        $ignoredTrailerB->tags()->attach($tagA);

        $user->ignoredTrailerTags()->attach($ignoredTagA);
        $user->ignoredTrailerTags()->attach($ignoredTagB);

        $trailers = Trailer::withoutIgnoredTags($user)->get();

        $this->assertCount(1, $trailers);
        $this->assertEquals($trailer->id, $trailers->first()->id);
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
