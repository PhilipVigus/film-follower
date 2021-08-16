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
    public $ignoredFilmTags;

    /** @var Collection */
    public $ignoredTrailerTags;

    /** @var Collection */
    public $allTags;

    public function mount()
    {
        $this->mostCommonTags = Tag::query()
            ->withCount('films')
            ->orderByDesc('films_count')
            ->orderBy('name')
            ->limit(50)
            ->get()
        ;

        $this->ignoredFilmTags = Auth::user()
            ->ignoredFilmTags()
            ->get()
        ;

        $this->ignoredTrailerTags = Auth::user()
            ->ignoredTrailerTags()
            ->withCount('films')
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
