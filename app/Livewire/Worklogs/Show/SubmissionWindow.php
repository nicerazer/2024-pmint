<?php

namespace App\Livewire\WorkLogs\Show;

use App\Models\WorkLog;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class SubmissionWindow extends Component
{
    public $workLog;

    #[On('refresh-submissions')]
    public function refreshComponent()
    {
        $this->workLog = WorkLog::find($this->workLog->id);

        $this->dispatch('$refresh');
    }

    public function render()
    {
        return view('livewire.work-logs.show.submission-window');
    }
}
