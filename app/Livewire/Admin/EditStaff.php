<?php

namespace App\Livewire\Admin;

use App\Helpers\UserRoleCodes;
use App\Livewire\Forms\EditStaffForm;
use App\Models\StaffUnit;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditStaff extends Component
{
    #[Reactive]
    public $model_id;
    public $staff;

    public $selected_section_id = -1;
    public $selected_unit_id = -1;
    public $staff_units;

    public EditStaffForm $form;

    public function save() {
        $this->form->update($this->staff);

        $this->redirect('/');
    }

    public function switchSection($id) {
        $this->selected_section_id = $id;
        $this->selected_unit_id = -1;
        $this->staff_units = StaffUnit::where('staff_section_id', $this->selected_section_id)->get();
    }

    public function switchUnit($id) {
        // $this->selected_unit_id = $id;
        // $this->units = StaffUnit::where('' this->selected_unit_id);
    }

    public function render()
    {
        $this->staff = User::find($this->model_id);
        $this->staff_units = StaffUnit::where('staff_section_id', $this->selected_section_id)->get();


        if ($this->staff) {
            $staff_roles = $this->staff->roles->pluck('id')->toArray();

            $this->form->name = $this->staff->name;
            $this->form->email = $this->staff->email;
            $this->form->ic = $this->staff->ic;
            $this->selected_section_id = $this->staff->unit->staffsection->id;
            $this->selected_unit_id = $this->staff->unit->id;
            $this->form->roles = $this->staff->roles->pluck('id')->toArray();
            $this->form->has_role_admin = in_array(UserRoleCodes::ADMIN, $staff_roles);
            $this->form->has_role_evaluator_1 = in_array(UserRoleCodes::EVALUATOR_1, $staff_roles);
            $this->form->has_role_evaluator_2 = in_array(UserRoleCodes::EVALUATOR_2, $staff_roles);
            $this->form->has_role_staff = in_array(UserRoleCodes::STAFF, $staff_roles);
        }

        Log::debug('Staff');
        Log::debug($this->staff_units->count());

        return view('livewire.admin.edit-staff');
    }
}
