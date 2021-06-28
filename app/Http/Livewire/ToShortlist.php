<?php

namespace App\Http\Livewire;

use App\Models\Film;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class ToShortlist extends Component
{
    /** @var Collection */
    public $films;

    protected $listeners = ['shortlist' => 'shortlist'];

    public function mount()
    {
        $this->films = $this->getFilmsToShortlist();
    }

    public function shortlist(Film $film, string $priority, string $comment)
    {
        Auth::user()->priorities()->updateOrCreate(['film_id' => $film->id], ['priority' => $priority, 'comment' => $comment]);
        Auth::user()->films()->updateExistingPivot($film, ['status' => Film::SHORTLISTED]);

        $this->films = $this->getFilmsToShortlist();
    }

    public function getFilmsToShortlist()
    {
        return Auth::user()
            ->filmsToShortlist()
            ->with('trailers')
            ->get()
        ;
    }

    public function openPriorityDetailsDialog(Film $film)
    {
        $priority = Auth::user()
            ->priorities()
            ->where('film_id', '=', $film->id)
            ->first()
        ;

        $this->emitTo(
            'modal',
            'open',
            'priorityDetailsDialog',
            [
                'film' => $film,
                'priority' => $priority
            ]
        );
    }

    public function render()
    {
        return view('livewire.to-shortlist');
    }
}
