<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {   
        die;
        //get order data by email
        // $orderData = [];
        // $newParam = ['email' => 'mohammed.2010vazeer@gmail.com1'];
        // $result = CurlAPI("subscriptions/checkActiveSubscription", 'POST', $newParam, 2, false, true);
    
        // if($result['status'] == false && isset($result['userOrder'])){
        //     $orderData = [];
        //     $orderData['success'] = true;
        //     $orderData['data'] = $result['userOrder'];
        // }
        // dd($orderData);

        //get order data
        $getOrderDataParams = [
            'order_id' => 77692712
        ];
        $orderData = CurlAPI("subscriptions/updateOrderData", 'POST', $getOrderDataParams, 2, false, true);

        dd($orderData);
        $txid = 19429969818;
        $txid = 776927;
        // $txid = 1710712966715;
        $verifyPayment = $this->verifyPaymentStatus($txid);
        dd( $verifyPayment );
    }

    public function verifyPaymentStatus($txnid = null)
    {
        $verifyPaymentParameters['key'] = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY');
        $verifyPaymentParameters['command'] = 'verify_payment';
        $verifyPaymentParameters['var1'] = $txnid;
        $hash = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY') . '|' . $verifyPaymentParameters['command'] . '|' . $verifyPaymentParameters['var1'] . '|' . config('epicconfig.PAYUMONEY.PAYUMONEY_SALT');
        $calculatedHash = strtolower(hash("sha512", $hash));
        $verifyPaymentParameters['hash'] = $calculatedHash;
        $data = 'key=' . $verifyPaymentParameters['key'] . '&command=' . $verifyPaymentParameters['command'] . '&var1=' . $verifyPaymentParameters['var1'] . '&hash=' . $verifyPaymentParameters['hash'];
        $url = config('epicconfig.PAYUMONEY.API_URL');

        $verifyPayment = si_transaction($url, $data);

        // $this->payuLog('Verify Payment Status', [ 'url' => $url, 'request' => $data, 'response' => $verifyPayment]);

        $verifyDetails = json_decode($verifyPayment);

        return $verifyDetails;
    }

    public function index1()
    {

        /* $routenamed = 'home-v2';
        $epicwebArr = CurlAPI("pages/" . $routenamed, "GET", ['displayLanguage' => 'ENGLISH', 'listLanguage' => 'all', 'page' => 1, 'tray_limit' => 5]);

        dd($epicwebArr);*/
        // dd(config('epicconfig.EPICAPI.API_AUTH_TOKEN'));
        $recommendationData = ['user_id' => 'epicepic123@mailinator.com', 'asset_type' => 'LISTEN'];
        // $recommendationArr = CurlAPI("pages/recommendation", "GET", $recommendationData);

        // $recommendationArr = CurlAPI("http://contentapi-njsapi.epicon.in/index/pages/homepage?slug=tv-shows&list_language=ALL&display_language=TAMIL", "GET", []);

        $params = [
            'slug' => 'home-v2',
            'list_language' => 'ALL',
            'display_language' => 'TAMIL',
            'page' => 1,
            'tray_limit' => 1,
        ];

        $data = CurlAPI("pages/homepage", "GET", $params);

        dd($data);
    }
}
