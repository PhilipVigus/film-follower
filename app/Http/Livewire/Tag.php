<?php

namespace App\Http\Livewire;

use App\Models\Film;
use Livewire\Component;
use Illuminate\Support\Arr;
use App\Models\Tag as TagModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class Tag extends Component
{
    /** @var Tag */
    public $tag;

    /** @var Collection */
    public $filmsToShortlist;

    /** @var Collection */
    public $shortlistedFilms;

    /** @var Collection */
    public $watchedFilms;

    public function mount(TagModel $tag)
    {
        $this->tag = $tag;

        $films = Auth::user()
            ->films()
            ->withPivot('status')
            ->whereHas('tags', function (Builder $query) use ($tag) {
                $query->where('id', $tag->id);
            })
            ->get()
            ->groupBy('pivot.status')
        ;

        $this->filmsToShortlist = Arr::exists($films, Film::TO_SHORTLIST) ? $films[Film::TO_SHORTLIST] : [];
        $this->shortlistedFilms = Arr::exists($films, Film::SHORTLISTED) ? $films[Film::SHORTLISTED] : [];
        $this->watchedFilms = Arr::exists($films, Film::WATCHED) ? $films[Film::WATCHED] : [];
    }

    public function render()
    {
        return view('livewire.tag');
    }
}
