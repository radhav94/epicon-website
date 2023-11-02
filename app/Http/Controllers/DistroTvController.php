<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class DistroTvController extends Controller
{   
    private  $limit;
    public function  __construct()
    {
        $this->limit = 10;
    }
    public function index($slug = 'home-v2')    
    {
        $pageslug = strtolower($slug);

        $routenamed = $pageslug;

        if (empty($routenamed)) {
            $routenamed = $pageslug;
        }
        profileActive();
        $data = $this->homepageData($slug);
        //dd($data);
        $result = $data['result'];

        if (request()->v == 2) {
            foreach ($result['pageData']['list'] as $key => $value) {
                d($value);
            }
            dd($result);
        }
        $pagetitle = @$result['data']['name'];
        $pagetype = ($routenamed == 'homepage' || $routenamed == 'home' || $routenamed == 'home-v2') ? 'HOME' : "CATALOG";
        if ($result && @$result['success'] ==  true) {
            $displayLanguageParam = $data['displayLanguageParam'];
            $stories = $data['stories'];
            // if ($displayLanguageParam == 'HINDI') {
            //     $meta = $this->getHindiMeta($pagetype, $pagetitle, $routenamed);
            // } else {
            //     $meta = $this->getMeta($pagetype, $pagetitle, $routenamed);
            // }
            //$meta_title = $meta['title'];
            // dd($meta);
            // $meta_title = strtoupper($slug);
            return view('pages.homepage-distro', compact('result', 'displayLanguageParam', 'stories'));
                    }
        return view('pages.error.404');
    }

    private function homepageData($slug = 'home-v2', $page = 1)
    {
        $stories = [];
        $listlang = Session::has('listLanguage') ? Session::get('listLanguage') : 'all';
        $displang = Session::has('displayLanguage') ? Session::get('displayLanguage') : 'en';
        $params = [
            'slug' => $slug,
            'list_language' => checkLang($listlang),
            'display_language' => checkLang($displang),
            'page' => $page,
            'limit' => $this->limit,
        ];

        if (isUserLoggedIn()) {
            $params['user_id'] = getUserId();
            $params['profile_id'] = getProfileId();
        }

        $result = CurlAPI("pages/distrotv/page", "GET", '', 1);
        //dd($result);
        if ($result && @$result['success'] ==  true) {
            $data = $result['data'] ?? [];
            $lists = $data['list'] ?? [];
            foreach ($lists as $list) {
                if (@$list['slug'] == "short-and-sweet") {
                    $stories = $this->epicShots();
                    break;
                }
                continue;
            }
        }
        $displayLanguageParam = setLanguageParameter();
        return [
            'result' => $result,
            'displayLanguageParam' => $displayLanguageParam,
            'stories' => $stories
        ];
    }

    public function loadMore(Request $request)
    {
        $slug = ($request->route == '/' || $request->route == 'hi') ? 'home-v2' : $request->route;
        $data = $this->homepageData($slug, $request->page);
        $result = $data['result'];
        if ($result && @$result['success'] ==  true) {
            $displayLanguageParam = $data['displayLanguageParam'];
            $stories = $data['stories'];

            $view = view('display.display-default', compact('result', 'displayLanguageParam', 'stories'))->render();

            return JSONResponse(
                200,
                'Success.',
                [
                    'html' => $view,
                ]
            );
        }
    }
    
    public function detail($pageslug, $contentslug, $season = null, $episode = null)
    {
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
                $contentID = $content['ID'] ?? "";
                $morelike_curlID = count(@$morelike_curl['data']) == 1 && @$morelike_curl['data'][0]['ID'] ? @$morelike_curl['data'][0]['ID'] : '';
                //check most like content and active content are same 
                if ($morelike_curlID && $morelike_curlID == $contentID) {
                    //if most like content has only one content and is same then set empty most like content
                    $morelike = [];
                } else {
                    $morelike = $morelike_curl['data'];
                }
            }

            //get about tab data
            $params = ['content_id' => $content['ID']];
            $about_curl = CurlAPI("pages/about", "POST", $params, 1);
            if ($about_curl && @$about_curl['success'] ==  true) {
                $about = $about_curl['data'];
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
            if ($content['asset_type'] == 'LISTEN') {
                $template = 'pages.detail.podcast';
            }

            return view($template, compact('content', 'displayLanguageParam', 'trailers', 'morelike', 'about'));
        }

        return view('pages.error.404');
    }
}
