<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class PayuWebhookCancelRecur
{

    public function processWebhookCallback(array $webhookResponse = [])
    {
        return 1;
        $this->payuLog("=== payu recur cancel BEGIN (inside processWebhookCallback | ".@$webhookResponse['authPayuId'].") ===");
        if(@$webhookResponse['status'] != 'active'){
            /**BEGIN call api to set is_recurring to false */
            $data = [
                'is_recurring' => false,
                'authpayuid'   => @$webhookResponse['authPayuId']
            ];
            $this->payuLog("Begin Calling Recur cancel API (subscriptions/cancelSiRecur)",'', $data);
            $response = CurlAPI("subscriptions/cancelSiRecur", 'POST',  $data, 2, false, true);
            $this->payuLog("End Calling Recur cancel API (subscriptions/cancelSiRecur)",'', $response);
            exit;
            /**END call api to set is_recurring to false */
        }else{
            $this->payuLog("=== payu recur cancel END (status active received | authpayuid : ".@$webhookResponse['authPayuId']." , status : ".@$webhookResponse['status'].") ");
            exit;
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