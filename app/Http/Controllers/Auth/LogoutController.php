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

        $request->session()->forget('user_id');
        $request->session()->forget('user');
        $request->session()->forget('user_token');
        $request->session()->forget('profile_data');
        $request->session()->flush();
        session_unset();
        $request->session()->regenerate();

        $result = CurlAPI("users/logout", "POST", [], 2);

        if ($result && @$result['success'] ==  true) {
            return JSONResponse(200, 'Logged out successfully', ['redirect' => route('homepage')]);
        } else {
            return JSONResponse(200, 'Logged out successfully', ['redirect' => route('homepage')]);
            // return JSONResponse(400, 'Some error occured');
        }
    }
}
