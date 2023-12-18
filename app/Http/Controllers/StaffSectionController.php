<?php

namespace App\Http\Controllers;

use App\Models\StaffSection;
use Illuminate\Http\Request;

class StaffSectionController extends Controller
{
    public function create() {
        return view('pages.infostructure-sections.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|unique:staff_sections'
        ]);

        $staffSection = StaffSection::create([
            'name' => $request->name
        ]);

        return redirect()->route('staff-sections.show', $staffSection->id)->with(['status', 'success', 'message' => 'Bahagian ditambah']);
    }

    public function index() {
        return view('pages.infostructure-sections.index', StaffSection::all());
    }

    public function show(StaffSection $staffSection) {
        request()->flash(['status' => 'success', 'message' => 'Bahagian ditambah']);
        // return $staffSection;
        return view('pages.infostructure-sections.show', ['staffSection' => $staffSection]);
    }

    public function edit() {

    }

    public function update() {

    }

    public function destroy() {

    }

}
