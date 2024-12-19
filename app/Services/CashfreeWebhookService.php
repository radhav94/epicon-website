<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class CashfreeWebhookService
{

    public function processWebhookCallback(array $webhookResponse = [])
    {
        $this->cashfreeLog('webhook cashfree --begin--');
        $this->cashfreeLog("----- Sleeping for 5 mins -----");
        sleep(180);
        $this->cashfreeLog("----- webhook payload -----", '', $webhookResponse);

        if (!empty($webhookResponse) && strtolower(@$webhookResponse['data']['payment']['payment_status']) == 'success') {
            $webhookOrderData = @$webhookResponse['data']['order'];
            $webhookPaymentData = @$webhookResponse['data']['payment'];
            $webhookCustomerData = @$webhookResponse['data']['customer_details'];
            $getOrderDataParams = [
                'order_id' => @$webhookOrderData["order_id"]
            ];

            $this->cashfreeLog('Request Update Order Data --begin--', false, ['endpoint' => 'subscriptions/updateOrderData', 'request' => $getOrderDataParams]);
            $orderData = CurlAPI("subscriptions/updateOrderData", 'POST', $getOrderDataParams, 2, false, true);
            $this->cashfreeLog('Request Update Order Data --end--', false, ['endpoint' => 'subscriptions/updateOrderData', 'response' => $orderData]);

            $mismatchFlag = false; //if order_id is missmatched

            if (empty(@$orderData['data'])) {
                //new api
                if (isset($webhookCustomerData['customer_email']) && !empty(@$webhookCustomerData['customer_email'])) {

                    $newParam = ['email' => $webhookCustomerData['customer_email']];

                    $this->cashfreeLog('Request check active subscription --begin--', false, ['endpoint' => 'subscriptions/checkActiveSubscription', 'request' => $newParam]);
                    $result = CurlAPI("subscriptions/checkActiveSubscription", 'POST', $newParam, 2, false, true);
                    $this->cashfreeLog('Request check active subscription --end--', false, ['endpoint' => 'subscriptions/checkActiveSubscription', 'response' => $result]);

                    if ($result['status'] == false && isset($result['userOrder'])) {
                        $mismatchFlag = true;

                        $orderData = [];
                        $orderData['success'] = true;
                        $orderData['data'] = $result['userOrder'];
                        $this->cashfreeLog('cashfree-webhook -- missmatch found', false, ['order_id' => @$result['userOrder']['order_id']]);
                    }
                }
            } else {
                $newParam = ['email' => @$webhookCustomerData['customer_email']];

                $this->cashfreeLog('Request check active subscription --begin--', false, ['endpoint' => 'subscriptions/checkActiveSubscription', 'request' => $newParam]);
                $result = CurlAPI("subscriptions/checkActiveSubscription", 'POST', $newParam, 2, false, true);
                $this->cashfreeLog('Request check active subscription --end--', false, ['endpoint' => 'subscriptions/checkActiveSubscription', 'response' => $result]);

                if (@$result['status'] == true && @$result['userOrder']['order_status'] == 'complete') {
                    exit();
                }
            }

            if ($orderData && @$orderData['success'] == true && @$orderData['data']['order_status'] == 'initiated') {
                $orderData = $orderData['data'];
                // $verifyPayment = $this->verifyPaymentStatus(@$webhookData["order_id"]);

                // if ($verifyPayment) {

                if ($mismatchFlag) {
                    $txnId = $orderData['order_id'];
                } else {
                    $txnId = $webhookOrderData["order_id"];
                }

                //following data must be updated according to cashfree | api changes required
                $input = [
                    "key" => $webhookResponse["key"],
                    "hash" => $webhookResponse["hash"],
                    "txnid" => $txnId,
                    "amount" => $webhookPaymentData["payment_amount"],
                    "firstname" => $webhookCustomerData["customer_name"],
                    "email" => $webhookCustomerData["customer_email"],
                    "phone" => $webhookCustomerData["customer_phone"],
                    "productinfo" => $webhookResponse["productinfo"],
                    "surl" => $webhookResponse["surl"],
                    "furl" => $webhookResponse["furl"],
                    "api_version" => 12,
                    "lastname" => null,
                    "pg" => @$webhookResponse["pg"] != '' ? $webhookResponse["pg"] : null,
                    "order_id" => $txnId,
                    "payu_status" => $webhookResponse["status"]
                ];

                $this->cashfreeLog('Request Update Order Data --begin--', false, ['endpoint' => 'subscriptions/updateOrderData', 'request' => $getOrderDataParams]);
                $updatePayment = CurlAPI("subscriptions/updateOrderData", 'POST', $input, 2, false, true);
                $this->cashfreeLog('Request Update Order Data --end--', false, ['endpoint' => 'subscriptions/updateOrderData', 'response' => $orderData]);

                $updateOrderData = [
                    'plan' => $orderData['plan_id'] ?? '',
                    'user_id' => $orderData['user_id'] ?? '',
                    'order_id' => $txnId ?? '',
                    'order_status' => 'complete',
                    'payment_gateway' => 'cashfree',
                    'coupon_applied' => $orderData['coupon_applied'] ?? '',
                    'payment_mode' => $orderData['pg'] ?? '',      //optional parameter | not required for cashfree
                    'authPayuId' => $orderData['order_id'] ?? '',       //optional parameter | not required for cashfree
                    'is_recurring' => false,        //optional parameter | not required for cashfree
                ];

                $this->cashfreeLog('Request Update Order --begin--', $txnId, ['endpoint' => 'subscriptions/updateOrder', 'request' => $updateOrderData]);
                $updateOrder = CurlAPI("subscriptions/updateOrder", 'POST', $updateOrderData, 2, false, true);
                $this->cashfreeLog('Request Update Order --end--', $txnId, ['endpoint' => 'subscriptions/updateOrder', 'response' => $updatePayment]);

                // $amount = $webhookResponse['amount'] ?? 0;
                // $this->preDebit($webhookResponse, $orderData);
                // $this->recurringPayment($webhookResponse, $amount);
                // $this->EventPushData($webhookResponse);
                // } else {

                //     $this->cashfreeLog('payu-webhook -- Verify Payment Status Failed', false, [  'txnid' =>  $webhookResponse['txnid'] ]);

                // }
            } else {
                $this->cashfreeLog('cashfree-webhook -- subscriptions/updateOrderData else Loop', false, ['url' => 'subscriptions/updateOrderData', 'request' => $getOrderDataParams]);
            }
        } else {
            $this->cashfreeLog("cashfree-webhook -- payment status else loop " . @$webhookResponse['data']['payment']['payment_status'] . " Status -----");
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

        $this->cashfreeLog('payu-webhook -- Verify Payment Status', false, ['url' => $url, 'request' => $data, 'response' => $verifyPayment]);

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

        $this->cashfreeLog('payu-webhook -- Pre Debit', false, ['url' => $url, 'request' => $data, 'response' => $pre_debit]);
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

        $this->cashfreeLog('payu-webhook -- Recuring Payment', false, ['url' => $url, 'request' => $data, 'response' => $recurringPayment]);
    }

    public function EventPushData($order)
    {
        if ($order['status'] == "success") {
            $data['Mobile'] = @$order['phone'];
            EventPush($order['user_id'], 'Subscribe', $data, true, false);
        }
    }

    private function cashfreeLog($msg, $uid = '', $data = [])
    {
        $prefix = ($uid != '') ? '--TxId-' . $uid . '-- ' : '';
        if ($data) {
            Log::channel('cashfree')->info($prefix . '' . $msg . PHP_EOL . json_encode($data));
        } else {
            Log::channel('cashfree')->info($prefix . $msg);
        }
    }
}
