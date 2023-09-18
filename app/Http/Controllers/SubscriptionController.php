<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Route;
use Illuminate\Support\Facades\Log;
use App\Traits\payments;

class SubscriptionController extends Controller
{
    use payments;
    public function subscription(Request $request){
        //$sessionData = $request->session()->get('user_token');
        //d($sessionData);
        $result = CurlAPI("subscriptions/plans", "GET","", 2);
		if ($result && @$result['success'] ==  true) {

			$offerCount = count($result['plans'][0]['benifits']);
       		$plandata = [];
        	if($result['success']){
			
            foreach($result['plans'] as $val){
                $plandata[$val['id']]=[
                    'id'=> $val['id'],
                    'name'=> $val['name'],
                    'plan'=> $val['plan'],
                    'actual_price'=>$val['actual_price'],
                    'old_price'=>'',
                    'save'=>'',

                ];
				
				
            }
            if(!empty($plandata)){
                $request->session()->put('plandata', $plandata);
            }

        }else{
            echo "data not found";
        }
        
        return view('subscription.subscription', compact('result','offerCount'));

		}else{
			return false;
		}
	   

    }

    public function setSubscription(Request $request){	
		if (!isUserLoggedIn()) {
			return redirect('/');
		}

        $data = $request->all();
        $sessionData = $request->session()->get('plandata');
        $userData = $request->session()->get('user');

       
        $postData =[
            'user_id'=>$sessionData['epic_in_pl_1']['id'], 
            'plan_id'=>$userData['user_id'],
            'order_value'=>1, 

        ]; 
        //$resultData = CurlAPI("subscriptions/createorder", 'POST', $postData , 2);
        //dd($resultData);
		$Url = config('epicconfig.EPICAPI.API_DOMAIN_2');
		$token =  config('epicconfig.EPICAPI.API_AUTH_TOKEN');

		$curl = curl_init();
		curl_setopt_array($curl, array(
		//CURLOPT_URL => 'http://userapi-njsapi.epicon.in/subscriptions/createorder?auth_token=szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH',
		CURLOPT_URL => $Url.'?auth_token='.$token,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS =>'{
			"user_id":"'.$userData['user_id'].'",
				"plan_id":"epic_in_pl_1",
				"order_value":1
		}',
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json'
		),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$res = json_decode($response);
			if($sessionData[$data['amountid']]){
				$result = ($sessionData[$data['amountid']]);
			}
			return view('subscription.payment-method',compact('result'));
		
    }
    public function saveSubscription(Request $request){
        $request = Request();
		// d($request->all());exit;
        $sessionData = $request->session()->get('plandata');
        $userData = $request->session()->get('user');
        // d($sessionData);
		$routenamed = Route::currentRouteName();
		if (empty($routenamed)) {
			$routenamed = "savesubscriptions";
		}
		//pr($request->all());exit;
		Log::info("-----Supercoinpay fk pwa request------");
		Log::debug(json_encode($request->post()));
		//set for android renew plan flow
		if ($request->post('device') == 'android')
			$request->session()->put('android_renew', $request->post('device'));
		//pr($request->post());die;
		if (($request->post('purchase_subscription') == 'ContinueToPay' || $request->post('purchase_subscription') == 'ContinueToPaytm' || $request->post('purchase_subscription') == 'ContinueToPayuMoney' || $request->post('purchase_subscription') == 'amazonpay' || $request->post('purchase_subscription') == 'CC' || $request->post('purchase_subscription') == 'DC' || $request->post('purchase_subscription') == 'UPI' || $request->post('purchase_subscription') == 'NB'  || $request->post('purchase_subscription') == 'CASH'  || $request->post('purchase_subscription') == 'twid' || $request->post('purchase_subscription') == 'twid_fk' || $request->post('purchase_subscription') == 'twid_app' || $request->post('purchase_subscription') == 'twid_fk_app')
			&&
			(!empty($request->post('subscription_currency')) && !empty($request->post('subscription_amount')) && !empty($request->post('subscription_plan_id')))
		) {
			$payment_type = $request->payment_type;
			$currency = $request->post('subscription_currency');

			// check if subscription already exists to avoid multiple transactions - A@
			$user = $request->session()->get('user');
			$user_id = $user['user_id'];
			$session_id = $request->session()->get('user_token');

            $postData =[
                'user_id'=>$user_id, 
                'plan_id'=> $request->post('subscription_plan_id'),
                'order_value'=> $request->post('subscription_amount'),
    
            ]; 
            $subscriptionPurchases = CurlAPI("subscriptions/createorder", 'POST', $postData , 2);



			//$subscriptionPurchases = CurlAPI("subscriptions/createorder", 'POST', ['user_id' => $user_id, 'plan_id' => $request->post('subscription_plan_id'), 'order_value' => $request->post('subscription_amount')]);

			// echo "czz";d($subscriptionPurchases);exit();
			Log::info("-----User account purchases ----------");
			Log::debug(json_encode($subscriptionPurchases, JSON_UNESCAPED_SLASHES));
			Log::info("-----END----------------------");
			$enddate = date_create(date('Y-m-d', strtotime(@$subscriptionPurchases['content'][0]['subscription_end_date'])));
			$today = date_create(date('Y-m-d'));
			$dateDiff = date_diff($enddate, $today);
			$numOfDays = $dateDiff->format('%a');
            // echo "ZX";d($subscriptionPurchases); exit;
			if ($subscriptionPurchases['success'] == true && !empty(@$subscriptionPurchases['content'])) {
				$subscription_end_date = @$subscriptionPurchases['content'][0]['subscription_end_date'];
				$todaydate = date("Y-m-d") . "T" . date("H:i:s") . "Z";
				// if ($todaydate < $subscription_end_date && $numOfDays > 3) {
				// 	return redirect('/myaccount/view');
				// } else {
					// check if subscription already exists to avoid multiple transactions - A@
					$subscription_order = $this->__subscriptionOrder();
					d($subscription_order);
					d($payment_type);exit();

					return $this->processPaymentGateways($subscription_order, $payment_type);
				//}
			} else {
				// $subscription_order = $this->__subscriptionOrder();
                $order_data = $subscriptionPurchases['order_data'];
                $order =[
                    'order_id' => $order_data['order_id'],
                    'order_value' => $order_data['order_value'],
                    'plan_id' => $order_data['plan_id'],
                    'created_date' => $order_data['created_date'],
                    'validity' => $order_data['validity'],
                ];
                $currency = 'INR';
				// return $this->processPaymentGateways($subscription_order, $payment_type);
                return $this->processPaymentGateways($order,$currency,$payment_type);
			}
		} else if ($request->post('purchase_subscription') == 'giftcard' && $request->post('payment_type') == 'giftcard') {
			if (!empty($request->post('card_number')) && !empty($request->post('card_pin')) && !empty($request->post('user_id')) && !empty($request->post('user_session_id'))) {
				$getBinVerfyData = array(
					'card_number' => $request->post('card_number'),
					'plan_id' => $request->post('subscription_plan_id')
				);
				Log::info("-----QWIKCILVER BIN VERIFY DATA------");
				Log::debug(json_encode($getBinVerfyData));
				Log::info("-----End------");
				// pr($getBinVerfyData);
				$getbinverfyresponseData = CurlAPIWITHOUTV2("giftcard/getbinverfy", 'POST', $getBinVerfyData);
				// pr($getbinverfyresponseData);
				Log::info("-----QWIKCILVER BIN VERIFY RESPONSE------");
				Log::debug(json_encode($getbinverfyresponseData));
				Log::info("-----End------");
				//For Payu GA events
				$pName = 'Monthly';
				$plan_name = '';
				if ($request->session()->has('plan_type'))
					$plan_name = $request->session()->get('plan_type');

				if ($plan_name == "1 Year") {
					$pName = "Yearly";
				}
				if ($plan_name == "6 Months") {
					$pName = "Half Yearly";
				}
				if ($plan_name == "3 Months") {
					$pName = "Quarterly";
				}
				if ($plan_name == "1 Month") {
					$pName = "Monthly";
				}

				if (@$getbinverfyresponseData['success'] == 'true') {
					@$balanceData = array(
						'user_id' => $request->post('user_id'),
						'session_id' => $request->post('user_session_id'),
						'card_number' => $request->post('card_number'),
						'card_pin' => $request->post('card_pin')
					);
					Log::info("-----QWIKCILVER BALANCE CHECK DATA------");
					Log::debug(json_encode(@$balanceData));
					Log::info("-----End------");
					// pr($balanceData);
					@$balanceresponseData = CurlAPIWITHOUTV2("giftcard/balance", 'POST', $balanceData);
					// pr($balanceresponseData);
					Log::info("-----QWIKCILVER BALANCE CHECK RESPONSE------");
					Log::debug(json_encode(@$balanceresponseData));
					Log::info("-----End------");

					if (@$balanceresponseData['success'] == 'true') {
						@$redeemData = array(
							'user_id' => $request->post('user_id'),
							'session_id' => $request->post('user_session_id'),
							'card_number' => $request->post('card_number'),
							'card_pin' => $request->post('card_pin'),
							'plan_id' => $getbinverfyresponseData['plan_id']
						);
						Log::info("-----QWIKCILVER REDEEM DATA------");
						Log::debug(json_encode(@$balanceData));
						Log::info("-----End------");
						// pr($redeemData);
						@$redeemresponseData = CurlAPIWITHOUTV2("giftcard/redeem", 'POST', @$redeemData);
						// pr($redeemresponseData);exit();
						Log::info("-----QWIKCILVER REDEEM API RESPONSE------");
						Log::debug(json_encode(@$redeemresponseData));
						Log::info("-----End------");
						$subscription_expiry_date = @$redeemresponseData['subscription_data']['subscription_end_date'] ?? '';
						$request->session()->put('subscription_expiry_date', $subscription_expiry_date);
						if (@$redeemresponseData['success'] == 'true') {

							//Redirect on home page if success and pack created
							$message =  'Subscription pack redeemed successfully.';
							//Store for GA tracking
							$request->session()->put('authEventTrack', $pName);
							$request->session()->put('eventCat', 'Subscription Success');
							//Moengage event tracker
							$menuUserData = userData();
							$commonData = getCommonProperties();
							$subSDate = isset($redeemresponseData['subscription_data']['subscription_start_date']) ? $redeemresponseData['subscription_data']['subscription_start_date'] : '';
							$subEDate = isset($redeemresponseData['subscription_data']['subscription_end_date']) ? $redeemresponseData['subscription_data']['subscription_end_date'] : '';
							$moengage_subscription_plan = array(
								'Plan Type' => $pName,
								'Plan Amount' => $request->post('subscription_amount'),
								'Currency' => $request->post('subscription_currency'),
								'Plan Start Date' => $subSDate,
								'Plan Expire Date' => $subEDate,
							);
							$commonMenuUserData = array_merge($menuUserData, $commonData, $moengage_subscription_plan);
							EventPush($user->user_id, 'Subscribe', $commonMenuUserData, true, false);
							return redirect('/')->with(['trackingSubscription' => $trackingSubscription]);
							// return redirect('/');
							// return view('epicon.epicv',compact('message'));
						} elseif ($redeemresponseData['errorcode'] == '10010') {
							if (!empty($balanceresponseData['card_details']['amount']) && !empty($balanceresponseData['card_details']['card_currency'])) {
								$balanceinsuffmsg = " Your card balance is " . $balanceresponseData['card_details']['card_currency'] . $balanceresponseData['card_details']['amount'];
							} else {
								$balanceinsuffmsg = "";
							}
							$message = 'Balance is insufficient.' . $balanceinsuffmsg;
							$request->session()->put("qwikCilvermsg", $message);
							//Store for GA tracking
							$request->session()->put('authEventTrack', $pName);
							$request->session()->put('eventCat', 'Subscription Failure');
							return redirect('/getSubscription')->with(['trackingSubscription' => $trackingSubscription, 'message' => $message]);
						} elseif ($redeemresponseData['errorcode'] == '10086') {
							$message = 'Either card number or card pin is incorrect.';
							$request->session()->put("qwikCilvermsg", $message);
							//Store for GA tracking
							$request->session()->put('authEventTrack', $pName);
							$request->session()->put('eventCat', 'Subscription Failure');
							return redirect('/getSubscription')->with(['trackingSubscription' => $trackingSubscription, 'message' => $message]);
						} else {
							$message = $redeemresponseData['message'];
							//Store for GA tracking
							$request->session()->put('authEventTrack', $pName);
							$request->session()->put('eventCat', 'Subscription Failure');
							$request->session()->put("qwikCilvermsg", $message);
							return redirect('/getSubscription')->with(['trackingSubscription' => $trackingSubscription, 'message' => $message]);
						}
					} else {
						// $message = 'Balance is insufficient.';
						$message = @$balanceresponseData['message'];
						//Store for GA tracking
						$request->session()->put('authEventTrack', $pName);
						$request->session()->put('eventCat', 'Subscription Failure');
						$request->session()->put("qwikCilvermsg", $message);
						return redirect('/getSubscription')->with(['trackingSubscription' => @$trackingSubscription, 'message' => $message]);
					}
				} elseif ($getbinverfyresponseData['errorcode'] == '1089') {
					$request->session()->put("qwikCilvermsg", $getbinverfyresponseData['message']);
					//Store for GA tracking
					$request->session()->put('authEventTrack', $pName);
					$request->session()->put('eventCat', 'Subscription Failure');
					return redirect('/getSubscription')->with(['trackingSubscription' => @$trackingSubscription, 'message' => @$message]);
				} else {
					$message = 'Invalid Card Details.';
					$request->session()->put("qwikCilvermsg", $message);
					//Store for GA tracking
					$request->session()->put('authEventTrack', $pName);
					$request->session()->put('eventCat', 'Subscription Failure');

					return redirect('/getSubscription')->with(['trackingSubscription' => $trackingSubscription, 'message' => $message]);
				}
			} else {
				$message = 'Card Number / PIN cannot be empty.';
				$request->session()->put("qwikCilvermsg", $message);
				//Store for GA tracking
				$request->session()->put('authEventTrack', 'QwikCilver-Card / PIN is empty');
				$request->session()->put('eventCat', 'Subscription Failure');

				return redirect('/getSubscription')->with(['trackingSubscription' => $trackingSubscription, 'message' => $message]);
			}
		}

    }
    public function planBenefit(Request $request){
        $data = $request->all();
        $result = CurlAPI("subscriptions/plans", "GET","", 2);
		if ($result && @$result['success'] ==  true) {

			if($result['success']){

				$plandata=[];
				foreach($result['plans'] as $key=>$val){
				if(($val['id'] == $data['planid'])){
					$plandata[]=$val;
					break;
				}
				
			}
			//d($plandata);exit();
			$html="";
			foreach($plandata as $key => $val){
				$i=0;
				foreach($val['benifits'] as $bn=>$bnval){
				$html.='<li>
					<a href="#">
						<span class="off-image">
						<img src="'.$bnval['vendor_image'].'" alt=""></span>
						<div class="ac-content">
							<div class="left">
								<div class="circle-logo">
									
								</div>
								<span>Exc. Offer</span>
							</div>
							<div class="right">
								<h5>25% OFF</h5>
								<p id="vname">'.$bnval['vendor_name'].'</p>
								<span>Valid until 03 March 2022</span>
							</div>
						</div>
					</a>
				</li>';
				$i++;
				}
			
			}
			$res['html'] = '<ul class="additional-carousel mb-0 mt-3 p-0">'.$html.'</ul>';
			$res['count'] = $i;
	
			return response()->json($res, 201)->header('Content-Type', 'application/json');
			}else{
				return response()->json($message, 201)->header('Content-Type', 'application/json');
			}

		}else{
			return response()->json($message, 201)->header('Content-Type', 'application/json');
		}
        $message="data not found";
		
        

    }

