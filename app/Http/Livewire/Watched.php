<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class Watched extends Component
{
    /** @var Collection */
    public $films;

    public function mount()
    {
        $this->films = $this->getFilms();
    }

    public function getFilms()
    {
        return Auth::user()
            ->watchedFilms()
            ->with(['reviews' => function ($query) {
                $query->where('user_id', '=', Auth::id());
            }])->get()
        ;
    }

    public function render()
    {
        return view('livewire.watched');
    }
}
