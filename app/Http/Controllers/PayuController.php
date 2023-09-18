<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Softon\Indipay\Facades\Indipay;
use Illuminate\Support\Facades\Log;
use Request;
use Route;
use Auth;
use URL;
use Session;
use Redirect;
use Input;
use App\Traits\payments;
use Ixudra\Curl\Facades\Curl;

/*
 * @package laravel
 * @subpackage Controller
 */
class PayuController extends Controller
{
	use payments;    
	public function __paymentprocess($order,$currency,$payment_type){
	    /* All Required Parameters by your Gateway */
        $request = Request();
        // d($order);exit();
        $order_number = $order['order_id'];
        $totalamount = $order['order_value'];
        $plan_id = $order['plan_id'];
        $timestamp =$order['created_date'];
        @$validity =$order['validity'];
        $splitTimeStamp = explode("T",$timestamp);
        $newDate = $splitTimeStamp[0];
        $startdate = date("d-m-Y", strtotime($newDate));
        $finalcurrency = $currency;
        if(!empty($order['eq_amount']) && !empty($request->post('subscription_eq_amount'))){
            //$finalcurrency = 'USD';
            //$totalamount = $order['eq_amount'];
            $totalamount = $order['order_value'];
            $finalcurrency = $currency;
        }
        $forcepg = $request->post('payment_method');

        if($finalcurrency == 'INR'){
            config(['epicconfig.PayUMoney.INDIPAY_MERCHANT_ID'=>config('epicconfig.INR_PayUMoney.INDIPAY_MERCHANT_ID')]);
            config(['epicconfig.PayUMoney.INDIPAY_ACCESS_CODE'=>config('epicconfig.INR_PayUMoney.INDIPAY_ACCESS_CODE')]);
            config(['epicconfig.PayUMoney.INDIPAY_WORKING_KEY'=>config('epicconfig.INR_PayUMoney.INDIPAY_WORKING_KEY')]);
        }
        

        if(strtoupper(env('APP_ENV'))=='PRODUCTION'){
            if ($request->post('device') == 'android' || $request->post('device') == 'ios'){
                    if (empty($request->post('email'))){
                        $parameters = ['tid' => time(),
                            'txnid' => $order_number,
                            'amount' => $totalamount,
                            'firstname' => $request->post('first_name'),
                            'email' => $request->post('mobile'),
                            'phone' => $request->post('mobile'),
                            'productinfo' => 'epicon ' . $plan_id];
                    }
                    else{
                        $parameters = ['tid' => time(),
                            'txnid' => $order_number,
                            'amount' => $totalamount,
                            'firstname' => $request->post('first_name'),
                            'email' => $request->post('email'),
                            'phone' => '',
                            'productinfo' => 'epicon ' . $plan_id];
                    }

                    if($finalcurrency == 'USD'){
                        $rate = $this->getConvertedPrice($finalcurrency,'INR');
                        $totalamount = (!empty($totalamount) && $rate!==false) ? floor($rate) * $totalamount : env('INR_TO_USD_RATE',70) * $totalamount;
                        $parameters['amount'] = round(floor($totalamount), 2);
                    }
            } else {
                $user = getLoggedInUser();
                echo "user---";dd($user->user_id); exit;
                $firstname = $user->name;
                if(empty($firstname)){
                    $firstname = $user->user_id;    // firstname is manadatory in payu
                }
                if($finalcurrency == 'INR'){
                    $parameters = ['tid' => time(),
                        'txnid' => $order_number,
                        'amount' => $totalamount,
                        'firstname'=>$firstname,
                        'email'=>$user->user_id,
                        'phone'=>'',
                        'si'=>1,
                        'productinfo'=>'epicon '.$plan_id,
                        //'udf1'=>$user->user_id.'#'.$user->user_subscription_type
                    ];
                    // dd($parameters);
                }else{
                    $parameters = ['tid' => time(),'txnid' => $order_number,'amount' => $totalamount,'firstname'=>$firstname,'email'=>$user->user_id,'phone'=>'','productinfo'=>'epicon '.$plan_id];
                    if($finalcurrency == 'USD'){
                        $rate = $this->getConvertedPrice($finalcurrency,'INR');
                        $totalamount = (!empty($totalamount) && $rate!==false) ? floor($rate) * $totalamount : env('INR_TO_USD_RATE',70) * $totalamount;
                        $parameters['amount'] = round(floor($totalamount), 2);
                    }
                }
            }
        } else {
            $totalamount = 1.00;
            if ($request->post('device') == 'android' || $request->post('device') == 'ios'){
                if (empty($request->post('email'))){
                    $parameters = ['tid' => time(),
                        'txnid' => $order_number,
                        'amount' => $totalamount,
                        'firstname' => $request->post('first_name'),
                        'email' => $request->post('mobile'),
                        'phone' => $request->post('mobile'),
                        'productinfo' => 'epicon ' . $plan_id];
                }
                else{
                    $parameters = ['tid' => time(),
                        'txnid' => $order_number,
                        'amount' => $totalamount,
                        'firstname' => $request->post('first_name'),
                        'email' => $request->post('email'),
                        'phone' => '9999999999',
                        'productinfo' => 'epicon ' . $plan_id];
                }
                if($finalcurrency == 'USD'){
                    $rate = $this->getConvertedPrice($finalcurrency,'INR');
                    $totalamount = (!empty($totalamount) && $rate!==false) ? floor($rate) * $totalamount : env('INR_TO_USD_RATE',70) * $totalamount;
                    $parameters['amount'] = round(floor($totalamount), 2);
                }
                Log::info("----------#####log for ios full renew plan for payu -----------");
                Log::debug(json_encode($parameters));
                Log::info("-----END ios full renew plan for payu----------------------");
            }else {
                $user = getLoggedInUser();
                if($finalcurrency == 'INR'){
                    
                    $parameters = ['tid' => time(),
                        'txnid' => $order_number,
                        'amount' => $totalamount,
                        'firstname'=>$user->name,
                        'email'=>$user->user_id,
                        'phone'=>'',
                        'si'=>1,
                        'productinfo'=>'epicon '.$plan_id,
                        //'udf1'=>$user->user_id.'#'.$user->user_subscription_type
                    ];
                }else{
                    $parameters = ['tid' => time(),'txnid' => $order_number,'amount' => $totalamount,'firstname'=>$user->name,'email'=>$user->user_id,'phone'=>'','productinfo'=>'epicon '.$plan_id];
                    if($finalcurrency == 'USD'){
                        $rate = $this->getConvertedPrice($finalcurrency,'INR');
                        $totalamount = (!empty($totalamount) && $rate!==false) ? floor($rate) * $totalamount : env('INR_TO_USD_RATE',70) * $totalamount;
                        $parameters['amount'] = round(floor($totalamount), 2);
                    }
                }
            }
        }
        if(config('epicconfig.PAYUMONEY.ENABLE_RECURRING_AT_FROM_TRANSACTION')==true){
                $billingCycle = 'MONTHLY';
                if($plan_id == 'epic_in_pl_1' || $plan_id == 'epic_row_pl_1'){
                    $billingInterval = 1;
                    $newstartdate = date("Y-m-d");
                    $billingCycle = 'DAILY';
                    $newstartdate = date("Y-m-d");
                    $endstartdate = date("Y-m-d",strtotime("+99 year"));
                }
                else if ($plan_id == 'epic_in_pl_2' || $plan_id == 'epic_row_pl_2') {
                    $billingInterval = 3;
                    $newstartdate = date("Y-m-d");
                    $billingCycle = 'DAILY';
                    $newstartdate = date("Y-m-d");
                    $endstartdate = date("Y-m-d",strtotime("+99 year"));
                }
                else if ($plan_id == 'epic_in_pl_3' || $plan_id == 'epic_row_pl_3') {
                    $billingInterval = 6;
                    $newstartdate = date("Y-m-d");
                    $endstartdate = date("Y-m-d",strtotime("+99 year"));
                }
                else{
                    $billingInterval = 12;
                    $newstartdate = date("Y-m-d");
                    $endstartdate = date("Y-m-d",strtotime("+99 year"));
                }
                $parameters['si'] = 1;
                $parameters['si_details'] = json_encode([
                    'billingAmount'=>$totalamount,
                    'billingCurrency'=>$finalcurrency,
                    'billingCycle'=>$billingCycle,
                    'billingInterval'=>$billingInterval,
                    'paymentStartDate'=>$newstartdate,
                    'paymentEndDate'=>$endstartdate
                ]);
        }

        if(in_array($payment_type,['CC','DC','NB','CASH','UPI'])){
            $parameters['pg'] = $payment_type;    
        }
        
        // if($parameters['pg']=='UPI'){
        //     $parameters['bankcode'] = "INTENT";    
        // }
        //$parameters['txn_s2s_flow'] = 2;
        $parameters['curl'] = config('epicconfig.PAYUMONEY.RESPONSE_URL');
        $parameters['surl'] = config('epicconfig.PAYUMONEY.RESPONSE_URL');
        $parameters['furl'] = config('epicconfig.PAYUMONEY.RESPONSE_URL');
        Log::info("----------#####full parametes for log for ios full renew plan for payu -----------");
        Log::debug(json_encode($parameters));
        Log::info("-----full parametes for END ios full renew plan for payu----------------------");
        $request->session()->forget('orderdata');
        $request->session()->put('orderdata',$order);

        $request->session()->forget('payuParams');
        $request->session()->put('payuParams',$parameters);

        Log::info("-----PayUMoney Request Data------");
		Log::debug(json_encode($parameters));
		Log::info("-----End------");
		$orderD = Indipay::gateway('PayUMoney')->prepare($parameters);
        //$orderD = Indipay::prepare($parameters);
        return Indipay::process($orderD);
	}

