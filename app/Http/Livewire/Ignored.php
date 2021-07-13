<?php

namespace App\Http\Livewire;

use App\Models\Film;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class Ignored extends Component
{
    /** @var Collection */
    public $ignoredFilms;

    /** @var Collection */
    public $filmsWithIgnoredTags;

    /** @var Collection */
    public $ignoredTagsIds;

    /** @var array */
    protected $listeners = [
        'refresh-film-list' => 'refreshFilms',
    ];

    public function mount()
    {
        $this->ignoredTagsIds = Auth::user()->ignoredFilmTags->pluck('id');

        $this->refreshFilms();
    }

    public function refreshFilms()
    {
        $this->filmsWithIgnoredTags = Film::whereHas('tags', function ($query) {
            $query->whereIn(
                'id',
                $this->ignoredTagsIds
            );
        })
            ->with(['tags' => function ($query) {
                $query->whereIn(
                    'id',
                    $this->ignoredTagsIds
                );
            }])
            ->get()
        ;

        $this->ignoredFilms = Auth::user()
            ->ignoredFilms()
            ->get()
        ;
    }

    public function render()
    {
        return view('livewire.ignored');
    }
}
