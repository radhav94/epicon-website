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
            'Authorization' => 'Basic MjRjOWIyYWYtNjM2Zi00MjViLTkwZjUtODI3NjI1NmZiNTE4',
            'Accept' => 'application/json',
            'Cookie' => '__cf_bm=eDHllvhoj99zAOo7VeDp4FL81HyGN12fG2wLX9uP5M4-1694688186-0-AdTC3iLJpDAFrF/XMALJlmy7xNa/Pn47yzz2sWH8w/3v3S/+FaaZq7EYAzeOGTEhDfQIjz9RFMBhZVsUS2G6/f8=; __cf_bm=L_pkXpCkhSsqhYZQyG.ICwkMn7nV6itcRE9iLQ7H2XA-1697205677-0-AS9cr18Ug1Qfhh2HOpYTLVVgwn6cYKYyq9CLdAKcgVebc8eTKSv4EqAY312XY+9xUbm9bP/P2rbTbre9eL0Wnb0=',
        ];

        try {
            $response = $client->request('GET', $url, ['headers' => $headers]);
            $body = $response->getBody();
            $data = json_decode($body, true);

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
