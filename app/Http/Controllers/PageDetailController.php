<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class PageDetailController extends Controller
{
    public function detail($pageslug, $contentslug, $season = null, $episode = null)
    {
        $request = request();
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
        $pagetype = in_array($pageslug, ['homepage', 'home', 'home-v2']) ? 'HOME' : 'CATALOG';
        $result = CurlAPI($url, "GET", $params, 1);
        if ($result && @$result['success'] ==  true) {
            $displayLanguageParam = setLanguageParameter();
            // if ($displayLanguageParam == 'HINDI') {
            //     $meta = $this->getHindiMeta($pagetype, $contentslug, $pageslug);
            // } else {
            //     $meta = $this->getMeta($pagetype, $contentslug, $pageslug);
            // }
            $content = $result['content'] ?? [];

            if (empty($content)) {
                return view('pages.error.404');
            }

            $trailers = [];
            $morelike = [];

            //get trailers tab data
            $params = ['content_id' => @$content['ID']];

            $trailers_curl = CurlAPI("pages/trailers-and-more", "POST", $params, 1, false, true);
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
            $about = [];
            $params = ['content_id' => @$content['ID']];
            $about_curl = CurlAPI("pages/about", "POST", $params, 1, false, true);
            if ($about_curl && @$about_curl['success'] ==  true) {
                $about = $about_curl['data'] ?? [];
            }

            /*if (request()->get('v') != '') {
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
            }*/

            $template = 'pages.detail.page-detail';
            if (@$content['asset_type'] == 'LISTEN') {
                $template = 'pages.detail.podcast';
            }

            $meta_title = $content['meta_title'] ?? @$content['title'];
            if($meta_title){
                if (substr(trim($meta_title), -9) === '| EPIC ON') {
                    $meta_title = substr($meta_title, 0, -9);
                } 
            }

            $meta = [
                'title' => $meta_title,
                'description' => @$content['description']
            ];
            
            $nextmovieArray =[];
            $nextval=[];
            if($content['content_type'] == "VIDEO"){
                if(!session()->has('nextmovieArray')){
                    $params = ['catalog_slug' => 'movies','kids_content'=>kidsMode() ? 'true' : 'false'];
                    $nextmovieArray = CurlAPI("v2Content/standaloneContent/", "GET", $params, 1);
                    if ($nextmovieArray && @$nextmovieArray['success'] ==  true) {

                        $request->session()->put('nextmovieArray', $nextmovieArray);
                    }
                }
                $nextmovieArray = session()->get('nextmovieArray') ?? [];
                if (!empty($nextmovieArray && isset($nextmovieArray['data']))) {
                    $key = array_search($contentslug, array_column($nextmovieArray['data'],'slug'));
                        $nextKey = ($key !== false) ? $key+1 : 0;
                        $nextval = $nextmovieArray['data'][$nextKey] ?? '';
                        if ($nextval == '' && $nextKey == count($nextmovieArray['data'])) {
                            session()->forget('nextmovieArray');
                        }
                    }


            }
           
            return view($template, compact('content', 'displayLanguageParam', 'trailers', 'morelike', 'meta', 'about', 'pageslug','contentslug','nextval'));
        }

        if (strtolower($pageslug) === 'en') {
            $pageslug = request()->segment(2);
        }

        $pageCheckArr = array_map('strtolower', array('ebook', 'ebooks', 'epic-shorts', 'watch', 'genre', 'listen'));
        if (in_array(strtolower($pageslug), $pageCheckArr)) {
            return redirect('/', 301);
        } else {
            return redirect($pageslug, 301);
        }

        // return view('pages.error.404');
    }

    public function clap(Request $request)
    {
        $params = [
            'content_id' => $request->content_id,
        ];
        $result = CurlAPI("pages/clap", "POST", $params, 1, false, true);

        if ($result && @$result['success'] ==  true) {
            return JSONResponse(200, 'Success', ['claps' => countConvert(@$result['claps'])]);
        } else {
            return JSONResponse(400, 'Some error occured');
        }
    }
}
