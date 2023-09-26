<?php

namespace App\Livewire\Worklogs\Edit;

use App\Helpers\WorkLogHelper;
use App\Models\WorkLog;
use Livewire\Component;

class SetStatus extends Component
{
    public $worklog;

    public function mount(WorkLog $worklog)
    {
        $this->worklog = $worklog;
    }

    public function accept()
    {
        $this->worklog->update([
                'accepted_level_1_at' => now(),
                'status' => WorkLogHelper::COMPLETED,
        ]);

        return $this->redirect('/worklogs/'. $worklog->id)
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
        return view('livewire.worklogs.edit.set-status');
    }
}
