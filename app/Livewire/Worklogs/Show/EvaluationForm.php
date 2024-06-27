<?php

namespace App\Livewire\WorkLogs\Show;

use App\Helpers\WorkLogCodes;
use App\Models\WorkLog;
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
            $wl = $this->submission->worklog;
            $wl->status = [
                'yes' => WorkLogCodes::COMPLETED,
                'no' => WorkLogCodes::TOREVISE,
            ][$this->is_accept];

            $wl->save();
            $this->submission->save();
        });

        $this->dispatch('refresh-submissions');
    }

    // public function updateLatestSubmission(WorkLog $wl) {
    //     $latestSub = $wl->latestSubmission;
    //     if (auth()->user()->isEvaluator1()) {
    //         $latestSub->evaluator_id = auth()->user()->id;
    //         if ($latestSub->evaluated_at) {
    //             if ($latestSub->is_accept)
    //                 $wl->status = false;
    //             else
    //                 $wl->status = false;
    //         }
    //     }
    //     $latestSub->save();
    // }

    public function render()
    {
        return view('livewire.work-logs.show.evaluation-form');
    }
}
