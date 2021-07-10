<?php

namespace App\Http\Livewire\Modals;

use App\Models\Film;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Ignore extends Component
{
    /** @var Film */
    public $film;

    public function mount(array $data = [])
    {
        $this->film = $data['film'] ?? null;
    }

    public function ignoreFilm(Film $film)
    {
        Auth::user()
            ->films()
            ->updateExistingPivot(
                $film,
                ['status' => Film::IGNORED]
            )
        ;

        $this->emit('refresh-film-list');
    }

    public function render()
    {
        return view('livewire.modals.ignore');
    }
}
