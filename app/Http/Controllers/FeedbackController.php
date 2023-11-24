<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function feedback() {
        return view('feedback.feedback');
    }

    public function saveFeedback() {
        $request = Request();
        $feedback = $request->post('feedback') ? $request->post('feedback') : "";
        $curlData = [
            "type" => "feedback",
            "feedback" => $feedback
        ];
        $response = CurlAPI("users/deleteAccount", "POST", $curlData, 2, true);

        if ($response) {
            $error_code = array_key_exists("errorcode", $response) ? $response['errorcode'] : '';
            return JSONResponse(200, '', ['message' => @$response['message'], 'success' => @$response['success'], 'errorcode' => $error_code]);
        } else {
            return JSONResponse(200, '', ['message' => "Something went wrong. Please try again!", 'success' => false]);
        }
    }

}
