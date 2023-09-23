<?php
namespace App\Traits;
use Request;
use Illuminate\Support\Facades\Log;
trait payments {
 
  public function processPaymentGateways($order,$payment_type){
  	   $container = app();
		$request = Request();
		$currency = $request->post('subscription_currency');
		$gateway = $request->post('payment_type');
		$request->session()->put('transactionCurrency',$currency);
		if($gateway=='juspay') {
            return $container->call('App\Http\Controllers\JuspayController@juspay', [$order,$currency,$payment_type]);
        }
		elseif($gateway=='ccavenue'){

            if(!empty($request->post('subscription_eq_amount'))){
                $order['eq_amount'] = $request->post('subscription_eq_amount');
            }
            return $container->call('App\Http\Controllers\CcavenueController@__paymentprocess', [$order,$currency]);

        } else if($gateway=='amazonpay'){
            // return $container->call('App\Http\Controllers\AmazonpayController@__amazonprocess', [$order,$currency]);
            return $container->call('App\Http\Controllers\AmazonpayController@__amazonprocess', ['order'=>$order,'currency'=>$currency]);
        //} else if($gateway=='ccavenue' && $currency != 'INR'){
        } else if(($gateway=='twid' || $gateway=='twid_fk') || ($gateway=='twid_app' || $gateway=='twid_fk_app')){
        //For supercoins changes
            // return $container->call('App\Http\Controllers\FlipkartSupercoinController@__supercoinprocess', [$order,$currency]);
             return $container->call('App\Http\Controllers\FlipkartSupercoinController@__supercoinprocess', ['order'=>$order,'currency'=>$currency]);
        }
		else{
            // return $container->call('App\Http\Controllers\PayuController@__paymentprocess', [$order,$currency,$payment_type]);
             return $container->call('App\Http\Controllers\NewPayuController@__paymentprocess', ['order'=>$order,'currency'=>$currency,'payment_type'=>$payment_type]);
             // return App::call('\App\Http\Controllers\indexController@showlistdetail',['displayLanguage'=>'','pageslug'=>$pageslug,'listcatalog'=>$listcatalog,'contentslug'=>'watch','seasonslug'=>'','episodeslug'=>'']);
        }
  }
 
