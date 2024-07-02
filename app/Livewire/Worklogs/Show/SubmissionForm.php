<?php

namespace App\Livewire\WorkLogs\Show;

use App\Helpers\WorkLogCodes;
use App\Models\Submission;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\File;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Livewire\WithFileUploads;
use Whoops\Exception\ErrorException;

class SubmissionForm extends Component
{
    use WithFileUploads;

    public $worklog;
    public $body;
    public $fileTempPaths = [];
    public $attachments = [];
    private $imageCount = 0;
    private $docCount = 0;

    public function rules() {
        return [
            'attachments' => 'nullable',
            'attachments.*' => ['nullable', 'max:1000000',
                File::types([
                    'image/jpg', 'image/jpeg', 'image/png', 'image/gif',
                    'text/csv', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/rtf', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'application/gzip', 'application/pdf', 'application/vnd.rar', 'application/zip', 'application/x-7z-compressed'
                ])],
            'body' => 'nullable|string',
        ];
    }

    // public function messages() {}

    public function save()
    {
        Log::debug('Submission Form: Saving initiated');
        $this->validate();
        Log::debug('Submission Form: Validated inputs');
        DB::transaction(function () {
            // TODO: Check past submissions for evaluation timestamp. Can continue if filled
            $submission = new Submission();

            if (! $this->validatesSubmission())
                throw new ErrorException('Something went wrong. Please refer to admin.');

            $submission->body = $this->body;
            $submission->work_log_id = $this->worklog->id;

            $submissionNumber = $this->worklog->submissions()->count() + 1;
            $submission->number = $submissionNumber;
            $submission->submitted_at = now();
            $submission->save();

            $this->worklog->status = WorkLogCodes::SUBMITTED;
            $this->worklog->save();

            Log::debug('Submission Form: Created submission');

            // Store by generated name, retreive (download) by original name
            $this->imageCount = 0;
            collect($this->attachments)->each(function($attachment) use ($submission) {
                if (in_array($attachment->getMimeType(), ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'])) {
                    // $submission->addMedia($attachment->getRealPath())->toMediaCollection('images');
                    $submission->addMedia($attachment->getRealPath())
                    ->usingName($attachment->getClientOriginalName())
                    ->toMediaCollection('images');

                    $this->imageCount++;
                } else {
                    // $submission->addMedia($attachment->getRealPath())->toMediaCollection('documents');
                    $submission->addMedia($attachment->getRealPath())
                    ->usingName($attachment->getClientOriginalName())
                    ->toMediaCollection('documents');
                    $this->docCount++;
                }

            });

            Log::debug('Image count: ' . $this->imageCount);
            Log::debug('Document count: ' . $this->docCount);
            Log::debug('Submission Form: Uploaded images');

        });
        $this->dispatch('refresh-submissions');
    }

    public function validatesSubmission(): bool {
        $assignedEvaluatorsCount = User::evaluator1s($this->worklog->unit->section->id)->count();

        if (! $assignedEvaluatorsCount) {
            // Evaluator 1 must be set when creating submissions
            Log::error('There is no evaluator assigned in section ' . $this->worklog->unit->section->name);
            return false;
        }
        if($this->worklog->submissions()->count() && ! $this->worklog->latestSubmission->evaluated()) {
            // 1. When there's one and more submissions (If never made submission can proceed), and
            // 2. The latest hasn't been evaluated, cancel the submission, throw error
            Log::error('The latest submission hasn\'t been evaluated yet. Do that first.');
            return false;
        }

        Log::notice('Submission creating: success');
        return true;
    }

    public function render()
    {
        return view('livewire.work-logs.show.submission-form');
    }
}
