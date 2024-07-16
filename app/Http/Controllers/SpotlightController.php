<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SpotlightController extends Controller
{
    public function index(){
         SilentLoginFunction();
         $spotlightData = CurlAPI("pages/topContents", "GET", null, 1);
        if($spotlightData && @$spotlightData['success'] == true){
            $meta = getMeta("CATALOG", "spotlight", "spotlight");
            return view('pages.spotlight-epicon', compact('spotlightData', 'meta'));
        }else{
            return view('pages.error.data-error');
        }
    }
}