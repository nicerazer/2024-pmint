<?php

namespace App\Livewire\Forms;

use App\Helpers\UserRoleCodes;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Reactive;
use Illuminate\Validation\Rule;
use Livewire\Form;
use Livewire\Attributes\Validate;

class EditStaffForm extends Form
{
    public ?User $staff;
    // #[Validate('required', message: 'Sila isi nama')]
    // #[Validate('string', message: 'Sila isi nama')]
    public $name;

    // #[Validate('unique:App\Models\User,email', message: 'Akaun dengan emel tersebut telah wujud dlm sistem')]
    public $email;

    // #[Validate('unique:App\Models\User,ic', message: 'Akaun dengan ic tersebut telah wujud dlm sistem')]
    // #[Validate('required', message: 'Sila isi nama')]
    // #[Validate('string', message: 'Sila isi nama')]
    public $ic;

    // #[Validate('array')]
    public $roles;

    // #[Reactive]
    // #[Validate('required|exists:App\Models\StaffSection,id')]
    public $selected_section_id = -1;
    // #[Validate('required|exists:App\Models\StaffUnit,id')]
    public $selected_unit_id = -1;

    // #[Validate('required|exists:App\Models\StaffUnit,id')]
    public $password;
    public $has_role_admin;
    public $has_role_evaluator_1;
    public $has_role_evaluator_2;
    public $has_role_staff;

    public function rules()
    {
        return [
            'name' => [ 'required', 'string' ],
            'email' => [
                'required', 'string', Rule::unique('users')->ignore($this->staff)
            ],
            'ic' => [
                'required', 'string', Rule::unique('users')->ignore($this->staff)
            ], 'roles' => [ 'array' ],
            'selected_section_id' => [
                'required', 'exists:App\Models\StaffSection,id'
            ],
            'selected_unit_id' => [
                'required', 'exists:App\Models\StaffUnit,id'
            ],
            'password' => ['nullable', 'string', 'min:8'],
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Sila isi nama.',
            'name.string' => 'Sila isi nama.',

            'email.required' => 'Sila isi e-mel.',
            'email.string' => 'Sila isi e-mel.',
            'email.unique' => 'E\'mel wujud di dalam sistem. Sila tukar.',

            'ic.required' => 'Sila isi no. kad pengenalan.',
            'ic.string' => 'Sila isi no. kad pengenalan.',
            'ic.unique' => 'Kad pengenalan wujud di dalam sistem. Sila tukar.',

            'roles.array' => 'Masalah teknikal. Sila muat naik semula halaman.',

            'selected_section_id.required' => 'Sila pilih bahagian.',
            'selected_section_id.exists' => 'Sila pilih bahagian.',

            'selected_unit_id.required' => 'Sila pilih unit.',
            'selected_unit_id.exists' => 'Sila pilih unit.',

            'password.string' => 'Masalah teknikal. Sila muat naik semula halaman.',
            'password.min' => 'Kata laluan mesti 8 patah perkataan atau lebih.',
        ];
    }

    public function setStaff(User $staff)
    {
        $this->staff = $staff;
    }

    public function update($staff)
    {
        $validated = $this->validate();

        $staff->name = $validated['name'];
        $staff->ic = $validated['ic'];
        $staff->email = $validated['email'];
        $staff->staff_unit_id = $validated['selected_unit_id'];
        if ($validated['password'])
            $staff->password = Hash::make($validated['password']);
        $staff->roles()->sync($this->buildRoles());
        $staff->save();
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
