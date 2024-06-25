<?php

namespace App\Http\Middleware;

use App\Helpers\FlashStatusCode;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminIsPermitted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(! auth()->user()->isAdmin())
            return redirect()->route('home')->with([
                'status' => FlashStatusCode::ERROR,
                'message' => 'You are not permitted to do this action',
            ]);

        return $next($request);
    }
}
