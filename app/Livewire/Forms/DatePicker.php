<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class DatePicker extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.forms.date-picker');
    }
}
