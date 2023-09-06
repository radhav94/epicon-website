<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAccountController extends Controller
{
    public function addprofile()
    {
        // dd("true");
        // $params = [
        //     'slug' => 'home-v2',
        //     'list_language' => 'ALL',
        //     'display_language' => 'ENGLISH',
        //     'page' => 1,
        //     'tray_limit' => 5,
        // ];

        // $result = CurlAPI("pages/homepage", "GET", $params);
        // // dd($result['data']['list']['0']);
        // // dd($result);
        // if($result && @$result['success'] ==  true){

        //     $displayLanguageParam = setLanguageParameter();

        //     // dd($result);
            return view('epicon.add-profile');

        // }
        
    }

    public function manageprofile()
    {
        return view('epicon.manage-profile');
    }

    public function editprofile(){
        return view('epicon.edit-profile');
    }

    public function myaccount(){
        return view('my-account.my-account');
    }

    public function TransactionHistory(){
        return view('my-account.transaction-history');
    }
}
