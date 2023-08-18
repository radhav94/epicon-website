<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
 
        $params = [
            'slug' => 'home-v2',
            'list_language' => 'ALL',
            'display_language' => 'TAMIL',
            'page' => 1,
            'tray_limit' => 5,
        ];

        $result = CurlAPI("pages/homepage", "GET", $params);

        if($result && @$result['success'] ==  true){
            // dd($result);
            return view('pages.homepage', compact('result'));

        }
        
    }
}