  public function updateSubscription($transactionData,$gateway){
  		if((($user = getLoggedInUser())!=false) && !empty($gateway) && !empty($transactionData)){
			$user_id = $user->user_id;
			$session_id = $user->api_session_id;
			$statusToUpdate = "complete";
			$paytm_mobile = $transaction_subscription_id = $subscriptionPaymentMode = $note = $paymentservice = $qrpromotionsselected = '' ;
			if($gateway=='paytm'){
	    		if(strtoupper(env('APP_ENV'))=='PRODUCTION'){
					$order_id = $transactionData['ORDERID'];
				} else {
					$order_id = str_replace(strtoupper(env('APP_ENV'))."_","",$transactionData['ORDERID']);
				}
	    		$transaction_id = $transactionData['TXNID'];
	    		$bank_transaction_id = $transactionData['BANKTXNID'];
	    		$transaction_user_id = $transactionData['CUST_ID'];
	    		$transaction_amount = $transactionData['TXNAMOUNT'];
	    		$gateway_used = $transactionData['GATEWAYNAME'];
	    		$bankname = $transactionData['BANKNAME'];
	    		$paymentservice = $transactionData['PAYMENTMODE'];
	    		if($transactionData['STATUS']=="PENDING"){
	    			$statusToUpdate = "PENDING";
	    		}
	    		if($transactionData['TRANSACTION_MODE']=='subscription'){
	    			$transaction_id = (empty($transaction_id)) ? $transactionData['TXN_ID'] : $transaction_id;
		    		$transaction_subscription_id = $transactionData['SUBS_ID'];
		    		$subscriptionPaymentMode = $transactionData['PAYMENTMODE'];
	    		}
	    		
	    	}
	    	
	    	if($gateway=='ccavenue'){
	    		$order_id = str_replace("db_","",$transactionData['order_id']);
	    		$transaction_id = $transactionData['tracking_id'];
	    		$bank_transaction_id = $transactionData['bank_ref_no'];
	    		$transaction_amount = $transactionData['amount'];
	    		$paymentmode = $transactionData['payment_mode'];    		
	    		$paymentservice = $transactionData['card_name'];    		
	    	}
	    	if($gateway=='ccavenuerecurring'){
	    		$order_id = str_replace("db_","",$transactionData['order_id']);
	    		$transaction_id = $transactionData['tracking_id'];
	    		$bank_transaction_id = $transactionData['order_bank_response'];
	    		$transaction_amount = $transactionData['amount'];
	    		$paymentmode = $transactionData['payment_mode'];    		
	    	}
            if($gateway == 'payumoney'){
                $order_id = str_replace("db_","",$transactionData['order_id']);
                $transaction_amount = intval($transactionData['amount']);
                $paymentmode = $transactionData['mode'];
                $statusToUpdate = 'complete';
                $paymentservice = $transactionData['mode'];
                $bank_transaction_id = $transactionData['bank_ref_num'];
                $transaction_id = $transactionData['mihpayid'];
                $transaction_subscription_id = isset($transactionData['subscriptionId'])?$transactionData['subscriptionId']:'';

	    	}
            if($gateway=='amazonpay'){
                $order_id = $transactionData['sellerOrderId'];
                $transaction_id = $transactionData['amazonOrderId'];
                $bank_transaction_id = $transactionData['bank_txn'];
                $transaction_amount = $transactionData['orderTotalAmount'];
                $paymentmode = $transactionData['discriminator'];
                $gateway = 'amazonpay';
            }
            if($gateway=='amazonwallet'){
                $order_id = $transactionData['merchantTransactionId'];
                $transaction_id = $transactionData['amazonTransactionId'];
                $bank_transaction_id = $transactionData['bank_txn'];
                $transaction_amount = $transactionData['amount'];
                $paymentmode = "amazonwallet";
                $gateway = 'amazonpay';
            }
            if($gateway == 'juspay'){
                $order_id = str_replace("db_","",$transactionData['order_id']);
                $transaction_amount = intval('159');
                $paymentmode = 'CC';
                $statusToUpdate = 'complete';
                $paymentservice = 'juspay';
                $bank_transaction_id = 'tnx458435934';
                $transaction_id = 'txn675675654654';
                $transaction_subscription_id = isset($transactionData['subscriptionId'])?$transactionData['subscriptionId']:'';
            }
            if($gateway=='supercoinpay'){
                $order_id = $transactionData['order_id'];
                $transaction_id = $transactionData['transaction_id'];
                $transaction_amount = $transactionData['plan_amount'];
                $paymentmode = $transactionData['payment_gateway'];
                $gateway = 'supercoinpay';
            }
	    	if(strtoupper(env('APP_ENV'))!='PRODUCTION'){
	    		$order_id = str_replace(strtoupper(env('APP_ENV'))."_","",$order_id);
	    	}
	    	$postedData = [];
	    	$postedData = [
				'user_id'=>$user_id,
				'session_id'=>$session_id,
				'order_id'=>$order_id,
				'order_status'=>$statusToUpdate,
				'transaction_id'=>$transaction_id,
				'payment_gateway'=>$gateway,
				'bank_ref_no'=>$bank_transaction_id,
				'payment_mode'=>$paymentservice,
                'plan_amount' => $transaction_amount
			];
	    	$request = Request();
			if($transactionData['web_device']=='app_android'){
				$postedData['web_device'] = 'app_android';
				$postedData['user_id'] = $request->post('vads_cust_email');
				if($transactionData['session_id']){
					$postedData['session_id'] = $transactionData['session_id'];
				}
			}
//			if($request->session()->has('qrpromotionsselected') && !empty($request->session()->get('qrpromotionsselected'))){
//				$postedData['mi_token'] = $request->session()->get('qrpromotionsselected');
//			}
            //new code to put up for coupon as for api
            if($request->session()->has('usercounponplan') && $request->session()->get('usercounponplan')){
                $couponplans = (!empty($request->session()->get('usercounponplan'))) ? json_decode($request->session()->get('usercounponplan'),true) : [];
                if(!empty($couponplans['couponcode'])){
                    $postedData['coupon_applied'] = $couponplans['couponcode'];
                    $request->session()->forget('usercounponplan');
                }
            }
            //new code to put end for api and tracking
            $request->session()->forget('qrpromotionsselected');
			$epicwebArr = CurlAPI("subscriptions/updateorder",'POST',$postedData);
            if(!empty($transactionData['status']) && strtolower($transactionData['status'])=='success'){
    			$epicwebArrplans = CurlAPI("subscriptions/plans");
                foreach ($epicwebArrplans['plans'] as $plan) {
                    if($epicwebArr['subscription_data']['plan_id'] == $plan['id']){
                        $samzo_coins = array(
                            'samzo_coins' => $plan['samzo_coins'],
                        );
                    }
                }
                $postedDatasamzo = array(
                    'user_id' => $user_id,
                    'session_id' => $session_id,
                    'property' => 'idle_time',
                    'property_value' => $samzo_coins['samzo_coins']
                );
                $samzo_coin = CurlAPIWITHOUTV2("games/samzocredit",'POST',$postedDatasamzo);
                    Log::info("-----samzocredit coin Response");
                    Log::debug(json_encode($samzo_coin,JSON_UNESCAPED_SLASHES));
                    Log::info("-----END----------------------");
            }
            Log::info("-----web updateorder Response");
            Log::debug(json_encode($postedData,JSON_UNESCAPED_SLASHES));       
            Log::debug(json_encode($epicwebArr,JSON_UNESCAPED_SLASHES));
            Log::info("-----micoupon:".$request->session()->get('qrpromotionsselected')."----");
            Log::info("-----END----------------------");
            $request->session()->forget('qrpromotionsselected');
			return $epicwebArr;
		}
		return ['success'=>false];
    }

