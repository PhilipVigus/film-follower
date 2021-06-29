<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\CanCreateOrEditShortlistPriority;
use App\Models\Film;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class Shortlist extends Component
{
    use CanCreateOrEditShortlistPriority;

    /** @var Collection */
    public $films;

    protected $listeners = ['shortlist' => 'shortlist'];

    public function mount()
    {
        $this->films = $this->getFilms();
    }

    public function unshortlist(Film $film)
    {
        Auth::user()->films()->updateExistingPivot($film, ['status' => Film::TO_SHORTLIST]);

        $this->films = $this->getFilms();
    }

    public function getFilms()
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
