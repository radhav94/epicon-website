<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Validator;
use Redirect;
//use Intervention\Image\ImageManagerStatic as Image;
use Auth;
class payustatus12hour extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payu:status12hour {createdDatetime?} {orderID?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lookup Payu Orders using this CLI';

    protected $configParams = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->configParams = [
            'key'=>config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY'),
            'cc_api_transUrl'=>config('epicconfig.PAYUMONEY.API_URL'),
            'salt'=>config('epicconfig.PAYUMONEY.PAYUMONEY_SALT')
        ];

        // test
        // $this->configParams = [
        //     'key'=>"5Z7qv4",
        //     'cc_api_transUrl'=>"https://test.payu.in/merchant/postservice.php?form=2",
        //     'salt'=>'9S0qvfqO'
        // ];

        //production
        // $this->configParams = [
        //     'key'=>"lkvpv7",
        //     'cc_working_key'=>"lkvpv7",
        //     'cc_api_transUrl'=>"https://info.payu.in/merchant/postservice.php?form=2",
        //     'salt'=>'Rj7KA4rC'
        // ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        $this->info("Lookup Script Started at ".date("Y-m-d H:i:s"));
        $toTransactionRef = $jsonprepare = $successOrders = $orders = $mailArr = $ccordersToConfirm = $ordersToConfirm = $orderIds = []; 
        $sendMail = false;$i=0;
        $last24Hour = date("Y-m-d H:i:s", strtotime("-24 hours"));
        $startdate = new \DateTime($last24Hour);$enddate = new \DateTime();
        $this->info("Orders from date ".$last24Hour);
        /*$ordsPosted = [
            'payment_gateway' => 'payumoney',
            'created_date'=> $last24Hour,
        ];
        Log::info("-----payu get order request-----");
        Log::debug(json_encode($ordsPosted,JSON_UNESCAPED_SLASHES));
        Log::info("-----END------------");
        //print_r($ordsPosted);
        $curlResp = $this->CurlAPICron('cms/getorders','POST',$ordsPosted,'u9XBBnHOHQ5qiQ7Vgaf31K640F4OGiyN');
        print_r($curlResp);
        Log::info("-----payu  - cms get order resposne-----");
        Log::debug(json_encode($curlResp,JSON_UNESCAPED_SLASHES));
        Log::info("-----END------------");
        if($curlResp['success']==true){
            //$ordersToConfirm = $curlResp['orders'];
            foreach($curlResp['orders'] as $a=>$orda){
                if($orda['order_status']!='complete'){
                    $ordersToConfirm[] = $orda;
                }
            }
           
        }*/
        $ordsPostedAndroid = [
            'payment_gateway' => 'PayU',
            'created_date'=> $last24Hour,
            'order_status'=>'complete'
        ];
        // Log::debug(json_encode($ordsPostedAndroid,JSON_UNESCAPED_SLASHES));
        // Log::info("-----END------------");
        $curlRespAndroid = $this->CurlAPICron('cms/getorders','POST',$ordsPostedAndroid,'u9XBBnHOHQ5qiQ7Vgaf31K640F4OGiyN');
        // Log::debug(json_encode($curlRespAndroid,JSON_UNESCAPED_SLASHES));
        
