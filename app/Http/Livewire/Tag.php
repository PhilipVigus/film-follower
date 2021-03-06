<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tag as TagModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class Tag extends Component
{
    /** @var Tag */
    public $tag;

    /** @var bool */
    public $ignored;

    /** @var array */
    public $films;

    /** @var Collection */
    public $searchKeys;

    public function mount(TagModel $tag)
    {
        $this->tag = $tag;

        $this->ignored = Auth::user()->ignoredTags->contains($tag);

        $this->films = Auth::user()
            ->films()
            ->with('trailers', 'priorities', 'reviews')
            ->withPivot('status')
            ->whereHas('tags', function (Builder $query) {
                $query->where('tags.id', $this->tag->id);
            })
            ->get()
            ->toArray()
        ;

        $this->searchKeys = collect(['title', 'tags.name', 'trailers.type', 'priorities.comment', 'reviews.comment']);
    }

    public function toggleIgnoreTag(bool $ignored)
    {
        $ignored
            ? Auth::user()->ignoredTags()->attach($this->tag)
            : Auth::user()->ignoredTags()->detach($this->tag)
        ;
    }

    public function render()
    {
        return view('livewire.tag');
    }
}