    public function payuMoneyResponse()
    {
        // For default Gateway
        Log::info("-----PayuMoney Default Response start");
        $request = Request();
        Log::debug(json_encode($request->all()));
        Log::info("----------#####-----------");
        //Log::debug(json_encode($request));
        Log::info("-----END----------------------");
        $orderdata = $request->session()->get('orderdata');
        Log::info("-----Order Data-----------".json_encode($orderdata));
        $request->session()->forget('orderdata');
        $transactionCurrency = $request->session()->get('transactionCurrency');
        //For Payu GA events
        $pName = 'Monthly';
        if(isset($orderdata['plan_name'])){
            if($orderdata['plan_name']=="1 Year"){
                $pName = "Yearly";
            }
            if($orderdata['plan_name']=="6 Months"){
                $pName = "Half Yearly";
            }
            if($orderdata['plan_name']=="3 Months"){
                $pName = "Quarterly";
            }
            if($orderdata['plan_name']=="1 Month"){
                $pName = "Monthly";
            }
        }
        else{
            $orderdata['plan_name'] = '';
        }
        $paymentresponse = Indipay::gateway('PayUMoney')->response($request);
        Log::info("-----PayuMoney Response");
        Log::debug(json_encode($paymentresponse, JSON_UNESCAPED_SLASHES));
        Log::info("-----END----------------------");

        $trackingUSDAmount = '';
        if ($request->session()->has('userselectedplan')) {
            $userselectedplan = $request->session()->get('userselectedplan');
            if (isset($orderdata['plan_id']) && $orderdata['plan_id'] == $userselectedplan['id'] && !empty($userselectedplan['eq_usd_price'])) {
                $trackingUSDAmount = $userselectedplan['eq_usd_price'];
            }
        }
        if ($transactionCurrency != 'USD') {
            $rate = $this->getConvertedPrice($transactionCurrency, 'USD');
            $trackingUSDAmount = (empty($trackingUSDAmount) && $rate !== false) ? $rate * $paymentresponse['amount'] : $trackingUSDAmount;
        }
        Log::info("-----trackingUSDAmount: " . $trackingUSDAmount . "------");
        $trackingSubscription['status'] = '';
        $trackingSubscription['success'] = '';
        $trackingSubscription['subscription_data'] = [
            "_id" => md5($paymentresponse['txnid']),
            "plan_amount" => ($paymentresponse['amount']),
            "transaction_id" => $paymentresponse['txnid'],
            "order_id" => isset($orderdata['order_id']) ? $orderdata['order_id'] : '',
            "user_id" => isset($orderdata['user_id']) ? $orderdata['user_id'] : '',
            "plan_id" => isset($orderdata['plan_id']) ? $orderdata['plan_id'] : '',
            "plan_name" => isset($orderdata['plan_name']) ? $orderdata['plan_name'] : '',
            "payment_gateway" => "payumoney"
        ];
        $paymtentStatus = strtolower($paymentresponse['status']);
        $authEventTrack = 'Subscription purchased/payment response is invalid';
        $app_test =  Session::get('app_test');
        $b2b_data = $request->session()->get('b2b_data_pack');

        //Moengage event tracker
        $menuUserData=userData();
        $commonData=getCommonProperties();
        $subSDate = isset($orderdata['subscription_start_date']) ? $orderdata['subscription_start_date'] : '';
        $subEDate = isset($orderdata['subscription_end_date']) ? $orderdata['subscription_end_date'] : '';
        $moengage_subscription_plan = array(
            'Plan Type' => $pName,
            'Plan Amount' => $paymentresponse['amount'],
            'Currency' => $transactionCurrency,
            'Plan Start Date' => $subSDate,
            'Plan Expire Date' => $subEDate,
        );
        $commonMenuUserData=array_merge($menuUserData,$commonData,$moengage_subscription_plan);        

        if(($paymtentStatus == "success" || $paymtentStatus == "pending" || $paymtentStatus == "failure")){
            Log::info("-----before updateSubscription: ------");
            //ZION Recurring Start
            $user_id = $user_session_id = 0;
            if(($user = getLoggedInUser())!=false) {
                $user_id = $user->user_id;
                Log::info($user_id);
            } else {
                Log::info("user session information blank");
            }
            $paymentresponse['order_id'] = isset($orderdata['order_id']) ? $orderdata['order_id'] : '';
            if(strtoupper(env('APP_ENV'))=='PRODUCTION'){
                if(strtoupper(env('ANDROID_APP_TEST'))=='YES' && $app_test=='Y'){
                    Log::info("-----######Android---TESTMODE--". $orderdata['order_id']."--------"); 
                    /********** REMOVE UPDATE CALL as per new payment flow */
                } else {  
                    /*if($paymtentStatus == "failure" || $paymtentStatus == "pending"){
                        $paymentresponse['note'] = 'graceperiodpack';
                    } 
                    $trackingSubscription = $updateOrderResponse = $this->updateSubscription($paymentresponse, 'payumoney');
                    Log::info("-----update order api Response");
                    Log::debug(json_encode($updateOrderResponse, JSON_UNESCAPED_SLASHES));
                    Log::info("-----END----------------------");*/
                }
            } else {
                if(strtoupper(env('ANDROID_APP_TEST'))=='YES' && $app_test=='Y'){
                    Log::info("-----######Android---TESTMODE--". $orderdata['order_id']."--------"); 
                    /********** REMOVE UPDATE CALL as per new payment flow */
                } else {  
                    /*if($paymtentStatus == "failure" || $paymtentStatus == "pending"){
                        $paymentresponse['note'] = 'graceperiodpack';
                    } 
                    $trackingSubscription = $updateOrderResponse = $this->updateSubscription($paymentresponse, 'payumoney');
                    Log::info("-----update order api Response");
                    Log::debug(json_encode($updateOrderResponse, JSON_UNESCAPED_SLASHES));
                    Log::info("-----END----------------------");*/
                }
            }
            if ($paymtentStatus == "success") {
                $purchasedPlan_id = "";
                if (!empty($updateOrderResponse['subscription_data'])) {
                    $purchasedPlan_id = $updateOrderResponse['subscription_data']['plan_id'];
                }
                $message = 'You have successfully purchased a subscription plan.';
                $eventCat = 'Subscription Success';
                //$authEventTrack = "PayuMoney-Success-" . $purchasedPlan_id;
                $authEventTrack = $pName;
                if($b2b_data == 'b2b_data_pack'){
                    $eventCat = 'Subscription Renewed';
                    $commonMenuUserData['Mobile'] = (isset($user->mobile) && !empty($user->mobile)) ? $user->mobile : '';
                    EventPush($user_id,'Subscribtion Renewal',$commonMenuUserData, true, false);
                }else{
                    $commonMenuUserData['Mobile'] = (isset($user->mobile) && !empty($user->mobile)) ? $user->mobile : '';
                    EventPush($user_id,'Subscribe',$commonMenuUserData, true, false);
                }
            } else {
                $message = 'While your payment is in the process of being verified, your grace period has been activated';
                $eventCat = 'GP Subscription Success';
                $authEventTrack = "PayuMoney-Aborted  Pack Created";
                if($b2b_data == 'b2b_data_pack'){
                    $eventCat = 'GP Subscription Renewed';
                    $authEventTrack = "PayuMoney-Renewed-Aborted Pack Created";
                }
            }
        } else if ($paymtentStatus == "aborted") {
            $message = 'You have cancelled the transaction.';
            $eventCat = 'Subscription Failure';
            //$authEventTrack = "PayuMoney-Cancelled";
            $authEventTrack = $pName;
            if($b2b_data == 'b2b_data_pack'){
                $eventCat = 'Subscription Renew Failure';
            }
        } else if ($paymtentStatus === "failure") {
            $message = 'The transaction has been declined.';
            $eventCat = 'Subscription Failure';
            //$authEventTrack = "PayuMoney-Declined";
            $authEventTrack = $pName;
            if($b2b_data == 'b2b_data_pack'){
                $eventCat = 'Subscription Renew Failure';
            }
        } else {
            $message = 'Error occured.';
            $eventCat = 'Subscription Failure';
            //$authEventTrack = "PayuMoney-Error";
            $authEventTrack = $pName;
            if($b2b_data == 'b2b_data_pack'){
                $eventCat = 'Subscription Renew Failure';
            }
        }

        //Store for GA tracking
        $request->session()->put('authEventTrack', $authEventTrack);
        $request->session()->put('eventCat', $eventCat);

        if (!empty($trackingUSDAmount)) $trackingSubscription['subscription_data']['Amount'] = $trackingUSDAmount;
        $b2b_data = $request->session()->get('b2b_data_pack');
        $android = Session::get('app');

        if ($b2b_data == 'b2b_data_pack') {
            $trackingSubscription['subscription_data']['landingnative'] = "true";
            return redirect('/getSubscriptionNative?reftoken=' . md5(time()))->with(['trackingSubscription' => $trackingSubscription]);

        }
        elseif ($android == 'app'){
            return redirect('/getSubscriptionNativeAndroid?reftoken=' . md5(time()))->with(['eventCat' => $eventCat, 'authEventTrack' => $authEventTrack, 'trackingSubscription' => $trackingSubscription]);

        }
        else {
            $request->session()->put('message',$message);
            return redirect('myaccount/view?reftoken='.md5(time()))->with(['trackingSubscription' => $trackingSubscription]);

        }
    }
    public function payuResponseHash(){
        // $request = Request();
        // $key = $request->post('key');
        $key=$_POST["key"];
        $txnid=$_POST["txnid"];
        $amount=$_POST["amount"]; //Please use the amount value from database
        $productinfo=$_POST["productinfo"];
        $firstname=$_POST["firstname"];
        $email=$_POST["email"];
        $status = $_POST["status"];
        $postedhash= $_POST["hash"];
        $salt="your salt key"; //Please change the value with the live salt for production environment

        //hash sequence
        //$responseHashSeq = $salt.'|'.$status.'|udf1|udf2|||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;

        $responseHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;

        $calculated_hash = hash("sha512", $responseHashSeq);
        Log::info("all posted variables:".print_r($_POST,true));
        Log::info("calculated hash:".$calculated_hash);

        if($calculated_hash==$postedhash){
            Log::info("transaction is valid");
        }
        else{
            Log::info("transaction tampered");
        }

        echo $calculated_hash;
    }

