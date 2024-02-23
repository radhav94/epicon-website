<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    private  $limit;
    public function  __construct()
    {
        $this->limit = 10;
    }

    public function index()
    {
        $data['url'] = url()->current();
        $current_uri = request()->segments();
        $data['current_uri'] = $current_uri;
        $removeArr = array(
            "/en/",
            "/index.php/",
            "/watch/",
            "/listen/",
        );

        // $filteredUri = array_diff($current_uri, $removeArr);
        // $data['filteredUri'] = $filteredUri;

        // dd($data);

        if (count($current_uri) >= 5) {
            $data['wow'] = count($current_uri);
            $data['new_url'] = env('APP_URL') . $current_uri[0] . '/' . $current_uri[1] . '/' . $current_uri[2] . '/' . $current_uri[3];
        } else {
            $data['new_url'] = str_replace($removeArr, '/', $data['url']);
        }

        // dd($data);

        return redirect($data['new_url']);
    }
}
