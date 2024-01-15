<?php

namespace App\Http\Controllers;

use App\Models\StaffSection;
use App\Models\WorkUnit;
use Illuminate\Http\Request;

class WorkUnitController extends Controller
{
    public function create() {
        return view('pages.infostructure-units.create');

    }

    public function index() {
        return WorkUnit::count();
    }

    public function show(StaffSection $staffSection, WorkUnit $workUnit) {
        return view('pages.infostructure-units.show', compact('staffSection', 'workUnit'));
    }

    public function update(Request $request, StaffSection $staffSection, WorkUnit $workUnit) {
        $workUnit->name = $request->name;
        $workUnit->save();

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Nama ditukar kepada ' . $request->name
        ]);
    }
}
