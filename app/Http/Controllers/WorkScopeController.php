<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkScopeRequest;
use App\Http\Requests\UpdateWorkScopeRequest;
use App\Models\WorkScope;

class WorkScopeController extends Controller
{
    public function create()
    {
        return view('pages.work-scopes.create');
    }
}
