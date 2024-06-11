<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PopularController extends Controller
{
    public function NewsPopular(){
        SilentLoginFunction();
        $data = ['auth_token' => config('epicconfig.EPICAPI.API_AUTH_TOKEN')];
        $PopularResponse = CurlAPI("pages/getPopularContent", 'GET', $data , 1);
        // dd($PopularResponse);
        if($PopularResponse && @$PopularResponse['success'] == true){
            $Populardata = @$PopularResponse['data'];
            return view('pages.new-popular')->with('popular',$Populardata);
        }else{
            return response()->view('pages.error.404', [], 404);
        }
        
    }
}
