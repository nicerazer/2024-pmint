<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Validate;
use App\Models\StaffUnit;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class EditStaffunit extends Component
{
    #[Reactive]
    public $model_id;
    public $staff_unit;

    #[Validate('required', message: 'Nama unit tidak boleh tinggal kosong')]
    #[Validate('string', message: 'Borang ada masalah teknikal. Sila muat semula halaman.')]
    #[Validate('unique:App\Models\StaffUnit,name', message: 'Unit dengan nama tersebut wujud di dalam sistem. Sila isi semula.')]
    public $name = '';

    #[Validate('required', message: 'Sila pilih bahagian.')]
    #[Validate('exists:App\Models\StaffSection,id', message: 'Bahagian tidak wujud dalam sistem. Sila muat semula halaman.')]
    public $staff_section_id;

    public $delete_confirm_pass;
    public $delete_confirm_pass_unmatched;

    public function rules()
    {
        return [
            'name' => [
                'required','string',
                Rule::unique('staff_sections')->ignore($this->model_id)
            ],
            'staff_section_id' => [
                'required|exists:App\Models\StaffSection,id',
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Sila isi nama unit',
            'name.string' => 'Sila isi nama unit',
            'name.unique' => 'Unit dengan nama tersebut wujud di dalam sistem. Sila isi yang lain.',
            'staff_section_id.required' => 'Sila pilih bahagian.',
            'staff_section_id.exists' => 'Sila pilih bahagian.',
        ];
    }

    public function save() {
        $this->validate();

        $this->staff_unit->update(
            $this->only(['name','staff_section_id'])
        );

        session()->flash('status-class', 'success');
        session()->flash('message', 'Unit \''. $this->staff_unit->name .'\' telah dikemaskini');
        session()->flash('admin_is_creating', 0);
        session()->flash('admin_model_context', 'staff_unit');
        session()->flash('admin_model_id', $this->staff_unit->id);

        $this->redirect('/');
    }

    public function delete() {
        if(! password_verify($this->delete_confirm_pass, auth()->user()->password)) {
            $this->delete_confirm_pass = '';
            $this->delete_confirm_pass_unmatched = true;
            return;
        }

        $res = StaffUnit::destroy($this->model_id);

        return redirect('/')
            ->with('status-class', 'success')
            ->with('message', 'Unit telah dibuang: ID ' . $res);
    }

    #[On('switched-unit')]
    public function switchedUnit($staff_unit_id) {
        $staff_unit = StaffUnit::find($staff_unit_id);
        $this->staff_section_id = $staff_unit->staff_section_id;
        Log::debug($this->staff_section_id);
    }

    public function render()
    {
        $this->staff_unit = StaffUnit::find($this->model_id);
        if ($this->staff_unit) {
            $this->name = $this->staff_unit->name;
        }
        return view('livewire.admin.edit-staffunit');
    }
}
