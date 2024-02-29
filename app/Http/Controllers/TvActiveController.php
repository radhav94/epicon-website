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
        
        dd($code);



        // } else {
        //     return  redirect('/');
        // }
    }
}
