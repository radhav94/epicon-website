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
        $uniqueHistoryData = [];
        $action = array(
            'action' => 'view',
            'profile_id' => $profile_id
        );
        $wishData = CurlAPI("pages/wishlist", 'POST', $action, 1, true);
        $param = ['profile_id' => $profile_id];
        $histData = CurlAPI("pages/user/watch_history", 'GET', $param, 1, true);
        if (@$histData['success'] == true) {
            $historydata = @$histData['data'];
            if (!empty($historydata) && is_array($historydata)) {
                foreach ($historydata as $item) {
                    if (isset($item['slug'])) {
                        $uniqueHistoryData[$item['slug']] = $item;
                    }
                }
            }
        } 
        if (@$wishData && @$wishData['success'] == true || @$histData && @$histData['success'] == true) {            
            $data = @$wishData['contents'];
            return view('library.library', compact('data', 'uniqueHistoryData'));
        } else {
            \Log::channel('error_404')->debug('--------------('.$slug.')  Error ('.date('h:i:s A').')----------------------');
            \Log::channel('error_404')->debug('Error =>'.json_encode($result));
            return response()->view('pages.error.404', [], 404);
        }
    }
}
