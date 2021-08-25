<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Film as FilmModel;
use Illuminate\Support\Facades\Auth;

class Film extends Component
{
    /** @var FilmModel */
    public $film;

    /** @var string */
    public $status;

    public function mount(FilmModel $film)
    {
        $this->film = $film;
        $film->load('trailers');

        $this->status = Auth::user()
            ->films()
            ->where('films.id', $film->id)
            ->withPivot('status')
            ->get()
            ->first()
            ->pivot
            ->status
        ;
    }

    public function render()
    {
        return view('livewire.film');
    }
}
