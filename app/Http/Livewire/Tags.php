<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Tags extends Component
{
    /** @var string */
    public $allTags;

    /** @var Collection */
    public $ignoredFilmTagIds;

    /** @var Collection */
    public $ignoredTrailerTitlePhrases;

    public function mount()
    {
        $this->ignoredFilmTagIds = Auth::user()
            ->ignoredTags()
            ->get()
            ->pluck('id')
        ;

        $this->allTags = json_encode(Tag::query()
            ->withCount('films')
            ->orderByDesc('films_count')
            ->orderBy('name')
            ->get()
            ->toArray())
        ;

        $this->ignoredTrailerTitlePhrases = Auth::user()
            ->ignoredTrailerTitlePhrases()
            ->get()
            ->pluck('phrase')
        ;
    }

    public function toggleIgnoredFilmTag(Tag $tag)
    {
        Auth::user()->ignoredTags()->where(['tags.id' => $tag->id])->exists() ?
            Auth::user()->ignoredTags()->detach($tag) :
            Auth::user()->ignoredTags()->attach($tag)
        ;
    }

    public function addPhrase(string $phrase)
    {
        Auth::user()->ignoredTrailerTitlePhrases()->create(['phrase' => $phrase]);
    }

    public function removePhrase(string $phrase)
    {
        Auth::user()->ignoredTrailerTitlePhrases()->where('phrase', $phrase)->delete();
    }

    public function render()
    {
        return view('livewire.tags');
    }
}
