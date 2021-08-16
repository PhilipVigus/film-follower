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
    public $ignoredTrailerTags;

    /** @var Collection */
    public $allTags;

    /** @var Collection */
    public $ignoredFilmTagIds;

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
            ->ignoredFilmTags()
            ->get()
            ->makeHidden('pivot')
            ->pluck('id')
        ;

        $this->ignoredTrailerTags = Auth::user()
            ->ignoredTrailerTags()
            ->get()
        ;

        $this->allTags = Tag::orderBy('name')->get();
    }

    public function toggleIgnoredFilmTag(Tag $tag)
    {
        Auth::user()->ignoredFilmTags()->where(['tags.id' => $tag->id])->exists() ?
            Auth::user()->ignoredFilmTags()->detach($tag) :
            Auth::user()->ignoredFilmTags()->attach($tag)
        ;
    }

    public function render()
    {
        return view('livewire.tags');
    }
}