    public function payuNewHash(){
        $key=$_POST["key"];
        $txnid=$_POST["txnid"];
        $amount=$_POST["amount"]; //Please use the amount value from database
        $productinfo=$_POST["productinfo"];
        $firstname=$_POST["firstname"];
        $email=$_POST["email"];
        $salt="your salt key"; //Please change the value with the live salt for production environment

        //hash sequence
        //String hashSequence = key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5||||||salt;

        $hashSeq = $key.'|'.$txnid.'|'.$amount.'|'.$productinfo.'|'.$firstname.'|'.$email.'|||||||||||'.$salt;
        $hash = hash("sha512", $hashSeq);
        Log::info("all posted variables:".print_r($_POST,true));
        echo $hash;
    }

    public function transactioncallback()
    {
        $request = Request();
        $transaction = $request->post();
        Log::info("------paumoney transactioncallback response-----");
        Log::debug(json_encode($request->post()));
        Log::info("------End-----");
        
        $orderstraing = $transaction['mihpayid'];
        $order_id = $transaction['txnid'];
        $mode = $transaction['mode'];
        $status = $transaction['status'];
        $payuunmappedstatus = $transaction['unmappedstatus'];
                // callbacked disabled
                /*if(
                    (
                        $status=='failure' && ($payuunmappedstatus=='failure' || $payuunmappedstatus=='auth' || $payuunmappedstatus=='dropped')
                    ) || 
                    ($status=='success' && $payuunmappedstatus=='captured' && $mode=='UPI')
                ){
                    $ordsPostedAndroid = ['order_id'=>$order_id];
                    Log::info("------paumoney getsingleorder api request params -----");
                    Log::debug(json_encode($ordsPostedAndroid));
                    Log::info("------End-----");
                    $curlRespAndroid = $this->CurlAPICron('cms/getsingleorder','POST',$ordsPostedAndroid,'u9XBBnHOHQ5qiQ7Vgaf31K640F4OGiyN');
                    Log::info("------paumoney getsingleorder api response -----");
                    Log::debug(json_encode($curlRespAndroid));
                    Log::info("------End-----");
                    if($curlRespAndroid['success']==true && $curlRespAndroid['order_data'] && $curlRespAndroid['order_data']['order_status']=='initiated'){
                        $order_data = $curlRespAndroid['order_data'];
                        unset($order_data['_id']);
                        unset($order_data['__v']);
                        $order_data['payment_mode'] = $mode;
                        $order_data['order_status'] = 'Complete';
                        $order_data['note'] = 'PackCreatedByCallback';
                        Log::info("------paumoney cms-updateorder api request -----");
                        Log::debug(json_encode($order_data));
                        Log::info("------End-----");
                        $curlRespAndroidOrder = $this->CurlAPICron('cms/updateorder','POST',$order_data,'u9XBBnHOHQ5qiQ7Vgaf31K640F4OGiyN');
                        Log::info("------paumoney cms-updateorder api response -----");
                        Log::debug(json_encode($curlRespAndroidOrder));
                        Log::info("------End-----");
                    } else {
                        Log::info("------payu callback checked done. pack exist -----");
                    }   
                }*/
    }

