<?php

namespace App\Livewire\WorkLogs;

use App\Livewire\Forms\WorklogForm;
use App\Models\StaffUnit;
use App\Models\WorkScope;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateWorklog extends Component
{
    use WithFileUploads;
    // public $work_scope_id = '';
    // public $description = '';
    // public $expected_at = '';
    // #[Reactive]
    public $selectedUnitId = -1;
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
        $this->selectedUnitId = $unit_id;
        Log::info($this->selectedUnitId);
    }

    public function render()
    {
        $work_units = StaffUnit::where('staff_section_id', auth()->user()->unit->staffSection->id)->get();
        $work_scopes = WorkScope::where('staff_unit_id', $this->selectedUnitId)->get();
        return view('livewire.work-logs.create-form', compact('work_units', 'work_scopes'));
    }
}
