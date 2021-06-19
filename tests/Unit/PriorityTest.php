<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PriorityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_trailers_table_has_the_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('priorities', [
                'id', 'user_id', 'film_id', 'level', 'note',
            ])
        );
    }
}
