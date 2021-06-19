<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Films;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowFilmsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_logged_in_user_can_view_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('films'));

        $response->assertSuccessful();
        $response->assertViewIs('films');
    }

    /** @test */
    public function a_guest_user_is_redirected_to_the_login_page()
    {
        $response = $this->get(route('films'));

        $response->assertRedirect('login');
    }

    /** @test */
    public function the_list_includes_all_movies_the_user_has_to_shortlist()
    {
        $firstFilm = Film::factory()->create();
        $secondFilm = Film::factory()->create();
        $shortlistedFilm = Film::factory()->create();

        $user = User::factory()->create();

        $user->films()->updateExistingPivot($shortlistedFilm, ['status' => Film::SHORTLISTED]);

        $response = Livewire::actingAs($user)->test(Films::class);

        $this->assertCount(2, $response->films);
        $this->assertEquals($response->films[0]->id, $firstFilm->id);
        $this->assertEquals($response->films[1]->id, $secondFilm->id);
    }
}
