<?php

namespace Tests\Unit;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\Film;
use App\Models\Trailer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_tags_table_has_the_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('tags', [
                'id', 'name', 'slug',
            ])
        );
    }

    /** @test */
    public function a_tag_can_be_associated_with_many_films()
    {
        $tag = Tag::factory()->create();
        $filmA = Film::factory()->create();
        $filmB = Film::factory()->create();

        $filmA->tags()->attach($tag);
        $filmB->tags()->attach($tag);

        $this->assertCount(2, $tag->films);
    }

    /** @test */
    public function a_tag_can_be_associated_with_no_films()
    {
        $tag = Tag::factory()->create();

        $this->assertEmpty($tag->films);
    }

    /** @test */
    public function a_tag_can_be_associated_with_many_trailers()
    {
        $tag = Tag::factory()->create();
        $trailerA = Trailer::factory()->create();
        $trailerB = Trailer::factory()->create();

        $trailerA->tags()->attach($tag);
        $trailerB->tags()->attach($tag);

        $this->assertCount(2, $tag->trailers);
    }

    /** @test */
    public function a_tag_can_be_associated_with_no_trailers()
    {
        $tag = Tag::factory()->create();

        $this->assertEmpty($tag->trailers);
    }
}
