<?php

namespace App\Http\Controllers;

use App\Models\StaffSection;
use Illuminate\Http\Request;

class StaffSectionController extends Controller
{
    public function create() {

    }

    public function store() {

    }

    public function index() {
        return view('pages.staff-sections.index', StaffSection::all());
    }

    public function show() {

    }

    public function edit() {

    }

    public function update() {

    }

    public function destroy() {

    }

}
