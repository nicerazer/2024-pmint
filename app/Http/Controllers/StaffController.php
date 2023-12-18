<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function show(User $staff) {
        return view('pages.staffs.show');
    }

    public function create()
    {
        return view('pages.staffs.create');
    }

    public function store()
    {
        return view('pages.staffs.create');
    }
}
