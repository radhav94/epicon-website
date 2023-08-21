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
            'display_language' => 'ENGLISH',
            // 'page' => 1,
            // 'tray_limit' => 5,
        ];

        $result = CurlAPI("pages/homepage", "GET", $params);
        // dd($result['data']['list']['0']);
        // dd($result);
        if ($result && @$result['success'] ==  true) {

            $displayLanguageParam = setLanguageParameter();

            // dd($result);
            return view('pages.homepage', compact('result', 'displayLanguageParam'));
        }
    }
}
