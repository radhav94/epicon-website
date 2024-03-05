<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

// Testing URL
// https://epicon-revamp-v2.test/activatetv/C85CD7
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
                $result =  $this->verifyTvCode($code);
                if (isset($result) && !empty($result) && $result['success'] == true) {
                    return view('activetv.tv-success', ['result' => $result]);
                } else {
                    return view('activetv.tv-failure', ['result' => $result]);
                }
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
