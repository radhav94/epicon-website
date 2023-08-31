<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
            'page' => 1,
            'limit' => 50,
        ];

        $result = CurlAPI("pages/homepage", "GET", $params, 1);

        if (request()->v == 2) {
            foreach ($result['data']['list'] as $key => $value) {
                d($value);
            }
            dd($result);
        }

        // dd($result['data']['list']['20']);
        // $temp = [];
        // foreach ($result['data']['list'] as $key => $value) {
        //    $temp[] = $value['display_type'];
        // }
        // dd(array_unique(array_column($result['data']['list'], "display_type")));
        // dd($result);
        if ($result && @$result['success'] ==  true) {

            $displayLanguageParam = setLanguageParameter();

            // dd($result['data']['list'][18]);
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
        // dd($result);
        if ($result && @$result['success'] ==  true) {
            Cache::forget('getWishlist');
            // session()->forget('user_wishlist');

            return JSONResponse(200, ($request->action == 'add') ? 'Added to wishlist' : 'Removed from wishlist');
        } else {
            return JSONResponse(400, 'Error.');
        }
    }
}
