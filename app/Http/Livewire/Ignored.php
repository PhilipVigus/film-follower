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
    public $filmsWithIgnoredTags;

    /** @var Collection */
    public $ignoredTagsIds;

    /** @var array */
    protected $listeners = [
        'refresh-film-list' => 'refreshFilms',
    ];

    public function mount()
    {
        $this->ignoredTagsIds = Auth::user()->ignoredTags->pluck('id');

        $this->refreshFilms();
    }

    public function refreshFilms()
    {
        $this->films = Auth::user()
            ->ignoredFilms()
            ->with('tags')
            ->get()
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

        $this->refreshFilms();
    }

    public function render()
    {
        return view('livewire.ignored');
    }
}
