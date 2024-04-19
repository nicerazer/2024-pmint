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
        $newUnit = StaffUnit::create(
            $this->only(['name', 'staff_section_id'])
        );

        session()->flash('status-class', 'success');
        session()->flash('message', 'Bahagian telah ditambah');
        session()->flash('admin_is_creating', 0);
        session()->flash('admin_model_context', 'staff_unit');
        session()->flash('admin_model_id', $newUnit->id);

        $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.admin.create-staffunit');
    }
}
