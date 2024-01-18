<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class LiveTvController extends Controller
{
    public function livetv(Request $request){
        SilentLoginFunction();
        $routenamed = Route::currentRouteName();
        if (empty($routenamed)) {
            $routenamed = "live-tv";
        }
        $livetvArr = CurlAPI("contents/livetv", 'GET', '' , 3, true);

        $pagetitle = "LIVETV";
        $pagetype = ($routenamed == 'home') ? 'HOME' : "LIVETV";
        if($livetvArr && @$livetvArr['success'] == true){
            $response = @$livetvArr['content'];
            $displayLanguageParam = setLanguageParameter();

            $meta = getMeta($routenamed);
            return view('pages.livetv.live-tv', compact('response','meta', 'displayLanguageParam'));
        }else{
            return view('pages.error.data-error');
        }
    }

}
