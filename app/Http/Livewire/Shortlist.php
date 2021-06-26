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

    public function mount()
    {
        $this->films = $this->getShortlistedFilms();
    }

    public function unshortlist(Film $film)
    {
        Auth::user()->films()->updateExistingPivot($film, ['status' => Film::TO_SHORTLIST]);

        $this->films = $this->getShortlistedFilms();
    }

    public function getShortlistedFilms()
    {
        return Auth::user()
            ->shortlistedFilms()
            ->with(['priorities' => function($query) {
                $query->where('user_id', '=', Auth::id());
            }])
            ->get()
        ;
    }

    public function render()
    {
        return view('livewire.shortlist');
    }
}
