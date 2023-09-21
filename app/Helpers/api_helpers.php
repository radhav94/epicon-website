<?php

declare(strict_types=1);

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Session;



function CurlAPI_old($context, $method = 'GET', $data = null, $apiDomain = 1)
{

    if ($apiDomain == 3) {
        $url = config('epicconfig.EPICAPI.API_DOMAIN_3') . $context;
    }else if ($apiDomain == 2) {
        $url = config('epicconfig.EPICAPI.API_DOMAIN_2') . $context;
    } else {
        $url = config('epicconfig.EPICAPI.API_DOMAIN_1') . $context;
    }
    $token = Session::get('user_token') ?? '';
    return ApiHelper::api($url, $method, $data, $token);
}

function CurlAPI($context, $method = 'GET', $data = null, $apiDomain = 1, $sendUserToken = false)
{

    if ($apiDomain == 3) {
        $url = config('epicconfig.EPICAPI.API_DOMAIN_3') . $context;
    }else if ($apiDomain == 2) {
        $url = config('epicconfig.EPICAPI.API_DOMAIN_2') . $context;
    } else {
        $url = config('epicconfig.EPICAPI.API_DOMAIN_1') . $context;
    }

    $token = Session::get('user_token') ?? '';

    $headers = ['x-access-auth-token: ' . config('epicconfig.EPICAPI.API_AUTH_TOKEN')];
    if ($sendUserToken) {
        $headers[] = "Authorization: " . $token;
    }

    $curl = curl_init();

    if (strtoupper($method) == 'GET') {
        $api_url = ($data != null && !empty($data)) ? $url . "?" . http_build_query($data) : $url;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => $headers,
        ));
    } else {
        $headers[] = 'Content-Type: application/json';

        $req_data = ($data != null && !empty($data)) ? json_encode($data) : null;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>  $req_data,
            CURLOPT_HTTPHEADER => $headers,
        ));
    }


    $response = curl_exec($curl);
    $curl_errno = curl_errno($curl);

    curl_close($curl);
    // dd($response);
    if ($curl_errno > 0) {

        return ['success' => false, 'message' => 'Curl failed', 'error' => $curl_errno];
    } else {
        $apiresponse = json_decode($response, true);

        return $apiresponse;
    }
}
