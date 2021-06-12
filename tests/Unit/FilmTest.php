<?php

namespace Tests\Unit;

use Tests\TestCase;
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
}
