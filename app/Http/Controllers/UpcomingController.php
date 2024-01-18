<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpcomingController extends Controller
{
    public function UpcomingEpicon(){
         SilentLoginFunction();
         $data = ['auth_token' => config('epicconfig.EPICAPI.API_AUTH_TOKEN')];
         $UpcomingResponse = CurlAPI("pages/upcomingContent", 'GET', $data , 1);

        if($UpcomingResponse && @$UpcomingResponse['success'] == true){
            $Upcomingdata = $UpcomingResponse['data'] ?? [];
            $upcoming = $Upcomingdata;
            
            $meta = getMeta('coming-soon');
            
            // return view('pages.upcoming-epicon')->with('upcoming',$Upcomingdata);
            return view('pages.upcoming-epicon', compact('upcoming', 'meta'));
        }else{
            return view('pages.error.data-error');
        }
    }
}
