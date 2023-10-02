<?php

namespace App\Livewire\WorkLogs;

use App\Models\WorkLog;
use Livewire\Component;

class CreateForm extends Component
{
    public $work_scope_id = '';
    public $description = '';
    public $end_time = '';
    public $end_date = '';
    public $expected_at = '';

    public function save()
    {
        // TODO Start and End date/time
        $this->expected_at = "{$this->end_time} {$this->end_date}";

        $workLog = WorkLog::create(
            collect(['started_at' => now(), 'author_id' => auth()->user()->id]
            )->merge($this->only(['work_scope_id', 'description', 'expected_at']))->toArray()
        );

        return $this->redirect()->route('workLogs.index', $workLog)
            ->with('status', 'Log Kerja dicipta.');
    }

    public function render()
    {
        return view('livewire.work-logs.create-form');
    }
}
