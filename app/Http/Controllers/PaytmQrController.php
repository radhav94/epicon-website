<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Request;
use Route;
use Auth;
use URL;
use Session;
use Redirect;
use App\Traits\payments;
use Illuminate\Support\Facades\Cache;

class PaytmQrController extends Controller{
    use payments;

    public function getPaytmSubscriptionQr(){
    	$request = Request();
    	$order_id = $request->get('orderid');
    	$amount = $request->get('amount');
    	// $currency = $request->get('currency');
    	// if(empty($currency)){
    	// 	$currency = 'INR';
    	// }
    	// cms getsingleorder api to get order data
    	// $order_response = CurlAPI("cms/getsingleorder",'POST',array('order_id'=>$order_id));
    	// $order_data = isset($order_response['order_data'])?$order_response['order_data']:'';
    	// $this->getSubscriptionInitiate($order_data,$currency,'Subscription Initiated');

    	// order_id, amount, HR201234751RT833456
    	Log::info("-----Paytm-QR-Create");	
    	include(app_path().'/Libraries/encdec_paytm.php');

    	// config('epicconfig.PAYTM.PAYTM_MERCHANT_ID');
    	$PAYTMQR_MERCHANT_ID = config('epicconfig.PAYTMQR.PAYTMQR_MERCHANT_ID'); // EPICTE75923614314699
    	$PAYTMQR_POS_ID = config('epicconfig.PAYTMQR.PAYTMQR_POS_ID'); // 9683634578
    	$PAYTMQR_SECRET_KEY = config('epicconfig.PAYTMQR.PAYTMQR_SECRET_KEY'); // 9683634578
    	$PAYTMQR_URL = config('epicconfig.PAYTMQR.PAYTMQR_URL'); // 9683634578
    	
    	$chbody= '{
			"businessType": "QR_ORDER",
			"amount": "'.$amount.'",
			"mid": "'.$PAYTMQR_MERCHANT_ID.'",
			"orderId": "'.$order_id.'",
			"posId": "'.$PAYTMQR_POS_ID.'",
			"orderDetails": "Payment for the order:-'.$order_id.'",
			"imageRequired": "true",
			"contactPhoneNo": "",
			"invoiceDetails": "true",
			"displayName": "Paytm"
			}}';
		Log::info("-----Paytm-QR-chbody");	
		Log::debug($chbody);
		// return $chbody;
		// echo "<pre>"; print_r($chbody); echo "</pre>"; die('end of chbody');
		$paytm_secret_key = $PAYTMQR_SECRET_KEY; //'zBDZxvO%BCS%SOXw'; // get the data form config file
		$Checksumhash = getChecksumFromString($chbody,$paytm_secret_key);

		$Checksumhash = '"'.$Checksumhash.'"';
		// echo "<pre>"; print_r($Checksumhash); echo "</pre>"; die('end of Checksumhash');

		$body = '{ 
			"head":{
			   "clientId":"C11",
			   "version":"v1",
			   "requestTimestamp":"Time", 
			   "channelId":"POS",  
			   "signature":'.$Checksumhash.'
			},
			"body":'.$chbody.'
		}';

		// echo "<pre>"; print_r($body); echo "</pre>"; die('end of body');
		$headerValue = array('Content-Type:application/json');
		//echo "<pre>";
		//print_r( $headerValue);

		// $url =  'https://securegw-stage.paytm.in/qr/create'; // get the data from config file
		$url =  $PAYTMQR_URL; // get the data from config file

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);   
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headerValue);
		$info = curl_getinfo($ch);
		$response = curl_exec($ch);
		Log::info("-----Paytm-QR-response");	
		Log::debug($response);
		// echo "<pre>"; print_r($response); echo "</pre>"; die('end of response');
		$response_array = json_decode($response,true);
		// echo "<pre>"; print_r($response_array['body']); echo "</pre>"; die('end of code');
		$result["resultStatus"] = $response_array['body']['resultInfo']['resultStatus'];
		$result["resultMsg"] = $response_array['body']['resultInfo']['resultMsg'];
		$result["qrCodeId"] = $response_array['body']['qrCodeId'];
		$result["qrData"] = $response_array['body']['qrData'];
		$result["image"] = $response_array['body']['image'];
		Log::info("-----Paytm-QR-result");	
		Log::debug($response);
		Log::info("-----Paytm-QR-result End <=========================>");	
		// echo "<pre>"; print_r($result); echo "</pre>"; die('end of ajit');
		$result = json_encode($result);
		return $result;
		// return view('epicon.GetPaytmRSA',compact('result'));
		// echo '<br/><br/><b>
		// RESULT :</b> ' .$result;
		// echo $checkSum;
    }

    public function getPaytmQrPaymentStatus(){
    	Cache::clear();
    	Log::info("-----Paytm-QR-Status check");	
    	$return_array = array();
    	// $return_array['status'] = false;
    	include(app_path().'/Libraries/encdec_paytm.php');
    	$request = Request();
    	$PAYTMQR_STATUS_URL = config('epicconfig.PAYTMQR.PAYTMQR_STATUS_URL'); // 9683634578
    	$PAYTMQR_MERCHANT_ID = config('epicconfig.PAYTMQR.PAYTMQR_MERCHANT_ID'); // EPICTE75923614314699
    	$PAYTMQR_POS_ID = config('epicconfig.PAYTMQR.PAYTMQR_POS_ID'); // 9683634578
    	$PAYTMQR_SECRET_KEY = config('epicconfig.PAYTMQR.PAYTMQR_SECRET_KEY'); // 9683634578

    	$order_id = $request->get('orderid');
    	Log::debug($order_id);
    	Log::info("-----Paytm-QR-Status array");	
    	$pay_status_array = array(
    		'MID'=>"".$PAYTMQR_MERCHANT_ID."", //EPICTE75923614314699
    		'ORDERID'=>"".$order_id."", // HR201234751RT833456
    		// 'CHECKSUMHASH'=>"KBiS3mhw1vOcpSoWj8ijEPy7jxeGh4vOx6iGpw2eiatZdLH%2BuON1Ivaxq7e4NHWMkaGbwL6V%2F6VMTzO%2BqR2HCr%2BgenMflLCMe9KSAEVa1ZU%3D"
    	);
    	Log::debug($pay_status_array);
    	$paytm_secret_key = $PAYTMQR_SECRET_KEY; //'zBDZxvO%BCS%SOXw'; // get the data form config file
    	$check_sum_hash = getChecksumFromArray($pay_status_array,$paytm_secret_key);
		$check_sum_hash = '"'.$check_sum_hash.'"';
		$pay_status_array['CHECKSUMHASH'] =$check_sum_hash;
		//"K5ln3UX/7nzWRytKHfoF3FjEM5whwtxDUimx0d9NQypRSEMvFYBUllpwylDLi/nh4u7Pe/UgqU7eMtl0362cvrj1UwTCBPsE5oXoeOZY1ew="
		// return $check_sum_hash;

    	$json_data = json_encode($pay_status_array);    	
    	// return urlencode($json_data);
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "".$PAYTMQR_STATUS_URL."?JsonData=".urlencode($json_data)."",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_HTTPHEADER => array(		    
		    "cache-control: no-cache"
		  ),
		));
		Log::info("-----Paytm-QR-Status API response");	
		$result = curl_exec($curl);
		Log::debug($result);
		$err = curl_error($curl);
		curl_close($curl);

		$response = json_decode($result,true);
		$response['ErrorCode'] = 'VAER-PF111';
		$response['ErrorMsg'] = 'ORDER ID IS REQUIRED';
		if (isset($response['STATUS']) && isset($response['TXNID'])) {
			$return_array['STATUS'] = $response['STATUS'];
			$return_array['TXNID'] = $response['TXNID'];
			echo json_encode($return_array,true);
			die;
		}else{
			$return_array['STATUS'] = 'false';
			$return_array['TXNID'] = null;
			echo json_encode($return_array,true);
			die;
		}
	
		

		// $order_response = CurlAPI("cms/getsingleorder",'POST',array('order_id'=>$order_id));
  //   	$order_data = isset($order_response['order_data'])?$order_response['order_data']:'';
		// if($return_array['STATUS'] == 'TXN_SUCCESS'){
		// 	$this->getSubscriptionInitiate($order_data,$currency,'Subscription payment success');
		// }else if($return_array['STATUS'] == 'TXN_FAILURE'){
		// 	$this->getSubscriptionInitiate($order_data,$currency,'Subscription payment failed');
		// }
		
		
		// echo "<pre>"; print_r(json_encode($response,true)); echo "</pre>"; die('end of code');
		// need to update subscription if payment sucessfull
		
		// $postedData = [
        //     'order_id'=>$respone_base64_decode_array['data']['transactionId'],
        //     'order_status'=>$statusToUpdate, // complete
        //     'transaction_id'=>$respone_base64_decode_array['data']['providerReferenceId'],
        //     'payment_gateway'=>'phonepe',
        //     'bank_ref_no'=>'',
        //     'note'=>'Update_by_phonepe_s2s'

        // ];
		// echo "<pre>"; print_r($paytm_status_array); echo "</pre>"; die('end of paytm_status_array');
		// $curlResp = CurlAPI('cms/paytmupdateorder','POST',$paytm_status_array,'u9XBBnHOHQ5qiQ7Vgaf31K640F4OGiyN');

		// echo "<pre>"; print_r($curlResp); echo "</pre>"; die('end of curlResp');
		if($response['STATUS'] == 'TXN_SUCCESS'){
			$paytm_status_array = [
				'order_id'=> $response['ORDERID'],
				'order_status'=>'complete', // complete $response['STATUS']
				'transaction_id'=>$response['TXNID'],
				// 'payment_gateway'=>'paytm_qr',
				'bank_ref_no'=>$response['BANKTXNID'],
				'note'=>'updateby_paytm_qr',			
				'paymentmode'=>$response['PAYMENTMODE'],
			];
			Log::info("-----Paytm-QR-Status API paytm_status_array");	
			Log::debug($paytm_status_array);
			// echo "<pre>"; print_r($paytm_status_array); echo "</pre>"; die('end of paytm_status_array');
			$curlResp = CurlAPI('cms/paytmupdateorder','POST',$paytm_status_array,'u9XBBnHOHQ5qiQ7Vgaf31K640F4OGiyN');
			Log::info("-----Paytm-QR-Status API paytmupdateorder response");	
			Log::debug($curlResp);
			if($curlResp['success'] == true){
				$return_array['status'] = 'success';
			}
			// array (
			//   'success' => true,
			//   'subscription_data' =>
			//   array (
			//     '_id' => '5dad9846f000f34b7d71afaf',
			//     'user_id' => 'nirmal.aricent@phonepe.com',
			//     'order_id' => '103539',
			//     'plan_id' => 'doc_in_pl_1',
			//     'plan_amount' => '499',
			//     'subscription_start_date' => '2019-10-21T11:36:38.722Z',
			//     'subscription_end_date' => '2020-01-19T11:36:38.722Z',
			//     'transaction_id' => 'P1910141603564253168881',
			//     'payment_gateway' => 'phonepe',
			//     'bank_ref_no' => '',
			//     '__v' => 0,
			//   ),
			// )
		}else if($response['STATUS'] == 'PENDING'){
			$return_array['status'] = 'pending';
		}else if($response['STATUS'] == 'TXN_FAILURE'){
			$return_array['status'] = 'fail';
		}
		Log::info("-----Paytm-QR-Status API response final");	
		Log::debug($return_array);
		echo json_encode($return_array);

		// echo "<pre>"; print_r(json_decode($result,true)); echo "</pre>"; die('end of code');


		// return view('epicon.GetRSA',compact('result'));
		// if ($err) {
		//   echo "cURL Error #:" . $err;
		// } else {
		//   echo $response;
		// }
    }
	

}
?>