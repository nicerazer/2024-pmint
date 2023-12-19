<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SwitchRoleController extends Controller
{
    public function __invoke(Role $role) {


        // Check if the user has the role he wants to switch
        if (!Auth::user()->roles->pluck('id')->contains($role->id))
            // dd ($role->id);
            return redirect()->back()->with([
                ['status' => 'error'],
                ['message' => 'Anda tiada kebenaran untuk tukar jawatan ' . $role->name],
            ]);

        session(['selected_role_id' => $role->id]);


        return redirect()->route('home')->with([
            ['status' => 'info'],
            ['message' => 'Jawatan ditukar kepada ' . $role->name],
        ]);
    }
}
