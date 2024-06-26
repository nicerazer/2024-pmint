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
use App\Helpers\FlashStatusCode;
use App\Models\SubmissionAccept;
use Illuminate\Support\Facades\DB;

class WorkLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(StoreWorkLogRequest $request)
    // {
    //     if (! Gate::allows('worklog-add')) {
    //         return redirect()->back()->with([
    //             'message' => 'Pengguna bukan staff, sila hubungi admin.',
    //             'status' => 'error',
    //         ]);
    //     }
    //     DB::beginTransaction();

    //     dd($request);

    //     $validated = $request->safe()->only([
    //         'title', 'image-uploads', 'body'
    //     ]);

    //     $validated->push('author_id', auth()->user()->id);

    //     $worklog = WorkLog::create($validated);

    //     $worklog->submission()->create();

    //     $validated = $request->validate([
    //         'image-uploads' => 'array'
    //     ]);

    //     // TODO : is this path or just filename
    //     foreach($validated['image-uploads'] as $image) {
    //         $worklog->addMedia($image)->toMediaCollection('images');
    //     }

    //     DB::commit();

    //     // TODO : temporary upload process?
    //     // Process temporary uploads
    //     // - Check if available
    //     // - Iterate process
    //     // --- Add to media library object
    //     // --- This automatically move file from temporary to actual collection


    //     redirect()->route('worklog.index');
    // }

    /**
     * Display the specified resource.
     */
    public function show(WorkLog $worklog)
    {
        if (auth()->user()->isStaff() && auth()->user()->id != $worklog->author_id) {
            return redirect()->route('home')->with([
                'message' => 'Tidak boleh akses log kerja bukan milik anda.',
                'status-class' => 'error',
            ]);
        }

        return view('pages.work-logs.show.index', ['worklog' => $worklog]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(WorkLog $worklog)
    // {
    //     if (! Gate::allows('worklog-update-basic')) {
    //         return redirect()->back()->with([
    //             'message' => 'Pengguna bukan staff / Masalah data, sila hubungi admin.',
    //             'status' => 'error',
    //         ]);
    //     }

    //     if ($worklog == null) return redirect()->back()->with([
    //         'message' => 'Log kerja tidak wujud!',
    //         'status' => 'error',
    //     ]);

    //     return view('pages.worklogs.edit', compact('worklog'));
    // }

    // public function submit(WorkLog $workLog)
    // {
    //     return redirect()->route('work-scopes.index')->with([
    //         'status' => FlashStatusCode::SUCCESS,
    //         'message' => 'Log kerja selesai dihantar',
    //     ]);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(UpdateWorkLogRequest $request, WorkLog $worklog)
    // {
    //     if (! Gate::allows('worklog-update-basic')) {
    //         return redirect()->back()->with([
    //             'message' => 'Pengguna bukan staff / Masalah data, sila hubungi admin.',
    //             'status' => 'error',
    //         ]);
    //     }

    //     $validated = $request->safe()->all();

    //     $worklog->description = $validated['description'];
    //     $worklog->body = $validated['workscope_id'];

    //     $worklog->expected_at = $validated['expected_at'];

    //     $worklog->save();

    //     return redirect()->back()->with([
    //         'message' => 'Kemaskini berjaya',
    //         'status' => 'success',
    //     ]);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(WorkLog $worklog)
    // {
    //     //
    // }
}
