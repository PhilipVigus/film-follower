<?php

namespace App\Http\Livewire;

use App\Models\Film;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Livewire\Traits\UsesPriorityDetailsModal;

class Shortlist extends Component
{
    use UsesPriorityDetailsModal;

    /** @var Collection */
    public $films;

    /** @var bool */
    public $deletePriorityDetails = true;

    protected $listeners = [
        'shortlist' => 'shortlist',
        'remove-from-shortlist' => 'removeFromShortlist',
        'add-review' => 'addReview',
    ];

    public function mount()
    {
        $this->films = $this->getFilms();
    }

    public function unshortlist(Film $film)
    {
        Auth::user()->films()->updateExistingPivot($film, ['status' => Film::TO_SHORTLIST]);

        $this->films = $this->getFilms();
    }

    public function getFilms()
    {
        return Auth::user()
            ->shortlistedFilms()
            ->with(['priorities' => function ($query) {
                $query->where('user_id', '=', Auth::id());
            }])
            ->get()
        ;
    }

    public function openRemoveFromShortlistDialog(Film $film)
    {
        $this->emitTo(
            'modal',
            'open',
            'removeFromShortlistDialog',
            [
                'film' => $film,
            ]
        );
    }

    public function openReviewDetailsDialog(Film $film)
    {
        $review = Auth::user()
            ->reviews()
            ->where('film_id', '=', $film->id)
            ->first()
        ;

        $this->emitTo(
            'modal',
            'open',
            'reviewDetailDialog',
            [
                'film' => $film,
                'review' => $review,
            ]
        );
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

        $this->films = $this->getFilms();
    }

    public function addReview(Film $film, string $rating, string $comment)
    {
        Auth::user()
            ->reviews()
            ->updateOrCreate(
                ['film_id' => $film->id],
                ['rating' => $rating, 'comment' => $comment]
            )
        ;

        Auth::user()
            ->films()
            ->updateExistingPivot(
                $film,
                ['status' => Film::WATCHED]
            )
        ;

        $this->films = $this->getFilms();
    }

    public function render()
    {
        return view('livewire.shortlist');
    }
}
