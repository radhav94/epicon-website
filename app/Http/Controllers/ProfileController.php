<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    private $profile_limit;

    public function __construct()
    {
        $this->profile_limit = config('global.max_profile_limit');
    }

    public function getProfileData()
    {
        $result = CurlAPI("users/viewProfile", "POST", null, 2);

        if ($result && @$result['success'] ==  true) {

            $profiles = $result['user_data']['profiles'] ?? [];

            $profile_limit = $this->profile_limit;

            $data = [
                'result' => $result,
                'profiles' => $profiles,
                'profile_limit' => $profile_limit,
            ];

            session()->put('profile_data', $data);

            return $data;
        } else {
            return false;
        }
    }

    public function index()
    {
        // $res = getProfileData();
        // dd($res);
        $res = $this->getProfileData();
        // dd($res);
        if ($res) {
            return view('pages.profile.manage-profile')->with('data', $res);
        } else {
            return view('pages.404');
        }
    }

    public function add()
    {
        return view('pages.profile.add-profile');
    }

    public function store(Request $request): JsonResponse
    {
        $param = [
            'name' => $request->name,
            'date_of_birth' => $request->dob,
            'profile_img' => null
        ];
        if ($request->hasFile('profile_img')) {
            $url = uploadFile('profile_img', 'profile');
            $param['profile_img'] = $url;
        }

        $result = CurlAPI("users/createProfile", "POST", $param, 2);

        if ($result && @$result['success'] ==  true) {
            return JSONResponse(200, 'Profile created successfully.', ['redirect' => route('profile.index')]);
        } else {
            return JSONResponse(400, 'Failed to create profile');
        }
    }
    public function edit($id)
    {
        // $all = request()->session()->all();
        // dd($all);
        $result = CurlAPI("users/viewProfile", "POST", null, 2);
        // dd($result);

        $profile = '';

        if ($result && @$result['success'] ==  true) {

            foreach ($result['user_data']['profiles'] as $key => $value) {
                if ($id == $value['id']) {
                    $value['date_of_birth'] = (isset($value['date_of_birth'])) ? timestampToDate($value['date_of_birth'], 'Y-m-d') : '';
                    $profile = $value;
                    break;
                }
            }
        }

        if ($profile) {
            return view('pages.profile.edit-profile', compact('profile'));
        } else {
            return view('pages.404');
        }
    }

    public function update(Request $request): JsonResponse
    {
        $param = [
            'profile_id' => $request->profile_id,
            'name' => $request->name,
            'date_of_birth' => $request->dob,
        ];

        if ($request->hasFile('profile_img')) {
            $url = uploadFile('profile_img', 'profile', null, [100, 100]);
            $param['profile_img'] = $url;
        } else {
            $param['profile_img'] = $request->old_profile_img ? $request->old_profile_img : '';
        }

        $result = CurlAPI("users/editProfile", "POST", $param, 2);

        if ($result && @$result['success'] ==  true) {
            return JSONResponse(200, 'Profile updated successfully.', ['redirect' => route('profile.index')]);
        } else {
            return JSONResponse(400, 'Failed to update profile');
        }
    }

    public function destroy($profile_id): JsonResponse
    {
        $params = [
            'profile_id' => $profile_id
        ];
        $result = CurlAPI("users/deleteProfile", "POST", $params, 2);

        if ($result && @$result['success'] ==  true) {
            return JSONResponse(200, 'Profile deleted successfully.', ['redirect' => route('profile.index')]);
        } else {
            return JSONResponse(400, 'Failed to delete profile');
        }
    }

    public function setChildPin(Request $request): JsonResponse
    {
        $param = ['pin' => $request->cpin_1 . $request->cpin_2 . $request->cpin_3 . $request->cpin_4];

        $result = CurlAPI("users/setChildPin", "POST", $param, 2);

        if ($result && @$result['success'] ==  true) {
            return JSONResponse(200, 'Pin added successfully.', ['redirect' => route('profile.index')]);
        } else {
            return JSONResponse(400, 'Failed to set pin');
        }
    }
}
