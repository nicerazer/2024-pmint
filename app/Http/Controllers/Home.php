<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Home extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (auth()->user()->isHR()) {
            return view('pages.staff-sections.index');
        }

        $workLogs = array('ongoing' => [], 'with_comments' => []);

        $workLogs['ongoing'] = auth()->user()->workLogs()
        ->select('*')
        ->selectRaw('TIMEDIFF(expected_at, now()) AS time_left')
        ->orderBy('time_left', 'desc')
        ->limit(5)->get();

        // return $workLogs['ongoing'][0];

        // return $workLogs['ongoing'];
        // return now();
        // "2023-09-26T08:39:29.322770Z"
        return view('pages.home.staff-evaluators', compact('workLogs'));
    }
}
