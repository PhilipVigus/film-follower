<?php

namespace App\Http\Livewire;

use App\Models\Film;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class Ignored extends Component
{
    /** @var Collection */
    public $films;

    /** @var Collection */
    public $filmsWithIgnoredTags;

    /** @var Collection */
    public $ignoredTagsIds;

    public function mount()
    {
        $this->ignoredTagsIds = Auth::user()->ignoredTags->pluck('id');

        $this->films = Auth::user()
            ->ignoredFilms()
            ->with('tags', 'trailers')
            ->get()
        ;
    }

    public function unignoreFilm(Film $film)
    {
        Auth::user()
            ->films()
            ->updateExistingPivot(
                $film,
                ['status' => Film::TO_SHORTLIST]
            )
        ;

        return redirect()->to(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.ignored');
    }
}
