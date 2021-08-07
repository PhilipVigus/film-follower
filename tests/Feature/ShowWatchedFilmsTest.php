<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Watched;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowWatchedFilmsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_logged_in_user_can_view_the_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('watched'));

        $response->assertSuccessful();
        $response->assertViewIs('watched');
    }

    /** @test */
    public function a_guest_user_is_redirected_to_the_login_page()
    {
        $response = $this->get(route('watched'));

        $response->assertRedirect('login');
    }

    /** @test */
    public function the_list_includes_all_films_the_user_has_watched()
    {
        Film::factory()->hasTrailers(2)->create();
        $watchedFilm = Film::factory()->hasTrailers(2)->create();

        $user = User::factory()->create();

        $user->films()->updateExistingPivot($watchedFilm, ['status' => Film::WATCHED]);
        $user->priorities()->create(['film_id' => $watchedFilm->id, 'rating' => 2]);
        $user->reviews()->create(['film_id' => $watchedFilm->id, 'rating' => 2]);

        $response = Livewire::actingAs($user)->test(Watched::class);

        $this->assertCount(1, $response->films);
        $this->assertEquals($response->films[0]->id, $watchedFilm->id);
    }
}
