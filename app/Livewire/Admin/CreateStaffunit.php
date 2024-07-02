<?php

namespace App\Livewire\Admin;

use App\Models\StaffSection;
use App\Models\StaffUnit;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateStaffunit extends Component
{
    #[Validate('required', message: 'Sila isi nama unit')]
    #[Validate('string', message: 'Sila isi nama unit')]
    // #[Validate('unique:App\Models\StaffUnit,name', message: 'Unit dengan nama tersebut wujud di dalam sistem. Sila isi yang lain.')]
    public $name = '';
    #[Validate('required', message: 'Sila pilih bahagian.')]
    #[Validate('exists:App\Models\StaffSection,id', message: 'Sila pilih bahagian.')]
    public $staff_section_id = 0;

    public function save() {
        $this->validate();
        $newUnit = StaffUnit::create(
            $this->only(['name', 'staff_section_id'])
        );

        session()->flash('status-class', 'success');
        session()->flash('message', 'Unit telah ditambah');
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
