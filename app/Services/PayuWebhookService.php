<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class PayuWebhookService
{

    public function processWebhookCallback(array $webhookResponse = [])
    {
        $this->payuLog('payu-webhook ----- Inside processWebhookCallback function -----');

        if (!empty($webhookResponse) && @$webhookResponse['status'] == 'success') {
            $getOrderDataParams = [
                'order_id' => $webhookResponse["txnid"]
            ];
            $orderData = CurlAPI("subscriptions/updateOrderData", 'POST', $getOrderDataParams, 2, false, true);

            $this->payuLog('payu-webhook -- Get User Order', false, [ 'url' => 'subscriptions/updateOrderData', 'request' => $getOrderDataParams, 'response' => $orderData ]);

            
            $mismatchFlag = false; //if order_id is missmatched

            if(empty(@$orderData['data'] )){
                //new api
                if(isset($webhookResponse['email']) && !empty($webhookResponse['email'])){


                    Log::info("----- Inside checkActiveSubscription -----");

                    $newParam = ['email' => $webhookResponse['email']];
                    $result = CurlAPI("subscriptions/checkActiveSubscription", 'POST', $newParam, 2, false, true);
                    

                    $this->payuLog('payu-webhook -- checkActiveSubscription', false, [ 'url' => 'subscriptions/checkActiveSubscription', 'request' => $newParam, 'response' => $result]);

                    if($result['status'] == false && isset($result['userOrder'])){
                        $mismatchFlag = true;
    
                        $orderData = [];
                        $orderData['success'] = true;
                        $orderData['data'] = $result['userOrder'];

                        $this->payuLog('payu-webhook -- missmatch found', false, [ 'order_id' => @$result['userOrder']['order_id']]);

                    }
                }
                
            }

            if ($orderData && @$orderData['success'] == true && @$orderData['data']['order_status'] == 'initiated') {
                $orderData = $orderData['data'];
                $verifyPayment = $this->verifyPaymentStatus($webhookResponse['txnid']);

                if ($verifyPayment) {

                    if($mismatchFlag){
                        $txnId = $orderData['order_id'];
                    }else{
                        $txnId = $webhookResponse["txnid"];
                    }

                    $input = [
                        "key" => $webhookResponse["key"],
                        "hash" => $webhookResponse["hash"],
                        "txnid" => $txnId,
                        "amount" => $webhookResponse["amount"],
                        "firstname" => $webhookResponse["firstname"],
                        "email" => $webhookResponse["email"],
                        "phone" => $webhookResponse["phone"],
                        "productinfo" => $webhookResponse["productinfo"],
                        "surl" => $webhookResponse["surl"],
                        "furl" => $webhookResponse["furl"],
                        "api_version" => 12,
                        "lastname" => $webhookResponse["lastname"] ?? null,
                        "pg" => @$webhookResponse["pg"] != '' ? $webhookResponse["pg"] : null,
                        "order_id" => $txnId,
                        "payu_status" => $webhookResponse["status"]
                    ];
                    
                    $updatePayment = CurlAPI("subscriptions/updateOrderData", 'POST', $input, 2, false, true);

                    $this->payuLog('payu-webhook -- updateOrderData', false, [ 'url' => 'subscriptions/updateOrderData', 'request' => $input, 'response' => $updatePayment]);

                    $updateOrderData = [
                        'plan' => $orderData['plan_id'] ?? '',
                        'user_id' => $orderData['user_id'] ?? '',
                        'order_id' => $txnId,
                        'order_status' => 'complete',
                        'payment_gateway' => 'payu',
                        'bank_ref_no' => @$webhookResponse['bank_ref_num'],
                        'transaction_id' => @$webhookResponse['mihpayid'] ?? '',
                        'authPayuId' => @$webhookResponse['mihpayid'] ?? '',
                        'is_recurring' => (@$webhookResponse['payment_source'] == 'sist') ? true : false,
                        'ios_receipt' => '',
                        'android_receipt' => '',
                        'web_device' => 'web',
                        'coupon_applied' => $orderData['coupon_applied'] ?? '',
                        'subscriptionId' => '',
                        'subscriptionPaymentMode' => '',
                        'note' => '',
                        'recurring_receipt' => '',
                        'bank_name' => '',
                        'payment_mode' => $webhookResponse['mode'] ?? '',
                        'x_country' => '',
                        'x_continent' => '',
                    ];

                    $updateOrder = CurlAPI("subscriptions/updateOrder", 'POST', $updateOrderData, 2, false, true);

                    $this->payuLog('payu-webhook -- updateOrder', false, [ 'url' => 'subscriptions/updateOrder', 'request' => $updateOrderData, 'response' => $updateOrder]);


                    // $amount = $webhookResponse['amount'] ?? 0;
                    // $this->preDebit($webhookResponse, $orderData);
                    // $this->recurringPayment($webhookResponse, $amount);
                    // $this->EventPushData($webhookResponse);
                } else {

                    $this->payuLog('payu-webhook -- Verify Payment Status Failed', false, [  'txnid' =>  $webhookResponse['txnid'] ]);
                    
                }
            } else {
                $this->payuLog('payu-webhook -- Get User Order Else Loop', false, [ 'url' => 'subscriptions/updateOrderData', 'request' => $getOrderDataParams]);
            }
        } else {

            $this->payuLog("payu-webhook ------- Received " . @$webhookResponse['status'] . " Status -----");
        }
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

        $this->payuLog('payu-webhook -- Verify Payment Status', false, [ 'url' => $url, 'request' => $data, 'response' => $verifyPayment]);

        $verifyDetails = json_decode($verifyPayment);

        return $verifyDetails->status;
    }

    public function preDebit(array $webhookResponse = [], array $orderData = []) 
    {
        $getOnlyDate = date('Y-m-d', strtotime(@$orderData['subscription_end_date']));
        $parameters['key'] = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY');
        $parameters['command'] = 'pre_debit_SI';
        $parameters['txnid'] = $webhookResponse['txnid'];
        $parameters['var1'] = json_encode([
            'authpayuid' => $webhookResponse['mihpayid'],
            'requestId' => md5($webhookResponse['mihpayid']),
            'debitDate' => $getOnlyDate,
            'invoiceDisplayNumber' => $webhookResponse['mihpayid'],
            'amount' => $webhookResponse['amount'],
            'action' => 'retreive',
        ]);
        $HASH = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY') . '|' . $parameters['command'] . '|' . $parameters['var1'] . '|' . config('epicconfig.PAYUMONEY.PAYUMONEY_SALT');
        $calculatedHash = strtolower(hash("sha512", $HASH));
        $parameters['hash'] = $calculatedHash;
        $data = 'key=' . $parameters['key'] . '&command=' . $parameters['command'] . '&var1=' . $parameters['var1'] . '&var2=&var3=&var4=&var5=&var6=&var7=&var8=&var9=&hash=' . $parameters['hash'];
        $url = config('epicconfig.PAYUMONEY.API_URL');
        $pre_debit = si_transaction($url, $data);

        $this->payuLog('payu-webhook -- Pre Debit', false, [ 'url' =>$url, 'request' => $data, 'response' => $pre_debit]);
    }

    public function recurringPayment(array $webhookResponse = [], $amount = 0) 
    {
        $parameters['key'] = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY');
        $parameters['command'] = 'si_transaction';
        $parameters['var1'] = json_encode([
            'authpayuid' => $webhookResponse['mihpayid'],
            'invoiceDisplayNumber' => $webhookResponse['mihpayid'],
            'amount' => $amount,
            'txnid' => 'rec_txid_' . $webhookResponse['txnid'],
            'phone' => $webhookResponse['phone'],
            "email" => $webhookResponse['email'],
        ]);

        $HASH = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY') . '|' . $parameters['command'] . '|' . $parameters['var1'] . '|' . config('epicconfig.PAYUMONEY.PAYUMONEY_SALT');
        $calculatedHash = strtolower(hash("sha512", $HASH));
        $parameters['hash'] = $calculatedHash;
        $data = 'key=' . $parameters['key'] . '&command=' . $parameters['command'] . '&var1=' . $parameters['var1'] . '&var2=&var3=&var4=&var5=&var6=&var7=&var8=&var9=&hash=' . $parameters['hash'];
        $url = config('epicconfig.PAYUMONEY.API_URL');
        $recurringPayment = si_transaction($url, $data);

        $this->payuLog('payu-webhook -- Recuring Payment', false, [ 'url' =>$url, 'request' => $data, 'response' => $recurringPayment]);
    }

    public function EventPushData($order)
    {   
        if ($order['status'] == "success") {
            $data['Mobile'] = @$order['phone'];
            EventPush($order['user_id'], 'Subscribe', $data, true, false);
        }
    }

    private function payuLog($msg, $uid='', $data=[]){
        $prefix = ($uid != '') ? '--TxId-'.$uid.'-- ' : '';

        if($data){
            Log::channel('payu_webhook')->info($prefix.''.$msg. PHP_EOL . json_encode($data));
        }else{
            Log::channel('payu_webhook')->info($prefix.$msg );
        }
    }
}