<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LibraryController extends Controller
{
    public function index(Request $request){
        // dd($request->session()->get('user_token'));
         $action = array(
                'action' => 'view',
            );
        $listResponseData = CurlAPI("pages/wishlist", 'POST', $action , 1);
        // dd($listResponseData);

        $historyResponse = CurlAPI("pages/user/watch_history", 'GET', '' , 1);
        // dd($historyResponse);
        if($historyResponse['success'] == true){
            $historydata = $historyResponse['data'];
        }else{
            $historydata = '';
        }
        if($listResponseData && @$listResponseData['success'] == true){
            $data = $listResponseData['contents'];
            // dd($listResponseData);
            // return view('library.library')->with('data', $listResponseData);
            return view('library.library',compact('data','historydata'));
        }else{
            return view('pages.404');
        }
        
    }
}
