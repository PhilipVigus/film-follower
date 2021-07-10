<?php

namespace App\Http\Livewire\Modals;

use App\Models\Film;
use Livewire\Component;
use App\Models\Priority;
use Illuminate\Support\Facades\Auth;

class PriorityDetails extends Component
{
    /** @var Film */
    public $film;

    /** @var Priority */
    public $priority;

    public function mount(array $data = [])
    {
        $this->film = $data['film'] ?? null;

        $this->priority = Auth::user()
            ->priorities()
            ->where('film_id', '=', $this->film['id'])
            ->first()
        ;
    }

    public function shortlist(Film $film, string $level, string $comment)
    {
        Auth::user()
            ->priorities()
            ->updateOrCreate(
                ['film_id' => $film->id],
                ['level' => $level, 'comment' => $comment]
            )
        ;

        Auth::user()
            ->films()
            ->updateExistingPivot(
                $film,
                ['status' => Film::SHORTLISTED]
            )
        ;

        $this->emit('refresh-film-list');
    }

    public function render()
    {
        return view('livewire.modals.priority-details');
    }
}
