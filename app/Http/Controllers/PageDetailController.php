<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class PageDetailController extends Controller
{
    public function detail($pageslug, $contentslug, $season = null, $episode = null)
    {
        SilentLoginFunction();
        $url = "pages/episode/{$pageslug}/{$contentslug}";
        $params = [];
        if ($season && $episode) {
            $url .= "/{$season}/{$episode}";
        } else if ($season) {
            $url .= "/{$season}";
        }
        // && !empty(getProfileId()) -> handle for old user
        if (isUserLoggedIn() && !empty(getProfileId())) {
            $params['user_id'] = getUserId();
            $params['profile_id'] = getProfileId();
        }

        $result = CurlAPI($url, "GET", $params, 1);
        if ($result && @$result['success'] ==  true) {
            $displayLanguageParam = setLanguageParameter();

            $content = $result['content'] ?? [];

            if(empty($content)){
                return view('pages.error.404');
            }

            $trailers = [];
            $morelike = [];

            //get trailers tab data
            $params = ['content_id' => @$content['ID']];

            $trailers_curl = CurlAPI("pages/trailers-and-more", "POST", $params, 1);
            if ($trailers_curl && @$trailers_curl['success'] ==  true) {
                $trailers = $trailers_curl['data'] ?? [];
            }

            //get more like this tab  data
            $params = ['catalog_slug' => @$content['catalog_slug']];
            $morelike_curl = CurlAPI("v2Content/related/" . @$content['ID'], "GET", $params, 1);
            if ($morelike_curl && @$morelike_curl['success'] ==  true) {

                $morelike_curlID = count(@$morelike_curl['data']) == 1 && @$morelike_curl['data'][0]['ID'] ? @$morelike_curl['data'][0]['ID'] : '';
                //check most like content and active content are same 
                if ($morelike_curlID && $morelike_curlID == @$content['ID']) {
                    //if most like content has only one content and is same then set empty most like content
                    $morelike = [];
                } else {
                    $morelike = $morelike_curl['data'] ?? [];
                }
            }

            //get about tab data
            $params = ['content_id' => @$content['ID']];
            $about_curl = CurlAPI("pages/about", "POST", $params, 1);
            if ($about_curl && @$about_curl['success'] ==  true) {
                $about = $about_curl['data'] ?? [];
            }


            if (request()->get('v') != '') {
                // dd($about);
                echo '--------Trailers --------';
                d($trailers);
                echo '--------morelike --------';

                d($morelike);
                echo '--------about --------';

                d($about);
                echo '--------result --------';

                dd($result);
                die;
            }

            $template = 'pages.detail.page-detail';
            if (@$content['asset_type'] == 'LISTEN') {
                $template = 'pages.detail.podcast';
            }

            return view($template, compact('content', 'displayLanguageParam', 'trailers', 'morelike', 'about', 'pageslug'));
        }

        return view('pages.error.404');
    }

    public function clap(Request $request)
    {
        $params = [
            'content_id' => $request->content_id,
        ];
        $result = CurlAPI("pages/clap", "POST", $params);

        if ($result && @$result['success'] ==  true) {
            return JSONResponse(200, 'Success', ['claps' => countConvert(@$result['claps'])]);
        } else {
            return JSONResponse(400, 'Some error occured');
        }
    }
}