	public function payuRecurringResponse()
    {
        $request = Request();
        $paymentresponse = $request->post();
        Log::info("------paumoney recurringh response-----");
        Log::debug(json_encode($request->post()));
        Log::info("------End-----");
        
        if($paymentresponse['status']=="Enabled" || $paymentresponse['paymentStatus']=="Due"){
            $postedData = Array(
                    'order_receipt' => $paymentresponse['subscriptionId'],
                    'transaction_id' => $paymentresponse['authRefId']
            );
            Log::info("-----payu cms updateorderReceipt API Request");
            Log::debug(json_encode($postedData,JSON_UNESCAPED_SLASHES));
            Log::info("-----END----------------------");
            $recurResponse = CurlAPI("v2/cms/updateorderReceipt",'POST',$postedData);
            Log::info("-----payu cms updateorderReceipt API Response");
            Log::debug(json_encode($recurResponse,JSON_UNESCAPED_SLASHES));
            Log::info("-----END----------------------");
        }

        if($paymentresponse['paymentStatus']=="Paid"){
            $postedData = Array(
                    'subscriptionId' => $paymentresponse['subscriptionId'],
                    'transaction_id' => $paymentresponse['authRefId'],
                    'bank_ref_no' => $paymentresponse['invoiceId'],
                    'order_status' => 'Complete',
                    'subscriptionPaymentMode' => 'payurecurring',
                    'payment_gateway'=>'PayU'
            );
            Log::info("-----payu cms recurring API Request");
            Log::debug(json_encode($postedData,JSON_UNESCAPED_SLASHES));
            Log::info("-----END----------------------");
            $recurResponse = CurlAPI("cms/ccavenuerecurringorder",'POST',$postedData);
            Log::info("-----payu cms recurring API Response");
            Log::debug(json_encode($recurResponse,JSON_UNESCAPED_SLASHES));
            Log::info("-----END----------------------");
            if($recurResponse['success']==true){
                $paymentstatus = 'success';
                $message = 'You have successfully purchased a subscription plan.';
                $eventCat = 'Subscription Success'; $authEventTrack = "PAYU-Success";
            }else{
                $message = 'The transaction has been declined.';
                $eventCat = 'Subscription Failure'; $authEventTrack = "PAYU-Declined";
                $paymentstatus = 'fail';
            }
            $trackingData = array();
            $trackingData = $recurResponse;
            return $this->getSubscriptionRecurrCleverTap($paymentstatus,$trackingData,$paymentresponse);
        }
        
    }

