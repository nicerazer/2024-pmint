<?php

namespace App\Livewire\Admin;

use App\Helpers\UserRoleCodes;
use App\Livewire\Forms\EditStaffForm;
use App\Models\StaffUnit;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditStaff extends Component
{
    public $old_model_id;
    #[Reactive]
    public $model_id;
    public $staff;

    // public $selected_section_id = -1;
    // public $selected_unit_id = -1;
    public $staff_units;

    public EditStaffForm $form;

    #[Computed]
    public function staffUnits () {
        return StaffUnit::where('staff_section_id', $this->form->selected_section_id)->get();
    }

    public function save() {
        $this->form->update($this->staff);

        session()->flash('status-class', 'success');
        session()->flash('message', 'Staff \''. $this->staff->name .'\' telah dikemaskini');
        session()->flash('admin_is_creating', 0);
        session()->flash('admin_model_context', 'staff');
        session()->flash('admin_model_id', $this->staff->id);

        $this->redirect('/');
    }

    public function switchSection($id) {
        $this->form->selected_section_id = $id;
        $this->form->selected_unit_id = -1;
        $this->staff_units = StaffUnit::where('staff_section_id', $this->form->selected_section_id)->get();
    }

    public function switchUnit($id) {
        // $this->selected_unit_id = $id;
        // $this->units = StaffUnit::where('' this->selected_unit_id);
    }

    // public function mount($model_id, $staff) {
    //     $this->form->setStaff(User::find($this->model_id));
    //     $this->model_id = $model_id;
    //     $this->staff = $staff;
    // }

    public function render()
    {

        // $this->form->setStaff(User::find($this->model_id));



        if (!$this->staff) {
            $this->form->selected_section_id = -1;
            $this->form->selected_unit_id = -1;
        }

        $this->staff = User::find($this->model_id);
        $this->form->staff = $this->staff;

        if ($this->form->staff) {
            Log::debug($this->old_model_id);
            Log::debug($this->model_id);
        }

        // if (false) {
        if ($this->staff && $this->old_model_id != $this->model_id) {
            $this->form->resetValidation();
            $this->old_model_id = $this->model_id;
            $staff_roles = $this->staff->roles->pluck('id')->toArray();

            $this->form->name = $this->staff->name;
            $this->form->email = $this->staff->email;
            $this->form->ic = $this->staff->ic;
            // Log::debug('numberrrrr:' . $this->staff->unit->id);
            // $this->form->selected_section_id += 5;
            $this->form->selected_section_id = $this->staff->unit->staffsection->id;
            $this->form->selected_unit_id = $this->staff->unit->id;
            $this->form->roles = $this->staff->roles->pluck('id')->toArray();
            $this->form->has_role_admin = in_array(UserRoleCodes::ADMIN, $staff_roles);
            $this->form->has_role_evaluator_1 = in_array(UserRoleCodes::EVALUATOR_1, $staff_roles);
            $this->form->has_role_evaluator_2 = in_array(UserRoleCodes::EVALUATOR_2, $staff_roles);
            $this->form->has_role_staff = in_array(UserRoleCodes::STAFF, $staff_roles);
        }
        // }
        // $this->form->selected_section_id = 5;

        // Log::debug('Staff');
        // Log::debug($this->staff_units->count());
        return view('livewire.admin.edit-staff');
    }

    // public function render() {
    // }
}
