<?php

namespace App\Http\Livewire;

use App\Models\Film;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class ToShortlist extends Component
{
    /** @var Collection */
    public $films;

    /** @var Collection */
    public $searchKeys;

    /** @var string */
    public $highlightedFilmId;

    /** @var array */
    public function mount()
    {
        $this->highlightedFilmId = (int) request('film');

        $this->films = $this->getFilms();

        $this->searchKeys = collect(['title', 'tags.name', 'trailers.type']);
    }

    public function getFilms(): Collection
    {
        return Auth::user()
            ->filmsToShortlist()
            ->withoutIgnoredTags(Auth::user())
            ->with([
                'trailers' => function ($query) {
                    $query->withoutIgnoredPhrases(Auth::user());
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

                return $this->sortByCreatedAt($a, $b)
                ;
            })
        ;
    }

    public function ignoreFilm(Film $film)
    {
        Auth::user()
            ->films()
            ->updateExistingPivot(
                $film,
                ['status' => Film::IGNORED]
            )
        ;

        return redirect()->to(request()->header('Referer'));
    }

    private function isHighlightedFilm(Film $film)
    {
        return $film->id === $this->highlightedFilmId;
    }

    private function sortByCreatedAt($a, $b)
    {
        return $a->created_at->timestamp <=> $b->created_at->timestamp;
    }

    public function render()
    {
        return view('livewire.to-shortlist');
    }
}
