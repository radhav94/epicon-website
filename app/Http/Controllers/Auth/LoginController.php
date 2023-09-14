<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Mobile Number Update and Send OTP
    public function setSendOTP(Request $request)
    {
        $mobile_number = $request->post('mobile_number');
        $signup_method = $request->post('signup_method');
        if (!empty($mobile_number)) {
            $SendotpRequestData = array(
                'user_id' => $mobile_number,
                'user_signup_method' => $signup_method,
            );
            $SendotpResponseData = [
                "success" => true,
                "message" => "OTP sent successfully."
            ];
            $SendotpResponseData = CurlAPI("users/sendOTP", 'POST', $SendotpRequestData, 2);
            $response['meassage'] = $SendotpResponseData['message'];
            // dd($SendotpResponseData);
            if ($SendotpResponseData['success'] == 'true') {
                $request->session()->put('mobile_number', $mobile_number);
                $viewname = 'homepage';
                return JSONResponse(200, 'OTP sent successfully.', ['user_id' => $mobile_number, 'user_signup_method' => $signup_method, 'response' => $response, 'success' => true]);
            } else {
                return JSONResponse(200, 'OTP sent failed.', ['response' => $response, 'success' => false]);
            }
        }
    }

    public function setOTPVerification(Request $request)
    {
        $request = Request();
        // dd($request->all());
        $userid = $request->post('user_id');
        $signup_method = $request->post('signupmethod');
        $user_agent = $request->post('user_agent');
        $otp_pin = $request->post('otp_pin');
        if (!empty($otp_pin)) {
            $verifyotpRequestData = array(
                'user_id' => $userid,
                'user_signup_method' => $signup_method,
                'otp' => $otp_pin,
                'user_agent' => $user_agent,
            );
            $verifyotpResponseData = [
                "success" => true,
                "message" => "OTP verified successfully."
            ];
            $verifyotpResponseData = CurlAPI("users/verifyOTP", 'POST', $verifyotpRequestData, 2);
            if (isset($verifyotpResponseData['user_data'])) {
                $is_verified = true;
            } else {
                $is_verified = false;
            }
            $response['message'] = $verifyotpResponseData['message'];
            $response['is_verified'] = $is_verified;

            // dd($verifyotpResponseData);
            if ($verifyotpResponseData['success'] == 'true' && $is_verified == true) {
                $user_data = $verifyotpResponseData['user_data'];
                $request->session()->put('user_id', $userid);
                $request->session()->put('user', $user_data);
                $request->session()->put('user_token', $verifyotpResponseData['token']);
                // $viewname = 'homepage';
                return JSONResponse(200, 'OTP verified successfully.', ['user_id' => $userid, 'user_signup_method' => $signup_method, 'otp_pin' => $otp_pin, 'response' => $response, 'user_data' => $user_data, 'success' => true]);
            } elseif ($verifyotpResponseData['success'] == 'true' && $is_verified == false) {
                $request->session()->put('user_id', $userid);
                return JSONResponse(200, 'OTP verified successfully.', ['user_id' => $userid, 'user_signup_method' => $signup_method, 'otp_pin' => $otp_pin, 'response' => $response, 'success' => true]);
            } else {
                // dd("Api failed");
                return JSONResponse(200, 'OTP not verified successfully.', ['user_id' => $userid, 'user_signup_method' => $signup_method, 'otp_pin' => $otp_pin, 'response' => $response, 'success' => false]);
                // Incorrect code entered. Please try again.
            }
        }
    }

    public function setSignUp(Request $request)
    {
        $request = Request();
        // dd($request->all());
        $userid = $request->post('userid');
        $signup_method = $request->post('sign_method');
        $username = $request->post('name');
        $password = $request->post('password');
        $date_of_birth = $request->post('dob');
        $gender = $request->post('gender');
        $postData = array(
            'user_id' => $userid,
            'user_signup_method' => $signup_method,
            'name' => $username,
            'password' => $password,
            'date_of_birth' => $date_of_birth,
            'gender' => $gender,

        );
        $registerResponseData = CurlAPI("users/register", 'POST', $postData, 2);
        // dd($registerResponseData);
        $response['message'] = $registerResponseData['message'];
        $userdata = $registerResponseData['user_data'];
        if ($registerResponseData['success'] == 'true') {
            $request->session()->put('user', $userdata);
            $request->session()->put('user_id', $userid);
            $request->session()->put('user_token', $registerResponseData['token']);
            return JSONResponse(200, 'User Registered Successfully.', ['user_id' => $userid, 'user_signup_method' => $signup_method, 'name' => $username, 'password' => $password, 'date_of_birth' => $date_of_birth, 'gender' => $gender, 'response' => $response, 'success' => true]);
        } else {
            return JSONResponse(200, 'User Registeration Failed.', ['response' => $response, 'success' => false]);
        }
    }

    public function setSignin(Request $request)
    {
        $request = Request();
        // dd($request->all());
        $userid = $request->post('mobilenumber');
        $password = $request->post('login_pwd');
        // $userAgent = $request->post('userAgent');
        $postedData = [
            'user_id' => $userid,
            'password' => $password,
            'user_agent' => 'WEB'
        ];

        $loginResponseData = CurlAPI("users/loginWithPassword", 'POST', $postedData, 2);
        // dd($loginResponseData);
        $response['message'] = $loginResponseData['message'];
        if ($loginResponseData['success'] == true && !empty($loginResponseData['user_data'])) {
            $userdata = $loginResponseData['user_data'];
            $request->session()->put('user', $userdata);
            $request->session()->put('user_id', $userid);
            $request->session()->put('user_token', $loginResponseData['token']);
            return JSONResponse(200, 'User Logged In Successfully.', ['redirect' => url('/') , 'success' => true]);
        } else {
            return redirect('/');
        }
    }

    public function SendForgotOtp(Request $request)
    {
        $mobile_number = $request->post('forgot-name');
        $signup_method = $request->post('signin_method');
        if (!empty($mobile_number)) {
            $SendotpRequestData = array(
                'user_id' => $mobile_number,
                'user_signup_method' => $signup_method,
            );
            $SendotpResponseData = [
                "success" => true,
                "message" => "OTP sent successfully."
            ];
            $SendotpResponseData = CurlAPI("users/sendForgotPassOTP", 'POST', $SendotpRequestData, 2);
            $response['meassage'] = $SendotpResponseData['message'];
            // dd($SendotpResponseData);
            if ($SendotpResponseData['success'] == 'true') {
                $request->session()->put('mobile_number', $mobile_number);
                // $viewname = 'homepage';
                return JSONResponse(200, 'OTP sent successfully.', ['user_id' => $mobile_number, 'user_signup_method' => $signup_method, 'response' => $response, 'success' => true]);
            } else {
                return JSONResponse(200, 'OTP sent failed.', ['response' => $response, 'success' => false]);
            }
        }
    }

    public function setForgotOTPVerification(Request $request)
    {
        $request = Request();
        // dd($request->all());
        $userid = $request->post('userid_no');
        $signup_method = $request->post('usersignupmethod');
        // $user_agent = $request->post('user_agent');
        $otp_pin = $request->post('otppin');
        if (!empty($otp_pin)) {
            $verifyotpRequestData = array(
                'user_id' => $userid,
                'user_signup_method' => $signup_method,
                'otp' => $otp_pin,
            );
            $verifyotpResponseData = [
                "success" => true,
                "message" => "OTP verified successfully."
            ];
            $verifyotpResponseData = CurlAPI("users/verifyForgotPassOTP", 'POST', $verifyotpRequestData, 2);
            // dd($verifyotpResponseData);

            $is_verified = false;
            if (isset($verifyotpResponseData['user_data'])) {
                $is_verified = true;
            }

            $response['message'] = $verifyotpResponseData['message'];
            $response['is_verified'] = $is_verified;

            // dd($verifyotpResponseData);
            if ($verifyotpResponseData['success'] == 'true' && $is_verified == true) {
                $user_data = $verifyotpResponseData['user_data'];
                // $request->session()->put('user_id', $userid);
                $request->session()->put('user', $user_data);
                // $viewname = 'homepage';
                return JSONResponse(200, 'OTP verified successfully.', ['user_id' => $userid, 'user_signup_method' => $signup_method, 'otp_pin' => $otp_pin, 'response' => $response, 'user_data' => $user_data, 'success' => true]);
            } elseif ($verifyotpResponseData['success'] == 'true' && $is_verified == false) {
                $request->session()->put('user_id', $userid);
                return JSONResponse(200, 'OTP verified successfully.', ['user_id' => $userid, 'user_signup_method' => $signup_method, 'otp_pin' => $otp_pin, 'response' => $response, 'success' => true]);
            } else {
                // dd("Api failed");
                return JSONResponse(200, 'OTP not verified successfully.', ['user_id' => $userid, 'user_signup_method' => $signup_method, 'otp_pin' => $otp_pin, 'response' => $response, 'success' => false]);
                // Incorrect code entered. Please try again.
            }
        }
    }

    public function ResetPasswordVerification(Request $request)
    {
        // $request = Request();
        // dd($request->all());
        $userid = $request->post('userid_detail');
        $signup_method = $request->post('user_sign_method');
        $password = $request->post('set-password');

        if (!empty($password)) {
            $verifyotpRequestData = array(
                'user_id' => $userid,
                'user_signup_method' => $signup_method,
                'password' => $password,
            );
            $verifyotpResponseData = [
                "success" => true,
                "message" => "OTP verified successfully."
            ];
            $verifyotpResponseData = CurlAPI("users/forgotPassword", 'POST', $verifyotpRequestData, 2);
            // dd($verifyotpResponseData);
            if (isset($verifyotpResponseData['user_data'])) {
                $is_verified = true;
            } else {
                $is_verified = false;
            }
            $response['message'] = $verifyotpResponseData['message'];
            $response['is_verified'] = $is_verified;

            // dd($verifyotpResponseData);
            if ($verifyotpResponseData['success'] == 'true' && $is_verified == true) {
                $user_data = $verifyotpResponseData['user_data'];
                $request->session()->put('user_id', $userid);
                $request->session()->put('user', $user_data);
                // $viewname = 'homepage';
                return JSONResponse(200, 'User verified successfully.', ['user_id' => $userid, 'user_signup_method' => $signup_method, 'response' => $response, 'user_data' => $user_data, 'success' => true]);
            } elseif ($verifyotpResponseData['success'] == 'true' && $is_verified == false) {
                $request->session()->put('user_id', $userid);
                return JSONResponse(200, 'User verified successfully.', ['user_id' => $userid, 'user_signup_method' => $signup_method, 'response' => $response, 'success' => true]);
            } else {
                // dd("Api failed");
                return JSONResponse(200, 'User not verified successfully.', ['user_id' => $userid, 'user_signup_method' => $signup_method, 'response' => $response, 'success' => false]);
                // Incorrect code entered. Please try again.
            }
        }
    }
}
