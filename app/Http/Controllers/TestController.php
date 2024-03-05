<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Detection\MobileDetect;

class TestController extends Controller
{
    public function index()
    {   

        $isIPhone = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "iphone")); 
        $isIPad = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "ipad")); 

        echo '--';
        d($isIPhone);
        echo '--';
        d($isIPad);

        // die;
        
    $detect = new MobileDetect();
    $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

    // $detect= $deviceType == 'phone' ? true : false;

    echo 'deviceType - '.$deviceType;
    echo '<br>';

    if ($detect->isiOS() || $detect->is('iPhone') || $detect->is('iPad') || $detect->is('iPod')) {
        echo "This is an Apple device <br>";
    } else {
        echo "This is not an Apple device <br>";
    }
    echo '<br><br><br>';
    echo '<br><br><br>';

    $ua = strtolower($_SERVER["HTTP_USER_AGENT"] ?? '');
    $isMob = is_numeric(strpos($ua, "mobile"));
    $isIPhone = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"] ?? ''), "iphone"));
    $isMobile =  (isset($isMob) && $isMob == true) || (isset($isIPhone) && $isIPhone == true) || (isset($_SERVER['HTTP_X_MOBILE']) && $_SERVER['HTTP_X_MOBILE'] == true) ? true : false;

    if($isMobile){
        echo '--mobile--';
    }else{
        echo '--not a mobile--';
    }
    // die;

        if(strtolower(env('APP_ENV')) == 'production'){
            return redirect('/');
        }
        
        $request = Request();
        d(request()->session()->all());
        echo '-------------------- <br>';
        $request->session()->get('user_token');
        $curlData = [];
        $genrelist = postCurlApicall("users/viewProfile", $curlData, 2);

        d($genrelist);
        echo '-------------------- <br>';

        echo "Old api <br>";

        $result = CurlAPI("users/viewProfile", "POST", null, 2);

        dd($result);
    }
    public function index1()
    {

        /* $routenamed = 'home-v2';
        $epicwebArr = CurlAPI("pages/" . $routenamed, "GET", ['displayLanguage' => 'ENGLISH', 'listLanguage' => 'all', 'page' => 1, 'tray_limit' => 5]);

        dd($epicwebArr);*/
        // dd(config('epicconfig.EPICAPI.API_AUTH_TOKEN'));
        $recommendationData = ['user_id' => 'epicepic123@mailinator.com', 'asset_type' => 'LISTEN'];
        // $recommendationArr = CurlAPI("pages/recommendation", "GET", $recommendationData);

        // $recommendationArr = CurlAPI("http://contentapi-njsapi.epicon.in/index/pages/homepage?slug=tv-shows&list_language=ALL&display_language=TAMIL", "GET", []);

        $params = [
            'slug' => 'home-v2',
            'list_language' => 'ALL',
            'display_language' => 'TAMIL',
            'page' => 1,
            'tray_limit' => 1,
        ];

        $data = CurlAPI("pages/homepage", "GET", $params);

        dd($data);
    }
}
