<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\CanCreateOrEditPriority;
use App\Http\Livewire\Traits\CanCreateOrEditShortlistPriority;
use App\Models\Film;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class ToShortlist extends Component
{

    use CanCreateOrEditShortlistPriority;

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
