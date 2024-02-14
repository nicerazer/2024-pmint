<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class CreateWorkscope extends Component
{
    public $staff_section_id = -1;
    public $unit_name = '';

    public function render()
    {
        return view('livewire.admin.create-workscope');
    }
}
