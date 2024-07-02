<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AllowsForTheirOwnWorkLogs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (! auth()->user()->id == $request->route()->parameter('worklog')->author_id) {
        if ($request->route()->parameter('worklog')->author_id) {
            return redirect('/');
            return redirect()->route('home')->with([
                'message' => 'Pengguna bukan staff / Masalah data, sila hubungi admin.',
                'status' => 'error',
            ]);
        }
        return $next($request);
    }
}
