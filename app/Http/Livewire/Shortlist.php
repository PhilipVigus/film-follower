<?php

namespace App\Http\Livewire;

use App\Models\Film;
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

        $this->films = $this->getFilms();

        $this->searchKeys = collect(['title', 'tags.name', 'trailers.type', 'priorities.comment']);
    }

    public function getFilms(): Collection
    {
        return Auth::user()
            ->shortlistedFilms()
            ->with([
                'trailers' => function ($query) {
                    $query->withoutIgnoredPhrases(Auth::user());
                },
                'priorities' => function ($query) {
                    $query->where('user_id', '=', Auth::id());
                },
                'tags',
            ])
            ->get()
            ->filter(function ($film) {
                return $film->trailers->isNotEmpty();
            })
            ->sort(function ($a, $b) {
                if ($this->highlightedFilmId) {
                    if ($this->isHighlightedFilm($b)) {
                        return 1;
                    }

                    if ($this->isHighlightedFilm($a)) {
                        return -1;
                    }
                }

                return $this->sortByRating($a, $b);
            })
        ;
    }

    private function isHighlightedFilm(Film $film)
    {
        return $film->id === $this->highlightedFilmId;
    }

    private function bringHighlightedFilmToTop()
    {
        return 1;
    }

    private function sortByRating($a, $b)
    {
        return $b->priorities->first()->rating <=> $a->priorities->first()->rating;
    }

    public function render()
    {
        return view('livewire.shortlist');
    }
}
