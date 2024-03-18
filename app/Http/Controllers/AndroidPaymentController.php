<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AndroidPaymentController extends Controller
{
    public function androidPayuUsingWeb(){

        $request = Request();

        $this->payuLog('-----Android Request Data------', false, [$request->all()]);


        $userid = $request->get('user_id');
        $firstname = $request->get('firstname');
        $order_number = $request->get('order_id');
        $totalamount = $request->get('order_value');
        $plan_id = $request->get('plan_id');
        $timestamp = $request->get('subscription_start_date');
        @$validity = $request->get('validity');
        $splitTimeStamp = explode("T", $timestamp);
        $newDate = $splitTimeStamp[0];
        $startdate = date("d-m-Y", strtotime($newDate));
        $finalcurrency = $request->get('currency');
        $payment_type = $request->get('pg');
        $mobile = $request->get('mobile');
        $email = $request->get('email');
        if (env('DEV_AMT') == true && ($userid == '123test123@mailinator.com' || $userid == '11test1@mailinator.com' || $userid == 'epicontest31@gmail.com' || $userid == '8169554956' || $userid == '9819208025')) {
            $totalamount = "1";
        }

        $parameters = ['tid' => time(),
        'txnid' => $order_number,
        'amount' => $totalamount,
        'firstname' => $firstname,
        'email' => $email,
        'phone' => $mobile,
        'productinfo' => 'epicon ' . $plan_id];
        if (strtoupper(env('APP_ENV')) == 'PRODUCTION') {
            if ($finalcurrency == 'USD') {
                $rate = getConvertedPrice($finalcurrency, 'INR');
                $totalamount = (!empty($totalamount) && $rate !== false) ? floor($rate) * $totalamount : env('INR_TO_USD_RATE', 83) * $totalamount;
                $parameters['amount'] = round(floor($totalamount), 2);
            }
            if ($finalcurrency == 'INR') {
                // if (env('PAYU_SI') == true) {
                //     $parameters['si'] = 1;
                // }
            } else {
                if ($finalcurrency == 'USD') {
                    $rate = getConvertedPrice($finalcurrency, 'INR');
                    $totalamount = (!empty($totalamount) && $rate !== false) ? floor($rate) * $totalamount : env('INR_TO_USD_RATE', 83) * $totalamount;
                    $parameters['amount'] = round(floor($totalamount), 2);
                }
            }
        } else {
            if ($finalcurrency == 'USD') {
                $rate = getConvertedPrice($finalcurrency, 'INR');
                $totalamount = (!empty($totalamount) && $rate !== false) ? floor($rate) * $totalamount : env('INR_TO_USD_RATE', 83) * $totalamount;
                $parameters['amount'] = round(floor($totalamount), 2);
            }
   
            if ($finalcurrency == 'INR') {
                // if (env('PAYU_SI') == true) {
                //     $parameters['si'] = 1;
                // }
            } else {
                if ($finalcurrency == 'USD') {
                    $rate = getConvertedPrice($finalcurrency, 'INR');
                    $totalamount = (!empty($totalamount) && $rate !== false) ? floor($rate) * $totalamount : env('INR_TO_USD_RATE', 83) * $totalamount;
                    $parameters['amount'] = round(floor($totalamount), 2);
                }
            }
        }
        
        $parameters['key'] = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY');
        $parameters['phone'] = $mobile ?? '';
        if (env('PAYU_SI') == true) {
                $billingCycle = 'MONTHLY';
                if ($plan_id == 'epic_in_pl_1') {
                    $billingInterval = 1;
                    $newstartdate = date("Y-m-d");
                    // $billingCycle = 'DAILY';
                    // $endstartdate = date("Y-m-d", strtotime("+1 day"));
                    $billingCycle = 'MONTHLY';
                    //$endstartdate = date("Y-m-d", strtotime("+1 month -1 day"));
                } else if ($plan_id == 'epic_in_pl_2') {
                    $billingInterval = 3;
                    $billingCycle = 'MONTHLY';
                    $newstartdate = date("Y-m-d");
                    //$endstartdate = date("Y-m-d", strtotime("+3 month -1 day"));
                } else if ($plan_id == 'epic_in_pl_3') {
                    $billingInterval = 6;
                    $billingCycle = 'MONTHLY';
                    $newstartdate = date("Y-m-d");
                    //$endstartdate = date("Y-m-d", strtotime("+6 month -1 day"));
                } else {
                    $billingInterval = 1;
                    $billingCycle = 'YEARLY';
                    $newstartdate = date("Y-m-d");
                    //$endstartdate = date("Y-m-d", strtotime("+1 year"));
                }
                $endstartdate = date("Y-m-d", strtotime("+10 year"));
                $parameters['si'] = 1;
                $parameters['api_version'] = "7";
                $parameters['si_details'] = json_encode([
                    'billingAmount' => $totalamount,
                    'billingCurrency' => $finalcurrency,
                    'billingCycle' => $billingCycle,
                    'billingInterval' => $billingInterval,
                    'paymentStartDate' => $newstartdate,
                    'paymentEndDate' => $endstartdate
                ]);

            $HASH = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY') . '|' . $parameters['txnid'] . '|' . $parameters['amount'] . '|' . $parameters['productinfo'] . '|' . $parameters['firstname'] . '|' . $parameters['email'] . '|||||||||||' . $parameters['si_details'] . '|' . config('epicconfig.PAYUMONEY.PAYUMONEY_SALT');
        }
        else{
            $HASH = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY') . '|' . $parameters['txnid'] . '|' . $parameters['amount'] . '|' . $parameters['productinfo'] . '|' . $parameters['firstname'] . '|' . $parameters['email'] . '||||||||||||' . config('epicconfig.PAYUMONEY.PAYUMONEY_SALT');
        }
   
        if (in_array($payment_type, ['CC', 'DC', 'NB', 'CASH', 'UPI'])) {
            $parameters['pg'] = $payment_type;
        }

        

        $calculated_hash = strtolower(hash("sha512", $HASH));
        $parameters['hash'] = $calculated_hash;
        $parameters['SALT'] = config('epicconfig.PAYUMONEY.PAYUMONEY_SALT');
        $parameters['curl'] = getUrl('androidPayuresponse');
        $parameters['surl'] = getUrl('androidPayuresponse');
        $parameters['furl'] = getUrl('androidPayuresponse');
        $parameters['payuUrl'] = config('epicconfig.PAYUMONEY.SUBSCRIPTION_URL');
        $parameters['phone'] = $mobile;
        $parameters['email'] = $email;
        $parameters['user_id'] = $userid;
        $parameters['order_id'] = $order_number;
        $parameters['payment_gateway'] = "payumoney";
        $parameters['web'] = "android";
        $parameters['plan_id'] = $plan_id;
        $parameters['mode'] = '';
        $parameters['epic_price'] = $totalamount;

        $this->payuLog('-----PayUMoney Request Data------', false, [$parameters]);

        $request->session()->forget('payuParams');
        $request->session()->put('payuParams', $parameters);

        $orderData = $request->session()->get('payuParams');
         if (env('PAYU_SI') == true) {
            return view('subscription.payumoneysi', compact('parameters'));
        }
        else{
            return view('subscription.payumoney', compact('parameters'));
        }
    }

    public function androidPayuresponse(Request $request){

        $paymentresponse = $request->all();

        $this->payuLog('-----Android payment Response Data------', false, [$paymentresponse]);

        $paymtentStatus = strtolower($paymentresponse['status']);
        $final_result = ['message' => 'The transaction has been declined.',
        'status'=>@$paymtentStatus,
        'payu_err_message'=>@$paymentresponse['error_Message'],
        'mode'=>@$paymentresponse['mode']
        ];
        $result = json_encode($final_result);
        if ($paymentresponse['status'] == 'success') {
            $orderData = $request->session()->get('payuParams');
            $getOnlyDate = date('Y-m-d', strtotime(@$orderData['subscription_end_date']));
            $countrycode = getCountryCode();
            
            $updateOrderData = [
                'plan' => $orderData['plan_id'] ?? '',
                'user_id' => $orderData['user_id'] ?? '',
                'order_id' => $orderData['order_id'] ?? '',
                'order_status' => 'complete',
                'payment_gateway' => $orderData['payment_gateway'] ?? '',
                'bank_ref_no' => $paymentresponse['bank_ref_num'] ?? '',
                'ios_receipt' => '',
                'android_receipt' => '',
                'web_device' => $orderData['web'] ?? '',
                'coupon_applied' => $orderData['coupon_applied'] ?? '',
                'subscriptionId' => '',
                'subscriptionPaymentMode' => '',
                'note' => '',
                'recurring_receipt' => '',
                'bank_name' => '',
                'payment_mode' => $paymentresponse['mode'] ?? '',
                'x_country' => @$countrycode,
                'x_continent' => @$countrycode,
            ];

            $planValue = $orderData['epic_price'] ?? '';
           
            $parameters_verify_payment['key'] = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY');
            $parameters_verify_payment['command'] = 'verify_payment';
            $parameters_verify_payment['var1'] = $paymentresponse['txnid'];
            $HASH = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY') . '|' . $parameters_verify_payment['command'] . '|' . $parameters_verify_payment['var1'] . '|' . config('epicconfig.PAYUMONEY.PAYUMONEY_SALT');
            $calculated_hash = strtolower(hash("sha512", $HASH));
            $parameters_verify_payment['hash'] = $calculated_hash;
            $data = 'key=' . $parameters_verify_payment['key'] . '&command=' . $parameters_verify_payment['command'] . '&var1=' . $parameters_verify_payment['var1'] . '&hash=' . $parameters_verify_payment['hash'];
            $url = config('epicconfig.PAYUMONEY.API_URL');
            $verify_payment = si_transaction($url, $data);

            $this->payuLog('-----Verify Payment Status------', false, ['url' => $url, 'requestdata' => $data, 'response' => $verify_payment]);

            $verifyDetails = json_decode($verify_payment);
            if ($verifyDetails->status) {
               
                $this->payuLog('-----updateOrderData request------', false, [ 'url' => 'subscriptions/updateOrder', 'request' => $updateOrderData]);

                $updatePayment = CurlAPI("subscriptions/updateOrder", 'POST', $updateOrderData, 2, false, true);

                $this->payuLog('-----updateOrderData response------', false, [ 'url' => 'subscriptions/updateOrder', 'request' => $updateOrderData, 'response' => $updatePayment]);

                $final_result = ['message' => 'You have successfully purchased a subscription plan.',
                'txnid'=>@$paymentresponse['txnid'],
                'bank_ref_num'=>@$paymentresponse['bank_ref_num'],
                'mode'=>@$paymentresponse['mode'],
                'status'=>@$paymtentStatus,
            ];
            $result = json_encode($final_result);
                return view('subscription.android-json', compact('result'));
            } else {
                return view('subscription.android-json', compact('result'));
            }
        } else {
            return view('subscription.android-json', compact('result'));
        }   


    }
    public function success(){
        return view('subscription.pay-success');
    }
    public function failure(){
        return view('subscription.pay-failure');
    }

    private function payuLog($msg, $uid='', $data=[]){
        $prefix = ($uid != '') ? '--TxId-'.$uid.'-- ' : '';

        if($data){
            Log::channel('payu_android')->info($prefix.''.$msg. PHP_EOL . json_encode($data));
        }else{
            Log::channel('payu_android')->info($prefix.$msg );
        }
    }
}
