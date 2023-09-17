<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function Setting() {
        $request = Request();
        /*genre section*/
        $profile_data = $request->session()->get('profile_data');
        $user_data = array_key_exists("result", $profile_data) &&
                        $profile_data['result']['success'] && 
                        array_key_exists("user_data", $profile_data['result'])
                        ? $profile_data['result']['user_data']
                        : [];
        $genrelist = CurlAPI("v2profilecontent/genrelist", 'GET', [], 1);

        /* active devices */
        $activeDevice = CurlAPI("users/getDevice", 'POST', [], 2);

        return view('settings.settings', compact('genrelist', 'user_data', 'activeDevice'));
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

    public function removeDevice() {
        $request = Request(); 
        $deviceId = $request->post('deviceId') ? $request->post('deviceId') : '';
        $curlData = ["id" => $deviceId];
        $response = CurlAPI("users/deleteDevice", "POST", $curlData, 2);
        return JSONResponse(200, '', ['message' => $response['message'], 'success' => $response['success']]);
    }

    public function setKidsPin() {
        $request = Request();
        $command = $request->post('command') ? $request->post('command') : '';
        $kidsPin = $request->post('kidsPin') ? implode("", $request->post('kidsPin')) : '';
        $oldKidsPin = $request->post('oldKidsPin') ? implode("", $request->post('oldKidsPin')) : '';
        $newKidsPin = $request->post('newKidsPin') ? implode("", $request->post('newKidsPin')) : '';
        if ($command == "createKidsPin") {
            $curlData = ["pin" => $kidsPin];
            $response = CurlAPI("users/setChildPin", "POST", $curlData, 2);
            if ($response['success']) {
                $profile_data = $request->session()->get('profile_data');
                $profile_data['result']['user_data']['kidSection'] = true;
                $request->session()->put('profile_data', $profile_data);
            }
        } else {
            $curlData = ["pin" => $newKidsPin, "old_pin" => $oldKidsPin];
            $response = CurlAPI("users/changeChildPin", "POST", $curlData, 2);
        }
        return JSONResponse(200, '', ['message' => $response['message'], 'success' => $response['success']]);
    }
}
