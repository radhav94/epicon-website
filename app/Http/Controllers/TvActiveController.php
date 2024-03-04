<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

// Testing URL
// https://epicon-revamp-v2.test/activatetv/F06B1C
class TvActiveController extends Controller
{
    public function activate_tv_code($code = 0)
    {
        if (isset($code) && $code != 0) {
            $user_id  = request()->session()->get('user_id');
            if (!isset($user_id)) {
                request()->session()->put('activetvcode', $code);
                request()->session()->put('tv_verify', true);
                header("Location:" . url('?type=login'));
            } else {
                $this->verifyTvCode($code);
                return redirect("?type=activetv");
            }
        } else {
            return  redirect('/');
        }
    }


    public  function verifyTvCode($code)
    {
        $postData['code'] = $code;
        $result = CurlAPI("users/verifyCode", "POST", $postData, 2, true);
        Log::info('------------------- TV Activation Result Start ---------------');
        Log::info(json_encode($result));
        Log::info('------------------- TV Activation Result End ---------------');
        session()->forget('activetvcode');
        session()->forget('tv_verify');
        return $result;
    }
}
