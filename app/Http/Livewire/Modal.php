<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Modal extends Component
{
    /** @var bool */
    public $show;

    /** @var string */
    public $view;

    /** @var array */
    public $data;

    protected $listeners = ['show' => 'show'];

    public function show(string $view, array $data = [])
    {
        $this->show = true;

        $this->view = $view;
        $this->data = $data;
    }

    public function hide()
    {
        $this->view = '';
        $this->data = [];
    }

    public function render()
    {
        return view('livewire.modal');
    }
}
