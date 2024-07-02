<?php

namespace App\Livewire\Forms;

use App\Helpers\UserRoleCodes;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Form;

class CreateStaffForm extends Form
{
    public $name;
    public $email;
    public $ic;
    public $position;
    public $password;

    public $selected_section_id = -1;
    public $selected_unit_id = -1;

    public $has_role_admin;
    public $has_role_evaluator_1;
    public $has_role_evaluator_2;
    public $has_role_staff;

    public function rules()
    {
        return [
            'name' => [ 'required', 'string', 'max:60'],
            'email' => [
                'required', 'string', 'email:rfc,dns'
            ],
            'ic' => [
                'required', 'string', 'max:12'
            ],
            'position' => [
                'sometimes', 'nullable', 'string', 'max:50',
            ],
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
            'name.max' => 'Nama tidak boleh melebihi 60 patah perkataan.',

            'email.required' => 'Sila isi e-mel.',
            'email.string' => 'Sila isi e-mel.',
            'email.unique' => 'E\'mel wujud di dalam sistem. Sila tukar.',

            'ic.required' => 'Sila isi no. kad pengenalan.',
            'ic.string' => 'Sila isi no. kad pengenalan.',
            'ic.unique' => 'Kad pengenalan wujud di dalam sistem. Sila tukar.',
            'ic.max' => 'Nama tidak boleh melebihi 12. Sila ikut format tanpa \'-\'',

            'position:string' => 'Masalah teknikal. Sila muat naik semula halaman.',
            'position:max' => 'Jawatan tidak boleh melebihi 12.',

            'selected_section_id.required' => 'Sila pilih bahagian.',
            'selected_section_id.exists' => 'Sila pilih bahagian.',

            'selected_unit_id.required' => 'Sila pilih unit.',
            'selected_unit_id.exists' => 'Sila pilih unit.',

            'password.string' => 'Masalah teknikal. Sila muat naik semula halaman.',
            'password.min' => 'Kata laluan mesti 8 patah perkataan atau lebih.',
        ];
    }

    public function store()
    {
        $validated = $this->validate();

        $newStaff = new User();

        $newStaff->name = $validated['name'];
        $newStaff->email = $validated['email'];
        if ($validated['position'])
            $newStaff->position = $validated['position'];
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
