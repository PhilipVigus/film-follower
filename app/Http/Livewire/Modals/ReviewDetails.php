<?php

namespace App\Http\Livewire\Modals;

use App\Models\Film;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ReviewDetails extends Component
{
    /** @var Film */
    public $film;

    /** @var int */
    public $rating = 0;

    /** @var string */
    public $comment = '';

    /** @var array */
    protected $rules = [
        'rating' => 'min:1|max:5|integer',
        'comment' => 'nullable|string',
    ];

    public function mount(array $data = [])
    {
        $this->film = $data['film'] ?? null;

        $review = Auth::user()
            ->reviews()
            ->where('film_id', '=', $this->film['id'])
            ->firstOrNew()
        ;

        $this->rating = $review->rating;
        $this->comment = $review->comment;
    }

    public function submit()
    {
        $this->validate();

        Auth::user()
            ->reviews()
            ->updateOrCreate(
                ['film_id' => $this->film['id']],
                ['rating' => $this->rating, 'comment' => $this->comment]
            )
        ;

        Auth::user()
            ->films()
            ->updateExistingPivot(
                $this->film['id'],
                ['status' => Film::WATCHED]
            )
        ;

        $this->emitTo('modal', 'close');

        return redirect()->to(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.modals.review-details');
    }
}
