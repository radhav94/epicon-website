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
        SilentLoginFunction();
        profileActive();
        $data = $this->homepageData($slug);

        $result = $data['result'];

        if ($result && @$result['success'] ==  true) {
            $displayLanguageParam = $data['displayLanguageParam'];
            $stories = $data['stories'];

            $meta = getMeta('distro-tv');

            return view('pages.homepage-distro', compact('result', 'meta', 'displayLanguageParam', 'stories'));
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
        SilentLoginFunction();
        $resultArr = CurlAPI("pages/distrotv/page/".$request->id, "GET", '', 1);
     
        if ($resultArr && @$resultArr['success'] ==  true) {
             $content = $resultArr['pageData'] ?? '';
             $content_url = $content['episodes_content']['url'];
             $session_id = generateUUIDv4();
             $uniqId = date('Ymdhms') . rand(100, 999);
             if (isset($_COOKIE['deviceId'])) {
                $deviceId = $_COOKIE['deviceId'];
              }else{
                $deviceId = generateDeviceId();
              }
              $replaceContent = ['__CACHE_BUSTER__'=>$uniqId,
                                  '__env.i__'=>$session_id ?? '',
                                  '__env.u__'=>$deviceId ?? '',
                                  '__APP_NAME__'=>'EPIC ON',
                                  '__APP_BUNDLE__'=>'',
                                  '__STORE_URL__'=>'', 
                                  '__APP_CATEGORY__'=>'entertainment', 
                                  '__APP_VERSION__'=>'V3',
                                  '__DEVICE_ID__'=>$deviceId,
                                  '__LIMIT_AD_TRACKING__'=>'0',
                                  '__IS_GDPR__'=>'0',
                                  '__IS_CCPA__'=>'0',
                                  '__ADVERTISING_ID__'=>$deviceId,
                                  '__DEVICE__'=> getUserAgent() ?? '',
                                  '__DEVICE_ID_TYPE__'=>'cookie',
                                  '__DEVICE_CONNECTION_TYPE__'=>'',
                                  '__CLIENT_IP__'=>$_SERVER['REMOTE_ADDR'] ??'',
                                  '__GEO_COUNTRY__'=>getCountryCode() ??'',
                                  '__LATITUDE__'=>'',
                                  '__LONGITUDE__'=>'',
                                  '__GEO_DMA__'=>'',
                                  '__GEO_TYPE__'=>'2',
                                  '__PAGEURL_ESC__'=>urlencode('https://www.epicon.in/'),
                                  '__PALN__'=>'',
                                  'amp;'=>''

                                ];
           $contentUrl = str_replace(array_keys($replaceContent), array_values($replaceContent), $content_url);
            return view('pages.detail.distro-details', compact('content','contentUrl'));
        }else{
            return view('pages.error.data-error');
        }
    }

    public function search(Request $request)
    {   
        $html = '';
        $searchTerm = $request->get('term');
        $type = $request->get('type','title');

        $contents = [];

        if($searchTerm){
            if($type == 'title'){
                $postData = [
                    'searchTerm' =>  $searchTerm,
                    'limit' =>  '25'
                ];
            }else{
                $postData = [
                    'root_genre' =>  $searchTerm,
                    'limit' =>  '25'
                ];
            }
    
            $searchResult = CurlAPI("pages/distrotv/search", 'POST', $postData, 1);
    
            if ($searchResult) {
                if (key_exists('contents', $searchResult)) {
                    $contents = $searchResult['contents'];
                }
            }
        }

        $html = view('display-distro.search-tray',compact('contents'))->render();

        return JSONResponse(
            200,
            'Success.',
            [
                'html' => $html,
            ]
        );
    }
}
