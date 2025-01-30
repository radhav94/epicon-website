<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function feedback()
    {
        $user = session()->get("user") ?? [];
        $countrycode = session()->get("countrycode");
        $mobile = isset($user['mobile']) && !empty($user['mobile']) ? $this->getUserMobile($user['mobile'], $countrycode) : "";
        $email = $user['email'] ?? "";
        return view(
            'feedback.feedback',
            [
                'show' => 'show',
                'mobile' => $mobile,
                'email' => $email,
                'countrycode' => $countrycode
            ]
        );
    }

    public function saveFeedback()
    {
        $request = Request();
        $country = $request->post('country') ?? "";
        $email = $request->post('email') ?? "";
        $message = $request->post('message') ?? "";
        $phone = $request->post('phone') ?? "";
        $stdisdcode = $request->post('isdcode') ?? "";
        $platform = $request->post('platform') ?? "";
        if (empty($email) || empty($message) || empty($country) || empty($platform)) {
            return JSONResponse(200, '', ['message' => "Please fill all required fields!", 'success' => false]);
        }
        $curlData = [
            "country" => $country,
            "email" => $email,
            "message" => $message,
            "phone" => !empty($phone) ? "$stdisdcode$phone" : "",
            "platform" => $platform
        ];
        $response = CurlAPI("pages/queries", "POST", $curlData, 1);

        $response = $response['payload'] ?? $response;

        if ($response) {
            $error_code = array_key_exists("errorcode", $response) ? $response['errorcode'] : '';
            return JSONResponse(200, '', ['message' => @$response['message'], 'success' => @$response['success'], 'errorcode' => $error_code]);
        } else {
            return JSONResponse(200, '', ['message' => "Something went wrong. Please try again!", 'success' => false]);
        }
    }

    private function getUserMobile($mobile, $countrycode)
    {
        $countrystate = getCountryStateData();
        $countryisdcode = '';
        if (!empty($countrystate)) {
            $key = array_search($countrycode, array_column($countrystate['countries'], "code"));
            $countryisdcode = $countrystate['countries'][$key]['countryisdcode'];
        }
        return substr($mobile, strlen($countryisdcode));
    }
}
