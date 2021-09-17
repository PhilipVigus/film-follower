<?php

namespace App\Http\Livewire;

use App\Models\Film;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class Reviewed extends Component
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

        $this->searchKeys = collect(['title', 'tags.name', 'trailers.type', 'priorities.comment', 'reviews.comment']);
    }

    public function getFilms(): Collection
    {
        return Auth::user()
            ->reviewedFilms()
            ->with([
                'trailers' => function ($query) {
                    $query->withoutIgnoredPhrases(Auth::user());
                },
                'priorities' => function ($query) {
                    $query->where('user_id', '=', Auth::id());
                },
                'reviews' => function ($query) {
                    $query->where('user_id', '=', Auth::id());
                },
                'tags',
            ])
            ->get()
            ->filter(function ($film) {
                return $film->trailers->isNotEmpty();
            })
            ->sort(function ($a, $b) {
                return $this->highlightedFilmId && $this->isHighlightedFilm($b)
                    ? $this->bringHighlightedFilmToTop()
                    : $this->sortByCreatedAt($a, $b)
                ;
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

    private function sortByCreatedAt($a, $b)
    {
        return $a->created_at->timestamp <=> $b->created_at->timestamp;
    }

    public function render()
    {
        return view('livewire.reviewed');
    }
}
