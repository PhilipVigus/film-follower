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
            ->withCount('films')
            ->get()
        ;

        $this->ignoredTrailerTags = Auth::user()
            ->ignoredTrailerTags()
            ->withCount('films')
            ->get()
        ;

        $this->allTags = Tag::all();
    }

    public function render()
    {
        return view('livewire.tags');
    }
}
