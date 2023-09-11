<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpcomingController extends Controller
{
    public function UpcomingEpicon(){
        return view('pages.upcoming-epicon');
    }
}
