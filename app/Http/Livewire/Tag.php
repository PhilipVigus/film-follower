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

    /** @var bool */
    public $ignored;

    /** @var Collection */
    public $filmsToShortlist;

    /** @var Collection */
    public $shortlistedFilms;

    /** @var Collection */
    public $watchedFilms;

    /** @var array */
    protected $listeners = [
        'refresh-film-list' => 'refreshFilms',
    ];

    public function mount(TagModel $tag)
    {
        $this->tag = $tag;

        $this->ignored = Auth::user()->ignoredTags->contains($tag);

        $this->refreshFilms();
    }

    public function refreshFilms()
    {
        $films = Auth::user()
            ->films()
            ->withPivot('status')
            ->whereHas('tags', function (Builder $query) {
                $query->where('tags.id', $this->tag->id);
            })
            ->get()
            ->groupBy('pivot.status')
        ;

        $this->filmsToShortlist = Arr::exists($films, Film::TO_SHORTLIST) ? $films[Film::TO_SHORTLIST] : [];
        $this->shortlistedFilms = Arr::exists($films, Film::SHORTLISTED) ? $films[Film::SHORTLISTED] : [];
        $this->watchedFilms = Arr::exists($films, Film::WATCHED) ? $films[Film::WATCHED] : [];
    }

    public function toggleIgnoreTag()
    {
        $this->ignored = ! $this->ignored;

        $this->ignored
            ? Auth::user()->ignoredTags()->attach($this->tag)
            : Auth::user()->ignoredTags()->detach($this->tag)
        ;
    }

    public function render()
    {
        return view('livewire.tag');
    }
}
