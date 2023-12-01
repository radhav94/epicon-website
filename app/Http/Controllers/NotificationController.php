<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
{
    public function getNotifications(Request $request)
    {
        // dd($request->all());
        $client = new Client();
        $url = 'https://onesignal.com/api/v1/notifications?app_id=71f3a678-707c-4f27-b722-836e941fab29&limit=10';

        // Headers
        $headers = [
            'Authorization' => "Basic ".env('NOTIFICATION_AUTH'),
            'Accept' => 'application/json',
        ];

        try {
            $response = $client->request('GET', $url, ['headers' => $headers]);
            $body = $response->getBody();
            $data = json_decode($body, true);

            /*$filteredNotifications = array_filter($data['notifications'], function ($notification) {
                echo date('Y-m-d H:i:s',$notification['send_after']);
                echo '<br>';

                return empty($notification['send_after']) || $notification['send_after'] <= strtotime(date('2023-11-27'));
            });
            dd($filteredNotifications);*/
            
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getServerIP(){
        echo "<pre>";
        print_r($_SERVER);
        $countrycode = getCountryCode();
        print_r($countrycode);
        // Check for the X-Forwarded-For header
    if (isset($_SERVER['HTTP_TRUE_CLIENT_IP'])) {
        $ipAddress = $_SERVER['HTTP_TRUE_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipAddress = '';
    }
    echo "=========".$ipAddress . "===============IP Adresss==========";
    $apiUrl = "https://ipinfo.io/{$ipAddress}/json";
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
    print_r($response);
        $input = [
            'x_country' => @$countrycode,
            'x_continent' => @$countrycode,
        ];
        // $result = CurlAPI("subscriptions/plans", "GET", "", 2);
        $result = CurlAPI("v2/subscriptions/plans", "GET", $input, 2);
        dd($result);
        echo "</pre>";
    }

}
