<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpcomingController extends Controller
{
    public function UpcomingEpicon(){
        $UpcomingResponse = CurlAPI("pages/upcomingContent", 'GET', '' , 1);

        if($UpcomingResponse && @$UpcomingResponse['success'] == true){
            $Upcomingdata = $UpcomingResponse['data'] ?? [];

            return view('pages.upcoming-epicon')->with('upcoming',$Upcomingdata);
        }else{
            return view('pages.error.data-error');
        }
    }
}
