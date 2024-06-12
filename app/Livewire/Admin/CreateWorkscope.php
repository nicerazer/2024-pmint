<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Validate;
use App\Models\StaffUnit;
use App\Models\WorkScope;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CreateWorkscope extends Component
{
    // public $staff_units;

    #[Validate('required', message: 'Sila pilih bahagian daripdada dropdown')]
    #[Validate('gte:1', message: 'Sila pilih bahagian daripdada dropdown')]
    #[Validate('exists:App\Models\StaffSection,id', message: 'Pilihan tidak wujud dalam database. Sila pilih semula bahagian')]
    public $selected_section_id = -1;

    #[Validate('required', message: 'Sila pilih unit daripdada dropdown')]
    #[Validate('gte:1', message: 'Sila pilih unit daripdada dropdown')]
    #[Validate('exists:App\Models\StaffUnit,id', message: 'Pilihan tidak wujud dalam database. Sila pilih semula bahagian')]
    public $selected_unit_id = -1;

    // #[Validate('unique:App\Models\WorkScope,title', message: 'Skop kerja yang sama wujud dalam sistem!')]
    #[Validate('required', message: 'Sila isi tajuk aktiviti')]
    #[Validate('string', message: 'Sila isi tajuk aktiviti')]
    public $title;

    public function render()
    {
        return view('livewire.admin.create-workscope');
    }

    public function save()
    {
        $validated = $this->validate();

        $created_workscope = WorkScope::create([
            'staff_unit_id' => $this->selected_unit_id,
            'title' => $this->title,
        ]);

        session()->flash('status-class', 'success');
        session()->flash('message', 'Tajuk aktiviti \''. $this->title .'\' telah ditambah untuk unit \'' . StaffUnit::find($this->selected_unit_id)->name . '\'');
        session()->flash('admin_is_creating', 0);
        session()->flash('admin_model_context', 'workscope');
        session()->flash('admin_model_id', $created_workscope->id);

        $this->redirect('/');
    }

    #[Computed]
    public function staff_units() {
        return StaffUnit::where('staff_section_id', $this->selected_section_id)->get();
    }

    public function switchSection($section_id)
    {
        $this->resetValidation(['staffUnit']);
        $this->selected_section_id = $section_id;
        $this->selected_unit_id = -1;
        // unset($this->staff_units);
    }
}
