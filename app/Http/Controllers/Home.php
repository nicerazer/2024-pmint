<?php

namespace App\Http\Controllers;

use App\Helpers\UserRoleCodes;
use Illuminate\Http\Request;

class Home extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (session('selected_role_id') == UserRoleCodes::ADMIN) {
            return view('pages.home.admin');
        }

        if (session('selected_role_id') == UserRoleCodes::EVALUATOR_1) {
            return view('pages.home.evaluator-1');
        }

        if (session('selected_role_id') == UserRoleCodes::EVALUATOR_2) {
            return view('pages.home.evaluator-2');
        }

        $worklogs = array('ongoing' => [], 'with_comments' => []);

        $worklogs['ongoing'] = auth()->user()->worklogs()
        ->select('*')
        // ->selectRaw('TIMEDIFF(expected_at, \''.now()->format('Y-m-d').'\') AS time_left')
        // ->orderBy('time_left', 'desc')
        ->limit(5)->get();
        // return '';

        // return $workLogs['ongoing'][0];

        // return $workLogs['ongoing'];
        // return now();
        // "2023-09-26T08:39:29.322770Z"
        return view('pages.home.staff');
    }
}
