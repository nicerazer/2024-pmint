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
    public $work_scopes;
    public $staffUnits = [];

    public function save()
    {
        $this->form->store();

        return redirect()->route('home')
            ->with('success', 'Log Kerja dicipta.');
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
        ->whereExists($workScopes)
        ->get();
        return view('livewire.work-logs.create-form');
    }
}
