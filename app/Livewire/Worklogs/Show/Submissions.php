<?php

namespace App\Livewire\WorkLogs\Show;

use App\Models\Submission;
use App\Models\WorkLog;
use Livewire\Attributes\On;
use Livewire\Component;

class Submissions extends Component
{
    public $worklog;
    public $submissions;

    public function render()
    {
        $this->submissions = Submission::where('work_log_id', $this->worklog->id)->orderByDesc('number')->get();
        return view('livewire.work-logs.show.submissions');
    }

    #[On('refresh-submissions')]
    public function refreshComponent()
    {
        $this->dispatch('$refresh');
    }
}
