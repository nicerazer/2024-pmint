<?php

namespace App\Livewire\WorkLogs\Show;

use Livewire\Attributes\On;
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
        // sleep(4);
        // TODO: Check past submissions for evaluation timestamp. Can continue if filled
        // dd ($this->only(['evaluator_comment', 'is_accept']) + ['evaluated_at' => now()]);
        $this->submission->update(
            $this->only(['evaluator_comment']) +
            ['evaluated_at' => now(),
            'evaluator_id' => auth()->user()->id,
            'is_accept' => $this->is_accept == 'yes']
        );
        $this->dispatch('refresh-submissions');
    }


    // #[On('refresh-submissions')]
    // public function refreshComponent()
    // {
    //     $this->submitting = true;
    // }

    public function render()
    {
        return view('livewire.work-logs.show.evaluation-form');
    }
}
