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
        $action = array(
            'action' => 'view',
            'profile_id' => $profile_id
        );
        $listResponseData = CurlAPI("pages/wishlist", 'POST', $action, 1, true);

        $param = ['profile_id' => $profile_id];
        $historyResponse = CurlAPI("pages/user/watch_history", 'GET', $param, 1, true, true);
        if (@$historyResponse['success'] == true) {
            $historydata = @$historyResponse['data'];
        } else {
            $historydata = '';
        }
        if ($listResponseData && @$listResponseData['success'] == true) {
            $data = @$listResponseData['contents'];

            return view('library.library', compact('data', 'historydata'));
        } else {
            return view('pages.error.data-error');
        }
    }
}
