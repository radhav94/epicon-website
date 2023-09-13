<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class PageDetailController extends Controller
{
    public function detail($pageslug, $contentslug)
    {
        $result = CurlAPI("pages/episode/{$pageslug}/{$contentslug}", "GET", [], 1);
        dd($result);
        if ($result && @$result['success'] ==  true) {

            $displayLanguageParam = setLanguageParameter();
            $content = $result['content'];

            return view('pages.page-detail', compact('content', 'displayLanguageParam'));
        }
    }
}
