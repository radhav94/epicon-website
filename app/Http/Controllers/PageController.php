<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class PageController extends Controller
{
    public function index()
    {

        $params = [
            // 'slug' => 'home-v2',
            'slug' => 'movies',
            'list_language' => 'ALL',
            'display_language' => 'ENGLISH',
            // 'page' => 1,
            // 'tray_limit' => 5,
        ];

        $result = CurlAPI("pages/homepage", "GET", $params);
        // dd($result['data']['list']['0']);
        // $temp = [];
        // foreach ($result['data']['list'] as $key => $value) {
        //    $temp[] = $value['display_type'];
        // }
        // dd(array_unique(array_column($result['data']['list'], "display_type")));
        // dd($result);
        if ($result && @$result['success'] ==  true) {

            $displayLanguageParam = setLanguageParameter();

            // dd($result);
            return view('pages.homepage', compact('result', 'displayLanguageParam'));
        }
    }
}
