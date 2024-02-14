<?php

namespace App\Http\Controllers;

use App\Helpers\UserRoleCodes;
use App\Models\StaffSection;
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

        if (
            session('selected_role_id') == UserRoleCodes::EVALUATOR_1 ||
            session('selected_role_id') == UserRoleCodes::EVALUATOR_2 ||
            session('selected_role_id') == UserRoleCodes::STAFF
        ) {
            return view('pages.home.staff');
        }

        // if (session('selected_role_id') == UserRoleCodes::EVALUATOR_2) {
        //     return view('pages.home.evaluator-2', [
        //         'staff_sections' => StaffSection::all(),
        //     ]);
        // }
    }
}
