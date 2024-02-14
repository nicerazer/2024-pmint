<?php

namespace App\Livewire\Forms;

use App\Helpers\WorkLogCodes;
use App\Models\Submission;
use App\Models\WorkLog;
use App\Models\WorkScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Livewire\Form;
use Livewire\WithFileUploads;

class WorklogForm extends Form
{
    use WithFileUploads;

    public $workUnit = "";
    public $activityType = 'main';
    public $workMain;
    public $workAlternative = '';
    public $workNotes = '';
    public $workStatus = WorkLogCodes::ONGOING;
    public $started_at;
    public $expected_submitted_at;
    public $submissionNotes = '';
    public $attachments = [];

    public function rules()
    {
        return [
            'workUnit' => 'required|exists:App\Models\StaffUnit,id',
            'activityType' => 'required|string',
            'workMain' => 'required_if:activityType,|exists:App\Models\WorkScope,id',
            'workAlternative' => 'string',
            'workNotes' => 'string',
            'workStatus' => 'required', Rule::in([WorkLogCodes::ONGOING, WorkLogCodes::SUBMITTED]),
            'started_at' => 'required|date',
            'expected_submitted_at' => 'required|date',
            'submissionNotes' => 'string',
            'attachments' => 'nullable',
            'attachments.*' => ['nullable', 'max:1000000',
                File::types([
                    'image/jpg', 'image/jpeg', 'image/png', 'image/gif',
                    'text/csv', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/rtf', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'application/gzip', 'application/pdf', 'application/vnd.rar', 'application/zip', 'application/x-7z-compressed'
                ])],
        ];
    }

    public function store() {
        $this->validate();
        $attributes = [
            'description' => $this->workNotes,
            'status' => $this->workStatus,
            'started_at' => $this->started_at,
            'expected_at' => $this->expected_submitted_at,
            'author_id' => auth()->user()->id,
            'staff_section_id' => $this->activityType == 'main' ?
                WorkScope::find($this->workMain)->id : auth()->user()->staff_section_id,
            'work_scope_id' => $this->activityType == 'main' ? $this->workMain : null,
            'custom_workscope_title' => $this->workAlternative,
        ];

        DB::beginTransaction();

        $worklog = WorkLog::create($attributes);

        if ($this->workStatus == WorkLogCodes::COMPLETED) {
            // Create a submission
            Submission::create([
                'body' => $this->submissionNotes,
                'submitted_at' => $this->expected_submitted_at,
                'work_log_id' => $worklog->id
            ]);

            collect($this->attachments)->each(function($attachment) use ($worklog) {
                if (in_array($attachment->getMimeType(), ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'])) {
                    $worklog->latestSubmission->addMedia($attachment->getRealPath())->toMediaCollection('images');
                } else {
                    $worklog->latestSubmission->addMedia($attachment->getRealPath())->toMediaCollection('documents');
                }
            });
        }

        DB::commit();

    }
}
