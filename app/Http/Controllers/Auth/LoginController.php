<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    // public function getSignin($message = '')
    // {
    //     // dd("Get Sign in");
    //     if (isLoggedInUser()) {
    //         // dd("true");
    //         return redirect('/');
    //     }
    //     $countrystate = getCountryStateData();
    //     // $pagetype = 'login';
    //     // $menuArray = getMainMenu();
    //     $menuArray = "";
    //     $request = Request();

    //     // redirect to
    //     $redirectto = '/';
    //     if (!empty($request->get('rt'))) {
    //         $redirectto = $request->get('rt');
    //         $request->session()->put('redirectto', $redirectto);

    //         // MI TV QR
    //         if (!empty($request->get('promotionkey'))) {
    //             $request->session()->forget('promotionkey');
    //             $request->session()->put('promotionkey', $request->get('promotionkey'));
    //         }

    //         // newspapaer QR
    //         if (!empty($request->get('qrpromocodekey'))) {
    //             $request->session()->forget('qrpromocodekey');
    //             $request->session()->put('qrpromocodekey', $request->get('qrpromocodekey'));
    //         }
    //     }
    //     // $meta = $this->getMeta($pagetype);
    //     $authEventTrack = '';
    //     if (!empty($message)) {
    //         $authEventTrack = 'Login Fail';
    //         $eventCat = 'Login';
    //     }
    //     return view('auth.login-reg-popup', compact('message', 'countrystate', 'menuArray', 'authEventTrack'));
    // }

    // Mobile Number Update and Send OTP
    public function setSendOTP(Request $request)
    {
        $mobile_number = $request->post('mobile_number');
        $signup_method = $request->post('signup_method');
        if ($signup_method == 'MOBILE' && !empty($request->post('stdisdcode'))) {
            $mobile_number = str_replace("+", "", $request->post('stdisdcode')) . $mobile_number;
        }
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
            if ($SendotpResponseData && (@$SendotpResponseData['success'] == 'true' || @$SendotpResponseData['success'] == true)) {
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
        $otp_pin = $request->post('otp_pin');
        if (!empty($otp_pin)) {
            $verifyotpRequestData = array(
                'user_id' => $userid,
                'user_signup_method' => $signup_method,
                'otp' => $otp_pin,
                'user_agent' => getUserAgent(),
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
            if ((@$verifyotpResponseData['success'] == 'true' || @$verifyotpResponseData['success'] == true) && $is_verified == true) {
                $user_data = $verifyotpResponseData['user_data'];
                $request->session()->put('user_id', $userid);
                $request->session()->put('user', $user_data);
                $request->session()->put('user_token', $verifyotpResponseData['token']);
                $request->session()->put('device_id', @$verifyotpResponseData['user_data']['device_id']);
                $subplan = checkSubscription();
                // $viewname = 'homepage';
                return JSONResponse(200, 'OTP verified successfully.', ['user_id' => $userid, 'user_signup_method' => $signup_method, 'otp_pin' => $otp_pin, 'response' => $response, 'user_data' => $user_data, 'success' => true,'subplan_status' => @$subplan['status']]);
            } elseif ((@$verifyotpResponseData['success'] == 'true' || @$verifyotpResponseData['success'] == true) && $is_verified == false) {
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
            'date_of_birth' => $date_of_birth != "" ? date("Y-m-d", strtotime($date_of_birth)) : "",
            'gender' => $gender,
        );
        $registerResponseData = CurlAPI("users/register", 'POST', $postData, 2);
        $request->session()->put('registerResponseData', $registerResponseData);
        $response['message'] = $registerResponseData['message'];
        
        if ($registerResponseData && (@$registerResponseData['success'] == 'true' || @$registerResponseData['success'] == true)) {
            $userdata = $registerResponseData['user_data'];
            session()->put('user', $userdata);
            session()->put('user_id', $userid);
            session()->put('user_token', $registerResponseData['token']);
            $request->session()->put('device_id', @$registerResponseData['user_data']['device_id']);
            return JSONResponse(200, 'User Registered Successfully.', ['user_id' => $userid, 'user_signup_method' => $signup_method, 'name' => $username, 'password' => $password, 'date_of_birth' => $date_of_birth, 'gender' => $gender, 'response' => $response, 'success' => true, 'user_token' => $registerResponseData['token']]);
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
        $signup_method = $request->post('signup_method');
        // $userAgent = $request->post('userAgent');
        if ($signup_method == 'MOBILE' && !empty($request->post('stdisdcode'))) {
            $userid = str_replace("+", "", $request->post('stdisdcode')) . $userid;
        }
        $postedData = [
            'user_id' => $userid,
            'password' => $password,
            'user_agent' => getUserAgent(),
        ];

        $loginResponseData = CurlAPI("users/loginWithPassword", 'POST', $postedData, 2);
        // dd($loginResponseData);
        $response['message'] = $loginResponseData['message'];
        
        if (@$loginResponseData['success'] == true && !empty($loginResponseData['user_data'])) {
            $userdata = $loginResponseData['user_data'];
            $request->session()->put('user', $userdata);
            $request->session()->put('user_id', $userid);
            $request->session()->put('user_token', $loginResponseData['token']);
            $request->session()->put('device_id', @$loginResponseData['user_data']['device_id']);

            if (!empty($request->post('rememberme'))) {
                setcookie("user_id", strtolower($userid), time() + 60 * 60 * 24 * 30);
                setcookie("user_password", $password, time() + 60 * 60 * 24 * 30);
            }
            $subplan = checkSubscription();
            return JSONResponse(200, 'User Logged In Successfully.', ['redirect' => url('/') , 'success' => true, 'subplan_status' => @$subplan['status']]);
        } else {
            return JSONResponse(200, 'Invalid Credentials.', ['response' => $response, 'success' => false]);
            // return redirect('/');
        }
    }

    public function SendForgotOtp(Request $request)
    {
        $user_id = $request->post('forgot-name');
        $countryCode = str_replace("+", "", $request->post('stdisdcode'));
        $signup_method = $request->post('signin_method');

        if($signup_method == 'MOBILE'){
            $user_id = $countryCode.$user_id;
        }

        if (!empty($user_id)) {
            $SendotpRequestData = array(
                'user_id' => $user_id,
                'user_signup_method' => $signup_method,
            );
    
            $SendotpResponseData = CurlAPI("users/sendForgotPassOTP", 'POST', $SendotpRequestData, 2);

            $response['meassage'] = @$SendotpResponseData['message'];

            if ($SendotpResponseData && (@$SendotpResponseData['success'] == 'true' || $SendotpResponseData['success'] == true)) {

                $request->session()->put('mobile_number', $user_id);

                return JSONResponse(200, 'OTP sent successfully.', ['user_id' => $user_id, 'user_signup_method' => $signup_method, 'response' => $response, 'success' => true]);
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
            if ((@$verifyotpResponseData['success'] == 'true' && @$verifyotpResponseData['success'] == true) && $is_verified == true) {
                $user_data = $verifyotpResponseData['user_data'];
                // $request->session()->put('user_id', $userid);
                $request->session()->put('user', $user_data);
                // $viewname = 'homepage';
                return JSONResponse(200, 'OTP verified successfully.', ['user_id' => $userid, 'user_signup_method' => $signup_method, 'otp_pin' => $otp_pin, 'response' => $response, 'user_data' => $user_data, 'success' => true]);
            } elseif ((@$verifyotpResponseData['success'] == 'true' && @$verifyotpResponseData['success'] == true) && $is_verified == false) {
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
            if ($verifyotpResponseData && (@$verifyotpResponseData['success'] == 'true' || $verifyotpResponseData['success'] == true) && $is_verified == true) {
                $user_data = $verifyotpResponseData['user_data'];
                $request->session()->put('user_id', $userid);
                $request->session()->put('user', $user_data);
                // $viewname = 'homepage';
                return JSONResponse(200, 'User verified successfully.', ['user_id' => $userid, 'user_signup_method' => $signup_method, 'response' => $response, 'user_data' => $user_data, 'success' => true]);
            } elseif ((@$verifyotpResponseData['success'] == 'true' || $verifyotpResponseData['success'] == true) && $is_verified == false) {
                $request->session()->put('user_id', $userid);
                return JSONResponse(200, 'User verified successfully.', ['user_id' => $userid, 'user_signup_method' => $signup_method, 'response' => $response, 'success' => true]);
            } else {
                // dd("Api failed");
                return JSONResponse(200, 'User not verified successfully.', ['user_id' => $userid, 'user_signup_method' => $signup_method, 'response' => $response, 'success' => false]);
                // Incorrect code entered. Please try again.
            }
        }
    }

    public function getGenreList() {
        $request = Request();
        $genrelist = CurlAPI("v2profilecontent/genrelist", 'GET', [], 1);
        return JSONResponse(200, '', ['response' => $genrelist, 'message' => $genrelist['message'], 'success' => $genrelist['success']]);
    }

    public function saveGenreForUser() {
        $request = Request();
        $genre = $request->post('genreInterest') ? $request->post('genreInterest') : [];
        $user_token = $request->session()->get('user_token');
        $curlData = ["genre" => $genre];
        $genrelist = postCurlApicall("v2profilecontent/savegenrelist", $curlData, 1, $user_token);
        return JSONResponse(200, '', ['message' => $genrelist['message'], 'success' => $genrelist['success']]);
    }
}
