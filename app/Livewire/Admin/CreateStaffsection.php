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
        // dd($this->only(['name']));
        StaffSection::create(
            $this->only(['name'])
        );
    }

    public function render()
    {
        return view('livewire.admin.create-staffsection');
    }
}
