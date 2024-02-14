<?php

namespace App\Livewire\WorkLogs\Show;

use App\Models\Submission;
use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\File;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Livewire\WithFileUploads;

class SubmissionForm extends Component
{
    use WithFileUploads;

    public $worklog;
    public $body;
    public $fileTempPaths = [];
    public $attachments = [];
    private $imageCount = 0;
    private $docCount = 0;

    public function save()
    {
        Log::debug('Submission Form: Saving initiated');
        $this->validate([
            'attachments' => 'nullable',
            'attachments.*' => ['nullable', 'max:10',
                File::types([
                    'image/jpg', 'image/jpeg', 'image/png', 'image/gif',
                    'text/csv', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/rtf', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'application/gzip', 'application/pdf', 'application/vnd.rar', 'application/zip', 'application/x-7z-compressed'
                ])],
            'body' => 'nullable|string',
        ]);
        Log::debug('Submission Form: Validated inputs');
        // TODO: Check past submissions for evaluation timestamp. Can continue if filled
        $submission = Submission::create(
            $this->only(['body']) + ['work_log_id' => $this->worklog->id]
        );
        Log::debug('Submission Form: Created submission');

        $this->imageCount = 0;
        collect($this->attachments)->each(function($attachment) use ($submission) {
            if (in_array($attachment->getMimeType(), ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'])) {
                $submission->addMedia($attachment->getRealPath())->toMediaCollection('images');
                $this->imageCount++;
            } else {
                $submission->addMedia($attachment->getRealPath())->toMediaCollection('documents');
                $this->docCount++;
            }

        });

        Log::debug('Image count: ' . $this->imageCount);
        Log::debug('Document count: ' . $this->docCount);
        Log::debug('Submission Form: Uploaded images');

        $this->imageCount = 0;
        $this->docCount = 0;
        $submission->refresh();

        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.work-logs.show.submission-form');
    }
}
