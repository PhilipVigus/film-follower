<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tag as TagModel;

class Tag extends Component
{
    /** @var ModelsTag */
    public $tag;

    public function mount(TagModel $tag)
    {
        $this->tag = $tag;
        $this->tag->load('films', 'films.trailers', 'films.tags');
    }

    public function render()
    {
        return view('livewire.tag');
    }
}
