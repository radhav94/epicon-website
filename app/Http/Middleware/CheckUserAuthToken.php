<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserAuthToken
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
                return redirect(route('homepage')."?type=logout");
            }
        }
        return $next($request);
    }
}
