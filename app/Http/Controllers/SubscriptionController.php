<?php

namespace App\Http\Controllers;

use App\Services\PayuWebhookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Route;

class SubscriptionController extends Controller
{
    public function subscription(Request $request)
    {   
        $meta = getMeta('subscription');
        $sessionData = $request->session()->get('user_token');
        $userData = $request->session()->get('plandata');
        //$request->session()->forget('plandata');
        $subscriptionPurchases = $allPurchasedPlans = $activePlan = $futurePlan = $result = [];
        $offerCount = 0;
        $today = date("Y-m-d") . "T" . date("H:i:s") . "Z";
        $todayStrToTime = strtotime($today);
        $usedDays = 0;
        $countrycode = getCountryCode();
        // $request->session()->put('countrycode',$countrycode);
        // dd($countrycode);
        $subscriptionPurchases = CurlAPI("users/purchases", "POST", "", 2, true, true);
        $input = [
            'auth_token' => config('epicconfig.EPICAPI.API_AUTH_TOKEN'),
            'x_country' => @$countrycode,
            'x_continent' => @$countrycode,
        ];
        // $result = CurlAPI("subscriptions/plans", "GET", "", 2);
        $result = CurlAPI("subscriptions/plans", "GET", $input, 2);
        // dd($result);
        if (empty(@$subscriptionPurchases['success']) && @$subscriptionPurchases['message'] == 'No subscriptions found') {

            //$result = CurlAPI("subscriptions/plans", "GET", "", 2);
            if ($result && @$result['success'] == true) {
                $offerCount = count(@$result['plans'][0]['benifits']);

                $plandata = [];
                foreach (@$result['plans'] as $val) {

                    if(isset($val['id'])){
                        $plandata[$val['id']] = [
                            'id' => $val['id'],
                            'name' => @$val['name'],
                            'plan' => @$val['plan'],
                            'actual_price' => @$val['actual_price'],
                            'currency' => @$val['currency'],
                            'epic_price' => @$val['actual_price'],
                            'save' => '',

                        ];
                    }
                }
                if (!empty($plandata)) {
                    $request->session()->put('plandata', $plandata);
                }

                return view('subscription.subscription', compact('result', 'offerCount', 'meta'));
            }else{
                return view('pages.error.data-error');
            }
        } else {
            if (isset($subscriptionPurchases['data'])) {
                foreach ($subscriptionPurchases['data'] as $k => $item) {
                    if (!isset($item['plan_name'])) {
                        $item['plan_name'] = '';
                    }
                    $allPurchasedPlans[@$item['plan_id']] = $item;
                    // now based on plan status from API
                    $planstartdate = @$item['subscription_start_date'];
                    $planstartdate = date("Y-m-d", strtotime($planstartdate));
                    if (@$item['plan_status'] == "current") {
                        $remainingDays = getDays($today, @$item['subscription_end_date'], 'IST');
                        $activePlan = $item;
                        $activePlan['remainingDays'] = $remainingDays;
                    } else if (@$item['plan_status'] == 'future' && date("Y-m-d") == $planstartdate) {
                        $remainingDays = getDays($today, @$item['subscription_end_date'], 'IST');
                        $activePlan = $item;
                        $activePlan['remainingDays'] = $remainingDays;
                    }
                }
            }

            if (empty($activePlan)) {
                //$result = CurlAPI("subscriptions/plans", "GET", "", 2);
                if ($result && @$result['success'] == true) {

                    //$offerCount = count($result['plans'][0]['benifits']);
                    $plandata = [];
                    foreach (@$result['plans'] as $val) {

                        if(isset($val['id'])){
                            $plandata[$val['id']] = [
                                'id' => $val['id'],
                                'name' => @$val['name'],
                                'plan' => @$val['plan'],
                                'actual_price' => @$val['actual_price'],
                                'currency' => @$val['currency'],
                                'epic_price' => @$val['actual_price'],
                                'save' => '',
                            ];
                        }
                    }
                    if (!empty($plandata)) {
                        $request->session()->put('plandata', $plandata);
                    }

                }
                return view('subscription.subscription', compact('result', 'offerCount', 'meta'));

            } else {

                $numOfDays = checkNumDays($activePlan['subscription_end_date']);
                if ($numOfDays <= 3) {
                    return view('subscription.subscription', compact('result', 'offerCount', 'meta'));
                } else {
                    //return redirect()->route('my-account');
                    return redirect()->route('homepage');
                }
            }

        }
    }

