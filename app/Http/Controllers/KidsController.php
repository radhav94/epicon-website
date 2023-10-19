<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class KidsController extends Controller
{
    private  $limit;
    public function  __construct()
    {
        $this->limit = 50;
    }

    public function index($slug = 'home')
    {
        if ($this->isKidsSectionEnabled()) {
            setcookie("KidsMode", true, time() + 60 * 60 * 24 * 30, '/');
            session()->put('kidsMode', true);
            $kid_profile = getDefaultProfile('kids');
            if ($kid_profile != "") {
                profileActive($kid_profile);
            }

            $params = [
                'slug' => 'kids-' . $slug,
                'list_language' => 'ALL',
                'display_language' => 'ENGLISH',
                'page' => 1,
                'limit' => $this->limit,
            ];

            $result = CurlAPI("pages/homepage", "GET", $params, 1);

            if (request()->v == 2) {
                foreach ($result['data']['list'] as $key => $value) {
                    d($value);
                }
                dd($result);
            }

            if ($result && @$result['success'] ==  true) {
                $displayLanguageParam = setLanguageParameter();
                $meta_title = strtoupper($slug);
                return view('pages.homepage', compact('result', 'displayLanguageParam', 'meta_title'));
            }
            return view('pages.error.404');
        } else {
            return redirect('/settings');
        }
    }

    public function verifyKidsPin()
    {
        $request = Request();
        $kidsPin = $request->post('kidsPin') ? implode("", $request->post('kidsPin')) : '';

        $curlData = ["pin" => $kidsPin];
        $response = CurlAPI("users/verifyChildPin", "POST", $curlData, 2, true);
        if (!$response) {
            return JSONResponse(400, "Something went wrong. Please try again!");
        }
        if ($response && @$response['success']) {
            $profile_data = $request->session()->get('profile_data');
            $profile_data['result']['user_data']['kidSection'] = true;
            $request->session()->put('profile_data', $profile_data);
            setcookie("KidsMode", false, time() + 60 * 60 * 24 * 30, '/');
            session()->put('kidsMode', false);
            $default_profile = getDefaultProfile();
            if ($default_profile != "") {
                profileActive($default_profile);
            }
        }
        return JSONResponse(200, '', ['message' => @$response['message'], 'success' => @$response['success'], 'redirect' => getUrlWithPrefix('homepage')]);
    }

    private function isKidsSectionEnabled()
    {
        $user = session()->has('user') ? session()->get('user') : [];
        if (array_key_exists('kidSection', $user) && $user['kidSection']) {
            return true;
        } else {
            return false;
        }
    }
}
