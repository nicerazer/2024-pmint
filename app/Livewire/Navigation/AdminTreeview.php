<?php

namespace App\Livewire\Navigation;

use Livewire\Component;

class AdminTreeview extends Component
{
    public $staff_sections;

    public function render()
    {
        return view('livewire.navigation.admin-treeview');
    }
}
