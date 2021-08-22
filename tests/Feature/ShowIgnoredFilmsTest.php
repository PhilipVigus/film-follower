<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Ignored;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowIgnoredFilmsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_logged_in_user_can_view_the_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('ignored'));

        $response->assertSuccessful();
        $response->assertViewIs('ignored');
    }

    /** @test */
    public function a_guest_user_is_redirected_to_the_login_page()
    {
        $response = $this->get(route('ignored'));

        $response->assertRedirect('login');
    }

    /** @test */
    public function the_list_includes_all_films_the_user_has_ignored()
    {
        Film::factory()->hasTrailers(2)->create();
        $ignoredFilm = Film::factory()->hasTrailers(2)->create();

        $user = User::factory()->create();

        $user->films()->updateExistingPivot($ignoredFilm, ['status' => Film::IGNORED]);

        $response = Livewire::actingAs($user)->test(Ignored::class);

        $this->assertCount(1, $response->ignoredFilms);
        $this->assertEquals($response->ignoredFilms[0]->id, $ignoredFilm->id);
    }

    /** @test */
    public function you_can_unignore_a_film()
    {
        Film::factory()->hasTrailers(2)->create();
        $ignoredFilm = Film::factory()->hasTrailers(2)->create();

        $user = User::factory()->create();

        $user->films()->updateExistingPivot($ignoredFilm, ['status' => Film::IGNORED]);

        $response = Livewire::actingAs($user)
            ->test(Ignored::class)
            ->call('unignoreFilm', $ignoredFilm)
        ;

        $this->assertEmpty($response->ignoredFilms);
    }
}
