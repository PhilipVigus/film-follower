<?php

namespace App\Http\Livewire;

use App\Models\Film;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class Films extends Component
{
    /** @var Collection */
    public $films;

    public function mount()
    {
        $this->films = Film::all();
    }

    public function render()
    {
        return view('livewire.films');
    }
}
