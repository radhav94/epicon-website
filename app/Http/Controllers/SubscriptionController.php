<?php

namespace App\Http\Controllers;

use App\Traits\payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Route;

class SubscriptionController extends Controller
{
    use payments;
    public function subscription(Request $request)
    {
        //$sessionData = $request->session()->get('user_token');
        $userData = $request->session()->get('user');
        //d($userData);exit;
        $subscriptionPurchases = $allPurchasedPlans = $activePlan = $futurePlan = $result = [];
        $offerCount = 0;
        $today = date("Y-m-d") . "T" . date("H:i:s") . "Z";
        $todayStrToTime = strtotime($today);
        $usedDays = 0;
        $subscriptionPurchases = CurlAPI("users/purchases", "POST", "", 2);
        //d($subscriptionPurchases);exit();

        if (empty(@$subscriptionPurchases['success']) && @$subscriptionPurchases['message'] == 'No subscriptions found') {

            $result = CurlAPI("subscriptions/plans", "GET", "", 2);
            if ($result && @$result['success'] == true) {

                $offerCount = count($result['plans'][0]['benifits']);
                $plandata = [];
                foreach ($result['plans'] as $val) {
                    $plandata[$val['id']] = [
                        'id' => $val['id'],
                        'name' => $val['name'],
                        'plan' => $val['plan'],
                        'actual_price' => $val['actual_price'],
                        'old_price' => '',
                        'save' => '',

                    ];

                }
                if (!empty($plandata)) {
                    $request->session()->put('plandata', $plandata);
                }

                return view('subscription.subscription', compact('result', 'offerCount'));
            }
        } else {
            foreach ($subscriptionPurchases['data'] as $k => $item) {
                if (!isset($item['plan_name'])) {
                    $item['plan_name'] = '';
                }
                $allPurchasedPlans[@$item['plan_id']] = $item;
                // now based on plan status from API
                $planstartdate = @$item['subscription_start_date'];
                $planstartdate = date("Y-m-d", strtotime($planstartdate));
                if ($item['plan_status'] == "current") {
                    $remainingDays = getDays($today, @$item['subscription_end_date'], 'IST');
                    $activePlan = $item;
                    $activePlan['remainingDays'] = $remainingDays;
                } else if ($item['plan_status'] == 'future' && date("Y-m-d") == $planstartdate) {
                    $remainingDays = getDays($today, @$item['subscription_end_date'], 'IST');
                    $activePlan = $item;
                    $activePlan['remainingDays'] = $remainingDays;
                }
            }
            if (!empty($activePlan)) {
                $result = CurlAPI("subscriptions/plans", "GET", "", 2);
                if ($result && @$result['success'] == true) {

                    $offerCount = count($result['plans'][0]['benifits']);
                    $plandata = [];
                    foreach ($result['plans'] as $val) {
                        $plandata[$val['id']] = [
                            'id' => $val['id'],
                            'name' => $val['name'],
                            'plan' => $val['plan'],
                            'actual_price' => $val['actual_price'],
                            'old_price' => '',
                            'save' => '',

                        ];

                    }
                    if (!empty($plandata)) {
                        $request->session()->put('plandata', $plandata);
                    }

                }
                return view('subscription.subscription', compact('result', 'offerCount'));

            } else {

                return redirect()->route('my-account');
            }

        }
    }