    protected function __subscriptionOrder()
	{
		$request = Request();
		Log::info("-----######__subscriptionOrder function Call------------");
		Log::debug(json_encode($request->post()));
        $user = getLoggedInUser();
        // dd($user); exit;
		if (($user = getLoggedInUser()) != false && $request->post('device') != 'android') {
			$user_id = ($user->user_id == $request->post('user_id')) ? $request->post('user_id') : 0;
			$session_id = ($user->api_session_id == $request->post('user_session_id')) ? $request->post('user_session_id') : 0;
			if ($request->post('payment_type') == 'juspay') {
				$paymentGateway = 'juspay';
			} elseif ($request->post('payment_type') == 'ccavenue') {
				$paymentGateway = 'ccavenue';
			} else if ($request->post('purchase_subscription') == 'amazonpay') {
				$paymentGateway = 'amazonpay';
			} else if (($request->post('payment_type') == 'twid' || $request->post('payment_type') == 'twid_fk') || ($request->post('payment_type') == 'twid_app' || $request->post('payment_type') == 'twid_fk_app')) {
				//For supercoins changes
				$request->session()->put('pg_source', $request->post('payment_type'));
				$paymentGateway = 'supercoinpay';
			} else {
				$paymentGateway = 'payumoney';
			}
			//new code for payments method for order value for api
			$couponplans = [];
			$finalamount = '';
			$coupon_applied = '';
			if ($request->session()->has('usercounponplan') && $request->session()->get('usercounponplan')) {
				$couponplans = (!empty($request->session()->get('usercounponplan'))) ? json_decode($request->session()->get('usercounponplan'), true) : [];
				if (!empty($couponplans['plans'])) {
					foreach ($couponplans['plans'] as $p => $pln) {
						if ($request->post('subscription_plan_id') == $pln['id']) {
							$finalamount = $pln['discounted_price'];
							$coupon_applied = $couponplans['couponcode'];
							break;
						}
					}
				}
			}
			if (($request->post('payment_type') == 'twid' || $request->post('payment_type') == 'twid_fk') || ($request->post('payment_type') == 'twid_app' || $request->post('payment_type') == 'twid_fk_app')) {
				if (empty($finalamount))
					$finalamount = $request->post('subscription_amount');

				$request->session()->put('bill_amount', $finalamount);
			}

			Log::info("-----######Before create order api Call------------");
			Log::debug(json_encode($user));
			//$paymentGateway = ($request->post('purchase_subscription')=='ContinueToPaytm') ? 'paytm' : 'ccavenue';
			if ($user_id && $session_id) {
				$promotions = ($request->post('promotionsselected') == 'promotions') ? 1 : 0;
				$request->session()->put('promotionsselected', $promotions);
				//var_dump($promotions);die;
				$postedData = [
					'user_id' => $user_id,
					'session_id' => $session_id,
					'plan_id' => $request->post('subscription_plan_id'),
					'payment_gateway' => $paymentGateway,
					'amount' => $request->post('subscription_amount')
				];
				if (!empty($couponplans['plans'])) {
					//$postedData['order_value'] = $finalamount;
					$postedData['amount'] = $finalamount;
					$postedData['coupon_applied'] = $coupon_applied;
				}
				/*if(strtoupper(env('APP_ENV'))=='PRODUCTION'){
					@$epicwebArr = CurlAPI("subscriptions/createorder",'POST',$postedData);
					Log::info("-----######web create order api response------------");
				} else {
					@$epicwebArr = CurlAPI("subscriptions/createupdateorder",'POST',$postedData);
					Log::info("-----######web create ordersubscription api response------------");
				}*/
				if (env('DEV_AMT') == true || $user_id == 'epic12311@mailinator.com' || $user_id == '919870460076' || $user_id == 'apitesting0807@gmail.com') {
					$postedData['amount'] = "1";
				}
				if (($request->post('payment_type') == 'twid' || $request->post('payment_type') == 'twid_fk') || ($request->post('payment_type') == 'twid_app' || $request->post('payment_type') == 'twid_fk_app')) {
					@$epicwebArr = CurlAPI("subscriptions/createorder", 'POST', $postedData);
					Log::info("-----######web create order api response------------");
				} else {
					@$epicwebArr = CurlAPI("subscriptions/createupdateorder", 'POST', $postedData);
					Log::info("-----######web create ordersubscription api response------------");
				}
				Log::debug(json_encode(@$epicwebArr));
				Log::info("-----######End------");
				if (@$epicwebArr['success'] == true) {
					$message = @$epicwebArr['message'];
					/*if(strtoupper(env('APP_ENV'))!='PRODUCTION' && empty($epicwebArr['order_data'])){
						$epicwebArr['order_data'] = $epicwebArr['subscription_data'];
						$epicwebArr['order_data']['order_value'] = $epicwebArr['subscription_data']['plan_amount'];
					}*/
					if (($request->post('payment_type') == 'twid' || $request->post('payment_type') == 'twid_fk') || ($request->post('payment_type') == 'twid_app' || $request->post('payment_type') == 'twid_fk_app')) {
					} else {
						@$epicwebArr['order_data'] = @$epicwebArr['subscription_data'];
						@$epicwebArr['order_data']['order_value'] = @$epicwebArr['subscription_data']['plan_amount'];
					}
					if ($request->session()->has('usercounponplan') && $request->session()->get('usercounponplan')) {
						$couponplans = (!empty($request->session()->get('usercounponplan'))) ? json_decode($request->session()->get('usercounponplan'), true) : [];
						if (!empty($couponplans['plans'])) {
							foreach ($couponplans['plans'] as $p => $pln) {
								if (@$epicwebArr['order_data']['plan_id'] == $pln['id']) {
									@$epicwebArr['order_data']['order_value'] = $pln['discounted_price'];
									break;
								}
							}
						}
					}
					@$epicwebArr['order_data']['samzo_coins'] = $request->post('samzo_coins');
					return @$epicwebArr['order_data'];
				} else {
					$message = "Error!" . @$epicwebArr['message'];
				}
			}
		} elseif ($request->post('device') == 'android' || $request->post('device') == 'ios') {
			$user_id = $request->post('user_id');
			$session_id = $request->post('user_session_id');
			if ($request->post('payment_type') == 'juspay') {
				$paymentGateway = 'juspay';
			} elseif ($request->post('payment_type') == 'ccavenue') {
				$paymentGateway = 'ccavenue';
			} else if (($request->post('payment_type') == 'twid' || $request->post('payment_type') == 'twid_fk') || ($request->post('payment_type') == 'twid_app' || $request->post('payment_type') == 'twid_fk_app')) {
				//For supercoins changes
				$request->session()->put('pg_source', $request->post('payment_type'));
				$paymentGateway = 'supercoinpay';
			} else if ($request->post('purchase_subscription') == 'amazonpay') {
				$paymentGateway = 'amazonpay';
			} else {
				$paymentGateway = 'payumoney';
			}
			if (($request->post('payment_type') == 'twid' || $request->post('payment_type') == 'twid_fk') || ($request->post('payment_type') == 'twid_app' || $request->post('payment_type') == 'twid_fk_app')) {
				if (empty($finalamount))
					$finalamount = $request->post('subscription_amount');

				$request->session()->put('bill_amount', $finalamount);
			}

			//$paymentGateway = ($request->post('purchase_subscription')=='ContinueToPaytm') ? 'paytm' : 'ccavenue';
			//      if($user_id && $session_id){
			$promotions = ($request->post('promotionsselected') == 'promotions') ? 1 : 0;
			$request->session()->put('promotionsselected', $promotions);
			//var_dump($promotions);die;
			$postedData = [
				'user_id' => $request->post('user_id'),
				'session_id' => $request->post('user_session_id'),
				'plan_id' => $request->post('subscription_plan_id'),
				'payment_gateway' => $paymentGateway,
				'promotions' => $promotions
			];
			Log::info("-----######Android create order api request-------");
			Log::debug(json_encode($postedData));
			Log::info("-----######End------");
			if (strtoupper(env('APP_ENV')) == 'PRODUCTION') {
				Log::info("-----######Android LIVE environment----------");
				$app_test =  Session::get('app_test');
				if (env('ANDROID_APP_TEST') == 'YES' && $app_test == 'Y') {
					if (($request->post('payment_type') == 'twid' || $request->post('payment_type') == 'twid_fk') || ($request->post('payment_type') == 'twid_app' || $request->post('payment_type') == 'twid_fk_app')) {
						@$epicwebArr = CurlAPI("subscriptions/createorder", 'POST', $postedData);
						Log::info("-----######Android create order api response--LIVEMODE----------");
					} else {
						@$epicwebArr = CurlAPI("subscriptions/createupdateorder", 'POST', $postedData);
						Log::info("-----######Android createupdateorder subscription api response--LIVEMODE----------");
					}
				} else {
					@$epicwebArr = CurlAPI("subscriptions/createorder", 'POST', $postedData);
					Log::info("-----######Android create order api response--LIVEMODE----------");
				}
			} else {
				Log::info("-----######Android DEV environment----------");
				$app_test =  Session::get('app_test');
				if (env('ANDROID_APP_TEST') == 'YES' && $app_test == 'Y') {
					if (($request->post('payment_type') == 'twid' || $request->post('payment_type') == 'twid_fk') || ($request->post('payment_type') == 'twid_app' || $request->post('payment_type') == 'twid_fk_app')) {
						@$epicwebArr = CurlAPI("subscriptions/createorder", 'POST', $postedData);
						Log::info("-----######Android create order api response--DEVMODE---------");
					} else {
						@$epicwebArr = CurlAPI("subscriptions/createupdateorder", 'POST', $postedData);
						Log::info("-----######Android createupdateorder subscription api response--TESTMODE----------");
					}
				} else {
					@$epicwebArr = CurlAPI("subscriptions/createorder", 'POST', $postedData);
					Log::info("-----######Android create order api response--DEVMODE---------");
				}
			}
			//Log::info("-----######Android create order api response------");
			Log::debug(json_encode($epicwebArr));
			Log::info("-----######End------");
			if (@$epicwebArr['success'] == true) {
				$message = @$epicwebArr['message'];
				$app_test =  Session::get('app_test');
				if (strtoupper(env('ANDROID_APP_TEST')) == 'YES' && $app_test == 'Y' && empty(@$epicwebArr['order_data'])) {
					if (($request->post('payment_type') == 'twid' || $request->post('payment_type') == 'twid_fk') || ($request->post('payment_type') == 'twid_app' || $request->post('payment_type') == 'twid_fk_app')) {
					} else {
						@$epicwebArr['order_data'] = @$epicwebArr['subscription_data'];
						@$epicwebArr['order_data']['order_value'] = @$epicwebArr['subscription_data']['plan_amount'];
						Log::info("-----######Android subscriptiondata assign to orderdata--TESTMODE----------");
					}
				}
				if ($request->session()->has('usercounponplan') && $request->session()->get('usercounponplan')) {
					$couponplans = (!empty($request->session()->get('usercounponplan'))) ? json_decode($request->session()->get('usercounponplan'), true) : [];
					if (!empty($couponplans['plans'])) {
						foreach ($couponplans['plans'] as $p => $pln) {
							if (@$epicwebArr['order_data']['plan_id'] == $pln['id']) {
								@$epicwebArr['order_data']['order_value'] = $pln['discounted_price'];
								break;
							}
						}
					}
				}
				return @$epicwebArr['order_data'];
			} else {
				$message = "Error!" . @$epicwebArr['message'];
			}
		}
		return null;
	}

