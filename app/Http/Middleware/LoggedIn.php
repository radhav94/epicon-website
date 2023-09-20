<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (isUserLoggedIn()) {
            return $next($request);
        }
        if ($request->ajax()) {
            return JSONResponse(400, 'Please log in or sign up to continue.');
        }
        return redirect(route('homepage'));
    }
}
