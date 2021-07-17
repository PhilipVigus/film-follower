<?php

namespace App\Http\Livewire;

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
            ->has('trailers')
            ->with('trailers', 'tags')
            ->get()
        ;
    }

    public function render()
    {
        return view('livewire.to-shortlist');
    }
}