    public function getCoupon(Request $request){
        $sessionData = $request->session()->get('user');
        $postData = $request->all();
        $userid = $sessionData['user_id']??'';
        $promocode = $postData['promocode'] ?? '';
        $postdata = array(
            'user_id' => $userid,
            'coupon_code' => $promocode,
        );

        $listResponseData = CurlAPI("subscriptions/createCouponOrder", 'POST', $postdata , 2);
		if ($listResponseData && @$listResponseData['success'] ==  true) {
            $sessionData = $request->session()->get('plandata');
            foreach ($listResponseData['plans'] as $key => $val) {
                if(isset($sessionData[$val['id']])){
                    $sessionData[$val['id']]=[
                        'id'=> $val['id'],
                        'name'=> $val['name'],
                        'plan'=> isset($sessionData[$val['id']]['plan']) ? $sessionData[$val['id']]['plan'] : '',
                        'actual_price'=> $val['discounted_price'], // this is use for final transaction
                        'old_price'=> $val['actual_price'], // this is actual price without discount
                        'save'=> '', // this is disount percetage like 20%
    
                    ];
                }
            }
            if(!empty($sessionData)){
                $request->session()->put('plandata', $sessionData);
            }            
            return response()->json($listResponseData, 200)->header('Content-Type', 'application/json');
        }else{
            return response()->json('Coupan not found.', 400)->header('Content-Type', 'application/json');
        }
        


    }
}
