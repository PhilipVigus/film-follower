<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class Watched extends Component
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
            ->watchedFilms()
            ->with(['reviews' => function ($query) {
                $query->where('user_id', '=', Auth::id());
            }])
            ->with('newTags')
            ->get()
        ;
    }

    public function render()
    {
        return view('livewire.watched');
    }
}
