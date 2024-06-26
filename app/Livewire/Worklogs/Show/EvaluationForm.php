<?php

namespace App\Livewire\WorkLogs\Show;

use App\Helpers\WorkLogCodes;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EvaluationForm extends Component
{
    public $submission;
    #[Validate('required|string')]
    public $evaluator_comment = '';
    #[Validate('required|string')]
    public $is_accept = 'no';

    public function save()
    {
        DB::transaction(function () {
            $this->submission->evaluator_comment = $this->evaluator_comment;
            $this->submission->evaluator_id = auth()->user()->id;
            $this->submission->evaluated_at = now();
            $this->submission->is_accept = $this->is_accept == 'yes';
            $this->submission->status = WorkLogCodes::COMPLETED;

            $this->submission->save();
        });

        $this->dispatch('refresh-submissions');
    }

    public function render()
    {
        return view('livewire.work-logs.show.evaluation-form');
    }
}
