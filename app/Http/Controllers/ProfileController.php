<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function index()
    {
        // dd(session()->all());
        // dd(Session::get('user_token'));
        $result = CurlAPI("users/viewProfile", "POST", null, 2);

        // dd($result);
        if ($result && @$result['success'] ==  true) {

            $profiles = $result['user_data']['profiles'];

            return view('pages.profile.manage-profile', compact('result', 'profiles'));
        } else {
            return view('pages.404');
        }
    }
    public function add()
    {
        return view('pages.profile.add-profile');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $param = [
            'name' => $request->name,
            'date_of_birth' => $request->dob,
            'profile_img' => null
        ];
        if ($request->hasFile('profile_picture')) {
            $url = uploadFile('profile_picture', 'profile');
            $param['profile_img'] = $url;
        }

        $result = CurlAPI("users/createProfile", "POST", $param, 2);

        if ($result && @$result['success'] ==  true) {
            return JSONResponse(200, 'Success.');
        } else {
            return JSONResponse(400, 'Error.');
        }
    }
    public function edit($id)
    {
        $result = CurlAPI("users/viewProfile", "POST", null, 2);

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

    public function update(Request $request)
    {
        $param = [
            'profile_id' => $request->profile_id,
            'name' => $request->name,
            'date_of_birth' => $request->dob,
        ];

        if ($request->hasFile('profile_picture')) {
            $url = uploadFile('profile_picture', 'profile');
            $param['profile_img'] = $url;
        }
        // d($param);
        $result = CurlAPI("users/editProfile", "POST", $param, 2);
        // dd($result);
        if ($result && @$result['success'] ==  true) {
            return JSONResponse(200, 'Success.');
        } else {
            return JSONResponse(400, 'Error.');
        }
    }
}
