<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RewardsController extends Controller
{
    public function MyRewards(){
        return view('rewards.my-reward');
    }
}
