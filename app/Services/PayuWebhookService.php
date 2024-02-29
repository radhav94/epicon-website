<?php

namespace App\Services;

use Log;

class PayuWebhookService
{

    public function processWebhookCallback(array $webhookResponse = [])
    {
        Log::info("----- Inside processWebhookCallback function -----");
        if (!empty($webhookResponse) && @$webhookResponse['status'] == 'success') {
            $getOrderDataParams = [
                'order_id' => $webhookResponse["txnid"]
            ];
            $orderData = CurlAPI("subscriptions/updateOrderData", 'POST', $getOrderDataParams, 2, false, true);

            if ($orderData && @$orderData['success'] == true && @$orderData['data']['order_status'] == 'initiated') {
                $orderData = $orderData['data'];
                $verifyPayment = $this->verifyPaymentStatus($webhookResponse['txnid']);

                if ($verifyPayment) {
                    $input = [
                        "key" => $webhookResponse["key"],
                        "hash" => $webhookResponse["hash"],
                        "txnid" => $webhookResponse["txnid"],
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
                        "order_id" => $webhookResponse["txnid"],
                        "payu_status" => $webhookResponse["status"]
                    ];
                    
                    $updatePayment = CurlAPI("subscriptions/updateOrderData", 'POST', $input, 2, false, true);
                    Log::info("----- updateOrderData -----");
                    Log::debug(json_encode($input));
                    Log::info("----- updateOrderDataResponse -----");
                    Log::debug(json_encode($updatePayment));

                    $updateOrderData = [
                        'plan' => $orderData['plan_id'] ?? '',
                        'user_id' => $orderData['user_id'] ?? '',
                        'order_id' => $webhookResponse["txnid"],
                        'order_status' => 'complete',
                        'payment_gateway' => 'payu',
                        'bank_ref_no' => @$webhookResponse['bank_ref_num'],
                        'transaction_id' => @$webhookResponse['mihpayid'],
                        'authPayuId' => @$webhookResponse['mihpayid'],
                        'is_recurring' => true,
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
                    Log::info("----- updateOrder -----");
                    Log::debug(json_encode($updateOrderData));
                    Log::info("----- updateOrderResponse -----");
                    Log::debug(json_encode($updateOrder));

                    $amount = $webhookResponse['amount'] ?? 0;
                    $this->preDebit($webhookResponse, $orderData);
                    $this->recurringPayment($webhookResponse, $amount);
                    // $this->EventPushData($webhookResponse);
                } else {
                    Log::info("----- Failed to Verify Payment Status -----");
                }
            } else {
                Log::info("----- User Order-----");
                Log::debug($orderData);
            }
        } else {
            Log::info("----- Received " . @$webhookResponse['status'] . " Status -----");
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

        Log::info("----- Verify Payment Status -----");
        Log::debug(json_encode($verifyPaymentParameters));
        Log::debug($verifyPayment);

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
        Log::info("----- PayuMoney Pre Debit response -----");
        Log::debug(json_encode($parameters));
        Log::debug($pre_debit);
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
        Log::info("----- PayuMoney Recuring Payment response -----");
        Log::debug(json_encode($parameters));
        Log::debug($recurringPayment);
    }

    public function EventPushData($order)
    {   
        if ($order['status'] == "success") {
            $data['Mobile'] = @$order['phone'];
            EventPush($order['user_id'], 'Subscribe', $data, true, false);
        }
    }
}