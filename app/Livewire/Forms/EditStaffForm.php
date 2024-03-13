<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Rule;
use Livewire\Form;
use Livewire\Attributes\Validate;

class EditStaffForm extends Form
{
    #[Validate('required', message: 'Sila isi nama')]
    #[Validate('string', message: 'Sila isi nama')]
    public $name;

    #[Validate('unique:App\Models\User,email', message: 'Akaun dengan emel tersebut telah wujud dlm sistem')]
    public $email;

    #[Validate('unique:App\Models\User,ic', message: 'Akaun dengan ic tersebut telah wujud dlm sistem')]
    #[Validate('required', message: 'Sila isi nama')]
    #[Validate('string', message: 'Sila isi nama')]
    public $ic;

    #[Validate('array')]
    public $roles;

    // #[Reactive]
    #[Validate('required|exists:App\Models\StaffSection,id')]
    public $selected_section_id = -1;
    #[Validate('required|exists:App\Models\StaffUnit,id')]
    public $selected_unit_id = 0;

    public $has_role_admin;
    public $has_role_evaluator_1;
    public $has_role_evaluator_2;
    public $has_role_staff;

    public function update($staff)
    {
        $validated = $this->validate();

        $staff->name = $validated['name'];
        $staff->ic = $validated['ic'];
        $staff->email = $validated['email'];
        if ($validated['password'])
            $staff->password = Hash::make($validated['password']);
        $staff->roles()->sync($validated['roles']);
        $staff->save();

        session()->flash('status-class', 'success');
        session()->flash('message', 'Staff id' . $staff->id . 'telah dikemaskini');
        session()->flash('admin_is_creating', 0);
        session()->flash('admin_model_context', 'staff');
        session()->flash('admin_model_id', $staff->id);
    }
}
