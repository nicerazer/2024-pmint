<?php

namespace App\Livewire\WorkLogs\Show;

use Livewire\Component;

class EvaluationForm extends Component
{
    public $submission;
    public $evaluator_comment = '';
    public $is_accept = false;

    public function save()
    {
        // TODO: Check past submissions for evaluation timestamp. Can continue if filled
        // dd ($this->only(['evaluator_comment', 'is_accept']) + ['evaluated_at' => now()]);
        $this->submission->update(
            $this->only(['evaluator_comment', 'is_accept']) + ['evaluated_at' => now()]
        );
    }

    public function render()
    {
        return view('livewire.work-logs.show.evaluation-form');
    }
}
