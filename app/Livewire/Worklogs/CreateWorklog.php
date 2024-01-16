<?php

namespace App\Livewire\WorkLogs;

use App\Livewire\Forms\WorklogForm;
use App\Models\WorkLog;
use App\Models\WorkScope;
use App\Models\WorkUnit;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class CreateWorklog extends Component
{
    // public $work_scope_id = '';
    // public $description = '';
    // public $expected_at = '';
    // #[Reactive]
    public $selectedWorkUnit = -1;
    public WorklogForm $form;

    public function save()
    {
        $this->form->store();

        return redirect()->route('worklogs.index')
            ->with('success', 'Log Kerja dicipta.');
    }

    public function switchUnit($unit_id)
    {
        Log::info('Selecting unit from dropdown list');
        Log::info($unit_id);
        $this->selectedWorkUnit = $unit_id;
        Log::info($this->selectedWorkUnit);
    }

    public function render()
    {
        $work_units = WorkUnit::where('staff_section_id', auth()->user()->staff_section_id)->get();
        $work_scopes = WorkScope::where('work_unit_id', $this->selectedWorkUnit)->get();
        return view('livewire.work-logs.create-form', compact('work_units', 'work_scopes'));
    }
}
