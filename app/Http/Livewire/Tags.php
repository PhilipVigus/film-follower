<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Livewire\Component;
use Illuminate\Support\Collection;

class Tags extends Component
{
    /** @var Collection */
    public $tags;

    public function mount()
    {
        $this->tags = Tag::query()
            ->withCount('films')
            ->orderByDesc('films_count')
            ->orderBy('name')
            ->limit(50)
            ->get()
        ;
    }

    public function render()
    {
        return view('livewire.tags');
    }
}
