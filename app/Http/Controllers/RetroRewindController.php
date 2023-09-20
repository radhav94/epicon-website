<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class RetroRewindController extends Controller
{

    public function retroRewindList($slug)
    {
        $page = 1;
        $limit = 9;
        $params = [
            'slug' => $slug,
            'page' => $page,
            'limit' => $limit,
        ];

        $result = CurlAPI("pages/retroContent", "POST", $params, 1);
        // dd($result);
        if ($result && @$result['success'] ==  true) {

            $displayLanguageParam = setLanguageParameter();

            $meta_title = strtoupper($slug);
            $result = $result['data'];

            return view('pages.retro-list', compact('result', 'displayLanguageParam', 'meta_title', 'slug', 'page'));
        }

        return view('pages.error.404');
    }
    public function retroRewindContent(Request $request)
    {
        $page = $request->page;
        $slug = $request->slug;
        $limit = 9;

        $params = [
            'slug' => $slug,
            'page' => $page,
            'limit' => $limit
        ];
        $dataCount = 0;
        $result = CurlAPI("pages/retroContent", "POST", $params, 1);

        if ($result && @$result['success'] == true) {
            $result = $result['data'];
            $dataCount = count($result);
            $paginateHTML = view('components.retro-rewind-content-list', compact('result', 'page'))->render();
        } else {
            $paginateHTML = "false";
        }

        return json_encode(['paginateHTML' => $paginateHTML, 'dataCount' => $dataCount, 'limit' => $limit]);
    }
}
