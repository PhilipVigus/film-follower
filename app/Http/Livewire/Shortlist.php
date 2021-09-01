<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class Shortlist extends Component
{
    /** @var Collection */
    public $films;

    /** @var Collection */
    public $searchKeys;

    public function mount()
    {
        $this->films = Auth::user()
            ->shortlistedFilms()
            ->with(['priorities' => function ($query) {
                $query->where('user_id', '=', Auth::id());
            }])
            ->with('tags', 'trailers')
            ->get()
            ->sortByDesc(function ($film, $key) {
                return $film->priorities->first()->rating;
            })
        ;

        $this->searchKeys = collect(['title', 'tags.name', 'trailers.type', 'priorities.comment']);
    }

    public function render()
    {
        return view('livewire.shortlist');
    }
}
