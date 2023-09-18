<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    public function index($slug = 'home-v2')
    {
        // $res = getWishlist();
        // dd($res);
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

            $meta_title = strtoupper($slug);

            // dd($result['data']['list'][18]);
            return view('pages.homepage', compact('result', 'displayLanguageParam', 'meta_title'));
        }
    }

    public function loadMore(Request $request)
    {
        // dd($request->all());
        $params = [
            'slug' => ($request->route == '/') ? 'home-v2' : $request->route,
            'list_language' => 'ALL',
            'display_language' => 'ENGLISH',
            'page' => $request->page,
            'limit' => 5,
        ];

        $result = CurlAPI("pages/homepage", "GET", $params, 1);

        // dd($result);


        if ($result && @$result['success'] ==  true) {

            $displayLanguageParam = setLanguageParameter();

            $view = view('display.display-default', compact('result', 'displayLanguageParam'))->render();

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
        $result = CurlAPI("pages/explorepage", "GET", [], 1);
        // dd($result);
        if ($result && @$result['success'] ==  true) {

            return view('pages.explore', compact('result'));
        }
    }

    public function explore_details($slug)
    {
        $page = 1;
        $params = [
            // 'page' => $request->page,
            'page' => $page,
            'limit' => 18,
        ];
        $result = CurlAPI("pages/midpage/".$slug, "GET", $params, 1);
        // dd($result);
        if ($result && @$result['success'] ==  true) {
            $result = $result['data'];
            return view('pages.explore_details', compact('result','slug','page'));
        }else{
            return view('pages.404');
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
            $html = '';

            if ($request->type == '1') {
                $wishAction = ($request->action == 'add') ? 'delete' : 'add';

                if ($wishAction == 'add') {
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none"><path d="M21.0026 15.1678H15.1693V21.0011C15.1693 21.6428 14.6443 22.1678 14.0026 22.1678C13.3609 22.1678 12.8359 21.6428 12.8359 21.0011V15.1678H7.0026C6.36094 15.1678 5.83594 14.6428 5.83594 14.0011C5.83594 13.3595 6.36094 12.8345 7.0026 12.8345H12.8359V7.00114C12.8359 6.35947 13.3609 5.83447 14.0026 5.83447C14.6443 5.83447 15.1693 6.35947 15.1693 7.00114V12.8345H21.0026C21.6443 12.8345 22.1693 13.3595 22.1693 14.0011C22.1693 14.6428 21.6443 15.1678 21.0026 15.1678Z" fill="white" /></svg>';
                } else {
                    $icon = '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.1422 11.1919H11.1898C11.1898 11.1919 10.6541 11.1919 9.99934 11.1919C9.34458 11.1919 8.80887 11.1919 8.80887 11.1919H2.85649C2.20173 11.1919 1.66602 10.6562 1.66602 10.0014C1.66602 9.34665 2.20173 8.81094 2.85649 8.81094H8.80887C8.80887 8.81094 9.34458 8.81096 9.99934 8.81096C10.6541 8.81096 11.1898 8.81094 11.1898 8.81094H17.1422C17.797 8.81094 18.3327 9.34665 18.3327 10.0014C18.3327 10.6562 17.797 11.1919 17.1422 11.1919Z" fill="white"/></svg>';
                }


                $html = '<button class="big-add-list addToList" data-id="' . $request->content_id . '" data-action="' . $wishAction . '" data-type="1">  ' . $icon . '</button>';
            }

            return JSONResponse(200, ($request->action == 'add') ? 'Added to wishlist' : 'Removed from wishlist', ['icon' => $html]);
        } else {
            return JSONResponse(400, 'Error.');
        }
    }

    public function showmidpagedetail($pageslug, $catalog){
        // dd($catalog);
        // if (($user = getLoggedInUser()) != false) {
        //     $epicwebArr = CurlAPI("pages/midpage", "POST", ['user_id' => $user->user_id, 'session_id' => $user->api_session_id, 'catalogId' => $catalogid]);
        // } else {
        $page = 1;
            $epicwebArr = CurlAPI("pages/midpageData", "POST", ['catalogId' => $catalog,'limit' => 50, 'page' => 1], 1);
            if(isset($epicwebArr) && $epicwebArr['success'] == true){
                $epicwebArr = $epicwebArr['data'];
                return view('pages.midpage',compact('epicwebArr','pageslug','catalog','page'));
            }else{
                return view('pages.404');
            }
    }

     public function paginatecontent(){
        $request = Request();
        // dd($request->all());
        $page = $request->page;
        $catalog = $request->catalogid;
        $epicwebArr = CurlAPI("pages/midpageData", "POST", ['catalogId' => $catalog,'limit' => 50, 'page' => $page], 1);
        // dd($epicwebArr);
        $catalogue_blade = "paginatecontent";
        if ($epicwebArr['success'] == true) {
            $epicwebArr = $epicwebArr['data'];
            $paginateHTML = (string) view('pages.' . $catalogue_blade, compact('epicwebArr', 'page', 'catalog'));
            
        } else {
            $paginateHTML = "false";
        }
        // dd($paginateHTML);
        return $paginateHTML;
     }
}
