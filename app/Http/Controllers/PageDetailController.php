<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class PageDetailController extends Controller
{
    public function detail($pageslug, $contentslug, $season = null, $episode = null)
    {
        $url = "pages/episode/{$pageslug}/{$contentslug}";
        if ($season && $episode) {
            $url .= "/{$contentslug}/{$season}/{$episode}";
        } else if ($season) {
            $url .= "/{$contentslug}/{$season}";
        }
        // echo $url;
        $result = CurlAPI($url, "GET", [], 1);
        // dd($result);
        if ($result && @$result['success'] ==  true) {
            $displayLanguageParam = setLanguageParameter();

            $content = $result['content'];
            $trailers = [];
            $morelike = [];

            //get trailers tab data
            $params = ['content_id' => $content['ID']];
            // $params = ['content_id' => 65769];
            $trailers_curl = CurlAPI("pages/trailers-and-more", "POST", $params, 1);
            if ($trailers_curl && @$trailers_curl['success'] ==  true) {
                $trailers = $trailers_curl['data'];
            }

            //get more like this tab  data
            $params = ['catalog_slug' => $content['catalog_slug']];
            $morelike_curl = CurlAPI("v2Content/related/" . $content['ID'], "GET", $params, 1);
            if ($morelike_curl && @$morelike_curl['success'] ==  true) {
                $morelike = $morelike_curl['data'];
            }

            //get about tab data
            $params = ['content_id' => $content['ID']];
            $about_curl = CurlAPI("pages/about", "POST", $params, 1);
            if ($about_curl && @$about_curl['success'] ==  true) {
                $about = $about_curl['data'];
            }

            // d($trailers);
            // d($morelike);

            // d($about);
            // echo 'About';
            // d($result);
            // die;

            return view('pages.detail.page-detail', compact('content', 'displayLanguageParam', 'trailers', 'morelike', 'about'));
        }
    }

    public function clap(Request $request)
    {
        $params = [
            'content_id' => $request->content_id,
        ];
        $result = CurlAPI("pages/clap", "POST", $params);

        if ($result && @$result['success'] ==  true) {

            return JSONResponse(200, 'Success');
        } else {
            return JSONResponse(400, 'Some error occured');
        }
    }
}
