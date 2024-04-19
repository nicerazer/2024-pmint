<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Validate;
use App\Models\StaffSection;
use Livewire\Component;

class CreateStaffsection extends Component
{
    #[Validate('required')]
    public $name = '';

    public function save() {
        $newSection = StaffSection::create(
            $this->only(['name'])
        );

        session()->flash('status-class', 'success');
        session()->flash('message', 'Bahagian telah ditambah');
        session()->flash('admin_is_creating', 0);
        session()->flash('admin_model_context', 'staff_section');
        session()->flash('admin_model_id', $newSection->id);

        $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.admin.create-staffsection');
    }
}
