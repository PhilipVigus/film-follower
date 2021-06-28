<?php

namespace App\Http\Livewire\Traits;

use App\Models\Film;
use Illuminate\Support\Facades\Auth;

trait CanCreateOrEditShortlistPriority {
    public function shortlist(Film $film, string $priority, string $comment)
    {
        Auth::user()->priorities()->updateOrCreate(['film_id' => $film->id], ['priority' => $priority, 'comment' => $comment]);
        Auth::user()->films()->updateExistingPivot($film, ['status' => Film::SHORTLISTED]);

        $this->films = $this->getFilms();
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
}
