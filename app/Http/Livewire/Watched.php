<?php

namespace App\Http\Livewire;

use App\Models\Film;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class Watched extends Component
{
    /** @var Collection */
    public $films;

    protected $listeners = [
        'remove-review' => 'removeReview',
    ];

    public function mount()
    {
        $this->films = $this->getFilms();
    }

    public function getFilms()
    {
        return Auth::user()
            ->watchedFilms()
            ->with(['reviews' => function ($query) {
                $query->where('user_id', '=', Auth::id());
            }])->get()
        ;
    }

    public function openRemoveReviewDialog(Film $film)
    {
        $review = Auth::user()
            ->reviews()
            ->where('film_id', '=', $film->id)
            ->first()
        ;

        $this->emitTo(
            'modal',
            'open',
            'removeReviewDialog',
            [
                'film' => $film,
                'review' => $review,
            ]
        );
    }

    public function removeReview(Film $film, bool $removeReviewDetails)
    {
        if ($removeReviewDetails) {
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

        $this->films = $this->getFilms();
    }

    public function render()
    {
        return view('livewire.watched');
    }
}
