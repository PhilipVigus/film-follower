<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Modals\Ignore;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IgnoreFilmTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function you_can_ignore_a_film()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Ignore::class, ['data' => ['film' => $film->toArray()]])
            ->call('ignoreFilm', $film)
        ;

        $this->assertEmpty($user->filmsToShortlist);
        $this->assertCount(1, $user->ignoredFilms);
    }
}
