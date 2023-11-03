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

    public function distrotvvideo(Request $request){   
        
        $resultArr = CurlAPI("pages/distrotv/page/".$request->id, "GET", '', 1);
     
        if ($resultArr && @$resultArr['success'] ==  true) {
             $content = $resultArr['pageData'] ?? '';
            return view('pages.detail.distro-details', compact('content'));
        }else{
            return view('pages.error.data-error');
        }
    }
}
