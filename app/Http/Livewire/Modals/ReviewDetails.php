<?php

namespace App\Http\Livewire\Modals;

use App\Models\Film;
use App\Models\Review;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ReviewDetails extends Component
{
    /** @var Film */
    public $film;

    /** @var Review */
    public $review;

    public function mount(array $data = [])
    {
        $this->film = $data['film'] ?? null;

        $this->review = Auth::user()
            ->reviews()
            ->where('film_id', '=', $this->film['id'])
            ->first()
        ;
    }

    public function addReview(Film $film, int $rating, string $comment)
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

        $this->emit('refresh-film-list');
    }

    public function render()
    {
        return view('livewire.modals.review-details');
    }
}
