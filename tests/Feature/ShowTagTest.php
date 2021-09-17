<?php

namespace Tests\Feature;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Tag as LivewireTag;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTagTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_logged_in_user_can_view_the_page()
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->create();

        $response = $this->actingAs($user)->get(route('tag', ['tag' => $tag]));

        $response->assertSuccessful();
        $response->assertSeeLivewire('tag');
    }

    /** @test */
    public function a_guest_user_is_redirected_to_the_login_page()
    {
        $tag = Tag::factory()->create();

        $response = $this->get(route('tag', ['tag' => $tag]));

        $response->assertRedirect('login');
    }

    /** @test */
    public function it_shows_all_films_with_the_specified_tag()
    {
        $filmWithTag = Film::factory()->hasTrailers()->create();
        $filmWithoutTag = Film::factory()->hasTrailers()->create();
        $tag = Tag::factory()->create();

        $filmWithTag->tags()->attach($tag);

        $user = User::factory()->create();

        $response = Livewire::actingAs($user)
            ->test(LivewireTag::class, ['tag' => $tag])
        ;

        $this->assertCount(1, $response->films);
        $this->assertEquals($filmWithTag->id, $response->films->first()->id);
    }
}
