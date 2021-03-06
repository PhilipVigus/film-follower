<?php

namespace Tests\Feature;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Tags;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTagsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_logged_in_user_can_view_the_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tags'));

        $response->assertSuccessful();
        $response->assertSeeLivewire('tags');
    }

    /** @test */
    public function a_guest_user_is_redirected_to_the_login_page()
    {
        $tag = Tag::factory()->create();

        $response = $this->get(route('tags'));

        $response->assertRedirect('login');
    }

    /** @test */
    public function you_can_ignore_a_tag()
    {
        $user = User::factory()->create();

        $tag = Tag::factory()->create();

        Livewire::actingAs($user)
            ->test(Tags::class)
            ->call('toggleIgnoredFilmTag', $tag)
        ;

        $this->assertCount(1, $user->ignoredTags);
        $this->assertEquals($tag->id, $user->ignoredTags->first()->id);
    }

    /** @test */
    public function you_can_unignore_a_tag()
    {
        $user = User::factory()->create();

        $tag = Tag::factory()->create();

        Livewire::actingAs($user)
            ->test(Tags::class)
            ->call('toggleIgnoredFilmTag', $tag)
            ->call('toggleIgnoredFilmTag', $tag)
        ;

        $this->assertEmpty($user->ignoredTags);
    }

    /** @test */
    public function you_can_add_a_trailer_phrase_to_ignore()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Tags::class)
            ->call('addPhrase', 'test phrase')
        ;

        $this->assertCount(1, $user->ignoredTrailerTitlePhrases);
        $this->assertEquals('test phrase', $user->ignoredTrailerTitlePhrases->first()->phrase);
    }

    /** @test */
    public function you_can_remove_a_trailer_phrase()
    {
        $user = User::factory()->create();
        $user->ignoredTrailerTitlePhrases()->create(['phrase' => 'test phrase']);

        Livewire::actingAs($user)
            ->test(Tags::class)
            ->call('removePhrase', 'test phrase')
        ;

        $this->assertEmpty($user->ignoredTrailerTitlePhrases);
    }
}
