<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class PageController extends Controller
{
    public function index($slug = 'home-v2')
    {
        // $res = getWishlist();
        // dd($res);
        // dd(getWishlist());

        $params = [
            'slug' => $slug,
            // 'slug' => 'home-v2',
            // 'slug' => 'movies',
            'list_language' => 'ALL',
            'display_language' => 'ENGLISH',
            // 'page' => 1,
            // 'tray_limit' => 5,
        ];

        $result = CurlAPI("pages/homepage", "GET", $params, 1);
        // dd($result['data']['list']['0']);
        // $temp = [];
        // foreach ($result['data']['list'] as $key => $value) {
        //    $temp[] = $value['display_type'];
        // }
        // dd(array_unique(array_column($result['data']['list'], "display_type")));
        // dd($result);
        if ($result && @$result['success'] ==  true) {

            $displayLanguageParam = setLanguageParameter();

            // dd($result);
            return view('pages.homepage', compact('result', 'displayLanguageParam'));
        }
    }

    public function getSpinnerContent(Request $request)
    {
        $result = CurlAPI("pages/spinnerContent", "POST", ['genre' => $request->genre]);
        // die($result['success']);
        // dd($result);

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
        // dd($request->all());
        $params = [
            'content_id' => $request->content_id,
            'action' => $request->action
        ];
        $result = CurlAPI("pages/wishlist", "POST", $params);

        if ($result && @$result['success'] ==  true) {
            return JSONResponse(200,  'Success.');
        } else {
            return JSONResponse(400, 'Error.');
        }
    }
}
