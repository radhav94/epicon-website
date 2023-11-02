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
        $segment = $request->segment(1) != 'hi' ? $request->segment(1) : $request->segment(2);
        $kidsmode = session()->get('kidsMode') ?? false;
        if (isUserLoggedIn()) {
            /* check authrization token expired start */
            if (getFirstSegment() != "assets" && !$request->ajax()) {
                $response = update_user_session();
                if (!$response) {
                    session()->flush();
                    return redirect(route('homepage') . "?type=logout");
                }
            }
            /* check authrization token end */
            if ($segment != 'kids' && $kidsmode && !$request->ajax()) {
                return redirect(route('kidsIndex'));
            }
        } else {
            if ($segment == "kids") {
                return redirect(route('homepage') . "?profile=kids");
            }
        }
        return $next($request);
    }
}
