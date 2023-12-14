<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Softon\Indipay\Facades\Indipay;
use Illuminate\Support\Facades\Log;
use Request;
use Route;
use Auth;
use App\Traits\payments;
/*
 * @package laravel
 * @subpackage Controller
 */
class PaytmController extends Controller
{
	use payments;    
    public function __paymentPaytmprocess($order,$currency){
        return $this->createSubscriptionAtPaytmCheckout($order,$currency);
    	$checkSum = "";
		$paramList = array();

		$ORDER_ID = $order['order_id'];
		$CUST_ID = $order["user_id"];
		if(strtoupper(env('APP_ENV'))=='PRODUCTION'){
			$TXN_AMOUNT = $order["order_value"];
		} else {
			$TXN_AMOUNT = "1.00";
		}

		// Create an array having all required parameters for creating checksum.
		$paramList["MID"] = config('epicconfig.PAYTM.PAYTM_MERCHANT_ID');
		$paramList["ORDER_ID"] = $ORDER_ID;
		$paramList["CUST_ID"] = $CUST_ID;
		$paramList["INDUSTRY_TYPE_ID"] = config('epicconfig.PAYTM.PAYTM_INDUSTRY_TYPE_ID');
		$paramList["CHANNEL_ID"] = config('epicconfig.PAYTM.PAYTM_CHANNEL_ID'); //"WEB";
		$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
		$paramList["WEBSITE"] =  config('epicconfig.PAYTM.PAYTM_MERCHANT_WEBSITE');
		$paramList["CALLBACK_URL"] = config('epicconfig.PAYTM.PAYTM_CALLBACK_URL');	
		
		include(app_path().'/Libraries/encdec_paytm.php');
		
		$checkSum = getChecksumFromArray($paramList,config('epicconfig.PAYTM.PAYTM_MERCHANT_KEY'));
		
		$PAYTM_TXN_URL = config('epicconfig.PAYTM.PAYTM_TXN_URL').'?orderid='.$ORDER_ID;
		return view('epicon.paytmredirect',compact('checkSum','PAYTM_TXN_URL','paramList'));
    }

