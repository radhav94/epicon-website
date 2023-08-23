<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
        // Mobile Number Update and Send OTP
    public function setSendOTP()
    {
        $request = Request();
        $mobile_number = $request->post('mobile_number');
        $signup_method = $request->post('signup_method');
        // dd($mobile_number);
        // dd($request->all());
        if(!empty($mobile_number)){
            $SendotpRequestData = array(
                'user_id' => $mobile_number,
                'user_signup_method' => $signup_method,
            );

            $SendotpResponseData = CurlAPI("users/sendOTP", 'POST', $SendotpRequestData);
            if ($SendotpResponseData['success'] == 'true') {
                $response['meassage'] = $SendotpResponseData['message'];
                $request->session()->put('mobile_number', $mobile_number);
                $viewname = 'homepage';
            // return view('pages.'.$viewname,compact('mobile_number','response'));
                return response()->json(['user_id' => $mobile_number, 'response' => $response, 'success' => true], 200)->header('Content-Type', 'application/json');
            }else{

            }
        }
        // if (!empty($request->post('mobile_number')) && !empty($request->post('country_code'))) {
        //     $mobile_number = str_replace("+", "", $request->post('country_code')) . $request->post('mobile_number');
        // }

        // if (($user = getLoggedInUser()) != false) {

        //     $SendotpRequestData = array(
        //         'user_id' => $user->user_id,
        //         'mobile' => $mobile_number,
        //     );

        //     $SendotpResponseData = CurlAPI("users/getVerificationOTP", 'POST', $SendotpRequestData);
            
        //     if ($SendotpResponseData['success'] == 'true') {
        //         $response['meassage'] = $SendotpResponseData['message'];
        //         $request->session()->put('mobile_number', $mobile_number);

        //         return response()->json(['user_id' => $user->user_id, 'session_id' => $user->api_session_id, 'response' => $response, 'success' => true], 200)->header('Content-Type', 'application/json');
        //     } else {
        //         $response['meassage'] = 'Please try after sometime';
        //         return response()->json(['response' => $response, 'success' => false], 200)->header('Content-Type', 'application/json');
        //     }
        // } else {
        //     $response['meassage'] = 'Please login';
        //     return response()->json(['response' => $response, 'success' => false], 200)->header('Content-Type', 'application/json');
        // }
    }
}