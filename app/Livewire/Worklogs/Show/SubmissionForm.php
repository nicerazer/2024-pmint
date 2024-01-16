<?php

namespace App\Livewire\WorkLogs\Show;

use App\Models\Submission;
use Illuminate\Http\Request;
use Livewire\Component;

class SubmissionForm extends Component
{
    public $worklog;
    public $body;
    public $fileponds = [];

    public function save()
    {
        // TODO: Check past submissions for evaluation timestamp. Can continue if filled
        Submission::create(
            $this->only(['body']) + ['work_log_id' => $this->worklog->id]
        );
    }

    public function render()
    {
        return view('livewire.work-logs.show.submission-form');
    }
}
