<?php

namespace App\Livewire\Admin;

use App\Models\StaffSection;
use App\Models\StaffUnit;
use Livewire\Component;

class CreateStaffunit extends Component
{
    // #[Validate('required')]
    public $name = '';
    public $staff_section_id = -1;

    public function save() {
        StaffUnit::create(
            $this->only(['name', 'staff_section_id'])
        );
    }

    public function render()
    {
        return view('livewire.admin.create-staffunit');
    }
}
