<?php

namespace Tests\Unit;

use Tests\TestCase;
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
}
