<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // $request->session()->forget('user_id');
        // $request->session()->forget('user');
        // $request->session()->forget('user_token');
        // $request->session()->forget('profile_data');
        // $request->session()->flush();
        // session_unset();

        // session()->forget('some_data');
        // session()->flush();
        $request->session()->regenerate();

        $all = $request->session()->all();
        dd($all);
        Session::flush();

        die('here');
        $result = CurlAPI("users/logout", "POST", [], 2);

        dd($result);

        if ($result && @$result['success'] ==  true) {
            Session::flush();

            return JSONResponse(200, 'Logged out successfully', ['redirect' => route('homepage')]);
        } else {
            return JSONResponse(400, 'Some error occured');
        }
    }
}
