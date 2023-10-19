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
        $segment = $request->segment(1) !='hi' ? $request->segment(1):$request->segment(2);
        $kidsmode = session()->get('kidsMode') ?? false;
         
        /* user session update and logout if auth token mismatch */
        if (isUserLoggedIn()) {
            $response = update_user_session();
            if (!$response) {
                $request->session()->flush();
                return redirect(route('homepage') . "?type=logout");
            }else{
               if($segment !='kids' && $kidsmode && !$request->ajax()){
                return redirect(route('kidsIndex'));
               }
            }

            return $next($request);
        }
        if ($request->ajax()) {
            return JSONResponse(400, 'Please log in or sign up to continue.');
        }
        return redirect(route('homepage'));
    }
}
