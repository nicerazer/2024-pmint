<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Validate;
use App\Models\StaffSection;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class EditStaffsection extends Component
{
    #[Validate('required|string|unique:App\Models\StaffSection')]
    public $name = '';
    #[Reactive]
    public $model_id;
    public $staff_section;

    public $delete_confirm_pass;
    public $delete_confirm_pass_unmatched;

    public function save() {
        // dd($this->only(['name']));
        $this->staff_section->update(
            $this->only(['name'])
        );

        session()->flash('status-class', 'success');
        session()->flash('message', 'Bahagian \''. $this->staff_section->name .'\' telah dikemaskini');
        session()->flash('admin_is_creating', 0);
        session()->flash('admin_model_context', 'staff_section');
        session()->flash('admin_model_id', $this->staff_section->id);

        $this->redirect('/');
    }

    public function delete() {
        if(! password_verify($this->delete_confirm_pass, auth()->user()->password)) {
            $this->delete_confirm_pass = '';
            $this->delete_confirm_pass_unmatched = true;
            return;
        }

        $res = StaffSection::destroy($this->model_id);

        return redirect('/')
            ->with('status-class', 'success')
            ->with('message', 'Bahagian telah dibuang: ID ' . $res);
    }

    public function render()
    {
        $this->staff_section = StaffSection::find($this->model_id);
        if ($this->staff_section)
            $this->name = $this->staff_section->name;
        return view('livewire.admin.edit-staffsection');
    }
}
