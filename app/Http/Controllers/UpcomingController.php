<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpcomingController extends Controller
{
    public function UpcomingEpicon(){
         SilentLoginFunction();
         $UpcomingResponse = CurlAPI("pages/upcomingContent", 'GET', '' , 1);

        if($UpcomingResponse && @$UpcomingResponse['success'] == true){
            $Upcomingdata = $UpcomingResponse['data'] ?? [];
            $upcoming = $Upcomingdata;
            $meta['title'] = "Get to Know About Upcoming OTT New Web Series and Movies";
            $meta['description'] = "Exciting collection of upcoming web series and movies on OTT platforms. Watch wide range of Hindi and English TV show and movies online";
            // return view('pages.upcoming-epicon')->with('upcoming',$Upcomingdata);
            return view('pages.upcoming-epicon', compact('upcoming', 'meta'));
        }else{
            return view('pages.error.data-error');
        }
    }
}
