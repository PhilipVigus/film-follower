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

    // /** @var Priority */
    // public $priority;

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

        $priority = Auth::user()
            ->priorities()
            ->where('film_id', '=', $this->film['id'])
            ->firstOrNew()
        ;

        $this->rating = $priority->rating;
        $this->comment = $priority->comment;
    }

    public function shortlist(Film $film, int $rating, string $comment)
    {
        Auth::user()
            ->priorities()
            ->updateOrCreate(
                ['film_id' => $film->id],
                ['rating' => $rating, 'comment' => $comment]
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

    public function submit()
    {
        $this->validate();

        Auth::user()
            ->priorities()
            ->updateOrCreate(
                ['film_id' => $this->film['id']],
                ['rating' => $this->rating, 'comment' => $this->comment]
            )
        ;

        Auth::user()
            ->films()
            ->updateExistingPivot(
                $this->film['id'],
                ['status' => Film::SHORTLISTED]
            )
        ;

        $this->emitTo('modal', 'close');
        $this->emit('refresh-film-list');
    }

    public function render()
    {
        return view('livewire.modals.priority-details');
    }
}
