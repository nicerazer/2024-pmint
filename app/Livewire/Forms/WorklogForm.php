<?php

namespace App\Livewire\Forms;

use App\Helpers\WorkLogCodes;
use App\Models\Submission;
use App\Models\WorkLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Form;

class WorklogForm extends Form
{
    public $workUnit = "";
    public $activityType = 'main';
    public $workMain;
    public $workAlternative = '';
    public $workNotes = '';
    public $workStatus = WorkLogCodes::ONGOING;
    public $started_at;
    public $expected_submitted_at;
    public $submissionNotes = '';
    public $image_uploads = [];
    public $document_uploads = [];

    public function rules()
    {
        return [
            'workUnit' => 'required|exists:App\Models\WorkUnit,id',
            'activityType' => 'required|string',
            'workMain' => 'required_if:activityType,|exists:App\Models\WorkScope,id',
            'workAlternative' => 'string',
            'workNotes' => 'string',
            'workStatus' => 'required', Rule::in([WorkLogCodes::ONGOING, WorkLogCodes::SUBMITTED]),
            'started_at' => 'required|date',
            'expected_submitted_at' => 'required|date',
            'submissionNotes' => 'string',
            'image_uploads' => 'array',
            'document_uploads' => 'array',
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
                $this->workMain->staff_section_id : auth()->user()->staff_section_id,
            'is_workscope_custom' => $this->activityType == 'side',
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
            // Add images and documents into the model's media library
            foreach($validated['image-uploads'] as $image) {
                $worklog->addMedia($image)->toMediaCollection('images');
            }
        }

        DB::commit();

    }
}
