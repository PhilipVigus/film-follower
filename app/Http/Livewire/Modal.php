<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Modal extends Component
{
    /** @var bool */
    public $open = false;

    /** @var string */
    public $view = '';

    /** @var array */
    public $data = [];

    /** @var array */
    protected $listeners = ['open' => 'open'];

    public function open(string $view, array $data = [])
    {
        $this->open = true;
        $this->view = $view;
        $this->data = $data;
    }

    public function close()
    {
        $this->view = '';
        $this->data = [];
    }

    public function render()
    {
        return view('livewire.modal');
    }
}
