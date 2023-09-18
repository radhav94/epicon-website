<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function Setting()
    {
        $request = Request();
        /*genre section*/
        $profile_data = CurlAPI("users/viewProfile", 'POST', [], 2);
        if (!$profile_data) {
            return view('pages.404');
        }
        $user_data = @$profile_data['success'] &&
            array_key_exists("user_data", $profile_data)
            ? $profile_data['user_data']
            : [];

        $genrelist = CurlAPI("v2profilecontent/genrelist", 'GET', [], 1);
        if (!$genrelist) {
            return view('pages.404');
        }

        /* active devices */
        $activeDevice = CurlAPI("users/getDevice", 'POST', [], 2);
        if (!$activeDevice) {
            return view('pages.404');
        }

        return view('settings.settings', compact('genrelist', 'user_data', 'activeDevice'));
    }

    public function updateUserGenre()
    {
        $request = Request();
        $genre = $request->post('genreInterest') ? $request->post('genreInterest') : [];
        $profile_data = $request->session()->get('profile_data');
        $profile_data['result']['user_data']['interests'] = $genre;
        $request->session()->put('profile_data', $profile_data);
        $curlData = ["genre" => $genre];
        $genrelist = postCurlApicall("v2profilecontent/editgenrelist", $curlData, 1);
        if (!$genrelist) {
            return JSONResponse(400, "Something went wrong. Please try again!");
        }
        return JSONResponse(200, '', ['message' => @$genrelist['message'], 'success' => @$genrelist['success']]);
    }

    public function removeDevice()
    {
        $request = Request();
        $deviceId = $request->post('deviceId') ? $request->post('deviceId') : '';
        $curlData = ["id" => $deviceId];
        $response = CurlAPI("users/deleteDevice", "POST", $curlData, 2);
        if (!$response) {
            return JSONResponse(400, "Something went wrong. Please try again!");
        }
        return JSONResponse(200, '', ['message' => @$response['message'], 'success' => @$response['success']]);
    }

    public function setKidsPin()
    {
        $request = Request();
        $command = $request->post('command') ? $request->post('command') : '';
        $kidsPin = $request->post('kidsPin') ? implode("", $request->post('kidsPin')) : '';
        $oldKidsPin = $request->post('oldKidsPin') ? implode("", $request->post('oldKidsPin')) : '';
        $newKidsPin = $request->post('newKidsPin') ? implode("", $request->post('newKidsPin')) : '';
        if ($command == "createKidsPin") {
            $curlData = ["pin" => $kidsPin];
            $response = CurlAPI("users/setChildPin", "POST", $curlData, 2);
            if ($response && @$response['success']) {
                $profile_data = $request->session()->get('profile_data');
                $profile_data['result']['user_data']['kidSection'] = true;
                $request->session()->put('profile_data', $profile_data);
            }
        } else {
            $curlData = ["pin" => $newKidsPin, "old_pin" => $oldKidsPin];
            $response = CurlAPI("users/changeChildPin", "POST", $curlData, 2);
        }
        if (!$response) {
            return JSONResponse(400, "Something went wrong. Please try again!");
        }
        return JSONResponse(200, '', ['message' => @$response['message'], 'success' => @$response['success']]);
    }

    public function changePassword()
    {
        $request = Request();
        $old_password = $request->post('old_password') ? $request->post('old_password') : '';
        $new_password = $request->post('new_password') ? $request->post('new_password') : '';
        $curlData = ["new_password" => $new_password, "current_password" => $old_password];
        $response = CurlAPI("users/changePassword", "POST", $curlData, 2);
        if (!$response) {
            return JSONResponse(400, "Something went wrong. Please try again!");
        }
        $error_code = array_key_exists("errorcode", $response) ? $response['errorcode'] : '';
        return JSONResponse(200, '', ['message' => @$response['message'], 'success' => @$response['success'], 'errorcode' => $error_code]);
    }

    public function deleteAccount()
    {
        $request = Request();
        $response = CurlAPI("users/deleteAccount", "POST", "", 2);
        if (!$response) {
            return JSONResponse(400, "Something went wrong. Please try again!");
        }
        $error_code = array_key_exists("errorcode", $response) ? $response['errorcode'] : '';
        return JSONResponse(200, '', ['message' => @$response['message'], 'success' => @$response['success'], 'errorcode' => $error_code]);
    }

    public function sendOTPForDeleteAccount()
    {
        $request = Request();
        $password = $request->post('password') ?? '';
        $curlData = ["password" => $password];
        $response = CurlAPI("users/sendDeleteAccountOTP", "POST", $curlData, 2);
        if (!$response) {
            return JSONResponse(400, "Something went wrong. Please try again!");
        }
        $error_code = array_key_exists("errorcode", $response) ? $response['errorcode'] : '';
        return JSONResponse(200, '', ['message' => @$response['message'], 'success' => @$response['success'], 'errorcode' => $error_code]);
    }
}
