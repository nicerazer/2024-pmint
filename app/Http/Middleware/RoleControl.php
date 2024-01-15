<?php

namespace App\Http\Middleware;

use App\Helpers\UserRoleCodes;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ( Auth::user()->roles()->count() == 0) {
            return redirect()->route('your-role-is-empty');
        }

        if (!session()->has('selected_role_id')) {
            $availableRoles = Auth::user()->roles;
            if ($availableRoles->contains(UserRoleCodes::STAFF))
                session(['selected_role_id' => UserRoleCodes::STAFF]);
            else
                session(['selected_role_id' => $availableRoles->first()->id]);
        }

        return $next($request);
    }
}
