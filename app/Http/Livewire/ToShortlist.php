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

    /** @var Collection */
    public $searchKeys;

    /** @var array */
    public function mount()
    {
        $this->films = Auth::user()
            ->filmsToShortlist()
            ->withoutIgnoredTags(Auth::user())
            ->with('tags', 'trailers')
            ->get()
            ->filter(function ($film) {
                return $film->trailers->isNotEmpty();
            })
        ;

        $this->searchKeys = collect(['title', 'tags.name', 'trailers.type']);
    }

    public function ignoreFilm(Film $film)
    {
        Auth::user()
            ->films()
            ->updateExistingPivot(
                $film,
                ['status' => Film::IGNORED]
            )
        ;

        return redirect()->to(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.to-shortlist');
    }
}
