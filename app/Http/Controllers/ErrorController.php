<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function index()
    {
        $data['url'] = url()->current();
        $removeArr = array(
            "/en/",
            "/index.php/",
            "/watch/",
            "/listen/",
        );

        $finalUrl = str_replace($removeArr, '/', $data['url']);
        $request = Request::create($finalUrl);
        $current_uri = $request->segments();
        if (count($current_uri) >= 5) {
            $data['new_url'] = env('APP_URL') . $current_uri[0] . '/' . $current_uri[1] . '/' . $current_uri[2] . '/' . $current_uri[3];
        } else {
            $data['new_url'] = $finalUrl;
        }
        return redirect($data['new_url']);
    }
}
