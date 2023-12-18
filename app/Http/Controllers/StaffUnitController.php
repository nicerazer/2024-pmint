<?php

namespace App\Http\Controllers;

use App\Models\StaffSection;
use App\Models\StaffUnit;
use Illuminate\Http\Request;

class StaffUnitController extends Controller
{
    public function create() {
        return view('pages.infostructure-units.create');

    }

    public function store() {

    }

    public function index() {
        return StaffUnit::count();
    }

    public function show(StaffSection $staffSection, StaffUnit $staffUnit) {
        return view('pages.infostructure-units.show', compact('staffSection', 'staffUnit'));
    }

    public function update(Request $request, StaffSection $staffSection, StaffUnit $staffUnit) {
        $staffUnit->name = $request->name;
        $staffUnit->save();

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Nama ditukar kepada ' . $request->name
        ]);
    }

    public function destroy() {

    }


}