    public function _androidPayuUsingWeb(){
    	$checkSum = "";
		$request = Request();

        Log::info("-----Android Request Data------");
        Log::debug(json_encode($_GET));
        Log::info("-----End------");

		$paramList = array();
		$ORDER_ID = $request->get('order_id');
		$CUST_ID = $request->get('user_id');
		$order_number = $request->get('order_id');
        $totalamount = $request->get('order_value');
        $plan_id = $request->get('plan_id');
        $timestamp =$request->get('created_date');
        $validity =$request->get('validity');
        $splitTimeStamp = explode("T",$timestamp);
        $newDate = $splitTimeStamp[0];
        $startdate = date("d-m-Y", strtotime($newDate));
        $currency = $request->get('currency');
        $finalcurrency = $currency;
        $username = (!empty($request->get('firstname')) ? $request->get('firstname') : 'Guest');

        if(!empty($request->get('eq_amount')) && !empty($request->get('subscription_eq_amount'))){
             $totalamount = $request->get('order_value');
             $finalcurrency = $currency;
        }
        config(['indipay.payumoney.successUrl'=>config('epicconfig.PAYUMONEY.ANDROID_RESPONSE_URL')]);
        config(['indipay.payumoney.failureUrl'=>config('epicconfig.PAYUMONEY.ANDROID_RESPONSE_URL')]);
        if(strtoupper(env('APP_ENV'))=='PRODUCTION'){
            if($finalcurrency == 'INR'){
                $parameters = ['tid' => time(),
                'txnid' => $order_number,
                'amount' => $totalamount,
                'firstname'=>$username,
                'email'=>$CUST_ID,
                'phone'=>'',
                'productinfo'=>$plan_id
                ];
            }else{
                $parameters = ['tid' => time(),'txnid' => $order_number,'amount' => $totalamount,'currency'=>$finalcurrency];    
            }
        } else { 
            $parameters = ['tid' => time(),
                'txnid' => $order_number,
                'amount' => $totalamount,
                'firstname'=>$username,
                'email'=>$CUST_ID,
                'phone'=>'',
                'productinfo'=>$plan_id
            ];
        }
        if(!empty($_GET['pg'])){
            $parameters['pg'] = $_GET['pg'];  
        }
        //$forcepg = $request->get('pg');
        //$parameters['pg'] = $forcepg;
        // if($forcepg=='UPI'){
        //    $parameters['bankcode'] = "INTENT";    
        // }
        $parameters['curl'] = config('epicconfig.PAYUMONEY.ANDROID_RESPONSE_URL');
        $parameters['surl'] = config('epicconfig.PAYUMONEY.ANDROID_RESPONSE_URL');
        $parameters['furl'] = config('epicconfig.PAYUMONEY.ANDROID_RESPONSE_URL');

        $request->session()->forget('andpayuParams');
        $request->session()->put('andpayuParams',$parameters);

        Log::info("-----PayUMoney Request Data------");
		Log::debug(json_encode($parameters));
		Log::info("-----End------");
        
        $orderD = Indipay::gateway('PayUMoney')->prepare($parameters);
        //$orderD = Indipay::prepare($parameters);
        return Indipay::process($orderD);
    }

