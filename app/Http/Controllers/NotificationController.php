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
        echo "</pre>";
    }

}
