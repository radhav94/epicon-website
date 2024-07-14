<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

function CurlAPI($context, $method = 'GET', $data = null, $apiDomain = 1, $sendUserToken = false,$sendAuthTokenparams = false, $logCommandCurl = false)
{

    if ($apiDomain == 3) {
        $url = config('epicconfig.EPICAPI.API_DOMAIN_3') . $context;
    }else if ($apiDomain == 2) {
        $url = config('epicconfig.EPICAPI.API_DOMAIN_2') . $context;
    } else {
        $url = config('epicconfig.EPICAPI.API_DOMAIN_1') . $context;
    }
    $auth_token = config('epicconfig.EPICAPI.API_AUTH_TOKEN');

    $token = Session::get('user_token') ?? '';

    $param = ['auth_token' => $auth_token];

    $headers = [];
    if (!$sendAuthTokenparams) {
        $headers[] = 'x-access-auth-token: ' . config('epicconfig.EPICAPI.API_AUTH_TOKEN');
    }
    if ($sendUserToken && !empty($token)) {
        $headers[] = "Authorization: " . $token;
    }



    $curl = curl_init();

    Log::channel('api')->info('-----------------------------------------'); 
    Log::channel('api')->info('Method : '.strtoupper($method)); 
    
    $verboseLog = fopen('php://temp', 'w+');

    if (strtoupper($method) == 'GET') {
        $api_url = ($data != null && !empty($data)) ? $url . "?" . http_build_query($data) : $url;

        Log::channel('api')->info('URL : '.$api_url); 

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
            CURLOPT_STDERR => $verboseLog,
            CURLOPT_VERBOSE => true,
        ));

        $checking_type = 'GET';
        $checking_url = $api_url;
        $checking_data = $data;
        if($logCommandCurl){
            $curlCommand = generateCurlCommand('GET', $api_url, $headers, $data, [],'api');
        }
    } else {
        $headers[] = 'Content-Type: application/json';

        $req_data = ($data != null && !empty($data)) ? json_encode($data) : null;
        if ($sendAuthTokenparams) {
        $url = $url . "?" . http_build_query($param);
        }

        Log::channel('api')->info('URL : '.$url); 
        Log::channel('api')->info('INPUT : '.$req_data); 

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
            CURLOPT_STDERR => $verboseLog,
            CURLOPT_VERBOSE => true,
        ));

        $checking_type = 'POST';
        $checking_url = $url;
        $checking_data = $req_data;
        if($logCommandCurl){
            $curlCommand =  generateCurlCommand('POST', $url, $headers, $req_data, [],'api');
        }
    }

    $response = curl_exec($curl);
    $curl_errno = curl_errno($curl);

    try {
        $response_data = json_decode($response? $response : '', true);
        if ($response === false || $curl_errno > 0 || $curl_errno == CURLE_OPERATION_TIMEOUTED || $curl_errno == CURLE_COULDNT_CONNECT || (isset($response_data['success']) && $response_data['success'] != true)) {
            $curl_error = curl_error($curl);
            $errorMessage = "cURL error ({$curl_errno}): {$curl_error}";
            \Log::channel('error_404')->debug('--------------(cUrl Hit) Error (' . date('h:i:s A') . ')----------------------');
            \Log::channel('error_404')->debug('----------- cURL=>');
            generateCurlCommand($checking_type, $checking_url, $headers, $checking_data, [],'error_404');
            \Log::channel('error_404')->debug('----------- -/ End cURL ---------');
            \Log::channel('error_404')->debug('Error Message =>' . json_encode($errorMessage ?? ''));
            \Log::channel('error_404')->debug('Status Code =>' . json_encode($http_status ?? ''));
            // Capture verbose output
            rewind($verboseLog);
            $verboseLogContent = stream_get_contents($verboseLog);
            // Log verbose output
            \Log::channel('error_404')->debug('Verbose Log =>' . json_encode($verboseLogContent ?? ''));
            \Log::channel('error_404')->debug('Error =>' . json_encode($response? $response : ''));
        }
        fclose($verboseLog);
    } catch (\Throwable $th) {
        $errorMessage = $th->getMessage();
        \Log::channel('error_404')->debug('Catch Error Message =>' . $errorMessage ?? '');
        }
    curl_close($curl);

    // dd($response);
    if ($curl_errno > 0) {
        Log::channel('api')->info('Status : Failed, Curl error : '.$curl_errno ); 

        return ['success' => false, 'message' => 'Curl failed', 'error' => $curl_errno];
    } else {
        Log::channel('api')->info('Status : Success'); 

        $apiresponse = json_decode($response? $response : '', true);

        return $apiresponse;
    }
}


function generateCurlCommand($method, $url, $headers, $data, $options,$log) {
        $command = "curl -X " . escapeshellcmd($method);

        // Add URL
        $command .= " \"" . escapeshellarg($url) . "\"";

        // Add headers
        foreach ($headers as $header) {
            $command .= " -H \"" . escapeshellarg($header) . "\"";
        }

        // Add data for POST requests
        if ($method == 'POST' && $data) {
            $command .= " -d '" . escapeshellarg(json_encode($data)) . "'";
        }

        // Add options
       /* $command .= " --max-redirs " . escapeshellarg($options['CURLOPT_MAXREDIRS']);
        $command .= " --connect-timeout " . escapeshellarg($options['CURLOPT_TIMEOUT']);
        if ($options['CURLOPT_FOLLOWLOCATION']) {
            $command .= " --location";
        }*/
        Log::channel($log)->info('-------Start Terminal Curl Call-------- '."\n\n". $command."\n"); 
        Log::channel($log)->info('-------End Terminal Curl Call-------- '); 

        return $command;
}