    public function _androidPayuresponse(){
    	// For default Gateway
        //Log::info("-----Android PayuMoney Default Response start");
        $request = Request();
        //Log::debug(json_encode($request));      
        $orderdata = $request->session()->get('orderdata');
        $request->session()->forget('orderdata');
        $andpayuParams = $request->session()->get('andpayuParams');
        $planid = $andpayuParams['productinfo'];

        //$paymentresponse = Indipay::response($request);   
        $paymentresponse = Indipay::gateway('PayUMoney')->response($request);
        Log::info("-----Android PayuMoney Response");
        Log::debug(json_encode($paymentresponse,JSON_UNESCAPED_SLASHES));
        Log::info("-----END----------------------");
        //return response()->json($paymentresponse,200)->header('Content-Type', 'application/json');
        $paymtentStatus = strtolower($paymentresponse['status']);
        if(config('epicconfig.PAYUMONEY.ENABLE_RECURRING_API')==true){
            if(($paymtentStatus == "success") || ($paymtentStatus == "awaited")){
                $paymentresponse['subscriptionId'] = $this->createsubscription($andpayuParams,$paymentresponse);
            }
        }
        //$result = $paymentresponse;
        $result = json_encode($paymentresponse);
        return view('epicon.android-json',compact('result'));
    }

