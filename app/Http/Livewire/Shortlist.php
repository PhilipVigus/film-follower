<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class Shortlist extends Component
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

        $this->films = $this->highlightedFilmId ? $this->getFilmsWithHighlightedFilm() : $this->getFilmsWithoutHighlightedFilm();

        $this->searchKeys = collect(['title', 'tags.name', 'trailers.type', 'priorities.comment']);
    }

    public function getFilmsWithHighlightedFilm()
    {
        $films = Auth::user()
            ->shortlistedFilms()
            ->with(['priorities' => function ($query) {
                $query->where('user_id', '=', Auth::id());
            }])
            ->with('tags', 'trailers')
            ->get()
            ->sortByDesc(function ($film, $key) {
                return $film->priorities->first()->rating;
            })
        ;

        return $this->films = $films->where('id', '=', $this->highlightedFilmId)
            ->merge(
                $films->where('id', '!==', $this->highlightedFilmId)
            )
        ;
    }

    public function getFilmsWithoutHighlightedFilm()
    {
        return Auth::user()
            ->shortlistedFilms()
            ->with(['priorities' => function ($query) {
                $query->where('user_id', '=', Auth::id());
            }])
            ->with('tags', 'trailers')
            ->get()
            ->sortByDesc(function ($film, $key) {
                return $film->priorities->first()->rating;
            })
        ;
    }

    public function render()
    {
        return view('livewire.shortlist');
    }
}
