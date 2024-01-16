<?php

namespace App\Livewire\WorkLogs\Show;

use Livewire\Component;

class Submissions extends Component
{
    public $workLog;

    public function render()
    {
        return view('livewire.work-logs.show.submissions', [
            'worklog' => $this->workLog
        ]);
    }
}
