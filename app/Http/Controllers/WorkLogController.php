<?php

namespace App\Http\Controllers;

use App\Models\WorkLog;
use App\Http\Requests\StoreWorkLogRequest;
use App\Http\Requests\UpdateWorkLogRequest;
use Helper\WorkLogHelper;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;

class WorkLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query types?
        // Admin, Penilai 1, Penilai 2, Warga Kerja
        // Sort By Status (Ongoing, Submitted, To Revise, Completed, Rejected)

        // $worklogs = WorkLog::latest();

        // Statuses from include to exclude them.

        // ONGOING   0
        // SUBMITTED 1
        // TOREVISE  2
        // COMPLETED 3
        // REJECTED  4
        // $statuses = ['ongoing', 'submitted', 'torevise', 'completed', 'rejected'];

        // $worklogs->when($statuses, function (Builder $query, array $statuses) {
        //     foreach ($statuses as $status) {
        //         $query->orWhere('status', $status);
        //     }
        // });

        // $sort_by = $request->query('sort_by');

        // // Status sortings
        // $worklogs->when($sort_by['expected_at'], function (Builder $query, string $expected_at) {
        //     $expected_at = in_array("asc", ['asc', 'desc']) ? $expected_at : 'asc'; // Make sure safe
        //     $query->orderBy('expected_at', $expected_at);
        // })->when($sort_by['started_at'], function (Builder $query, string $started_at) {
        //     $started_at = in_array("asc", ['asc', 'desc']) ? $started_at : 'asc'; // Make sure safe
        //     $query->orderBy('started_at', $started_at);
        // })->when($sort_by['submitted_at'], function (Builder $query, string $submitted_at) {
        //     $submitted_at = in_array("asc", ['asc', 'desc']) ? $submitted_at : 'asc'; // Make sure safe
        //     $query->orderBy('submitted_at', $submitted_at);
        // });
        return view('pages.work-logs.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('worklog-add')) {
            return redirect()->back()->with([
                'message' => 'Pengguna bukan staff, sila hubungi admin.',
                'status' => 'error',
            ]);
        }

        return view('pages.work-logs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkLogRequest $request)
    {
        if (! Gate::allows('worklog-add')) {
            return redirect()->back()->with([
                'message' => 'Pengguna bukan staff, sila hubungi admin.',
                'status' => 'error',
            ]);
        }

        $validated = $request->safe()->all();

        WorkLog::create($validated);

        redirect()->route('worklog.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkLog $workLog)
    {
        return view('pages.work-logs.show', compact('workLog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkLog $worklog)
    {
        if (! Gate::allows('worklog-update-basic')) {
            return redirect()->back()->with([
                'message' => 'Pengguna bukan staff / Masalah data, sila hubungi admin.',
                'status' => 'error',
            ]);
        }

        if ($worklog == null) return redirect()->back()->with([
            'message' => 'Log kerja tidak wujud!',
            'status' => 'error',
        ]);

        return view('pages.worklogs.edit', compact('worklog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkLogRequest $request, WorkLog $worklog)
    {
        if (! Gate::allows('worklog-update-basic')) {
            return redirect()->back()->with([
                'message' => 'Pengguna bukan staff / Masalah data, sila hubungi admin.',
                'status' => 'error',
            ]);
        }

        $validated = $request->safe()->all();

        $worklog->description = $validated['description'];
        $worklog->body = $validated['workscope_id'];

        $worklog->expected_at = $validated['expected_at'];

        $worklog->save();

        return redirect()->back()->with([
            'message' => 'Kemaskini berjaya',
            'status' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkLog $worklog)
    {
        //
    }
}
