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

    /** @var array */
    protected $listeners = [
        'refresh-film-list' => 'refreshFilms',
    ];

    public function mount()
    {
        $this->refreshFilms();
    }

    public function refreshFilms()
    {
        $this->films = Auth::user()
            ->filmsToShortlist()
            ->withoutIgnoredTags(Auth::user())
            ->with('tags')
            ->get()
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

        $this->refreshFilms();
    }

    public function render()
    {
        return view('livewire.to-shortlist');
    }
}
