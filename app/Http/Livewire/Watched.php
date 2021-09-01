<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class Watched extends Component
{
    /** @var Collection */
    public $films;

    /** @var Collection */
    public $searchKeys;

    public function mount()
    {
        $this->films = Auth::user()
            ->watchedFilms()
            ->with(['reviews' => function ($query) {
                $query->where('user_id', '=', Auth::id());
            }])
            ->with('tags', 'trailers', 'priorities', 'reviews')
            ->get()
        ;

        $this->searchKeys = collect(['title', 'tags.name', 'trailers.type', 'priorities.comment', 'reviews.comment']);
    }

    public function render()
    {
        return view('livewire.watched');
    }
}
