<?php

namespace App\Http\Livewire\Modals;

use App\Models\Film;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class RemoveFromShortlist extends Component
{
    /** @var Film */
    public $film;

    public function mount(array $data = [])
    {
        $this->film = $data['film'] ?? null;
    }

    public function removeFromShortlist(Film $film, bool $deletePriorityDetails)
    {
        if ($deletePriorityDetails) {
            Auth::user()
                ->priorities()
                ->where('film_id', '=', $film->id)
                ->delete()
            ;
        }

        Auth::user()
            ->films()
            ->updateExistingPivot(
                $film,
                ['status' => Film::TO_SHORTLIST]
            )
        ;

        $this->emitTo('modal', 'close');

        return redirect()->to(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.modals.remove-from-shortlist');
    }
}
