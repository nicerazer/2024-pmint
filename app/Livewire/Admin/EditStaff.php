<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditStaff extends Component
{
    #[Reactive]
    public $model_id;
    public $staff;

    #[Validate('required', message: 'Sila isi nama')]
    #[Validate('string', message: 'Sila isi nama')]
    public $name;

    #[Validate('unique:App\Models\User,email', message: 'Akaun dengan emel tersebut telah wujud dlm sistem')]
    public $email;

    #[Validate('unique:App\Models\User,ic', message: 'Akaun dengan ic tersebut telah wujud dlm sistem')]
    #[Validate('required', message: 'Sila isi nama')]
    #[Validate('string', message: 'Sila isi nama')]
    public $ic;

    #[Validate('array')]
    public $roles;

    public function render()
    {
        $this->staff = User::find($this->model_id);

        return view('livewire.admin.edit-workscope');
    }

    public function save()
    {
        $validated = $this->validate();

        $this->staff->name = $validated['name'];
        $this->staff->ic = $validated['ic'];
        $this->staff->email = $validated['email'];
        if ($validated['password'])
            $this->staff->password = Hash::make($validated['password']);
        $this->staff->roles()->sync($validated['roles']);
        $this->staff->save();

        session()->flash('status-class', 'success');
        session()->flash('message', 'Staff id' . $this->staff->id . 'telah dikemaskini');
        session()->flash('admin_is_creating', 0);
        session()->flash('admin_model_context', 'staff');
        session()->flash('admin_model_id', $this->workscope->id);

        $this->redirect('/');
    }
}
