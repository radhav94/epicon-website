<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PopularController extends Controller
{
    public function NewsPopular(){
        $PopularResponse = CurlAPI("pages/getPopularContent", 'GET', '' , 1);
        // dd($PopularResponse);
        if($PopularResponse && @$PopularResponse['success'] == true){
            $Populardata = @$PopularResponse['data'];
            return view('pages.new-popular')->with('popular',$Populardata);
        }else{
            return view('pages.error.data-error');
        }
        
    }
}
