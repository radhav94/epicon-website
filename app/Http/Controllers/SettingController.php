<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function Setting() {
        $request = Request();
        $profile_data = $request->session()->get('profile_data');
        $interests = $profile_data['result']['user_data']['interests'] ?? [];
        $genrelist = CurlAPI("v2profilecontent/genrelist", 'GET', [], 1);
        return view('settings.settings', compact('genrelist', 'interests'));
    }

    public function updateUserGenre() {
        $request = Request();
        $genre = $request->post('genreInterest') ? $request->post('genreInterest') : [];
        $profile_data = $request->session()->get('profile_data');
        $profile_data['result']['user_data']['interests'] = $genre;
        $request->session()->put('profile_data', $profile_data);
        $curlData = ["genre" => $genre];
        $genrelist = postCurlApicall("v2profilecontent/editgenrelist", $curlData, 1);
        return JSONResponse(200, '', ['message' => $genrelist['message'], 'success' => $genrelist['success']]);
    }


}
