<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Film as LivewireFilm;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowFilmTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_logged_in_user_can_view_the_page()
    {
        $user = User::factory()->create();
        $film = Film::factory()->hasTrailers()->create();

        $response = $this->actingAs($user)->get(route('film', ['film' => $film]));

        $response->assertSuccessful();
        $response->assertViewIs('film');
    }

    /** @test */
    public function a_guest_user_is_redirected_to_the_login_page()
    {
        $film = Film::factory()->hasTrailers()->create();

        $response = $this->get(route('film', ['film' => $film]));

        $response->assertRedirect('login');
    }

    /** @test */
    public function it_shows_the_specified_film()
    {
        $user = User::factory()->create();
        $film = Film::factory()->hasTrailers()->create();

        $response = $this->actingAs($user)->get(route('film', ['film' => $film]));

        $response = Livewire::actingAs($user)
            ->test(LivewireFilm::class, ['film' => $film])
        ;

        $this->assertEquals($film->id, $response->film->id);
    }
}
