<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IgnoredTrailerTitlePhraseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_ignored_trailer_title_phrases_table_has_the_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('ignored_trailer_title_phrases', [
                'id', 'user_id', 'phrase',
            ])
        );
    }
}
