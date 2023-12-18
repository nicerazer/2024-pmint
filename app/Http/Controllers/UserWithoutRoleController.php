<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserWithoutRoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (Auth::user()->roles()->count() != 0)
            return redirect()->route('home');
        return 'you have no role assigned. seek admin to assign you a role<br>your user id is : ' . auth()->user()->id;
    }
}
