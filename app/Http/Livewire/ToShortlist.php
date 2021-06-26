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

    protected $listeners = ['shortlist' => 'shortlistFilm'];

    public function mount()
    {
        $this->films = $this->getFilmsToShortlist();
    }

    public function shortlist(Film $film)
    {
        Auth::user()->films()->updateExistingPivot($film, ['status' => Film::SHORTLISTED]);

        $this->films = $this->getFilmsToShortlist();
    }

    public function getFilmsToShortlist()
    {
        return Auth::user()
            ->filmsToShortlist()
            ->with('trailers')
            ->get()
        ;
    }

    public function openShortlistModal(Film $film)
    {
        $this->emitTo('modal', 'open', 'shortlist', ['film' => $film]);
    }

    public function render()
    {
        return view('livewire.to-shortlist');
    }
}
