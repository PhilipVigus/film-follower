<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class Watched extends Component
{
    /** @var Collection */
    public $films;

    /** @var Collection */
    public $searchKeys;

    /** @var string */
    public $highlightedFilmId;

    public function mount()
    {
        $this->highlightedFilmId = (int) request('film');

        $this->films = $this->highlightedFilmId
            ? $this->getFilmsWithHighlightedFilm()
            : $this->getFilmsWithoutHighlightedFilm()
        ;

        $this->searchKeys = collect(['title', 'tags.name', 'trailers.type', 'priorities.comment', 'reviews.comment']);
    }

    public function getFilmsWithHighlightedFilm(): Collection
    {
        $films = Auth::user()
            ->watchedFilms()
            ->with(['reviews' => function ($query) {
                $query->where('user_id', '=', Auth::id());
            }])
            ->with('tags', 'trailers', 'priorities', 'reviews')
            ->get()
        ;

        return $this->films = $films->where('id', '=', $this->highlightedFilmId)
            ->merge(
                $films->where('id', '!==', $this->highlightedFilmId)
            )
        ;
    }

    public function getFilmsWithoutHighlightedFilm(): Collection
    {
        return Auth::user()
            ->watchedFilms()
            ->with(['reviews' => function ($query) {
                $query->where('user_id', '=', Auth::id());
            }])
            ->with('tags', 'trailers', 'priorities', 'reviews')
            ->get()
        ;
    }

    public function render()
    {
        return view('livewire.watched');
    }
}
