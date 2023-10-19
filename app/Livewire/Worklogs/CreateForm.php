<?php

namespace App\Livewire\WorkLogs;

use App\Models\WorkLog;
use Livewire\Component;

class CreateForm extends Component
{
    public $work_scope_id = '';
    public $description = '';
    public $expected_at = '';

    public function save()
    {
        $workLog = WorkLog::create(
            collect([
                'started_at' => now(),
                'author_id' => auth()->user()->id,
            ])->merge($this->only(['work_scope_id', 'description']))->toArray()
        );

        return redirect()->route('workLogs.index', $workLog)
            ->with('status', 'Log Kerja dicipta.');
    }

    public function render()
    {
        return view('livewire.work-logs.create-form');
    }
}
