<?php

namespace App\Livewire\Forms;

use App\Helpers\UserRoleCodes;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
    #[Validate('required|min:1|exists:App\Models\StaffSection,id')]
    public $selected_section_id = -1;
    #[Validate('required|min:1|exists:App\Models\StaffUnit,id')]
    public $selected_unit_id = -1;

    public $has_role_admin;
    public $has_role_evaluator_1;
    public $has_role_evaluator_2;
    public $has_role_staff;

    // public $newStaff;

    public function store()
    {
        $validated = $this->validate();

        $newStaff = new User();

        $newStaff->name = $validated['name'];
        $newStaff->email = $validated['email'];
        $newStaff->ic = $validated['ic'];
        $newStaff->password = Hash::make($validated['password']);
        $newStaff->staff_unit_id = $validated['selected_unit_id'];
        $newStaff->save();
        $newStaff->roles()->sync($this->buildRoles());
        $newStaff->refresh();

        $this->reset();

        return $newStaff;
    }

    public function buildRoles(): array {

        $roles = [];

        if ($this->has_role_admin == "yes") {
        array_push($roles, UserRoleCodes::ADMIN);
        }
        if ($this->has_role_evaluator_1 == "yes") {
        array_push($roles, UserRoleCodes::EVALUATOR_1);
        }
        if ($this->has_role_evaluator_2 == "yes") {
        array_push($roles, UserRoleCodes::EVALUATOR_2);
        }
        if ($this->has_role_staff == "yes") {
        array_push($roles, UserRoleCodes::STAFF);
        };

        return $roles;
    }
}
