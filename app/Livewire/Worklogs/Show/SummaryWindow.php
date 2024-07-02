<?php

namespace App\Livewire\WorkLogs\Show;

use App\Models\WorkLog;
use Livewire\Attributes\On;
use Livewire\Component;

class SummaryWindow extends Component
{
    public WorkLog $worklog;

    public function render()
    {
        return view('livewire.work-logs.show.summary-window');
    }

    #[On('refresh-submissions')]
    public function refreshComponent()
    {
        $this->worklog->refresh();
    }

}
