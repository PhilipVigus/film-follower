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
    public function a_user_can_view_page()
    {
        $response = $this->actingAs(User::factory()->create())->get(route('films'));

        $response->assertSuccessful();
        $response->assertViewIs('films');
    }

    /** @test */
    public function the_list_includes_all_movies_the_user_has_to_shortlist()
    {
        $firstFilm = Film::factory()->create();
        $secondFilm = Film::factory()->create();

        $response = Livewire::test(Films::class);

        $this->assertCount(2, $response->films);
        $this->assertEquals($response->films[0]->id, $firstFilm->id);
        $this->assertEquals($response->films[1]->id, $secondFilm->id);
    }
}
