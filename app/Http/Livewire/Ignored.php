<?php

namespace App\Http\Livewire;

use App\Models\Film;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class Ignored extends Component
{
    /** @var Collection */
    public $films;

    /** @var Collection */
    public $searchKeys;

    public function mount()
    {
        $this->films = $this->getFilms();

        $this->searchKeys = collect(['title', 'tags.name', 'trailers.type']);
    }

    public function getFilms(): Collection
    {
        return Auth::user()
            ->ignoredFilms()
            ->with('tags')
            ->with(['trailers' => function ($query) {
                $query->withoutIgnoredPhrases(Auth::user());
            }])
            ->get()
            ->filter(function ($film) {
                return $film->trailers->isNotEmpty();
            })
        ;
    }

    public function unignoreFilm(Film $film)
    {
        Auth::user()
            ->films()
            ->updateExistingPivot(
                $film,
                ['status' => Film::TO_SHORTLIST]
            )
        ;

        return redirect()->to(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.ignored');
    }
}
