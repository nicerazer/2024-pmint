<?php

namespace App\Livewire\WorkLogs\Edit;

use App\Helpers\WorkLogHelper;
use App\Models\WorkLog;
use Livewire\Component;

class SetStatus extends Component
{
    public $workLog;

    public function mount(WorkLog $workLog)
    {
        $this->workLog = $workLog;
    }

    public function accept()
    {
        $this->worklog->update([
                'accepted_level_1_at' => now(),
                'status' => WorkLogHelper::COMPLETED,
        ]);

        return $this->redirect()->back()
            ->with('status', 'Worklog has been set as complete.');
    }

    public function reject()
    {

    }

    // public function update()
    // {
    //     return $this->redirect('/worklogs/'. $worklog->id)
    //         ->with('status', 'Worklog has been set as complete.');
    // }

    public function render()
    {
        return view('livewire.work-logs.edit.set-status');
    }
}
