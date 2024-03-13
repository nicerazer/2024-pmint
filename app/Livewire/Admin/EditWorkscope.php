<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Validate;
use App\Models\StaffUnit;
use App\Models\WorkScope;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class EditWorkscope extends Component
{
    #[Reactive]
    public $model_id;
    public $workscope;

    // #[Validate('unique:App\Models\WorkScope,title', message: 'Skop kerja yang sama wujud dalam sistem!')]
    #[Validate('required', message: 'Sila isi tajuk aktiviti')]
    #[Validate('string', message: 'Sila isi tajuk aktiviti')]
    public $title;

    public function render()
    {
        $this->workscope = WorkScope::find($this->model_id);

        if ($this->workscope)
            $this->title = $this->workscope->title;

        return view('livewire.admin.edit-workscope');
    }

    public function save()
    {
        $validated = $this->validate();

        $this->workscope->title = $this->title;
        $this->workscope->save();

        session()->flash('status-class', 'success');
        session()->flash('message', 'Aktiviti \''. $this->title .'\' telah dikemaskini');
        session()->flash('admin_is_creating', 0);
        session()->flash('admin_model_context', 'workscope');
        session()->flash('admin_model_id', $this->workscope->id);

        $this->redirect('/');
    }
}
