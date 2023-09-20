<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class LiveTvController extends Controller
{
    public function livetv(){
        $request = Request();
        $livetvArr = CurlAPI("contents/livetv", 'GET', '' , 3, true);
        // dd($livetvArr);
        if($livetvArr && @$livetvArr['success'] == true){
            $response = $livetvArr['content'];
            $displayLanguageParam = setLanguageParameter();
            // dd($displayLanguageParam);
            return view('pages.livetv.live-tv', compact('response', 'displayLanguageParam'));
        }else{
            return view('pages.error.404');
        }
        // dd($response);
    }

}