    public function setSubscription(Request $request)
    {	
        
		if (!isUserLoggedIn()) {
            return redirect('/');
        }

        $data = $request->all();
        $sessionPlanData = $request->session()->get('plandata');
        $userData = $request->session()->get('user');
        if ($sessionPlanData[$data['amountid']]) {
            $result = ($sessionPlanData[$data['amountid']]);
        }

        $postData = [
            'user_id' => $userData['user_id'],
            'plan_id' => $result['id'],
            'order_value' => $result['actual_price'],

        ];
        $resultData = CurlAPI("subscriptions/createorder", 'POST', $postData, 2);
        if ($resultData['success'] == true && !empty(@$resultData['order_data'])) {
            $resorder = $resultData['order_data'];
            $orderPostData = [
                "plan_id" => $resorder['plan_id'],
                "user_id" => $resorder['user_id'],
                "payment_gateway" => "payu",
                "web_device" => $resorder['device'],
                "coupon_applied" => "N",
                "amount" => $resorder['order_value'],
            ];

            $updateData = CurlAPI("subscriptions/createupdateorder", 'POST', $postData, 2);
            //d($updateData);exit();

        }
        //dd($result);
        $txid = generateTransactionID();
        $amount = $result['actual_price'];
        $productinfo = $result['id'];
        $firstname = $userData['name'];
        if ((isset($userData['email'])) && !empty($userData['email'])) {
            $email = $userData['email'];

        } else {
            $email = "ramv339@gmail.com";
        }
        //echo $amount;exit;
        $HASH = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY') . "|" . $txid . "|" . $amount . "|" . $productinfo . "|" . $firstname . "|" . $email . "|||||||||||" . config('epicconfig.PAYUMONEY.PAYUMONEY_SALT');
        $calculated_hash = strtolower(hash("sha512", $HASH));
        $has = $calculated_hash;
        $payudata = [
            "has" => $has,
            "email" => $email,
            "txid" => $txid,
            "key" => config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY'),
            "firstname" => $firstname,
        ];

        return view('subscription.payment-method', compact('result', 'payudata'));

    }

    public function planBenefit(Request $request)
    {
        $data = $request->all();
        $result = CurlAPI("subscriptions/plans", "GET", "", 2);
        if ($result && @$result['success'] == true) {

            if ($result['success']) {

                $plandata = [];
                foreach ($result['plans'] as $key => $val) {
                    if (($val['id'] == $data['planid'])) {
                        $plandata[] = $val;
                        break;
                    }

                }
                //d($plandata);exit();
                $html = "";
                foreach ($plandata as $key => $val) {
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

                return response()->json($res, 201)->header('Content-Type', 'application/json');
            } else {
                return response()->json($message, 201)->header('Content-Type', 'application/json');
            }

        } else {
            return response()->json($message, 201)->header('Content-Type', 'application/json');
        }
        $message = "data not found";

    }

	public function getCoupon(Request $request)
    {
        $sessionData = $request->session()->get('user');
        $postData = $request->all();
        $userid = $sessionData['user_id'] ?? '';
        $promocode = $postData['promocode'] ?? '';
        $postdata = array(
            'user_id' => $userid,
            'coupon_code' => $promocode,
        );

        $listResponseData = CurlAPI("subscriptions/createCouponOrder", 'POST', $postdata, 2);
        if ($listResponseData && @$listResponseData['success'] == true) {
            $sessionData = $request->session()->get('plandata');
            foreach ($listResponseData['plans'] as $key => $val) {
                if (isset($sessionData[$val['id']])) {
                    $sessionData[$val['id']] = [
                        'id' => $val['id'],
                        'name' => $val['name'],
                        'plan' => isset($sessionData[$val['id']]['plan']) ? $sessionData[$val['id']]['plan'] : '',
                        'actual_price' => $val['discounted_price'], // this is use for final transaction
                        'old_price' => $val['actual_price'], // this is actual price without discount
                        'save' => '', // this is disount percetage like 20%

                    ];
                }
            }
            if (!empty($sessionData)) {
                $request->session()->put('plandata', $sessionData);
            }
            return response()->json($listResponseData, 200)->header('Content-Type', 'application/json');
        } else {
            return response()->json('Coupan not found.', 400)->header('Content-Type', 'application/json');
        }

    }

    public function checkpayu()
    {

        return view('subscription.payu');

    }
    public function payusuccess(Request $request)
    {
       // dd($request->all());
		 $payuResponse = $request->all();
		 if($payuResponse['status'] =='success'){

			return redirect('/my-account');

		 }

    }

    public function payufail(Request $request)
    {
        //dd($request->all());
        $payuResponse = $request->all();
        $result=[];
        if($payuResponse['status'] =='failure'){
             $result=[
                'message'=>$payuResponse['error_Message']??'',
             ];

			return view('subscription.subscription-fail', compact('result'));

		 }
		//return redirect('/subscription');

    }
}
