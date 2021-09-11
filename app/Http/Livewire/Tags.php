<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Tags extends Component
{
    /** @var Collection */
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

        $this->allTags = Tag::query()
            ->withCount('films')
            ->orderByDesc('films_count')
            ->orderBy('name')
            ->get()
        ;

        $this->ignoredTrailerTitlePhrases = Auth::user()
            ->ignoredTrailerTitlePhrases()
            ->get()
        ;
    }

    public function toggleIgnoredFilmTag(Tag $tag)
    {
        Auth::user()->ignoredTags()->where(['tags.id' => $tag->id])->exists() ?
            Auth::user()->ignoredTags()->detach($tag) :
            Auth::user()->ignoredTags()->attach($tag)
        ;
    }

    public function hydrate()
    {
        $this->allTags = Tag::query()
            ->withCount('films')
            ->orderByDesc('films_count')
            ->orderBy('name')
            ->get()
        ;
    }

    public function render()
    {
        return view('livewire.tags');
    }
}
