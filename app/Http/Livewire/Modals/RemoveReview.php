<?php

namespace App\Http\Livewire\Modals;

use App\Models\Film;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class RemoveReview extends Component
{
    /** @var Film */
    public $film;

    public function mount(array $data = [])
    {
        $this->film = $data['film'] ?? null;
    }

    public function removeReview(Film $film, bool $deleteReviewDetails)
    {
        if ($deleteReviewDetails) {
            Auth::user()
                ->reviews()
                ->where('film_id', '=', $film->id)
                ->delete()
            ;
        }

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
        return view('livewire.modals.remove-review');
    }
}