    public function setSubscription(Request $request)
    {
        if($request->has('amountid')){
            
        if (!isUserLoggedIn()) {
            return redirect('/');
        }
        $data = $request->all();
        $result = [];
        $sessionPlanData = $request->session()->get('plandata');
        $userData = $request->session()->get('user');
        if (@$sessionPlanData[@$data['amountid']]) {
            $result = (@$sessionPlanData[@$data['amountid']]);
        }
        if(empty($result)){
            return view('pages.error.data-error');  
        }
        return view('subscription.payment-method', compact('result', 'data'));
        }else{
            return redirect('subscription');
        }
    }

    public function saveSubscription(Request $request)
    {
        $formData = $request->all();
        $payment_type = $formData['payment_type'] ?? '';
        $sessionPlanData = $request->session()->get('plandata');
        $userData = $request->session()->get('user');
        if($sessionPlanData[$formData['amountid']]) {
            $result = ($sessionPlanData[$formData['amountid']]);
        }
        $currency = $result['currency'] ?? '';
        $countrycode = getCountryCode();
        // dd($currency);
        $postData = [
            'user_id' => $userData['user_id'],
            'plan_id' => $result['id'],
            'order_value' => $result['actual_price'],
            'x_country' => @$countrycode,
        ];
        $this->payuLog('Create Order Api Request', false, ['endpoint' => 'subscriptions/createorder', 'data' => $postData]);

        $resultData = CurlAPI("subscriptions/createorder", 'POST', $postData, 2, false, true);

        $txid = generateTransactionID();
        if ($resultData['success'] == true && !empty(@$resultData['order_data'])) {
            $resorder = $resultData['order_data'];
            $orderPostData = [
                "plan_id" => $resorder['plan_id'],
                "user_id" => $resorder['user_id'],
                "payment_gateway" => "payumoney",
                "web_device" => $resorder['device'],
                "coupon_applied" => $formData['coupanstatus'] ?? '',
                "amount" => $resorder['order_value'],
                "epic_price" => $result['epic_price'],
            ];
            $request->session()->put('create_order', $orderPostData);
            $txid = $resorder['order_id'];
        }

        $this->payuLog( 'Create Order Api Response', $txid,[$resultData]);

        $parameters = $this->paymentProcess($resultData, $currency, $payment_type);

        $this->payuLog( 'Payu Money Request data', $txid,[$parameters]);

        if(@$parameters['status'] == false){
            return view('pages.error.data-error');
        }
        else{

            // $txid = generateTransactionID();
            $amount = $result['actual_price'];
            $productinfo = $result['id'];
            $firstname = $userData['name'];
            $email = $userData['email'];
            if (env('PAYU_SI') == true) {
                $HASH = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY') . "|" . $txid . "|" . $parameters['amount'] . "|" . $parameters['productinfo'] . "|" . $parameters['firstname'] . "|" . $parameters['email'] . "|||||||||||" . $parameters['si_details'] . "|" . config('epicconfig.PAYUMONEY.PAYUMONEY_SALT');
                $calculated_hash = strtolower(hash("sha512", $HASH));
                $parameters = [
                    "hash" => $calculated_hash,
                    "email" => @$parameters['email'],
                    "txnid" => $txid,
                    "key" => @$parameters['key'],
                    "firstname" => @$parameters['firstname'],
                    "amount" => @$parameters['amount'],
                    "phone" => @$parameters['phone'],
                    "productinfo" => @$parameters['productinfo'],
                    "surl" => @$parameters['surl'],
                    "furl" => @$parameters['furl'],
                    "payuUrl" => @$parameters['payuUrl'],
                    "si_details" => @$parameters['si_details'],
                ];
            }
            else{
                $HASH = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY') . "|" . $txid . "|" . $parameters['amount'] . "|" . $parameters['productinfo'] . "|" . $parameters['firstname'] . "|" . $parameters['email'] . "||||||||||||" . config('epicconfig.PAYUMONEY.PAYUMONEY_SALT');
                $calculated_hash = strtolower(hash("sha512", $HASH));
                $parameters = [
                    "hash" => $calculated_hash,
                    "email" => @$parameters['email'],
                    "txnid" => $txid,
                    "key" => @$parameters['key'],
                    "firstname" => @$parameters['firstname'],
                    "amount" => @$parameters['amount'],
                    "phone" => @$parameters['phone'],
                    "productinfo" => @$parameters['productinfo'],
                    "surl" => @$parameters['surl'],
                    "furl" => @$parameters['furl'],
                    "payuUrl" => @$parameters['payuUrl']
                ];
            }
            if (env('PAYU_SI') == true) {
                return view('subscription.payumoneysi', compact('parameters'));
            }
            else{
                return view('subscription.payumoney', compact('parameters'));
            }
        }
    }

