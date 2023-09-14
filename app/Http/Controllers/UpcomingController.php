<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpcomingController extends Controller
{
    public function UpcomingEpicon(){
         $UpcomingResponse = CurlAPI("pages/upcomingContent", 'GET', '' , 1);
        // dd($UpcomingResponse);
        if($UpcomingResponse['success'] == true){
            $Upcomingdata = $UpcomingResponse['data'];
            // dd($Upcomingdata);
            return view('pages.upcoming-epicon')->with('upcoming',$Upcomingdata);
        }else{
            return view('pages.404');
        }
    }
}
