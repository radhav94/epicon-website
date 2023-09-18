<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
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
