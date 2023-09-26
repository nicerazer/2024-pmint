<?php

namespace App\Http\Controllers;

use App\Models\WorkLog;
use App\Http\Requests\StoreWorkLogRequest;
use App\Http\Requests\UpdateWorkLogRequest;
use App\Models\Revision;

class WorkLogController extends Controller
{
    public function store(StoreWorkLogRequest $request, WorkLog $worklog)
    {
        $validated = $request->safe()->all();

        $revision = new Revision();

        $revision->title = $validated['title'];
        $revision->body = $validated['body'];

        $revision->started_at = now();
        $revision->expected_at = $validated['expected_at'];

        $revision->save();

        redirect()->route('worklog.show', $worklog);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkLogRequest $request, WorkLog $worklog)
    {
        $validated = $request->safe()->all();

        $revision = new Revision();

        $revision->title = $validated['title'];
        $revision->body = $validated['body'];

        $revision->expected_at = $validated['expected_at'];

        $revision->save();

        redirect()->route('worklog.show', $worklog);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkLog $worklog)
    {
        $worklog->revision->destroy();

        redirect()->route('worklog.show', $worklog);
    }
}
