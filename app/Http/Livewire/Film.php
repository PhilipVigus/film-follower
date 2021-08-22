<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Film as FilmModel;

class Film extends Component
{
    /** @var FilmModel */
    public $film;

    public function mount(FilmModel $film)
    {
        $this->film = $film;
        $film->load('trailers');
    }

    public function render()
    {
        return view('livewire.film');
    }
}
