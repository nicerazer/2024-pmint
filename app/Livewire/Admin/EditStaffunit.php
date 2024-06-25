<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Validate;
use App\Models\StaffUnit;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class EditStaffunit extends Component
{
    #[Validate('required|string|unique:App\Models\StaffUnit')]
    public $name = '';
    #[Reactive]
    public $model_id;
    public $staff_unit;

    public $delete_confirm_pass;
    public $delete_confirm_pass_unmatched;

    public function save() {
        $this->validate();

        $this->staff_unit->update(
            $this->only(['name'])
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

    public function render()
    {
        $this->staff_unit = StaffUnit::find($this->model_id);
        if ($this->staff_unit)
            $this->name = $this->staff_unit->name;
        return view('livewire.admin.edit-staffunit');
    }
}
