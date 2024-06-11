<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LibraryController extends Controller
{
    public function index(Request $request)
    {
        $profile_id = session()->get('active_profile');
        $data = [];
        $historydata = [];
        $action = array(
            'action' => 'view',
            'profile_id' => $profile_id
        );
        $wishData = CurlAPI("pages/wishlist", 'POST', $action, 1, true);
        $param = ['profile_id' => $profile_id];
        $histData = CurlAPI("pages/user/watch_history", 'GET', $param, 1, true);
        if (@$histData['success'] == true) {
            $historydata = @$histData['data'];
        } 
        if (@$wishData && @$wishData['success'] == true || @$histData && @$histData['success'] == true) {            
            $data = @$wishData['contents'];
            return view('library.library', compact('data', 'historydata'));
        } else {
            return response()->view('pages.error.404', [], 404);
        }
    }
}
