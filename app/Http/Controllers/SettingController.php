<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;

class SettingController extends Controller
{

    public function Setting()
    {
        $request = Request();
        /*genre section*/
        $profile_data = CurlAPI("users/viewProfile", 'POST', [], 2, true, true);
        if (!$profile_data) {
            return view('pages.404');
        }

        $user_data = session()->get('user') ?? [];

        $genrelist = CurlAPI("v2profilecontent/genrelist", 'GET', [], 1);
        if (!$genrelist) {
            return view('pages.404');
        }

        /* active devices */
        $activeDevice = CurlAPI("users/getDevice", 'POST', [], 2, true, true);
        if (!$activeDevice) {
            return view('pages.404');
        }

        /* sync devices */
        $data = ['auth_token' => config('epicconfig.EPICAPI.API_AUTH_TOKEN')];
        $syncDevice = CurlAPI("users/getPin", 'GET', $data, 2, true);
        if (!$syncDevice) {
            return view('pages.404');
        }
        $syncPin = array_key_exists("pin", $syncDevice) ? $syncDevice['pin'] : "";

        $displayLanguage = $request->session()->has('displayLanguage') ? $request->session()->get('displayLanguage') : 'en';
        $listLanguage = $request->session()->has('listLanguage') ? $request->session()->get('listLanguage') : 'all';

        return view('settings.settings', compact('genrelist', 'user_data', 'activeDevice', 'syncPin', 'displayLanguage', 'listLanguage'));
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
        $response = CurlAPI("users/deleteDevice", "POST", $curlData, 2, true, true);
        $activeDeviceArr = CurlAPI("users/getDevice", 'POST', [], 2, true, true);

        $activeDevices = @$activeDeviceArr['success'] && array_key_exists('data', $activeDeviceArr) ? $activeDeviceArr['data'] : [];

        $url = $request->session()->get('silentUrl');

        if (count($activeDevices) <= 5) {
            session()->forget('maxDevice');
        }
        // update session code add here
        update_user_session();
        if (!$response) {
            return JSONResponse(400, "Something went wrong. Please try again!");
        }
        return JSONResponse(200, '', ['message' => @$response['message'], 'success' => @$response['success'], 'deviceCnt'=>count($activeDevices),'redirectUrl'=>$url??redirect('/')]);
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
            $response = CurlAPI("users/setChildPin", "POST", $curlData, 2, true, true);
            if ($response && @$response['success']) {
                $profile_data = session()->get('profile_data') ?? [];
                if (!$profile_data) {
                    $profile_data['result']['user_data']['kidSection'] = true;
                    $request->session()->put('profile_data', $profile_data);
                }
            }
        } else {
            $curlData = ["pin" => $newKidsPin, "old_pin" => $oldKidsPin];
            $response = CurlAPI("users/changeChildPin", "POST", $curlData, 2, true, true);
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
        $response = CurlAPI("users/changePassword", "POST", $curlData, 2, true, true);
        if (!$response) {
            return JSONResponse(400, "Something went wrong. Please try again!");
        }
        if (@$response['success'] == true) {
            $curlData = ["id" => 0];
            $deleteDevice = CurlAPI("users/deleteDevice", "POST", $curlData, 2, true, true);
            if (!$deleteDevice) {
                return JSONResponse(400, "Something went wrong. Please try again!");
            }
            $result = CurlAPI("users/logout", "POST", [], 2, true, true);
            $request->session()->forget('user_id');
            $request->session()->forget('user');
            $request->session()->forget('user_token');
            $request->session()->forget('profile_data');
            $request->session()->flush();
            session_unset();
            $request->session()->regenerate();
        }
        $error_code = array_key_exists("errorcode", $response) ? $response['errorcode'] : '';
        return JSONResponse(200, '', ['message' => @$response['message'], 'success' => @$response['success'], 'errorcode' => $error_code]);
    }

    public function deleteAccount()
    {
        $request = Request();
        $reason = $request->post('reason') && !empty($request->post('reason')) ?? '';

        $curlData = [
            "account_delete_reason" => $reason,
            "type" => ""
        ];
        $response = CurlAPI("users/deleteAccount", "POST", $curlData, 2, true);
        if (!$response) {
            return JSONResponse(400, "Something went wrong. Please try again!");
        }

        $response = $response['payload'] ?? $response;

        $error_code = array_key_exists("errorcode", $response) ? $response['errorcode'] : '';
        return JSONResponse(200, '', ['message' => @$response['message'], 'success' => @$response['success'], 'errorcode' => $error_code]);
    }

    public function sendOTPForDeleteAccount()
    {
        $request = Request();
        $password = $request->post('password') ?? '';
        $curlData = ["password" => $password];
        $response = CurlAPI("users/sendDeleteAccountOTP", "POST", $curlData, 2, true, true);
        if (!$response) {
            return JSONResponse(400, "Something went wrong. Please try again!");
        }
        $error_code = array_key_exists("errorcode", $response) ? $response['errorcode'] : '';
        return JSONResponse(200, '', ['message' => @$response['message'], 'success' => @$response['success'], 'errorcode' => $error_code]);
    }

    public function verifyOTPForDeleteAccount()
    {
        $request = Request();
        $otp = $request->post('verifyOTP') && !empty($request->post('verifyOTP'))
            && is_array($request->post('verifyOTP'))
            ? implode("", $request->post('verifyOTP'))
            : '';
        if (empty($otp)) {
            return JSONResponse(200, '', ['message' => "OTP is required", 'success' => 0, 'errorcode' => ""]);
        }
        $curlData = ["otp" => $otp];
        $response = CurlAPI("users/verifyDeleteAccountOTP", "POST", $curlData, 2, true, true);
        if (!$response) {
            return JSONResponse(400, "Something went wrong. Please try again!");
        }
        $error_code = array_key_exists("errorcode", $response) ? $response['errorcode'] : '';
        return JSONResponse(200, '', ['message' => @$response['message'], 'success' => @$response['success'], 'errorcode' => $error_code]);
    }

    function syncDevicePin()
    {
        $data = ['auth_token' => config('epicconfig.EPICAPI.API_AUTH_TOKEN')];
        $response = CurlAPI("users/getPin", 'GET', $data, 2, true);
        if (!$response) {
            return JSONResponse(400, "Something went wrong. Please try again!");
        }
        $syncPin = array_key_exists("pin", $response) ? $response['pin'] : "";
        return JSONResponse(200, '', ['message' => @$response['message'], 'success' => @$response['success'], 'syncPin' => $syncPin]);
    }

    function setLanguage()
    {
        $request = Request();
        $language = $request->input('language');
        $type = $request->input('type');
        if ($type == "display") {
            $request->session()->put('displayLanguage', $language);
            app()->setLocale(trim($language));
        } else {
            $request->session()->put('listLanguage', $language);
        }
        if ($language == 'hi') {
            return redirect('/hi');
        } else {
            return redirect('/');
        }
    }

    function deleteSearchHistory()
    {
        if (session()->has('active_profile') && session()->has('searchHistory')) {
            $activeProfile  = session()->get('active_profile');
            $searchHistory  = session()->get('searchHistory');
            if (key_exists($activeProfile, $searchHistory)) {
                unset($searchHistory[$activeProfile]);
            }
            session()->put('searchHistory', $searchHistory);
        }
        return JSONResponse(200, '', []);
    }
}
