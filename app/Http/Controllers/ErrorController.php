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
        $removeArr = array(
            "/en/",
            "/index.php/",
            "/watch/",
        );
        $data['new_url'] = str_replace($removeArr,'/',$data['url']);
        
        return redirect($data['new_url']);
    }
}
