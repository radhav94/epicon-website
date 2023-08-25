<?php

namespace App\Library;

use Illuminate\Support\Facades\Log;

class ApiHandler
{
	public $url;
	public $header;
	private $ch;
	private $pch;
	private $api_url;

	public function __construct()
	{
		$this->header = $this->getHeader();
		if ((!$this->ch) || empty($this->ch)) {
			$this->ch = curl_init();
		}
		if ((!$this->pch) || empty($this->pch)) {
			$this->pch = curl_init();
		}
	}

	public function getHeader()
	{
		$headerArr[] = "x-access-auth-token: " . config('epicconfig.EPICAPI.API_AUTH_TOKEN');

		if (env('logintoken')) {
			$headerArr[] = "Authorization: " . env('logintoken');
		}

		$headerArr[] = "Content-Type: application/x-www-form-urlencoded";
		$headerArr[] = "cache-control: no-cache";
		if (env('APP_ENV') != 'local' || env('APP_ENV') != 'LOCAL') {
			$clientip = (!empty($_SERVER['HTTP_TRUE_CLIENT_IP'])) ? $_SERVER['HTTP_TRUE_CLIENT_IP'] : ((!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) ? explode(",", $_SERVER['HTTP_X_FORWARDED_FOR'])[0] : '');
			$headerArr[] =  "HTTP_X_CCORG: " . (!empty($_SERVER['HTTP_X_CCORG']) ? $_SERVER['HTTP_X_CCORG'] : '');
			$headerArr[] =  "HTTP_TRUE_CLIENT_IP: " . $clientip;
		}
		return $headerArr;
	}

	public function api_query($url, $method = 'GET', $data = null)
	{

		$querystring = $fields_string = '';
		// if (!empty($_SERVER['HTTP_X_REGION'])) {
		// 	$data['x_country'] = $_SERVER['HTTP_X_REGION'];
		// }
		// if (!empty($_SERVER['HTTP_X_CONTINENT'])) {
		// 	$data['x_continent'] = $_SERVER['HTTP_X_CONTINENT'];
		// }
		// if (strtoupper(@$data['x_country']) == 'ROW') {
		// 	$data['x_country'] = $_SERVER['HTTP_X_CONTINENT'];
		// }
		if ($method == 'POST') {
			if ($data != null && !empty($data)) {
				$fields_string = http_build_query($data);
			}
			$this->api_url = $url;
			return $this->PostCurlToApi($fields_string);
		} else {
			$this->api_url = ($data != null && !empty($data)) ? $url . "?" . $this->preparePostFields($data) : $url;
			return $this->GetCurlToApi();
		}
	}


	public function api_query_without_v2($url, $method = 'GET', $data = null)
	{

		$querystring = $fields_string = '';
		if (!empty($_SERVER['HTTP_X_REGION'])) {
			$data['x_country'] = $_SERVER['HTTP_X_REGION'];
		}
		if (!empty($_SERVER['HTTP_X_CONTINENT'])) {
			$data['x_continent'] = $_SERVER['HTTP_X_CONTINENT'];
		}
		if (strtoupper(@$data['x_country']) == 'ROW') {
			$data['x_country'] = $_SERVER['HTTP_X_CONTINENT'];
		}
		if ($method == 'POST') {
			if ($data != null && !empty($data)) {
				$fields_string = http_build_query($data);
			}
			$this->api_url = $url;
			return $this->PostCurlToApi($fields_string);
		} else {
			$this->api_url = ($data != null && !empty($data)) ? $url . "?" . $this->preparePostFields($data) : $url;
			return $this->GetCurlToApi();
		}
	}

	public function GetCurlToApi()
	{
		Log::info("-----Method:GET-----URL:" . $this->api_url);
		curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->ch, CURLOPT_URL, $this->api_url);
		curl_setopt($this->ch, CURLOPT_AUTOREFERER, 1);
		//curl_setopt($this->ch, CURLOPT_FRESH_CONNECT, 1);
		curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->header);
		//curl_setopt($this->ch, CURLINFO_HEADER_OUT, true);	
		$getresult = curl_exec($this->ch);
		$curlhttpcode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
		//$headerout = curl_getinfo($this->ch,CURLINFO_HEADER_OUT);		
		$curl_error = curl_error($this->ch);
		$curl_errno = curl_errno($this->ch);
		//Log::info("-----Curl Header:".$headerout."------");
		//		Log::info("-----Curl Request Header:------");
		//		Log::debug($this->header);
		if ($curl_errno > 0) {
			Log::info("-----curl errorno:" . $curl_errno);
			return false;
		} else {
			$apiresponse = json_decode($getresult, true);
			$apilog = ((!empty($apiresponse) && $apiresponse != null) ? $apiresponse['success'] : null);
			Log::info("-----curl API response success param:" . @$apilog . "------message:" . @$apiresponse['message']);
			return $apiresponse;
		}
	}

	public function PostCurlToApi($fields_string)
	{

		Log::info("-----Method:POST-----URL:" . $this->api_url . "-----Data:" . $fields_string);
		curl_setopt($this->pch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($this->pch, CURLOPT_POST, true);
		if (!empty($fields_string)) {
			curl_setopt($this->pch, CURLOPT_POSTFIELDS, $fields_string);
		}
		curl_setopt($this->pch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->pch, CURLOPT_URL, $this->api_url);
		curl_setopt($this->pch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($this->pch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($this->pch, CURLOPT_HTTPHEADER, $this->header);
		$postresult = curl_exec($this->pch);
		$curlhttpcode = curl_getinfo($this->pch, CURLINFO_HTTP_CODE);
		$curl_error = curl_error($this->pch);
		$curl_errno = curl_errno($this->pch);

		if ($curl_errno > 0) {
			Log::info("-----curl errorno:" . $curl_errno);
			return false;
		} else {
			$postapiresponse = json_decode($postresult, true);
			@$postapilog = ((!empty($postapiresponse) && $postapiresponse != null) ? $postapiresponse['success'] : null);
			Log::info("-----curl API response success param:" . @$postapilog . "------message:" . @$postapiresponse['message']);
			return $postapiresponse;
		}
	}

	public function preparePostFields($array)
	{
		$params = array();
		foreach ($array as $key => $value) {
			$params[] = $key . '=' . urlencode($value);
		}
		return implode('&', $params);
	}
}
global $api_client;
$api_client = new ApiHandler();
