<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TvActiveController extends Controller
{
    public function activate_tv_code($code = 0)
    {
        // if (isset($code) && $code != 0) {
        SilentLoginFunction();
        profileActive();
        $user_id  = request()->session()->get('user_id');

        if (!isset($user_id)) {
            session(['activetvcode' => $code]);
        } else {
            $postData['code'] = $code;
            $result = CurlAPI("users/verifyCode", "POST", $postData, 2, true);
            $data['session'] = request()->session()->all();
            $data['result'] = $result;
            dd($data);
        }



        // } else {
        //     return  redirect('/');
        // }
    }
}
