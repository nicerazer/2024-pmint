<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkScopeRequest;
use App\Http\Requests\UpdateWorkScopeRequest;
use App\Models\WorkScope;

class WorkScopeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {

    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkScopeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkScope $workscope)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkScope $workscope)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkScopeRequest $request, WorkScope $workscope)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkScope $workscope)
    {
        //
    }
}
