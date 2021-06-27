<?php

namespace Tests\Unit;

use PDOException;
use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use App\Models\Priority;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PriorityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_priorities_table_has_the_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('priorities', [
                'id', 'user_id', 'film_id', 'priority', 'comment',
            ])
        );
    }

    /** @test */
    public function a_priority_relates_to_a_film()
    {
        $priority = Priority::factory()->create();

        $this->assertInstanceOf(Film::class, $priority->film);
    }

    /** @test */
    public function a_priority_must_relate_to_a_film()
    {
        $this->expectException(PDOException::class);

        Priority::factory()->create(['film_id' => null]);
    }

    /** @test */
    public function a_priority_is_belongs_to_a_user()
    {
        $priority = Priority::factory()->create();

        $this->assertInstanceOf(User::class, $priority->user);
    }

    /** @test */
    public function a_priority_must_belong_to_a_user()
    {
        $this->expectException(PDOException::class);

        Priority::factory()->create(['user_id' => null]);
    }

    /** @test */
    public function two_priorities_must_not_have_the_same_user_and_film()
    {
        $user = User::factory()->create();
        $film = Film::factory()->create();

        Priority::factory()->create(['user_id' => $user->id, 'film_id' => $film->id]);

        $this->expectException(PDOException::class);

        Priority::factory()->create(['user_id' => $user->id, 'film_id' => $film->id]);
    }
}