    public function paytmresponse(){
    	$request = Request();
    	$paytmChecksum = "";
		$paramList = array();
		$isValidChecksum = "FALSE";

		$paramList = $request->post();

		Log::info("-----paytm single response-----");
		Log::debug(json_encode($paramList,JSON_UNESCAPED_SLASHES));
		Log::info("-----END----------------------");

		$paytmChecksum = (!empty($request->post("CHECKSUMHASH"))) ? $request->post("CHECKSUMHASH") : ""; //Sent by Paytm pg
		if(empty($paytmChecksum)){
			$message = "You have cancelled the transaction.";
			return redirect('/getSubscription')->with('message',$message);
		}
		include(app_path().'/Libraries/encdec_paytm.php');
		$isValidChecksum = verifychecksum_e($paramList, config('epicconfig.PAYTM.PAYTM_MERCHANT_KEY'), $paytmChecksum); 
		$authEventTrack = $eventCat = '';
		//pr($request->post());die;

		if($isValidChecksum == "TRUE") {
			$transactionlog = "Checksum matched and following are the transaction details:" . "\n";
			if ($request->post("STATUS") == "TXN_SUCCESS" || $request->post("STATUS") == "PENDING") {
				$transactionlog .= "Transaction status is success" . "\n";
				//Verify amount & order id received from Payment gateway with your application's order id and amount.
				//$paramList['STATUS'] = "PENDING";
				if(!empty($paramList['SUBS_ID']) && $paramList['SUBS_ID'] != null){
					$paramList['TRANSACTION_MODE'] = 'subscription';	
				}
				$updateOrderResponse = $this->updateSubscription($paramList,'paytm');
				if($updateOrderResponse['success']==true){
					$message = "You have successfully purchased a subscription plan.";
					//$authEventTrack = 'Subscription purchased successfull';
					//return redirect('/getSubscription')->with(['message'=>$message,'eventCat'=>'Subscription','authEventTrack'=>$authEventTrack]);
					$purchasedPlan_id = "";
					if(!empty($updateOrderResponse['subscription_data'])){
						$purchasedPlan_id = $updateOrderResponse['subscription_data']['plan_id'];
					}
					if($request->post("STATUS") == "TXN_SUCCESS"){
						$eventCat = 'Subscription Success'; $authEventTrack = "PAYTM-Success-".$purchasedPlan_id;
					} else if($request->post("STATUS") == "PENDING"){
						$message = "Please wait. Transaction is in process";
						$eventCat = 'Subscription Attempt'; $authEventTrack = "PAYTM-TransactionPending";
					}
				} else {
					// As per implemented in Android
	        		$message = 'Error occured. Please wait...';
	        		$eventCat = 'Subscription Aborted'; $authEventTrack = "PAYTM-Aborted";
				}
				return redirect('/getSubscription?reftoken='.md5(time()))->with(['message'=>$message,'eventCat'=>$eventCat,'authEventTrack'=>$authEventTrack]);
			}  else {
				$transactionlog .= "Transaction status is failure" . "\n";
				$message = "You have cancelled the transaction.";
				//$authEventTrack = 'Subscription failed due to -'.$request->post("RESPMSG");
				if ($request->post('RESPCODE') == "141" || $request->post('RESPCODE') == "2271" || $request->post('RESPCODE') == "2272") {
					$message = "You have cancelled the transaction.";
					//$eventCat = 'Subscription Aborted'; $authEventTrack = "PAYTM-Aborted";
					$eventCat = 'Subscription Failure'; $authEventTrack = "PAYTM-TransactionCancelled"; // As per Android implementation
	            } else if(in_array($request->post('RESPCODE'),["202","205","208","220","296","401","402"])){
	            	$message = "Transaction Failed.";
	                $eventCat = 'Subscription Failure'; $authEventTrack = "PAYTM-TransactionDeclined";
	            }
	            else {
	            	$message = "Transaction Failed.";
	                $eventCat = 'Subscription Failure'; $authEventTrack = "PAYTM-Failure";
	            }
				return redirect('/getSubscription?reftoken='.md5(time()))->with(['message'=>$message,'eventCat'=>$eventCat,'authEventTrack'=>$authEventTrack]);
			}
			if (!empty($request->post()) && count($request->post())>0 )
			{ 
				foreach($request->post() as $paramName => $paramValue) {
					$transactionlog .= "\n" . $paramName . " = " . $paramValue;
				}
			}
		}
		else {
			$transactionlog = "\nChecksum mismatched.</b>";
			//$authEventTrack = 'Subscription response checksum is invalid';
			//$eventCat = 'Subscription';
			$eventCat = 'Subscription Failure'; $authEventTrack = "PAYTM-CancelledOrDeclinedOrError";
		}
		$message = "Payment Failure.";
		$meta = get404Meta();
		return view('epicon.404',compact('message','meta','authEventTrack','eventCat'));
    }

    public function _androidPaytmUsingWeb(){
    	$checkSum = "";
		$paramList = array();
		$request = Request();

		$ORDER_ID = $request->get('order_id');
		$CUST_ID = $request->get('customer_id');
		if(strtoupper(env('APP_ENV'))=='PRODUCTION'){
			$TXN_AMOUNT = $request->get('amount');
		} else {
			$TXN_AMOUNT = "1.00";
		}

		// Create an array having all required parameters for creating checksum.
		$paramList["MID"] = config('epicconfig.PAYTM.PAYTM_MERCHANT_ID');
		$paramList["ORDER_ID"] = $ORDER_ID;
		$paramList["CUST_ID"] = $CUST_ID;
		$paramList["INDUSTRY_TYPE_ID"] = config('epicconfig.PAYTM.PAYTM_INDUSTRY_TYPE_ID');
		$paramList["CHANNEL_ID"] = config('epicconfig.PAYTM.PAYTM_CHANNEL_ID'); //"WEB";
		$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
		$paramList["WEBSITE"] =  config('epicconfig.PAYTM.PAYTM_MERCHANT_WEBSITE');
		$paramList["CALLBACK_URL"] = config('epicconfig.PAYTM.PAYTM_ANDROID_RESPONSE_URL');	

		
		include(app_path().'/Libraries/encdec_paytm.php');
		$checkSum = getChecksumFromArray($paramList,config('epicconfig.PAYTM.PAYTM_MERCHANT_KEY'));
		$PAYTM_TXN_URL = config('epicconfig.PAYTM.PAYTM_TXN_URL').'?orderid='.$ORDER_ID;
		return view('epicon.paytmredirect',compact('checkSum','PAYTM_TXN_URL','paramList'));
	}
		
