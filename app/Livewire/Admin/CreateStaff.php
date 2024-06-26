<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\CreateStaffForm;
use App\Models\StaffUnit;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CreateStaff extends Component
{
    public $staff_units;
    public $sections;
    public $email;
    public $userType;
    public $newStaff;

    public CreateStaffForm $form;

    public function render()
    {
        $this->staff_units = StaffUnit::where('staff_section_id', $this->form->selected_section_id)->get();
        return view('livewire.admin.create-staff');
    }

    public function save()
    {
        $newStaff = $this->form->store();

        session()->flash('status-class', 'success');
        session()->flash('message', 'Staff telah ditambah');
        session()->flash('admin_is_creating', 0);
        session()->flash('admin_model_context', 'staff');
        session()->flash('admin_model_id', $newStaff->id);

        $this->redirect('/');
    }

    public function switchSection($section_id)
    {
        // Log::info('Selecting unit from dropdown list');
        // Log::info($section_id);
        $this->resetValidation(['form.staffUnit']);
        $this->form->selected_section_id = $section_id;
        $this->staff_units = StaffUnit::where('staff_section_id', $this->form->selected_section_id)->get();
        $this->form->selected_unit_id = -1;
        // Log::debug($this->work_scopes);
        // $this->form->initWorkScope($this->work_scopes);
        // Log::info($this->form->selected_section_id);
    }

}
