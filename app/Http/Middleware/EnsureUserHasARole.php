<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasARole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (! Auth::user())
        //     redirect()->route('login');

        if ( Auth::user()->roles()->count() == 0) {
            return redirect()->route('your-role-is-empty');
        }
        // dd (Role::find(session('selected_role_id'))->title);

        if (!session()->has('selected_role_id'))
            session(['selected_role_id' => Auth::user()->roles()->first()->id]);

        return $next($request);
    }
}
