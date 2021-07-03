<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Livewire\Traits\UsesPriorityDetailsModal;

class ToShortlist extends Component
{
    use UsesPriorityDetailsModal;

    /** @var Collection */
    public $films;

    protected $listeners = ['shortlist' => 'shortlist'];

    public function mount()
    {
        $this->films = $this->getFilms();
    }

    public function getFilms()
    {
        return Auth::user()
            ->filmsToShortlist()
            ->with('trailers')
            ->get()
        ;
    }

    public function render()
    {
        return view('livewire.to-shortlist');
    }
}