    public function getConvertedPrice($source_currency,$destination_currency,$amount=''){
        return false;
        if($source_currency!='' && $destination_currency!=''){
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.exchangeratesapi.io/latest?base=".$source_currency."&symbols=".$destination_currency,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Accept: */*",
                    "Accept-Encoding: gzip, deflate",
                    "Cache-Control: no-cache",
                    "Connection: keep-alive",
                    "Host: api.exchangeratesapi.io",
                    //		    "Postman-Token: 5f5c0182-96ac-4dcc-b7dc-0c75f9073a11,4bc83cc9-305f-4062-b68a-04d14a96e2e4",
                    //		    "User-Agent: PostmanRuntime/7.15.2",
                    "cache-control: no-cache"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            Log::info("-----Current Price Curl:------");
            Log::debug($response);
            Log::info("-----End------");
            if ($curl_errno > 0) {
                return false;
            } else {
                //return json_decode($response,true);
                $rates = json_decode($response,true);
                return $rates['rates'][$destination_currency];
            }
        } else {
            return false;
        }
    }

    public function getamazonbalance($context,$method='GET',$data = null,$amazonauthcode=''){
        $context = 'v2/subscriptionpay/getamazonbalance';
        $url = config('epicconfig.EPICAPI.API_DOMAIN').$context.'/';
        if($amazonauthcode!=''){
            $headerArr[] = "x-access-auth-token: ".$amazonauthcode;
        } else {
            $headerArr[] = "x-access-auth-token: ".config('epicconfig.EPICAPI.API_AUTH_TOKEN');  
        }
        $headerArr[] = "Content-Type: application/x-www-form-urlencoded";
        $headerArr[] = "cache-control: no-cache";
        if(env('APP_ENV')!='local' || env('APP_ENV')!='LOCAL'){
            @$clientip = (!empty($_SERVER['HTTP_TRUE_CLIENT_IP'])) ? $_SERVER['HTTP_TRUE_CLIENT_IP'] : explode(",",$_SERVER['HTTP_X_FORWARDED_FOR'])[0];
            @$headerArr[] =  "HTTP_X_CCORG: ".$_SERVER['HTTP_X_CCORG'];
            $headerArr[] =  "HTTP_TRUE_CLIENT_IP: ".$clientip;
        }
        Log::info("-----Amazon test------");
        Log::debug(json_encode($data));
        Log::info("-----End------");

        $querystring ='';
        @$data['x_country'] = $_SERVER['HTTP_X_REGION'];
        $ch = curl_init();
        if($method=='POST'){
            if($data!= null && !empty($data)){
                $fields_string = http_build_query($data);

                Log::info("-----Amazon test------");
                Log::info($fields_string);
                Log::info("-----End------");

                curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            }
            curl_setopt($ch, CURLOPT_POST, true);
        } else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            $querystring = ($data!= null && !empty($data)) ? $this->preparePostFields($data) : '';
            $url = $url."?".$querystring;
        }
        
        // Log::info("-----CurlObjInstance:".$ch."-----Method:".$method."-----URL:".$url."-----Data:".$fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArr);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);    
        $result = curl_exec($ch);
        $curlhttpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerout = curl_getinfo($ch,CURLINFO_HEADER_OUT);     
        $curl_error = curl_error($ch);
        $curl_errno = curl_errno($ch);
        curl_close($ch);
        Log::info("-----Curl Header:".$headerout."------");
        Log::info("-----Amazon transaction balance API Response------");
        Log::info($curl_errno);
        Log::debug($result);
        Log::info("-----End------");
        //pr($result);die;
        if ($curl_errno > 0) {
            return false;
        } else {
            return json_decode($result,true);
        }
    }

    public function preparePostFields($array) {
          $params = array();
          foreach ($array as $key => $value) {
            $params[] = $key . '=' . urlencode($value);
          }
          return implode('&', $params);
    }
     public function getSubscriptionRecurrCleverTap($paymentstatus,$trackingData,$paymentresponse){
        $txn_url = config('epicconfig.CLEVERTAP.CLEVERTAP_TXN_URL');
	$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $txn_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $orderdata = $trackingData['subscription_data'];
        unset($orderdata['_id']); unset($orderdata['__v']);
        $orderdata['order_status'] = 'Completed';
        $postData['ts'] = time();
        $postData['identity'] = $orderdata['user_id'];
        $postData['type'] = 'event';
        $postData['evtName'] = 'Renewal Subscription Completed';
        $postData['evtData'] = $orderdata;
	Log::info("-----CLEVERTAP CURL Parameters: ".$txn_url."----\n");
        Log::debug(json_encode($postData));
        Log::info("-----END----------------------");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"d\": [ ".json_encode($postData,JSON_PRETTY_PRINT)." ] }");
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = array();
        $headers[] = 'Content-Type: application/json; charset=utf-8';      
        $headers[] = 'X-CleverTap-Account-Id: '.config('epicconfig.CLEVERTAP.CLEVERTAP_ACCOUNT_ID');
        $headers[] = 'X-CleverTap-Passcode: '.config('epicconfig.CLEVERTAP.CLEVERTAP_PASSCODE');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        Log::info("-----CLEVERTAP CURL response");
        Log::debug($result);
        Log::info("-----END----------------------");
    }
}
?>
