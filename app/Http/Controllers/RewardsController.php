<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RewardsController extends Controller
{
    public function MyRewards(Request $request){
        // dd($request);
        $walletArr = CurlAPI("rewards/rewardsInfo", 'POST', '' , 2);
            // dd($walletArr);
            if($walletArr['success'] == true){
                $walletArr = $walletArr['data'];
                return view('rewards.my-reward',compact('walletArr'));
            }else{
                return view('pages.404');
            }
            // dd($walletArr);
    }
}
