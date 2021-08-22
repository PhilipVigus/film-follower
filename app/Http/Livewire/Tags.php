<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Tags extends Component
{
    /** @var Collection */
    public $mostCommonTags;

    /** @var Collection */
    public $allTags;

    /** @var Collection */
    public $ignoredFilmTagIds;

    /** @var Collection */
    public $ignoredTrailerTagIds;

    public function mount()
    {
        $this->mostCommonTags = Tag::query()
            ->withCount('films')
            ->orderByDesc('films_count')
            ->orderBy('name')
            ->limit(50)
            ->get()
        ;

        $this->ignoredFilmTagIds = Auth::user()
            ->ignoredTags()
            ->get()
            ->pluck('id')
        ;

        $this->allTags = Tag::orderBy('name')->get();
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
        $this->mostCommonTags = Tag::query()
            ->withCount('films')
            ->orderByDesc('films_count')
            ->orderBy('name')
            ->limit(50)
            ->get()
        ;
    }

    public function updating()
    {
        info('updating');
    }

    public function render()
    {
        return view('livewire.tags');
    }
}