        if(isset($curlRespAndroid['success'])){
            if($curlRespAndroid['success']==true){
                $ordersToConfirmAndroid = [];
                foreach($curlRespAndroid['orders'] as $z=>$ord){
                    if($ord['order_status']=='complete'){
                        $ordersToConfirmAndroid[] = $ord;
                    }
                }
                //$ordersToConfirmAndroid = $curlRespAndroid['orders'];
                $ordersToConfirm = array_merge($ordersToConfirm,$ordersToConfirmAndroid);
                //$ordersToConfirm = $ordersToConfirmAndroid;
                if(!empty($ordersToConfirm)){
                    foreach($ordersToConfirm as $i=>$order){
                        $orderIds[] = $order['order_id'];
                        $userids[$order['order_id']] = $order['user_id'];
                    }
                    $orderstraing = implode('|',$orderIds);
                    //$orderstraing = '10108124201';
                    //echo $orderstraing; die;
                    $hash = $this->configParams['key']."|verify_payment|".$orderstraing."|".$this->configParams['salt'];
                    $hashed = strtolower(hash('sha512', $hash));// hash("sha512", $hash);

                    $data = [
                        'key'=>$this->configParams['key'],
                        'command'=>'verify_payment',
                        'hash'=>$hashed,
                        'var1'=>$orderstraing
                    ];
                    //$url = $this->configParams['cc_api_transUrl']."&key=".$this->configParams['cc_working_key']."&command=verify_payment&hash=".$hashed."&txnID=317017";
                    $querystring = preparePostFields($data);
                    $this->info($querystring);
                    $url = $this->configParams['cc_api_transUrl'];
                    $this->info($url);
                    $ch = curl_init();  
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
                    curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS,$querystring);
                    $result = curl_exec($ch);
                    $err = curl_error($ch);
                    $errno =curl_errno($ch);
                    curl_close($ch);
                    if ($err) {
                        //$this->info("errodetails");
                        print_r($err);
                    } else {
                        print_r(json_decode($result,true));//die;
                        $payudata = json_decode($result,true);
                        // Log::info("-----12hours cron : payu verify_payment api response-----");
                        // Log::debug($result);
                        // Log::info("-----END------------");
                        $log = [];
                        if($payudata['status']==1 && !empty($payudata['transaction_details'])) {
                            //$payudata['transaction_details'][317515]['status'] = 'pending';
                            //$payudata['transaction_details'][317515]['unmappedstatus'] = 'pending';
                            foreach($payudata['transaction_details'] as $i=>$transaction){

                                if(
                                    ($transaction['status']=='success' && ($transaction['unmappedstatus']=='captured' || $transaction['unmappedstatus']=='pending')) || ($transaction['status']=='pending' && $transaction['unmappedstatus']=='initiated')
                                ){} else {
                                    $orderid = $transaction['txnid'];
                                    $njsPosted = ['order_id'=> (string) $orderid,'note'=>'updatebypayucron'];
                                    $curlResp = $this->CurlAPICron('cms/deactivatesubscription','POST',$njsPosted,'u9XBBnHOHQ5qiQ7Vgaf31K640F4OGiyN');
                                    print_r($curlResp);
                                    $log[$orderid] = $curlResp;
                                    if($curlResp=='User subscription deleted successfully.'){
                                        print_r($transaction);
                                        //$this->CurlClevertap($transaction,$userids);
                                    }
                                }
                            }
                        }
                        print_r($log);
                        // Log::info("-----cms deactivation api response-----");
                        // Log::debug(json_encode($log,JSON_UNESCAPED_SLASHES));
                        // Log::info("-----END------------");
                        //return json_decode($result,true);
                    }
                }
            }
        }
        else {
            $this->info("Orders not available for checking.");    
        }
        $this->info("Done at ".date("Y-m-d H:i:s"));
    }

    function CurlClevertap($transaction,$userids){
        $txn_url = config('epicconfig.CLEVERTAP.CLEVERTAP_TXN_URL');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $txn_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $postData['ts'] = time();
        $postData['type'] = 'event';
        $postData['evtName'] = "GP Subscription Failure";//$trackingData['eventCat'];//'Subscription Completed';
        if(!empty($transaction['email'])){
            $userdetails = $transaction['email'];
        } elseif(!empty($transaction['udf1'])){
            $userdetails = explode("#",$transaction['udf1']);
            $userdetails = $userdetails[0];
        }else{
            $userdetails = $userids[$transaction['txnid']];
        }
        
        $postData['identity'] = $userdetails;
        $postData['evtData'] = [
            "id"=> $transaction['txnid'],
            "order_status"=> 'Failed', 
            "Order Id"=> $transaction['txnid'],
            "Transaction Id"=> $transaction['mihpayid'],
            "UserId"=> $userdetails,
            "Currency Code"=> "INR",
            "plan_amount"=> $transaction['transaction_amount'],
            "payment_gateway"=> "Payu",
            "Amount"=> $transaction['transaction_amount'],
            "Error Message" => $transaction['error_Message'],
            "Payu_Status" => $transaction['status'],
            "Payu_unmappedstatus" => $transaction['unmappedstatus'],
        ];
        Log::info("-----CLEVERTAP CURL Parameters: ".$txn_url."----\n");
        Log::debug(json_encode($postData));
        Log::info("-----END----------------------");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"d\": [ ".json_encode($postData,JSON_PRETTY_PRINT)." ] }");
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = array();
        $headers[] = 'Content-Type: application/json; charset=utf-8';
        // $headers[] = 'X-CleverTap-Account-Id: K95-688-955Z';
        // $headers[] = 'X-CleverTap-Passcode: CRO-SQW-WPKL';          
        $headers[] = 'X-CleverTap-Account-Id: '.config('epicconfig.CLEVERTAP.CLEVERTAP_ACCOUNT_ID');
        $headers[] = 'X-CleverTap-Passcode: '.config('epicconfig.CLEVERTAP.CLEVERTAP_PASSCODE');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        Log::info("-----CLEVERTAP CURL response");
        Log::debug($result);
        Log::info("-----END----------------------"); 
    }

    function CurlAPICron($context,$method='GET',$data=null,$token=''){
        if(empty($context)) return;

        $url = config('epicconfig.EPICAPI.API_DOMAIN').$context.'/';
        $headerArr[] = "x-access-auth-token: ".$token;
        $headerArr[] = "Content-Type: application/x-www-form-urlencoded";
        $headerArr[] = "cache-control: no-cache";
        //$headerArr[] = "x-country: ".$_SERVER['HTTP_X_REGION'];
        $ch = curl_init();  
        $querystring ='';
        //$data['x_country'] = $_SERVER['HTTP_X_REGION'];
        //$data['x_cntri'] = getCountryFromXHeader();
        $data['x_country'] = getCountryFromXHeader();
        if($data!= null && !empty($data)){
            $querystring = preparePostFields($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$querystring);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if($method=='POST'){
            curl_setopt($ch, CURLOPT_POST, true);
        } else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            $url = $url."?".$querystring;
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        
        
        if(env('APP_ENV')!='local' || env('APP_ENV')!='LOCAL'){
            //$clientip = (!empty($_SERVER['HTTP_TRUE_CLIENT_IP'])) ? $_SERVER['HTTP_TRUE_CLIENT_IP'] : explode(",",$_SERVER['HTTP_X_FORWARDED_FOR'])[0];
            //$headerArr[] =  "HTTP_X_CCORG: ".$_SERVER['HTTP_X_CCORG'];
            ///$headerArr[] =  "HTTP_TRUE_CLIENT_IP: ".$clientip;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArr);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);    
        $result = curl_exec($ch);
        $curlhttpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerout = curl_getinfo($ch,CURLINFO_HEADER_OUT);
        $err = curl_error($ch);
        $errno =curl_errno($ch);
        //pr($err); pr($errno);die;
        Log::info("-----curl_errno:".$errno."------");
        Log::debug(json_encode($errno));
        Log::info("-----End------");
        curl_close($ch);
        if ($err) {
            return false;
        } else {
            //if(in_array($curlhttpcode,[504,502,500,404,400])) { return false; }
            return json_decode($result,true);
        }
    }

    /*public function curlCCAvenue($dataForEncryption,$command){
        if(!empty($dataForEncryption) && !empty($command)){
            $merchantid = $this->configParams['merchantid'];
            $cc_access_code = $this->configParams['cc_access_code']; 
            $cc_working_key = $this->configParams['cc_working_key'];
            $url = $this->configParams['cc_api_transUrl'];
            //include(app_path().'/Libraries/Crypto.php');
            $encrypted_data=$this->encrypt_ccapi($dataForEncryption,$cc_working_key);
            $postdata = 'enc_request='.$encrypted_data.'&access_code='.$cc_access_code.'&command='.$command.'&request_type=JSON&response_type=JSON&version=1.1';
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$postdata);
            $result = curl_exec($ch);
            $curlhttpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            //$this->info($curlhttpcode);$this->info($result);
            if($curlhttpcode==200 && !empty($result)){
                parse_str($result, $respArray);
                return $respArray;
            }
        }
        return false;
    }*/
    public function makeHtml($Orders){
        $html = 'Hi,<br/>';
        if(empty($Orders)){
            $html .= '<p>Transactions are not availabel.</p>';
        } else {
            $html .= '<table border="1" cellspacing="0" cellpadding="0">';
            $html .= '<thead><tr><th>Transaction Ref No</th><th>User Id</th><th>Order Id</th><th>Bank Reference No</th><th>PaymodeMode</th><th>OrderStatus</th><th>StatusMessage</th></tr></thead><tbody>';
            foreach($Orders as $k=>$v){
                $html .= '<tr><td>'.$v['reference_no'].'</td><td>'.$v['user_id'].'</td><td>'.$v['order_id'].'</td><td>'.$v['bank_ref_no'].'</td><td>'.$v['payment_mode'].'</td><td>'.$v['orderstatus'].'</td><td>'.$v['statusmessage'].'</td></tr>';
            }
            $html .= '</tbody></table>';
        }
        $html .= '<p>Thanks,<br/>Epic Team</p>';
        return $html;
    }
    public function prepareErrorHtml($respArray){
        $html = 'Hi,<br/>';
        $html .= '<p>Stats from orders initiated in Epic and successfull in CCAvenue. Errors during proccessing.</p>';
        $html .= '<p>';
        if(!empty($respArray['enc_response'])) {
            $html .= $respArray['enc_response'];
        }
        if(!empty($respArray['enc_error_code'])) {
            $html .= ' Error Code:'.$respArray['enc_error_code'];
        }
        $html .= '</p><p>Thanks,<br/>Epic Team</p>';
        return $html;
    }
    public function encrypt_ccapi($plainText,$key)
    {
        $secretKey = $this->hextobin_ccapi(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
        $blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
        $plainPad = $this->pkcs5_pad_ccapi($plainText, $blockSize);
        if (mcrypt_generic_init($openMode, $secretKey, $initVector) != -1) 
        {
              $encryptedText = mcrypt_generic($openMode, $plainPad);
                  mcrypt_generic_deinit($openMode);
                        
        } 
        return bin2hex($encryptedText);
    }
    public function decrypt_ccapi($encryptedText,$key)
    {
        $secretKey = $this->hextobin_ccapi(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText=$this->hextobin_ccapi($encryptedText);
        $openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
        mcrypt_generic_init($openMode, $secretKey, $initVector);
        $decryptedText = mdecrypt_generic($openMode, $encryptedText);
        $decryptedText = rtrim($decryptedText, "\0");
        mcrypt_generic_deinit($openMode);
        return $decryptedText;
    }
    //*********** Padding Function *********************

    public function pkcs5_pad_ccapi ($plainText, $blockSize)
    {
        $pad = $blockSize - (strlen($plainText) % $blockSize);
        return $plainText . str_repeat(chr($pad), $pad);
    }

    //********** Hexadecimal to Binary function for php 4.0 version ********
    public function hextobin_ccapi($hexString) 
    { 
        $length = strlen($hexString); 
        $binString="";   
        $count=0; 
        while($count<$length) 
        {       
            $subString =substr($hexString,$count,2);           
            $packedString = pack("H*",$subString); 
            if ($count==0)
            {
                $binString=$packedString;
            } else {
                $binString.=$packedString;
            } 
            $count+=2; 
        } 
        return $binString; 
    } 
}