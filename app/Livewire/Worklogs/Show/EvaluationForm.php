<?php

namespace App\Livewire\WorkLogs\Show;

use Livewire\Component;

class EvaluationForm extends Component
{
    public $submission;
    #[Validate('required|string')]
    public $evaluator_comment = '';
    #[Validate('required|boolean')]
    public $is_accept = false;

    public function save()
    {
        // TODO: Check past submissions for evaluation timestamp. Can continue if filled
        // dd ($this->only(['evaluator_comment', 'is_accept']) + ['evaluated_at' => now()]);
        $this->submission->update(
            $this->only(['evaluator_comment', 'is_accept']) + ['evaluated_at' => now(), 'evaluator_id' => auth()->user()->id]
        );
        $this->dispatch('evaluatedSubmission');
    }

    public function render()
    {
        return view('livewire.work-logs.show.evaluation-form');
    }
}
