<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminCheckAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    // Check if user has admin role
    if (Auth::check() && Auth::user()->role === 1) {
        return $next($request);
    }


    // User is authenticated and has admin role, continue to the requested route
    return $next($request);
    }
}