	public function createSubscriptionAtPaytmCheckout($order,$currency){
		$checkSum = "";
		$request = Request();
		$paramList = array();
		$ORDER_ID = $order['order_id'];
		$CUST_ID = $order["user_id"];
		//$RECURR = $request->post('recurring');
		$RECURR = 'TRUE';
		if(strtoupper(env('APP_ENV'))=='PRODUCTION'){
			$TXN_AMOUNT = $order["order_value"];
		} else {
			$TXN_AMOUNT = "1";
		}
		$paramList["MID"] = config('epicconfig.PAYTM.PAYTM_MERCHANT_ID');
		if(strtoupper(env('APP_ENV'))=='PRODUCTION'){
			$paramList["ORDER_ID"] = $ORDER_ID;
		} else {
			$paramList["ORDER_ID"] = strtoupper(env('APP_ENV'))."_".$ORDER_ID; 
		}
		$paramList["CUST_ID"] = $CUST_ID;
		if($RECURR == 'TRUE'){
		$paramList["INDUSTRY_TYPE_ID"] = config('epicconfig.PAYTM.PAYTM_INDUSTRY_TYPE_ID');
		$paramList["CHANNEL_ID"] = config('epicconfig.PAYTM.PAYTM_CHANNEL_ID'); //"WEB";
		$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
		$paramList["WEBSITE"] =  config('epicconfig.PAYTM.PAYTM_MERCHANT_WEBSITE');

		
		if(!empty($request->post('subscription_mobileno'))){
			$paramList["MOBILE_NO"] = $request->post('subscription_mobileno');	
		}
		$paramList["REQUEST_TYPE"] = "SUBSCRIBE";
		$paramList["SUBS_SERVICE_ID"] = $paramList["ORDER_ID"];
		$paramList["SUBS_AMOUNT_TYPE"] = "FIX";
		$paramList["SUBS_FREQUENCY_UNIT"] = "DAY";
		$paramList["SUBS_FREQUENCY"] = "1"; 
		$paramList["SUBS_ENABLE_RETRY"]	= "0";
		$paramList["SUBS_START_DATE"] = date("Y-m-d",strtotime($order['subscription_start_date'])); 
		$paramList["SUBS_EXPIRY_DATE"] = date("Y-m-d",strtotime($order['subscription_end_date'])); 
		/*if($request->post('payMode')=="CCDC"){
			$paramList["SUBS_PPI_ONLY"] = "N";
			$paramList["SUBS_PAYMENT_MODE"]	= $request->post('payment_option_ptm'); 
		} else {
			$paramList["SUBS_PPI_ONLY"] = "Y";
			$paramList["SUBS_PAYMENT_MODE"]	= "PPI";
		}*/
		$paramList["SUBS_PPI_ONLY"] = "";
		//$paramList["SUBS_PAYMENT_MODE"]	= "CC";
		$paramList["SUBS_GRACE_DAYS"] = "0";
		$paramList['CALLBACK_URL'] = url('/paytm/payloadresponse');
		}
        else{

			// Create an array having all required parameters for creating checksum.
			$paramList["MID"] = config('epicconfig.PAYTM.PAYTM_MERCHANT_ID');
			$paramList["ORDER_ID"] = $ORDER_ID;
			$paramList["CUST_ID"] = $CUST_ID;
			$paramList["INDUSTRY_TYPE_ID"] = config('epicconfig.PAYTM.PAYTM_INDUSTRY_TYPE_ID');
			$paramList["CHANNEL_ID"] = config('epicconfig.PAYTM.PAYTM_CHANNEL_ID'); //"WEB";
			$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
			$paramList["WEBSITE"] =  config('epicconfig.PAYTM.PAYTM_MERCHANT_WEBSITE');
			//$paramList["CALLBACK_URL"] = config('epicconfig.PAYTM.PAYTM_ANDROID_CALLBACK_URL').$paramList["ORDER_ID"];	
			$paramList["CALLBACK_URL"] = url('/paytm/payloadresponse');	
         	}
        

		$user = $request->session()->get('user');
		Log::info("-----paytm checksum parameters----");
		Log::debug(json_encode($paramList,JSON_UNESCAPED_SLASHES));
		Log::info("-----END----------------------");
		include(app_path().'/Libraries/encdec_paytm.php');
		//$checkSum = getChecksumFromString(json_encode($paramList,JSON_UNESCAPED_SLASHES), config('epicconfig.PAYTM.PAYTM_MERCHANT_KEY'));
		$checkSum = getChecksumFromArray($paramList,config('epicconfig.PAYTM.PAYTM_MERCHANT_KEY'));
		Log::info("-----checksum: ".$checkSum."----------------------");
		if(strtoupper(env('APP_ENV'))=='PRODUCTION'){
			$PAYTM_TXN_URL = 'https://securegw.paytm.in/order/process';
		} else {
			$PAYTM_TXN_URL = 'https://securegw-stage.paytm.in/order/process';
		}
		Log::info("-----paytm checkout request---paramcount:".count($paramList)."--");
		Log::debug(json_encode($paramList,JSON_UNESCAPED_SLASHES));
		Log::info("-----END----------------------");
 		return view('epicon.paytmredirect',compact('checkSum','PAYTM_TXN_URL','paramList'));
	}

