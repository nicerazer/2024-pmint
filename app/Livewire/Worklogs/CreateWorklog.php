<?php

namespace App\Livewire\WorkLogs;

use App\Livewire\Forms\CreateWorklogForm;
use App\Models\StaffUnit;
use App\Models\WorkScope;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateWorklog extends Component
{
    use WithFileUploads;

    public $selectedUnitId = -1;
    public CreateWorklogForm $form;
    public $work_scopes;
    public $staffUnits = [];

    public function mount() {
        $this->form->started_at = now();
        $this->form->expected_submitted_at = now();
    }

    public function save()
    {
        // dd($this->form->started_at->toDateString());
        // dd($this->form->expected_submitted_at);
        $this->form->store();

        return redirect()->route('home')
            ->with('status-class', 'success')
            ->with('message', 'Log Kerja dicipta.');
    }

    public function switchUnit($unit_id)
    {
        // Log::info('Selecting unit from dropdown list');
        // Log::info($unit_id);
        $this->resetValidation(['form.staffUnit']);
        $this->selectedUnitId = $unit_id;
        $this->work_scopes = WorkScope::where('staff_unit_id', $this->selectedUnitId)->get();
        Log::debug($this->work_scopes);
        $this->form->initWorkScope($this->work_scopes);
        // Log::info($this->selectedUnitId);
    }

    // public function mount(Post $post)
    // {
    //     $this->form->initForm($post);
    // }

    public function render()
    {
        $workScopes = WorkScope::query()
            ->whereColumn('work_scopes.staff_unit_id', 'staff_units.id');

        $this->staffUnits = StaffUnit::where('staff_section_id', auth()->user()->unit->staffSection->id)
        ->get();

        return view('livewire.work-logs.create-worklog');
    }
}
