<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Session;

if (!function_exists('postCurlApicall')) {
    function postCurlApicall($context, $data = null, $apiDomain = 1, $user_token = "") {
        if (empty($context)) return;

        $request = Request();
        $token = $request->session()->get('user_token') ?? $user_token;
        $curlData = $data && !empty($data) ? json_encode($data) : '';

        if ($apiDomain == 2) {
            $url = config('epicconfig.EPICAPI.API_DOMAIN_2') . $context . "?auth_token=" . config('epicconfig.EPICAPI.API_AUTH_TOKEN');
        } else {
            $url = config('epicconfig.EPICAPI.API_DOMAIN_1') . $context . "?auth_token=" . config('epicconfig.EPICAPI.API_AUTH_TOKEN');
        }
        

        $curl = curl_init();

        curl_setopt_array($curl, 
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>$curlData,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    "Authorization: $token"
                ),
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
    }
}
