<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PopularController extends Controller
{
    public function Popular(){
        return view('pages.new-popular');
    }
}
