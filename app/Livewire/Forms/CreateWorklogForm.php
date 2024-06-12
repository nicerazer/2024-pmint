<?php

namespace App\Livewire\Forms;

use App\Helpers\WorkLogCodes;
use App\Models\StaffUnit;
use App\Models\Submission;
use App\Models\WorkLog;
use App\Models\WorkScope;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Livewire\Form;
use Livewire\WithFileUploads;

class CreateWorklogForm extends Form
{
    use WithFileUploads;

    public $staffUnit = -1;
    public $activityType = 'main';
    public $workScopeMainId = -1;
    public $workAlternative = '';
    public $workNotes = '';
    public $workStatus = ''.WorkLogCodes::ONGOING;
    public $started_at = '2024';
    public $expected_submitted_at;
    public $submissionNotes = '';
    public $attachments = [];


    public function messages()
    {
        return [
            'staffUnit.required' => 'Unit perlu dipilih',
            'staffUnit.exists' => 'Unit tidak wujud dalam sistem',
        ];
    }

    public function rules()
    {
        // return ['staffUnit' => ['required', 'exists:App\Models\StaffUnit,id']];
        return [
            'staffUnit' => ['required', 'exists:App\Models\StaffUnit,id'],
            'activityType' => 'required|string|in:main,alternative',
            // 'workScopeMainId' => 'required|',
            'workScopeMainId' => [function (string $attribute, mixed $value, Closure $fail) {
                if ($this->activityType == 'main') {
                    if (!$value || $value == -1) {
                        $fail("Aktiviti perlu dipilih");
                    } else if (!WorkScope::find($value)) {
                        $fail("Aktiviti tidak wujud dalam sistem");
                    }
                }
            }],
            'workAlternative' => ['nullable','string',function (string $attribute, mixed $value, Closure $fail) {
                if ($this->activityType == 'alternative' && !$value) {
                    $fail("Aktiviti perlu diisi");
                }
            },],
            'workNotes' => 'required|string',
            'workStatus' => ['required', Rule::in([WorkLogCodes::ONGOING, WorkLogCodes::SUBMITTED])],
            'started_at' => 'required|date',
            // 'expected_submitted_at' => ['required','date', function (string $attribute, mixed $value, Closure $fail) {
            //     if ($this->workStatus == WorkLogCodes::ONGOING && !$value) {
            //         $fail("The {$attribute} is invalid.");
            //     }
            // }],
            'expected_submitted_at' => ['required','date'],
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

    // public function setPost(Post $post)
    // {
    //     $this->post = $post;

    //     $this->title = $post->title;

    //     $this->content = $post->content;
    // }

    public function initWorkScope($workScopes) {
        if ($workScopes->isEmpty()) {
            $this->workScopeMainId = -1;
        } else {
            $this->workScopeMainId = -1;
        }
    }

    public function store() {

        $this->validate();

        dd($this->started_at);

        $attributes = [
            'description' => $this->workNotes,
            'status' => $this->workStatus,
            'started_at' => $this->started_at,
            'expected_at' => $this->expected_submitted_at,
            'author_id' => auth()->user()->id,
            'wrkscp_is_main' => $this->activityType == 'main',
            'wrkscp_main_id' => $this->workScopeMainId == -1 ? 1 : $this->workScopeMainId,
            'wrkscp_alt_unit_id' => auth()->user()->unit->id,
            'wrkscp_alt_title' => $this->workAlternative,

            // 'is_work_alternative' => $this->activityType == 'alternative',
            // 'main_staff_section_id' => $this->workScopeMainId,
            // 'alt_staff_section_id' => auth()->user()->staff_section_id,

            // 'is_work_alt' => $this->activityType == 'alternative',
            // // 'staff_section_id' => $this->activityType == 'main' ?
            // //     $this->workScopeMainId : auth()->user()->staff_section_id,
            // 'work_scope_id' => $this->activityType == 'main' ? $this->workScopeMainId : null,
            // 'custom_workscope_title' => $this->workAlternative,
        ];

        DB::transaction(function () use ($attributes) {

            $worklog = WorkLog::create($attributes);

            if ($this->workStatus == WorkLogCodes::SUBMITTED) {
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

        });

    }
}
