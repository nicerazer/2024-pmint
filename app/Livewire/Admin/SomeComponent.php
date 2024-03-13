<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class SomeComponent extends Component
{
    public $coolvar = 'asd';

    public function render()
    {
        return view('livewire.admin.some-component');
    }
}
