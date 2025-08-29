<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is not logged in, redirect to login page
        if (!$request->user()) {
            return redirect()->route('account.login'); // ✅ Fixed: matches your route name
        }

        // If logged in, allow request
        return $next($request);
    }
}
