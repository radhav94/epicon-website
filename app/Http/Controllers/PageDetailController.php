<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class PageDetailController extends Controller
{
    public function detail($pageslug, $contentslug)
    {
        $result = CurlAPI("pages/episode/{$pageslug}/{$contentslug}", "GET", [], 1);
        // dd($result);
        if ($result && @$result['success'] ==  true) {
            $displayLanguageParam = setLanguageParameter();

            $content = $result['content'];
            $trailers = [];
            $morelike = [];

            //get trailers data
            $trailers_curl = CurlAPI("pages/trailers-and-more", "POST", [], 1);
            if ($trailers_curl && @$trailers_curl['success'] ==  true) {
                $trailers = $trailers_curl['data'];
            }

            $params = ['catalog_slug' => $content['catalog_slug']];
            $morelike_curl = CurlAPI("v2Content/related/" . $content['ID'], "GET", $params, 1);
            if ($morelike_curl && @$morelike_curl['success'] ==  true) {
                $morelike = $morelike_curl['data'];
            }

            d($trailers);
            d($morelike);

            dd($result);


            return view('pages.page-detail', compact('content', 'displayLanguageParam', 'trailers', 'morelike'));
        }
    }
}
