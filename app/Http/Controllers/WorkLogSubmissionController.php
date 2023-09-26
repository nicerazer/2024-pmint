<?php

namespace App\Http\Controllers;

use App\Models\WorkLog;
use App\Http\Requests\StoreWorkLogRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class WorkLogSubmissionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function update(WorkLog $worklog) : RedirectResponse
    {
        if (! Gate::allows('worklog-submission')) {
            return redirect()->back(Response::HTTP_UNAUTHORIZED)->with([
                'message' => 'Pengguna bukan staff / Masalah data, sila hubungi admin.',
                'status' => 'error',
            ]);
        }

        $worklog->submitted_at = now();
        $worklog->save();

        return redirect()->back()->with([
            'message' => 'Log Kerja berjaya dihantar untuk semak',
            'status' => 'info',
        ]);
    }
}
