<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class Shortlist extends Component
{
    /** @var Collection */
    public $films;

    public function mount()
    {
        $this->films = Auth::user()
            ->shortlistedFilms()
            ->with('trailers')
            ->get()
        ;
    }

    public function render()
    {
        return view('livewire.shortlist');
    }
}
