<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Modals\Unignore;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnignoreFilmTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function you_can_ignore_a_film()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        $user->films()
            ->updateExistingPivot(
                $film,
                ['status' => Film::IGNORED]
            )
        ;

        Livewire::actingAs($user)
            ->test(Unignore::class, ['data' => ['film' => $film->toArray()]])
            ->call('unignoreFilm', $film)
        ;

        $this->assertEmpty($user->ignoredFilms);
        $this->assertCount(1, $user->filmsToShortlist);
    }
}