    /*public function generateHash($params, $salt) {
        $hashString = $params["key"] . "|" . $params["txnid"] . "|" . $params["amount"] . "|" . $params["productinfo"] . "|" . $params["firstname"] . "|" . $params["email"] . "||||||" . $salt;
        $hash = hash("sha512", $hashString);
        return $hash;
    }

    public function generateHashWithSI($params, $salt) {
        $hashString = $params["key"] . "|" . $params["txnid"] . "|" . $params["amount"] . "|" . $params["productinfo"] . "|" . $params["firstname"] . "|" . $params["email"] . "||||||" . $params["si_details"].'|'.$salt;
        $hash = hash("sha512", $hashString);
        return $hash;
    }*/

    public function paymentProcess($orderArr, $currency, $payment_type)
    {   
        
        /* All Required Parameters by your Gateway */
        $request = Request();
        $userData = $request->session()->get('user');
        $userid = $userData['user_id'] ?? '';
        
        $order = $orderArr['order_data'];

        $this->payuLog( 'Inside paymentProcess function', $order['order_id']);

        $order_number = $order['order_id'];
        $totalamount = $order['order_value'];
        $plan_id = $order['plan_id'];
        $timestamp = $order['created_date'];
        @$validity = $order['validity'];
        $splitTimeStamp = explode("T", $timestamp);
        $newDate = $splitTimeStamp[0];
        $startdate = date("d-m-Y", strtotime($newDate));
        $finalcurrency = $currency;
        
        // test amount logic
        $parameters['status'] = "";
        if (env('DEV_AMT') == true && ($userid == '123test123@mailinator.com' || $userid == '11test1@mailinator.com' || $userid == 'epicontest31@gmail.com' || $userid == '8169554956' || $userid == '9819208025' || $userid == 'newrahul@mailinator.com' || $userid == 'newprathamesh@mailinator.com' || $userid == '917977495428' || $userid == '918169554956' || $userid == 'nilesh@mailinator.com' || strpos($userid, "-test@mailinator.com") !== false)
        ) {
            $totalamount = "1";
        }
        $parameters = ['tid' => time(), 'txnid' => $order_number, 'amount' => $totalamount, 'firstname' => @$userData['name'], 'email' => @$userData['email'], 'phone' => @$userData['mobile'], 'productinfo' => 'epicon ' . $plan_id];
        if (strtoupper(env('APP_ENV')) == 'PRODUCTION') {
            if ($request->post('device') == 'android' || $request->post('device') == 'ios') {
                if ($finalcurrency == 'USD') {
                    $rate = getConvertedPrice($finalcurrency, 'INR');
                    $totalamount = (!empty($totalamount) && $rate !== false) ? floor($rate) * $totalamount : env('INR_TO_USD_RATE', 83) * $totalamount;
                    $parameters['amount'] = round(floor($totalamount), 2);
                }
            } else {
                if ($finalcurrency == 'INR') {
                    if (env('PAYU_SI') == true) {
                        $parameters['si'] = 1;
                    }
                } else {
                    //$parameters = ['tid' => time(), 'txnid' => $order_number, 'amount' => $totalamount, 'firstname' => $userData['name'], 'email' => $userData['email'], 'phone' => @$userData['mobile'], 'productinfo' => 'epicon ' . $plan_id];
                    if ($finalcurrency == 'USD') {
                        $rate = getConvertedPrice($finalcurrency, 'INR');
                        // dd($rate);
                        $totalamount = (!empty($totalamount) && $rate !== false) ? floor($rate) * $totalamount : env('INR_TO_USD_RATE', 83) * $totalamount;
                        $parameters['amount'] = round(floor($totalamount), 2);
                    }
                }
            }
        } else {
            // if not production - run below code
            if ($request->post('device') == 'android' || $request->post('device') == 'ios') {
                if ($finalcurrency == 'USD') {
                    $rate = getConvertedPrice($finalcurrency, 'INR');
                    $totalamount = (!empty($totalamount) && $rate !== false) ? floor($rate) * $totalamount : env('INR_TO_USD_RATE', 83) * $totalamount;
                    $parameters['amount'] = round(floor($totalamount), 2);
                }
       
            } else {
                if ($finalcurrency == 'INR') {
                    if (env('PAYU_SI') == true) {
                        $parameters['si'] = 1;
                    }
                } else {
                    //$parameters = ['tid' => time(), 'txnid' => $order_number, 'amount' => $totalamount, 'firstname' => $userData['name'], 'email' => $userid, 'phone' => $userData['mobile'], 'productinfo' => 'epicon ' . $plan_id];
                    if ($finalcurrency == 'USD') {
                        $rate = getConvertedPrice($finalcurrency, 'INR');
                        $totalamount = (!empty($totalamount) && $rate !== false) ? floor($rate) * $totalamount : env('INR_TO_USD_RATE', 83) * $totalamount;
                        $parameters['amount'] = round(floor($totalamount), 2);
                    }
                }
            }
        }

        $parameters['key'] = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY');
        $parameters['phone'] = $userData['mobile'];
        if (env('PAYU_SI') == true) {
            $billingCycle = 'MONTHLY';
            if ($plan_id == 'epic_in_pl_1') {
                $billingInterval = 1;
                $newstartdate = date("Y-m-d");
                // $billingCycle = 'MONTHLY';
                // $endstartdate = date("Y-m-d", strtotime("+1 month -1 day"));

                $billingCycle = 'DAILY';
                $endstartdate = date("Y-m-d", strtotime("+1 day"));

            } else if ($plan_id == 'epic_in_pl_2') {
                $billingInterval = 3;
                $billingCycle = 'MONTHLY';
                $newstartdate = date("Y-m-d");
                $endstartdate = date("Y-m-d", strtotime("+3 month -1 day"));
            } else if ($plan_id == 'epic_in_pl_3') {
                $billingInterval = 6;
                $billingCycle = 'MONTHLY';
                $newstartdate = date("Y-m-d");
                $endstartdate = date("Y-m-d", strtotime("+6 month -1 day"));
            } else {
                $billingInterval = 1;
                $billingCycle = 'YEARLY';
                $newstartdate = date("Y-m-d");
                $endstartdate = date("Y-m-d", strtotime("+1 year"));
            }
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
        $parameters['curl'] = getUrl('payusuccess');
        $parameters['surl'] = getUrl('payusuccess');
        $parameters['furl'] = getUrl('payufail');
        $parameters['payuUrl'] = config('epicconfig.PAYUMONEY.SUBSCRIPTION_URL');
        $parameters['phone'] = $parameters['phone'];
        $parameters['email'] = $parameters['email'];
        $parameters['status'] = true; 


        $request->session()->forget('orderdata');
        $request->session()->put('orderdata', $order);

        $request->session()->forget('payuParams');
        $request->session()->put('payuParams', $parameters);

        //$orderData = $request->session()->get('orderdata');
        //dd($parameters);
        return $parameters;
    }

    public function planBenefit(Request $request)
    {
        $data = $request->all();
        $message = "data not found";
        $countrycode = getCountryCode();
        $input = [
            'auth_token' => config('epicconfig.EPICAPI.API_AUTH_TOKEN'),
            'x_country' => @$countrycode,
            'x_continent' => @$countrycode,
        ];
        $result = CurlAPI("subscriptions/plans", "GET", $input, 2);
        if ($result && @$result['success'] == true) {

            if ($result['success']) {

                $plandata = [];
                foreach ($result['plans'] as $key => $val) {
                    if (($val['id'] == $data['planid'])) {
                        $plandata[] = $val;
                        break;
                    }

                }
                $html = "";
                foreach ($plandata as $key => $val) {
                    $pname = $val['name'];
                    $i = 0;
                    foreach ($val['benifits'] as $bn => $bnval) {
                        $html .= '<li>
                    <a href="#">
                        <span class="off-image">
                        <img src="' . $bnval['vendor_image'] . '" alt=""></span>
                        <div class="ac-content">
                            <div class="left">
                                <div class="circle-logo">

                                </div>
                                <span>Exc. Offer</span>
                            </div>
                            <div class="right">
                                <h5>25% OFF</h5>
                                <p id="vname">' . $bnval['vendor_name'] . '</p>
                                <span>Valid until 03 March 2022</span>
                            </div>
                        </div>
                    </a>
                </li>';
                        $i++;
                    }

                }
                $res['html'] = '<ul class="additional-carousel mb-0 mt-3 p-0">' . $html . '</ul>';
                $res['count'] = $i;
                $res['pname'] = ucfirst(strtolower($pname));
                return response()->json($res, 200)->header('Content-Type', 'application/json');
            } else {
                return response()->json($message, 201)->header('Content-Type', 'application/json');
            }

        } else {
            return response()->json($message, 201)->header('Content-Type', 'application/json');
        }

    }

    public function getCoupon(Request $request)
    {
        $sessionData = $request->session()->get('user');
        $postData = $request->all();
        $userid = $sessionData['user_id'] ?? '';
        $promocode = $postData['promocode'] ?? '';
        $countrycode = getCountryCode();
        $postdata = array(
            'user_id' => $userid,
            'coupon_code' => $promocode,
            'x_country' => @$countrycode,
        );

        $listResponseData = CurlAPI("subscriptions/createCouponOrder", 'POST', $postdata, 2, false, true);
        // dd($listResponseData);
        if ($listResponseData && @$listResponseData['success'] == true) {
            $sessionData = $request->session()->get('plandata');
            foreach ($listResponseData['plans'] as $key => $val) {
                if (isset($sessionData[$val['id']])) {
                    $sessionData[$val['id']] = [
                        'id' => $val['id'],
                        'name' => $val['name'],
                        'plan' => isset($sessionData[$val['id']]['plan']) ? $sessionData[$val['id']]['plan'] : '',
                        'actual_price' => $val['discounted_price'], // this is use for final transaction
                        'currency' => $val['currency'],
                        'epic_price' => $val['actual_price'], // this is actual price without discount
                        'save' => '', // this is disount percetage like 20%

                    ];
                }
            }
            if (!empty($sessionData)) {
                 $storeSessionData = $request->session()->put('plandata', $sessionData);
            }
            $listResponseData['planSessionData'] = $storeSessionData;
            return response()->json($listResponseData, 200)->header('Content-Type', 'application/json');
        } else {
            return response()->json('Coupan not found.', 201)->header('Content-Type', 'application/json');
        }

    }
    public function thankyou(Request $request){
        return view('subscription.thankyou');
    }
    public function payusuccess(Request $request)
    {
        $paymentresponse = $request->all();

        $this->payuLog( 'Inside Payu success function', @$paymentresponse['txnid'], [$paymentresponse]);

        $paymtentStatus = strtolower($paymentresponse['status']);
        $final_result = ['message' => 'The transaction has been declined.'];
        //$getOnlyDate = date('Y-m-d', strtotime(@$orderdata['subscription_end_date']));
        if (@$paymentresponse['status'] == 'success') {
            $orderData = $request->session()->get('orderdata');
            $orderValue = $request->session()->get('create_order');
            $getOnlyDate = date('Y-m-d', strtotime(@$orderData['subscription_end_date']));
            $countrycode = getCountryCode();

            $updateOrderData = [
                'plan' => $orderValue['plan_id'] ?? '',
                'user_id' => $orderValue['user_id'] ?? '',
                'order_id' => $orderData['order_id'] ?? '',
                'order_status' => 'complete',
                'payment_gateway' => $orderValue['payment_gateway'] ?? '',
                'bank_ref_no' => $paymentresponse['bank_ref_num'] ?? '',
                'transaction_id' => $paymentresponse['mihpayid'] ?? '',
                'ios_receipt' => '',
                'android_receipt' => '',
                'web_device' => $orderValue['web'] ?? '',
                'coupon_applied' => $orderValue['coupon_applied'] ?? '',
                'subscriptionId' => '',
                'subscriptionPaymentMode' => '',
                'note' => '',
                'recurring_receipt' => '',
                'bank_name' => '',
                'payment_mode' => $paymentresponse['mode'] ?? '',
                'x_country' => @$countrycode,
                'x_continent' => @$countrycode,

            ];

            $planValue = $orderValue['epic_price'] ?? '';
            ///////////---*** Verify Payment Start ***---///////////

            $parameters_verify_payment['key'] = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY');
            $parameters_verify_payment['command'] = 'verify_payment';
            $parameters_verify_payment['var1'] = $paymentresponse['txnid'];
            $HASH = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY') . '|' . $parameters_verify_payment['command'] . '|' . $parameters_verify_payment['var1'] . '|' . config('epicconfig.PAYUMONEY.PAYUMONEY_SALT');
            $calculated_hash = strtolower(hash("sha512", $HASH));
            $parameters_verify_payment['hash'] = $calculated_hash;
            $data = 'key=' . $parameters_verify_payment['key'] . '&command=' . $parameters_verify_payment['command'] . '&var1=' . $parameters_verify_payment['var1'] . '&hash=' . $parameters_verify_payment['hash'];
            $url = config('epicconfig.PAYUMONEY.API_URL');

            $this->payuLog( 'Verify Payment Status - Request', @$paymentresponse['txnid'], ['url' => $url, 'data' => $data]);

            $verify_payment = si_transaction($url, $data);

            $this->payuLog( 'Verify Payment Status - Response', @$paymentresponse['txnid'], [$verify_payment]);

            ///////////---*** Verify Payment End ***---///////////

            $verifyDetails = json_decode($verify_payment);
            $data= json_decode( json_encode($verify_payment), true);

            if ($verifyDetails->status) {
                $this->payuLog( 'Verify Payment Status - success', @$paymentresponse['txnid']);
                
                ///------***Update create order with payment details***--------///
                $this->payuLog( 'UpdateOrder Api Request', @$paymentresponse['txnid'], ['url' => 'subscriptions/updateOrder', 'data' => $updateOrderData]);

                $updatePayment = CurlAPI("subscriptions/updateOrder", 'POST', $updateOrderData, 2, false, true);

                $this->payuLog( 'UpdateOrder Api Response', @$paymentresponse['txnid'], [$updatePayment]);
                ///------***End payment details***--------///

                $this->EventPushData($paymtentStatus);

                $final_result = ['message' => 'You have successfully purchased a subscription plan.'];
                return view('subscription.thankyou', compact('final_result','orderData'));
            } else {
                ///---*** if payment not verify ***---///
                $this->payuLog( 'Verify Payment Status - Failed', @$paymentresponse['txnid']);

                return view('subscription.subscription-fail', compact('final_result'));
            }
        } else {
            return view('subscription.subscription-fail', compact('final_result'));
        }

    }

    public function EventPushData($paymtentStatus)
    {
        $request = Request();
        $orderdata = $request->session()->get('orderdata');
        $userData = $request->session()->get('user');
        $orderdata['plan_name'] = "1 Month";
        $user_id = $userData['user_id'] ?? '';
        $pName = 'Monthly';
        if (isset($orderdata['plan_name'])) {
            if ($orderdata['plan_name'] == "1 Year") {
                $pName = "Yearly";
            }
            if ($orderdata['plan_name'] == "6 Months") {
                $pName = "Half Yearly";
            }
            if ($orderdata['plan_name'] == "3 Months") {
                $pName = "Quarterly";
            }
            if ($orderdata['plan_name'] == "1 Month") {
                $pName = "Monthly";
            }
        } else {
            $orderdata['plan_name'] = '';
        }
        if ($paymtentStatus == "success") {

            $message = 'You have successfully purchased a subscription plan.';
            $eventCat = 'Subscription Success';
            $authEventTrack = $pName;

            $commonMenuUserData['Mobile'] = (isset($userData['mobile']) && !empty($userData['mobile'])) ? $userData['mobile'] : '';
            EventPush($user_id, 'Subscribe', $commonMenuUserData, true, false);

        }
        ///---*** Store for GA tracking ***---///
        $request->session()->put('authEventTrack', $authEventTrack);
        $request->session()->put('eventCat', $eventCat);

    }

    public function payufail(Request $request)
    {
        $paymtentStatus = $request->all();

        $this->payuLog( 'PAYMENT FAILED RESPONSE', @$paymtentStatus['txnid'],[$paymtentStatus]);

        $orderdata = $request->session()->get('orderdata');
        $this->payuLog( 'Payment Failed - Order data from session', @$paymtentStatus['txnid'],[$orderdata]);

        
        $message = "";
        $orderdata['plan_name'] = "1 Month";
        $pName = 'Monthly';
        if (isset($orderdata['plan_name'])) {
            if ($orderdata['plan_name'] == "1 Year") {
                $pName = "Yearly";
            }
            if ($orderdata['plan_name'] == "6 Months") {
                $pName = "Half Yearly";
            }
            if ($orderdata['plan_name'] == "3 Months") {
                $pName = "Quarterly";
            }
            if ($orderdata['plan_name'] == "1 Month") {
                $pName = "Monthly";
            }
        } else {
            $orderdata['plan_name'] = '';
        }

        if ($paymtentStatus['status'] == "aborted") {
            $message = $paymtentStatus['error_Message'];
            $eventCat = 'Subscription Failure';
            $authEventTrack = $pName;
        } else if ($paymtentStatus['status'] === "failure") {
            $message = $paymtentStatus['error_Message'];
            $eventCat = 'Subscription Failure';
            $authEventTrack = $pName;
        } else {
            $message = $paymtentStatus['error_Message'];
            $eventCat = 'Subscription Failure';
            $authEventTrack = $pName;
        }

        ///---*** Store for GA tracking ***---///
        $request->session()->put('authEventTrack', $authEventTrack);
        $request->session()->put('eventCat', $eventCat);

        return view('subscription.subscription-fail', compact('message'));
    }

    public function sendOtpAjax(Request $request)
    {
        $ajaxData = $request->all();
        $email = $mobile = $stdcode = "";
        $type = $ajaxData['type'] ?? '';
        if($type == "email"){
            $email = $ajaxData['userdetail'] ?? '';
        }else{
            $mobile = $ajaxData['userdetail'] ?? '';
            $stdcode = $ajaxData['stdcode'] ?? '';
        }
        $otpResponse = [];
        $postData = [
            'mobile' => $stdcode.$mobile,
            'email' => $email,
        ];
        //dd($postData);
        $otpResponse = CurlAPI("users/contactDetailsOTP", "POST", $postData, 2, true, true);
        if ($otpResponse && @$otpResponse['success'] == true) {
            return response()->json($otpResponse, 200)->header('Content-Type', 'application/json');
        } else {
            return response()->json('something went wrong !', 201)->header('Content-Type', 'application/json');
        }
    }

    public function verifyOtpAjax(Request $request)
    {
        $ajaxData = $request->all();
        $email = $mobile = $stdcode = "";
        $countrycode = getCountryCode();
        if($countrycode == 'IN'){
            $currency = ' Rs. ';
        }else{
            $currency = ' $ ';
        }
        $otp = $ajaxData['vpin'] ? implode("",$ajaxData['vpin']) : '';
        $type = $ajaxData['type'] ?? '';
        if($type == "email"){
            $email = $ajaxData['userdetail'] ?? '';
        }else{
          $mobile =  $ajaxData['userdetail'] ?? '';
          $stdcode = $ajaxData['stdcode'] ?? '';
        }
        $verifyResponse = [];
        $postData = [
            'mobile' => $stdcode.$mobile,
            'email' => $email,
            'otp' => $otp
        ];
        $verifyResponse = CurlAPI("users/contactDetailsOTPVerify", "POST", $postData, 2, true, true);
        //dd($verifyResponse);
        $verifyResponse['html'] = '<button class="fill-btn px-5" type="submit">' . __('Continue Pay') . $currency . $ajaxData['price'] . '
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.75 12C4.75 11.5858 5.08579 11.25 5.5 11.25H19.5C19.9142 11.25 20.25 11.5858 20.25 12C20.25 12.4142 19.9142 12.75 19.5 12.75H5.5C5.08579 12.75 4.75 12.4142 4.75 12Z" fill="#070707"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9697 4.46967C12.2626 4.17678 12.7374 4.17678 13.0303 4.46967L20.0303 11.4697C20.3232 11.7626 20.3232 12.2374 20.0303 12.5303L13.0303 19.5303C12.7374 19.8232 12.2626 19.8232 11.9697 19.5303C11.6768 19.2374 11.6768 18.7626 11.9697 18.4697L18.4393 12L11.9697 5.53033C11.6768 5.23744 11.6768 4.76256 11.9697 4.46967Z" fill="#070707"/>
          </svg>
    </button>';
        
        if ($verifyResponse && @$verifyResponse['success'] == true) {
            update_user_session();
            return response()->json($verifyResponse, 200)->header('Content-Type', 'application/json');
        } else {
            return response()->json($verifyResponse, 201)->header('Content-Type', 'application/json');
        }

        //update session

    }




    public function cancelRecurringPayu()
    {
        $parameters_verify_payment = [];
        $parameters_verify_payment['key'] = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY');
        $parameters_verify_payment['command'] = 'mandate_revoke';
        $parameters_verify_payment['var1'] = json_encode([
            'authPayuId' => '403993715530242574',
            'requestId' => 'b3f5ea242a7a8026281909ca75eebe7d',
        ]);
        //dd($parameters_verify_payment['var1']);
        $HASH = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY') . '|' . $parameters_verify_payment['command'] . '|' . $parameters_verify_payment['var1'] . '|' . config('epicconfig.PAYUMONEY.PAYUMONEY_SALT');
        $calculated_hash = strtolower(hash("sha512", $HASH));
        $parameters_verify_payment['hash'] = $calculated_hash;
        $data = 'key=' . $parameters_verify_payment['key'] . '&command=' . $parameters_verify_payment['command'] . '&var1=' . $parameters_verify_payment['var1'] . '&hash=' . $parameters_verify_payment['hash'];

        //dd($data);
        $url = "https://test.payu.in/merchant/postservice.php?form=2";
        $verify_payment = si_transaction($url, $data);
        //dd($verify_payment);
    }

    public function cancelMembership(Request $request){
        $ajaxData = $request->all();
        $Response = false;
        $error['message'] = "something went wrong !"; 
        $Response = CurlAPI("subscriptions/cancelSubscription", "POST", '', 2, true, true);
        if ($Response['success'] == true && !empty(@$Response['message'])) {
            return response()->json($Response, 200)->header('Content-Type', 'application/json');
        } else {
            return response()->json($error, 201)->header('Content-Type', 'application/json');
        }
    }


    public function payuWebhook(Request $request){
        Log::channel('payu')->info("payu webhook : ". json_encode($request->all()));

        $payuResponse = $request->all();
        $payuWebhookService = new PayuWebhookService();
        $payuWebhookService->processWebhookCallback($payuResponse);

        return response()->json('success', 200);
    }

    private function payuLog($msg, $uid='', $data=[]){
        $prefix = ($uid != '') ? '--TxId-'.$uid.'-- ' : '';

        if($data){
            Log::channel('payu')->info($prefix.''.$msg. PHP_EOL . json_encode($data));
        }else{
            Log::channel('payu')->info($prefix.$msg );
        }
    }

}