	public function payloadresponse(){
		$request = Request();
		$paytmChecksum = "";
		$paramList = array();
		$isValidChecksum = "FALSE";

		$paramList = $request->post();
		Log::info("-----paytm checkout response-----");
		Log::debug(json_encode($paramList,JSON_UNESCAPED_SLASHES));
		Log::info("-----END----------------------");
		include(app_path().'/Libraries/encdec_paytm.php');
		if(!empty($request->post("TXNID")) && empty($request->post("CHECKSUMHASH"))){
			$message = "You have cancelled the transaction.";
			return redirect('/getSubscription')->with('message',$message);
		} else if(!empty($request->post("TXNID")) && !empty($request->post("CHECKSUMHASH"))){
			$isValidChecksum = verifychecksum_e($paramList, config('epicconfig.PAYTM.PAYTM_MERCHANT_KEY'), $request->post("CHECKSUMHASH")); 
		} else if(!empty($request->post("TXN_ID")) && !empty($request->post("REQUECOUNT")) && $request->post("REQUECOUNT") == 0 ){
			$isValidChecksum = 'TRUE';
		}
		if($isValidChecksum == "TRUE") {
			if ($request->post("STATUS") == "TXN_SUCCESS" || $request->post("STATUS") == "PENDING") {
				if(!empty($paramList['SUBS_ID'])){
					$paramList['TRANSACTION_MODE'] = 'subscription';	
				}
				$updateOrderResponse = $this->updateSubscription($paramList,'paytm');
				if($updateOrderResponse['success']==true){
					$message = "You have successfully purchased a subscription plan.";
					$purchasedPlan_id = "";
					if(!empty($updateOrderResponse['subscription_data'])){
						$purchasedPlan_id = $updateOrderResponse['subscription_data']['plan_id'];
					}
					if($request->post("STATUS") == "TXN_SUCCESS"){
						$eventCat = 'Subscription Success'; $authEventTrack = "PAYTM-Success-".$purchasedPlan_id;
					} else if($request->post("STATUS") == "PENDING"){
						$message = "Please wait. Transaction is in process";
						$eventCat = 'Subscription Attempt'; $authEventTrack = "PAYTM-TransactionPending";
					}
				} else {
					$message = 'Error occured. Please wait...';
					$eventCat = 'Subscription Aborted'; $authEventTrack = "PAYTM-Aborted";
				}
			}  else {
				$message = "You have cancelled the transaction.";
				if ($request->post('RESPCODE') == "141" || $request->post('RESPCODE') == "2271" || $request->post('RESPCODE') == "2272") {
					$message = "You have cancelled the transaction.";
					$eventCat = 'Subscription Failure'; $authEventTrack = "PAYTM-TransactionCancelled"; 
				} else if(in_array($request->post('RESPCODE'),["202","205","208","220","296","401","402"])){
					$message = "Transaction Failed.";
					$eventCat = 'Subscription Failure'; $authEventTrack = "PAYTM-TransactionDeclined";
				} else {
					$message = "Transaction Failed.";
					$eventCat = 'Subscription Failure'; $authEventTrack = "PAYTM-Failure";
				}
			}
		} else {
			$eventCat = 'Subscription Failure'; $authEventTrack = "PAYTM-CancelledOrDeclinedOrError";
			
		}
		return redirect('/getSubscription')->with(['message'=>$message,'eventCat'=>$eventCat,'authEventTrack'=>$authEventTrack]);
	}
	public function androidCreateSubscriptionAtPaytmCheckout(){
        $checkSum = "";
        $request = Request();
        $paramList = array();
        //$ORDER_ID = '13343';
        //$CUST_ID = 'kiranaaa@gmail.com';
        //$RECURR = 'FALSE';
        $ORDER_ID = $request->post('order_id');
        $CUST_ID = $request->post('user_id');
        $RECURR = $request->post('recurring');
        //dd($ORDER_ID,$CUST_ID,$RECURR);
        if(strtoupper(env('APP_ENV'))=='PRODUCTION'){
            $TXN_AMOUNT = $request->order_value;
        } else {
            $TXN_AMOUNT = "1";
        }
        $paramList["MID"] = config('epicconfig.PAYTM.PAYTM_MERCHANT_ID');
        if(strtoupper(env('APP_ENV'))=='PRODUCTION'){
            $paramList["ORDER_ID"] = $ORDER_ID;
        } else {
            $paramList["ORDER_ID"] = strtoupper(env('APP_ENV'))."_".$ORDER_ID;
        }
        $paramList["CUST_ID"] = $CUST_ID;
        if($RECURR == 'true'){
        $paramList["INDUSTRY_TYPE_ID"] = config('epicconfig.PAYTM.PAYTM_INDUSTRY_TYPE_ID');
        $paramList["CHANNEL_ID"] = config('epicconfig.PAYTM.PAYTM_CHANNEL_ID'); //"WEB";
        $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
        $paramList["WEBSITE"] =  config('epicconfig.PAYTM.PAYTM_MERCHANT_WEBSITE');

        if(!empty($request->post('subscription_mobileno'))){
            $paramList["MOBILE_NO"] = $request->post('subscription_mobileno');
        }
        $paramList["REQUEST_TYPE"] = "SUBSCRIBE";
        $paramList["SUBS_SERVICE_ID"] = $paramList["ORDER_ID"];
        $paramList["SUBS_AMOUNT_TYPE"] = "FIX";
        $paramList["SUBS_FREQUENCY_UNIT"] = "DAY";
        $paramList["SUBS_FREQUENCY"] = $request->post('validity');
        $paramList["SUBS_ENABLE_RETRY"]	= "0";
//        $paramList["SUBS_START_DATE"] = date("Y-m-d",strtotime($request->subscription_start_date));
//        $paramList["SUBS_EXPIRY_DATE"] = date("Y-m-d",strtotime($request->subscription_end_date));
        //$paramLists['VALIDITY'] = $request->post('validity');
        $paramLists['VALIDITY'] = $request->post('validity');
        if($paramList['VALIDITY'] == '90'){

           // $paramList["SUBS_START_DATE"] = $request->post('subscription_start_date');
            $paramList["SUBS_START_DATE"] = date("Y-m-d",strtotime($request->subscription_start_date));
            $paramList["SUBS_EXPIRY_DATE"] = date("Y-m-d",strtotime($paramList['SUBS_START_DATE']." + ".$paramLists['VALIDITY']." days")); //
            //dd($paramList["SUBS_EXPIRY_DATE"]);
        }else{
            //$paramList['SUBS_START_DATE'] = $request->post('subscription_start_date');
            $paramList["SUBS_START_DATE"] = date("Y-m-d",strtotime($request->subscription_start_date));
            $paramList["SUBS_EXPIRY_DATE"] = date("Y-m-d",strtotime($paramList['SUBS_START_DATE']." + ".$paramLists['VALIDITY']." days"));
        }
        /*if($request->post('payMode')=="CCDC"){
            $paramList["SUBS_PPI_ONLY"] = "N";
            $paramList["SUBS_PAYMENT_MODE"]	= $request->post('payment_option_ptm');
        } else {
            $paramList["SUBS_PPI_ONLY"] = "Y";
            $paramList["SUBS_PAYMENT_MODE"]	= "PPI";
        }*/
        $paramList["SUBS_PPI_ONLY"] = "";
        //$paramList["SUBS_PAYMENT_MODE"]	= "CC";
        $paramList["SUBS_GRACE_DAYS"] = "0";
        $paramList['CALLBACK_URL'] = url('/paytm/payloadresponseandroid');
        //$user = $request->session()->get('user');
        
        }
        else{

			// Create an array having all required parameters for creating checksum.
			$paramList["MID"] = config('epicconfig.PAYTM.PAYTM_MERCHANT_ID');
			$paramList["ORDER_ID"] = $ORDER_ID;
			$paramList["CUST_ID"] = $CUST_ID;
			$paramList["INDUSTRY_TYPE_ID"] = config('epicconfig.PAYTM.PAYTM_INDUSTRY_TYPE_ID');
			$paramList["CHANNEL_ID"] = config('epicconfig.PAYTM.PAYTM_CHANNEL_ID'); //"WEB";
			$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
			$paramList["WEBSITE"] =  config('epicconfig.PAYTM.PAYTM_MERCHANT_WEBSITE');
			//$paramList["CALLBACK_URL"] = config('epicconfig.PAYTM.PAYTM_ANDROID_CALLBACK_URL').$paramList["ORDER_ID"];	
			$paramList["CALLBACK_URL"] = url('/paytm/payloadresponseandroid');	
         	}
        Log::info("-----paytm checksum parameters----");
        Log::debug(json_encode($paramList,JSON_UNESCAPED_SLASHES));
        Log::info("-----END----------------------");
        include(app_path().'/Libraries/encdec_paytm.php');
        //$checkSum = getChecksumFromString(json_encode($paramList,JSON_UNESCAPED_SLASHES), config('epicconfig.PAYTM.PAYTM_MERCHANT_KEY'));
        $checkSum = getChecksumFromArray($paramList,config('epicconfig.PAYTM.PAYTM_MERCHANT_KEY'));
        //dd($paramList,config('docubayconfig.PAYTM.PAYTM_MERCHANT_KEY'),$checkSum);
        Log::info("-----checksum: ".$checkSum."----------------------");
        if(strtoupper(env('APP_ENV'))=='PRODUCTION'){
        	$PAYTM_TXN_URL = 'https://securegw.paytm.in/order/process';
	    } else {
	    	$PAYTM_TXN_URL = 'https://securegw-stage.paytm.in/order/process';	
	    }
        Log::info("-----paytm checkout request---paramcount:".count($paramList)."--");
        Log::debug(json_encode($paramList,JSON_UNESCAPED_SLASHES));
        Log::info("-----END----------------------");
        return view('epicon.paytmredirect',compact('checkSum','PAYTM_TXN_URL','paramList'));

        
    }
    public function androidpayloadresponse(){
        $request = Request();
        $paytmChecksum = "";
        $paramList = array();
        $isValidChecksum = "FALSE";
        $paramList = $request->post();
        Log::info("-----paytm checkout android response-----");
        Log::debug(json_encode($paramList,JSON_UNESCAPED_SLASHES));
        Log::info("-----END----------------------");
        include(app_path().'/Libraries/encdec_paytm.php');
        if(!empty($request->post("TXNID")) && !empty($request->post("CHECKSUMHASH"))){
            /*$message = "You have successfully purchased a subscription plan.";
            if(!empty($paramList['SUBS_ID'])){
                    $paramList['TRANSACTION_MODE'] = 'subscription';
                }
            $updateOrderResponse = $this->updateSubscription($paramList,'paytm');*/

            //return response()->json(['status' => $request->post("STATUS"), 'TXNID' => $request->post("TXNID"), 'RESPMSG' => $request->post("RESPMSG"),'TXNAMOUNT' => $request->post("TXNAMOUNT")]);
            //return redirect('/getSubscription')->with('message',$message);
            $paramList['status'] = $request->post("STATUS");
            //return json_encode(['status' => $request->post("STATUS"), 'TXNID' => $request->post("TXNID"), 'RESPMSG' => $request->post("RESPMSG"),'TXNAMOUNT' => $request->post("TXNAMOUNT")]);
            return json_encode($paramList);
        }
        else if ($request->post("STATUS") == "TXN_FAILURE"){
            $message = "Transaction Failed.";
            //return response()->json(['status' => $request->post("TXN_FAILURE"), 'RESPCODE' => $request->post("RESPCODE"), 'RESPMSG' => $request->post("RESPMSG")]);
            return json_encode(['status' => $request->post("TXN_FAILURE"), 'RESPCODE' => $request->post("RESPCODE"), 'RESPMSG' => $request->post("RESPMSG")]);
        }else if(!empty($request->post("TXNID")) && !empty($request->post("CHECKSUMHASH"))){
            $isValidChecksum = verifychecksum_e($paramList, config('docubayconfig.PAYTM.PAYTM_MERCHANT_KEY'), $request->post("CHECKSUMHASH"));
        } else if(!empty($request->post("TXN_ID")) && !empty($request->post("REQUECOUNT")) && $request->post("REQUECOUNT") == 0 ){
            $isValidChecksum = 'TRUE';
        }
        if($isValidChecksum == "TRUE") {
            if ($request->post("STATUS") == "TXN_SUCCESS" || $request->post("STATUS") == "PENDING") {
                if(!empty($paramList['SUBS_ID'])){
                    $paramList['TRANSACTION_MODE'] = 'subscription';
                }
                $updateOrderResponse = $this->updateSubscription($paramList,'paytm');
                if($updateOrderResponse['success']==true){
                    $message = "You have successfully purchased a subscription plan.";
                    $purchasedPlan_id = "";
                    if(!empty($updateOrderResponse['subscription_data'])){
                        $purchasedPlan_id = $updateOrderResponse['subscription_data']['plan_id'];
                    }
                    if($request->post("STATUS") == "TXN_SUCCESS"){
                        $eventCat = 'Subscription Success'; $authEventTrack = "PAYTM-Success-".$purchasedPlan_id;$status = 'true';
                    } else if($request->post("STATUS") == "PENDING"){
                        $message = "Please wait. Transaction is in process";
                        $eventCat = 'Subscription Attempt'; $authEventTrack = "PAYTM-TransactionPending";$status = 'false';
                    }
                } else {
                    $message = 'Error occured. Please wait...';
                    $eventCat = 'Subscription Aborted'; $authEventTrack = "PAYTM-Aborted";$status = 'false';
                }
            }
            else {
                $message = "You have cancelled the transaction.";
                if ($request->post('RESPCODE') == "141" || $request->post('RESPCODE') == "2271" || $request->post('RESPCODE') == "2272") {
                    $message = "You have cancelled the transaction.";
                    $eventCat = 'Subscription Failure'; $authEventTrack = "PAYTM-TransactionCancelled";$status = 'false';
                } else if(in_array($request->post('RESPCODE'),["202","205","208","220","296","401","402"])){
                    $message = "Transaction Failed.";
                    $eventCat = 'Subscription Failure'; $authEventTrack = "PAYTM-TransactionDeclined";$status = 'false';
                } else {
                    $message = "Transaction Failed.";
                    $eventCat = 'Subscription Failure'; $authEventTrack = "PAYTM-Failure";$status = 'false';
                }
            }
        } else {
            $eventCat = 'Subscription Failure'; $authEventTrack = "PAYTM-CancelledOrDeclinedOrError";$status = 'false';

        }
        return response()->json(['status' => $status, 'response' => ['msg' => $message,'autheventtrack' => $authEventTrack,'eventcat' => $eventCat]]);
        //return redirect('/getSubscription')->with(['message'=>$message,'eventCat'=>$eventCat,'authEventTrack'=>$authEventTrack]);
    }
}
