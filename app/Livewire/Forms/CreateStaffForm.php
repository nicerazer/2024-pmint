<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Rule;
use Livewire\Form;
use Livewire\Attributes\Validate;

class CreateStaffForm extends Form
{
    #[Validate('required')]
    public $name;
    #[Validate('required|email:rfc,dns|unique:App\Models\User')]
    public $email;
    #[Validate('required|unique:App\Models\User')]
    public $ic;
    #[Validate('required')]
    public $password;
    // #[Reactive]
    #[Validate('required|exists:App\Models\StaffSection,id')]
    public $selected_section_id = -1;
    #[Validate('required|exists:App\Models\StaffUnit,id')]
    public $selected_unit_id = 0;

    public function save()
    {
        $this->validate();

        User::create($this->all());

        $this->reset();
    }
}
