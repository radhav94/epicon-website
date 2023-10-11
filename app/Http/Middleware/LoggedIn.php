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
            $response = update_user_session();
            if (!$response) {
                $request->session()->flush();
                return redirect(route('homepage') . "?type=logout");
            }
            return $next($request);
        }
        if ($request->segment(1) == "kids") {
            $url = $request->url();
            return redirect(route('homepage') . "?profile=kids&redirect=$url");
        }
        if ($request->ajax()) {
            return JSONResponse(400, 'Please log in or sign up to continue.');
        }
        return redirect(route('homepage'));
    }
}