    public function createsubscription($andpayuParams,$paymentresponse){
        $planid = $andpayuParams['productinfo'];
        $billingCycle = 'MONTHLY';
        if($planid == 'epic_in_pl_1' || $plan_id == 'epic_row_pl_1'){
                $billingInterval = 1;
               // $newstartdate = date("Y-m-d H:i:s",strtotime("+1 month"));
                $newstartdate = date("Y-m-d H:i:s");
                $newstartdate = str_replace(" ","T",$newstartdate).".000Z";            
                $billingCycle = 'DAILY';
            }
            else if ($planid == 'epic_in_pl_2' || $plan_id == 'epic_row_pl_2') {
                $billingInterval = 3;
                //$newstartdate = date("Y-m-d H:i:s",strtotime("+3 month"));
                $newstartdate = date("Y-m-d H:i:s");
                $newstartdate = str_replace(" ","T",$newstartdate).".000Z";
                $billingCycle = 'DAILY';
            }
            else if ($planid == 'epic_in_pl_3' || $plan_id == 'epic_row_pl_3') {
                $billingInterval = 6;
                $newstartdate = date("Y-m-d H:i:s",strtotime("+6 month"));
                $newstartdate = str_replace(" ","T",$newstartdate).".000Z";
            }
            else{
                $billingInterval = 12;
                $newstartdate = date("Y-m-d H:i:s",strtotime("+1 year"));
                $newstartdate = str_replace(" ","T",$newstartdate).".000Z";
            }
            //$postdata['merchantId'] = '5Z7qv4';
            $postdata['merchantId'] = config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY');
            $postdata['authRefId'] = $paymentresponse['mihpayid'];
            $postdata['subscriberEmail'] = $andpayuParams['user_id'];
            $postdata['subscriberMobile'] = '9999999999';
            //$newstartdate = date("Y-m-d H:i:s",strtotime("+1 days"));
            //$newstartdate = str_replace(" ","T",$newstartdate).".000Z";
            //$lastOneHour = date("Y-m-d H:i:s", strtotime("+1 days"));
            $postdata['subscriptionPlans'] = [0=>[
                'planName'=>$andpayuParams['name'],
                'startDate'=>$newstartdate,
                'totalCount'=>99,
                'billingInterval'=>$billingInterval,
                'billingCycle'=>$billingCycle,
                'amount'=>[
                    'value'=>number_format($paymentresponse['amount'],2),
                    'currency'=>"INR"
                ]
            ]];
           // $pass = 'merchantId:5Z7qv4|9S0qvfqO';
            $pass = 'merchantId:'.config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY').'|'.config('epicconfig.PAYUMONEY.PAYUMONEY_SALT');
            $signature_zion = hash('sha512',$pass);
            $postdata = json_encode($postdata);
            $subsURL = config('epicconfig.PAYUMONEY.SUBSCRIPTION_URL');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$subsURL."api/sub/v1/merchant/subscriptions");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$postdata);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = [
                'Content-Type: application/json',
                'X-PayU-Subscription-Signature: '.$signature_zion,
                ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $server_output = curl_exec ($ch);
            //print_r(json_decode($server_output));
            curl_close ($ch);
            Log::info("-----PayuMoney subscription Response");
            Log::debug($server_output);
            Log::info("-----END----------------------");
            //$payresponse = json_decode($server_output,true);
            $subscriptionresposne = json_decode($server_output,true);
            return $subscriptionresposne['subscriptionId'];
    }

    public function CurlClevertapEvent($transaction){
        $txn_url = config('epicconfig.CLEVERTAP.CLEVERTAP_TXN_URL');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $txn_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $postData['ts'] = time();
        $postData['type'] = 'event';
        $postData['evtName'] = "GP Subscription Failure";
        if(!empty($transaction['email'])){
            $userdetails = $transaction['email'];
            $postData['identity'] = $userdetails;
            $postData['evtData'] = [
                "id"=> $transaction['txnid'],
                "order_status"=> 'Failed', 
                "Order Id"=> $transaction['txnid'],
                "Transaction Id"=> $transaction['mihpayid'],
                "UserId"=> $userdetails,
                "Currency Code"=> "INR",
                "plan_amount"=> $transaction['amount'],
                "payment_gateway"=> "PayU",
                "Amount"=> $transaction['amount'],
                "Error Message" => $transaction['error_Message']
            ];
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
}
