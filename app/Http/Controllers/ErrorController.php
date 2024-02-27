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
        $data['current_uri'] = $current_uri;
        if (count($current_uri) >= 5) {
            if (strtolower($current_uri[0]) == 'kids') {
                $data['new_url'] = env('APP_URL') . $current_uri[0] . '/' . $current_uri[1] . '/' . $current_uri[2] . '/' . $current_uri[3] . '/' . $current_uri[4];
            } else {
                $data['new_url'] = env('APP_URL') . $current_uri[0] . '/' . $current_uri[1] . '/' . $current_uri[2] . '/' . $current_uri[3];
            }
        } else {
            $data['new_url'] = $finalUrl;
        }
        // dd($data);
        return redirect($data['new_url']);
    }
}
