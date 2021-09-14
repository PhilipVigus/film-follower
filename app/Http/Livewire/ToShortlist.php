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
            ->where('films.id', '<>', $this->highlightedFilmId)
            ->with('tags')
            ->with(['trailers' => function ($query) {
                $query->withoutIgnoredPhrases(Auth::user());
            }])
            ->get()
            ->when($this->highlightedFilmId, function ($collection) {
                return $collection->prepend(
                    Film::query()
                        ->where('id', $this->highlightedFilmId)
                        ->with('tags', 'trailers')
                        ->get()
                        ->first()
                );
            })
            ->filter(function ($film) {
                return $film->trailers->isNotEmpty();
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

    public function render()
    {
        return view('livewire.to-shortlist');
    }
}
