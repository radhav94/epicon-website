<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    private  $limit;
    public function  __construct()
    {
        $this->limit = 3;
    }


    public function index($slug = 'home-v2')
    {
        if(in_array($slug,['assets']))
        {
            return false;
        }
        // dd(session()->get('user_token'));

        $request = Request();
        if (!empty($userUuid = ($request->get('userUuid') ?? ""))) {
            session()->put('userUuid', $userUuid);
        }
        
        $pageslug = strtolower($slug);

        SilentLoginFunction();

        profileActive();
        check_Tv_Activation_Code();
        $data = $this->homepageData($slug);
        $result = $data['result'];

        $pagetitle = @$result['data']['name'];
        $pagetype = in_array($pageslug, ['homepage', 'home', 'home-v2']) ? 'HOME' : 'CATALOG';

        if ($result && @$result['success'] ==  true) {
            $displayLanguageParam = $data['displayLanguageParam'];
            $stories = $data['stories'];

            $meta = getMeta($pagetype, $pagetitle, $pageslug);
            /* This code handles CDN cache during load more. (Start) */
            $display_type = array_column($result['data']['list'], "display_type");
            $continuewatching = in_array("continuewatching", $display_type) ? 'YES' : 'NO';
            /* This code handles CDN cache during load more. (End) */

            // dd($meta);
            return view('pages.homepage', compact('result', 'displayLanguageParam', 'stories', 'meta', 'slug', 'continuewatching'));
        }

        $whichLogic = 2;

        if ($whichLogic === 1) {

            $pageCheckArr = array_map('strtolower', array('epicoins-faq', 'listen&pid=15', 'getSubscription', 'login', 'documentaries', 'verifyotp', 'watch', 'loginwithpwd', 'resetpwdapi', 'sendotp', 'sendforgototp', 'verifyforgototp', 'amar-chitra-katha', 'catalog', 'index.php'));
            if (in_array(strtolower($pageslug), $pageCheckArr)) {
                return redirect('/', 301);
            } else {

            \Log::channel('error_404')->debug('-------------- Error ('.date('h:i:s A').')----------------------');
            \Log::channel('error_404')->debug('Error =>'.json_encode($result));
                return response()->view('pages.error.404', [], 404);
            }
        } else {

            $pageCheckArr = array_map('strtolower', array('about-us', 'movies', 'tv-shows', 'podcast', 'explore', 'premium', 'live-tv', 'distro-tv', 'kids', 'new-popular', 'coming-soon', 'feedback', 'privacy', 'terms-of-use'));
            if (!in_array(strtolower($pageslug), $pageCheckArr) && !empty($result)) {
                return redirect('/', 301);
            } else {
                return response()->view('pages.error.404', [], 404);
            }
        }
    }

    public function loadMore(Request $request)
    {
        $start = microtime(true);
        $slug = ($request->route == '/' || $request->route == 'hi') ? 'home-v2' : $request->route;
        $data = $this->homepageData($slug, $request->page);
        $result = $data['result'];
        if ($result && @$result['success'] ==  true) {
            $displayLanguageParam = $data['displayLanguageParam'];
            $stories = $data['stories'];

            $view = view('display.display-default', compact('result', 'displayLanguageParam', 'stories', 'slug'))->render();

            $end = microtime(true);
            $executionTime = $end - $start;
            \Log::channel('responseTime')->info("Request ($slug/$request->page) took $executionTime seconds \n");
            return JSONResponse(
                200,
                'Success.',
                [
                    'html' => $view,
                ]
            );
        }
    }

    public function explore()
    {
        SilentLoginFunction();
        $result = CurlAPI("pages/explorepage", "GET", [], 1);

        $slug = 'explore';

        if ($result && @$result['success'] ==  true) {
            $pagetitle = @$result['data']['name'];


            $pagetype = "CATALOG";

            $meta = getMeta($pagetype, $pagetitle, $slug);

            return view('pages.explore', compact('result', 'meta'));
        }
        \Log::channel('error_404')->debug('--------------(pages/explorepage)  Error ('.date('h:i:s A').')----------------------');
        \Log::channel('error_404')->debug('Error =>'.json_encode($result));
        return response()->view('pages.error.404', [], 404);
    }

    public function explore_details($slug)
    {
        SilentLoginFunction();
        $page = 1;
        $limit = 20;
        $params = [
            'limit' => $limit,
            'page' => $page,
        ];
     
        $result = CurlAPI("pages/explorePage/" . $slug, "GET", $params, 1);

        if ($result && @$result['success'] ==  true) {
            $result = $result['pageData'] ?? [];

            //$meta['title'] = ($displayLanguageParam == 'HINDI') ? 'विवरण खोजें' : 'Explore - ' . ucfirst($slug);
            $meta = exploreGetMeta($slug);
            return view('pages.explore_details', compact('result', 'slug', 'page', 'meta', 'limit'));
        } else {
            \Log::channel('error_404')->debug('--------------(pages/explorePage/)  Error ('.date('h:i:s A').')----------------------');
            \Log::channel('error_404')->debug('Error =>'.json_encode($result));
            return response()->view('pages.error.404', [], 404);
        }
    }

    public function getSpinnerContent(Request $request)
    {
        $result = CurlAPI("pages/spinnerContent", "POST", ['genre' => $request->genre], 1, false, true);


        if ($result && @$result['success'] ==  true) {
            return JSONResponse(
                200,
                'Success.',
                [
                    'image' => @$result['data']['vertical_cover_image']['large'],
                    'url' => url(@$result['data']['url'])
                ]
            );
        } else {
            return JSONResponse(400, 'Error.');
        }
    }

    public function wishlist(Request $request)
    {
        $params = [
            'content_id' => $request->content_id,
            'action' => $request->action,
            'profile_id' => session()->get('active_profile') ?? ''
        ];
        $result = CurlAPI("pages/wishlist", "POST", $params, 1, true);

        if ($result && @$result['success'] ==  true) {
            Cache::forget('getWishlist');
            // session()->forget('user_wishlist');
            $html = '';

            if ($request->type == '1') {
                $wishAction = ($request->action == 'add') ? 'delete' : 'add';

                if ($wishAction == 'add') {
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 28 28" fill="none"><path d="M21.0026 15.1678H15.1693V21.0011C15.1693 21.6428 14.6443 22.1678 14.0026 22.1678C13.3609 22.1678 12.8359 21.6428 12.8359 21.0011V15.1678H7.0026C6.36094 15.1678 5.83594 14.6428 5.83594 14.0011C5.83594 13.3595 6.36094 12.8345 7.0026 12.8345H12.8359V7.00114C12.8359 6.35947 13.3609 5.83447 14.0026 5.83447C14.6443 5.83447 15.1693 6.35947 15.1693 7.00114V12.8345H21.0026C21.6443 12.8345 22.1693 13.3595 22.1693 14.0011C22.1693 14.6428 21.6443 15.1678 21.0026 15.1678Z" fill="white" /></svg>';
                } else {
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 22 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20.8161 0.272093C21.2325 0.65643 21.2584 1.30553 20.8741 1.72189L7.999 15.6699C7.80961 15.8751 7.54478 15.9942 7.26561 15.9998C6.98644 16.0054 6.71706 15.8969 6.51962 15.6995L1.155 10.3349C0.754324 9.9342 0.754324 9.28458 1.155 8.88391C1.55567 8.48324 2.20529 8.48324 2.60596 8.88391L7.2155 13.4935L19.3663 0.330085C19.7506 -0.086281 20.3997 -0.112245 20.8161 0.272093Z" fill="white"/>
                    </svg>';
                }


                $html = '<button class="big-add-list addToList" data-id="' . $request->content_id . '" data-action="' . $wishAction . '" data-type="1">  ' . $icon . '</button>';
            }

            return JSONResponse(200, ($request->action == 'add') ? 'Added to wishlist' : 'Removed from wishlist', ['icon' => $html]);
        } else {
            return JSONResponse(400, 'Something went wrong. Please try again!');
        }
    }

    public function showmidpagedetail(Request $request, $pageslug, $catalog = null, $redirect = 'other')
    {
        $page = 1;
        $slug = $pageslug;
        $limit = 48;
        $perpage = 20;

        $hybidData = $request->all();
        if ($request->is_hybrid) {

            $genre_viewall = json_encode(explode(",", $request->genre_viewall));
            $catalog_viewall = json_encode(explode(",", $request->catalog_viewall));
            $list_language_viewall = json_encode(explode(",", $request->list_language_viewall));
            $params = [
                'is_hybrid' => 'true',
                'catalog_viewall' => $catalog_viewall,
                'genre_viewall' => $genre_viewall,
                'list_language_viewall' => $list_language_viewall,
                'limit' => $limit,
                'page' => 1
            ];
            $epicwebArr = $this->hybridCurl($params);
        } else {
            if ($redirect == 'explore') {
                $url = "pages/midpage/{$pageslug}";
                $epicwebArr = CurlAPI($url, "GET", ['page' => 1, 'catalog_slug' => $catalog,'view_all'=>'true'], 1);
            } else {
                $epicwebArr = CurlAPI("pages/midpageData", "GET", ['catalogId' => $catalog, 'limit' => $limit, 'page' => 1], 1);
            }
        }
        if (isset($epicwebArr) && @$epicwebArr['success'] == true) {
            $epicwebArr = $epicwebArr['data'];
            return view('pages.midpage', compact('epicwebArr', 'pageslug', 'catalog', 'page', 'hybidData', 'perpage'));
        } else {
            \Log::channel('error_404')->debug('--------------(pages/midpage/'.$slug.')  Error ('.date('h:i:s A').')----------------------');
            \Log::channel('error_404')->debug('Error =>'.json_encode($epicwebArr));
            return response()->view('pages.error.404', [], 404);
        }
    }

    public function channelsmidpagedetail($slug)
    {
        $title = $slug;
        $slug = "live|" . $slug;
        $page = 1;
        $epicwebArr = CurlAPI("pages/midpageData", "GET", ['slug' => $slug, 'page' => 1, 'limit' => 48], 1);

        if (isset($epicwebArr) && @$epicwebArr['success'] == true) {
            $epicwebArr = $epicwebArr['data'];
            return view('pages.chanel.channelmidpage', compact('epicwebArr', 'title', 'slug', 'page'));
        } else {
            \Log::channel('error_404')->debug('--------------(pages/midpageData/'.$slug.')  Error ('.date('h:i:s A').')----------------------');
            \Log::channel('error_404')->debug('Error =>'.json_encode($epicwebArr));
            return response()->view('pages.error.404', [], 404);
        }
    }

    public function paginatecontent()
    {
        $request = Request();
        $page = $request->page;
        $pageslug = $request->pageslug;
        $catalog = "";
        $limit = 48;
        $dataCount = "";
        if ($request->is_hybrid) {

            $genre_viewall = json_encode(explode(",", $request->genre_viewall));
            $catalog_viewall = json_encode(explode(",", $request->catalog_viewall));
            $list_language_viewall = json_encode(explode(",", $request->list_language_viewall));
            $params = [
                'is_hybrid' => 'true',
                'catalog_viewall' => $catalog_viewall,
                'genre_viewall' => $genre_viewall,
                'list_language_viewall' => $list_language_viewall,
                'limit' => $limit,
                'page' => $page
            ];
            $epicwebArr = $this->hybridCurl($params);
        } else {
            $mainslug = $request->mainslug;
            $catalog = $request->catalogid;
            if (isset($mainslug) && $mainslug == 'explore') {
                $url = "pages/midpage/{$pageslug}";
                $epicwebArr = CurlAPI($url, "GET", ['page' => $page, 'catalog_slug' => $catalog,'view_all' => 'true'], 1);
            } else {
                $epicwebArr = CurlAPI("pages/midpageData", "GET", ['catalogId' => $catalog, 'limit' => $limit, 'page' => $page], 1);
            }
        }
        $catalogue_blade = "paginatecontent";
        if ($epicwebArr && @$epicwebArr['success'] == true) {
            $epicwebArr = $epicwebArr['data'];
            $dataCount = count($epicwebArr);
            $paginateHTML = (string) view('pages.' . $catalogue_blade, compact('epicwebArr', 'page', 'catalog'));
        } else {
            $paginateHTML = "false";
        }
        return json_encode(['paginateHTML' => $paginateHTML, 'dataCount' => $dataCount, 'limit' => $limit]);
    }

    public function channelpaginatecontent()
    {
        $request = Request();
        $page = $request->page;
        $limit = 48;
        $slug = $request->slug;
        $epicwebArr = CurlAPI("pages/midpageData", "GET", ['slug' => $slug, 'limit' => $limit, 'page' => $page], 1);
        $catalogue_blade = "chanel.channelpaginatecontent";
        if ($epicwebArr && @$epicwebArr['success'] == true) {
            $epicwebArr = $epicwebArr['data'];
            $dataCount = count($epicwebArr);
            $paginateHTML = (string) view('pages.' . $catalogue_blade, compact('epicwebArr', 'page', 'slug'));
        } else {
            $paginateHTML = "false";
        }
        return json_encode(['paginateHTML' => $paginateHTML, 'dataCount' => $dataCount, 'limit' => $limit]);
    }

    public function explorecontent()
    {
        $request = Request();
        // dd($request->all());
        $page = $request->page;
        $slug = $request->slug;
        $limit = 20;
        $params = [
            'page' => $page,
            'limit' => $limit,
        ];
        $dataCount = 0;
        $result = CurlAPI("pages/midpage/" . $slug, "GET", $params, 1);
        $explore_blade = "explorecontent";
        if ($result && @$result['success'] == true) {
            $result = $result['data'];
            $dataCount = count($result);
            $paginateHTML = (string) view('pages.' . $explore_blade, compact('result', 'page'));
        } else {
            $paginateHTML = "false";
        }
        return json_encode(['paginateHTML' => $paginateHTML, 'dataCount' => $dataCount, 'limit' => $limit]);
    }

    public function ajaxStoryData(Request $request)
    {
        $id = $request->id;



        if (preg_match("/[a-z]/i", $id)) {

            $content_list = $this->epicShotsByShortCode($id);

            $story_list['content_list'] = array_values($content_list);

            $meta = [

                'title' => @$story_list['content_list'][0]['title'],

                'description' => @$story_list['content_list'][0]['short_description'],

                'image' => @$story_list['content_list'][0]['story_image'],

            ];
        } else {

            $story_list = $this->epicShots($id);
        }



        if ($story_list) {

            $view = view('components.epic-story-popup', compact('story_list'))->render();

            return JSONResponse(

                200,

                'Success.',

                [

                    'html' => $view,

                ]

            );
        } else {

            return JSONResponse(

                200,

                'Success.',

                [

                    'html' => null,

                ]

            );
        }
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

        $result = CurlAPI("pages/homepage", "GET", $params, 1, false, false, true);
        // dd($result);
        if ($result && @$result['success'] ==  true) {
            $data = $result['data'] ?? [];
            $lists = $data['list'] ?? [];
            foreach ($lists as $list) {
                if ($list['display_type'] == "shortandsweet") {
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
            'stories' => $stories,
        ];
    }

    private function epicShots($story_id = "")
    {
        $stories_arr = [];
        $response = CurlAPI("pages/stories", "GET", null, 1);
        if ($response && @$response['success'] == true) {
            $data = $response['data'] ?? [];
            $list = $data['list'] ?? [];
            foreach ($list as $val) {
                if (@$val['status']) {
                    $stories = key_exists('stories', $val) ? $val['stories'] : [];
                    foreach ($stories as $story) {
                        if (!empty($story_id) && @$story['ID'] == $story_id) {
                            $stories_arr = $story;
                            break;
                        } else {
                            $stories_arr[] = [
                                'id' => @$story['ID'],
                                'title' => @$story['title'],
                                'img_url' => getCardImage($story, 'imageUrl', 'small', []),
                                'short_code' => @$story['content_list'][0]['short_code']
                            ];
                        }
                    }
                }
            }
        }
        return $stories_arr;
    }

    private function epicShotsByShortCode($short_code = "")

    {

        $stories_arr = [];

        $response = CurlAPI("pages/stories/video?short_code=" . $short_code, "GET", null, 1);

        if ($response && @$response['success'] == true) {

            $stories_arr = $response['data']['list'] ?? [];
        }

        return $stories_arr;
    }


    public function hybridCurl($param)
    {

        $data = http_build_query($param);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => config('epicconfig.EPICAPI.API_DOMAIN_1') . '/pages/midpageData',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH',
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }

    public function storyPage($short_code)
    {
        $showStory = 1;

        $content_list = $this->epicShotsByShortCode($short_code);

        if ($content_list) {
            $story_list['content_list'] = array_values($content_list);

            $meta = [

                'title' => @$story_list['content_list'][0]['title'],

                'description' => @$story_list['content_list'][0]['short_description'],

                'image' => @$story_list['content_list'][0]['story_image'],

            ];



            return view('pages.story.storypage', compact('story_list', 'meta', 'showStory'));
        }

        return redirect()->to(url('/'));
    }
}
