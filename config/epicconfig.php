<?php
$environment = strtoupper(env('APP_ENV'));
if($environment=='PRODUCTION'){
	return [
		'EPICCOIN'=>[
			'VIDEO_WATCH_POINT_PER_MIN'=>'2',
			'PLATFORM_SPENT_POINT_PER_MIN'=>'1',
			'SIGNUP_PER_USER'=>'20',
			'SUBSCRIPTION_SPENT_POINT_PER_INR'=>'3',
		],		
		'MISCCONFIG'=>[
			'GAID'=>'G-8JER642T3Z',
			'ONESIGNAL_APPID'=>'71f3a678-707c-4f27-b722-836e941fab29',
			'JWPLAYER_KEY'=>'KjZLp2bXKLFcL2hCVYkFGYOMt5R/lLYPPlMUHJNj5VI3fqJ2',
			'AD_CONFIGID'=>'AW-848963660',
		],
		'ASSET'=>[
            'ASSET_URL'=>'https://www.epicon.in'
        ],
		'EPICAPI'=>[
			'API_DOMAIN'=>'https://njsapi.epicon.in/',

			'API_DOMAIN_1'=>'https://contentapiprod-njsapi.epicon.in/index/',
			'API_DOMAIN_2' => 'http://userapiprod-njsapi.epicon.in/',
			'API_DOMAIN_3' => 'https://njsapi.epicon.in/v2/',

			'API_AUTH_TOKEN'=>'szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH',
			'CONSCENT_API_URL' => 'https://api.conscent.in',
			'CONSCENT_SDK_URL' => 'https://sdk.conscent.in',
			'CONSCENT_CLIENT_ID' => '60d05885b173a174624b2937',

		],
		'CCAVENUE'=>[
			'INDIPAY_MERCHANT_ID'=>'137971',
			'INDIPAY_ACCESS_CODE'=>'AVZL77FD57BP65LZPB',
			'INDIPAY_WORKING_KEY'=>'FA1026AD3B664261B2BDA9719579E52D',
			'ANDROID_ACCESS_CODE'=>'AVEC82GA76AS04CESA',
			'ANDROID_WORKING_KEY'=>'360C42BCB5F50057F822D14B4C26A10F',
			'ANDROID_GETRSAKEY_URL'=>'https://secure.ccavenue.com/transaction/getRSAKey'
		],
        'PAYUMONEY'=>[
            'PAYUMONEY_MERCHANT_KEY'=>'lkvpv7', // MERCHABT_ID 117245
            'PAYUMONEY_SALT'=>'Rj7KA4rC',
            'RESPONSE_URL'=>'https://www.epicon.in/payumoney/response',//url('/payumoney/response'),
            'ANDROID_RESPONSE_URL'=>'https://www.epicon.in/payumoney/androidresponse',//url('payumoney/androidresponse'),
            'TESTMODE'=>false,
            'SUBSCRIPTION_URL'=>'https://secure.payu.in/_payment/',
            'ENABLE_RECURRING_API'=>false,
            'API_URL'=>'https://info.payu.in/merchant/postservice.php?form=2',
            'ENABLE_RECURRING_AT_FROM_TRANSACTION'=>false,
        ],
        'PAYTMQR'=>[
			'PAYTMQR_MERCHANT_ID'=>'EPICTE67767187383060',
			'PAYTMQR_POS_ID'=>'9683634578',
			'PAYTMQR_SECRET_KEY'=>'I#m_0Z0Wduu8gFgA', //paytm_secret_key
			'PAYTMQR_URL'=>'https://securegw.paytm.in/qr/create', //paytm_secret_key
			'PAYTMQR_STATUS_URL'=>'https://securegw.paytm.in/merchant-status/getTxnStatus', //paytm_secret_key
		],
		'PAYTM'=>[
			'PAYTM_ENVIRONMENT'=>'TEST',
			'PAYTM_STATUS_QUERY_URL'=>'https://securegw-stage.paytm.in/merchant-status/getTxnStatus',
			'PAYTM_STATUS_QUERY_NEW_URL'=>'https://securegw-stage.paytm.in/merchant-status/getTxnStatus',
			'PAYTM_CHANNEL_ID'=>'WEB',
			'PAYTM_MERCHANT_ID'=>'EPICTE95887575931629', // 'EPICTE92166207376016',
			'PAYTM_MERCHANT_KEY'=>'ngjvT1YD3ktF@IhZ',
			'PAYTM_MERCHANT_WEBSITE'=>'WEBPROD', //'WEBSTAGING',
			'PAYTM_TXN_URL'=>'https://securegw.paytm.in/theia/processTransaction',
			'PAYTM_INDUSTRY_TYPE_ID'=>'Retail92',
			'PAYTM_CALLBACK_URL'=> 'https://epicon.epicchannel.com/paytm/response',
			'PAYTM_ANDROID_MERCHANT_ID'=>'EPICTE92166207376016',
			'PAYTM_ANDROID_MERCHANT_KEY'=>'ngjvT1YD3ktF@IhZ',
			'PAYTM_ANDROID_MERCHANT_WEBSITE'=>'APPPROD',
			'PAYTM_ANDROID_STATUS_QUERY_URL'=>'',
			'PAYTM_ANDROID_STATUS_NEW_QUERY_URL'=>'',
			'PAYTM_ANDROID_TXN_URL'=>'https://securegw.paytm.in/theia/processTransaction',
			'PAYTM_ANDROID_CHANNEL_ID'=>'WAP',
			'PAYTM_ANDROID_INDUSTRY_TYPE_ID'=>'Retail92',
			'PAYTM_ANDROID_CALLBACK_URL'=> 'https://securegw.paytm.in/theia/paytmCallback?ORDER_ID=',
			'PAYTM_ANDROID_RESPONSE_URL'=> 'https://epicon.epicchannel.com/ccavep/ptmResponseHandler',
		],
		'CLEVERTAP'=>[
			'CLEVERTAP_ACCOUNT_ID'=>'6KZ-ZK5-Z65Z',
			'CLEVERTAP_PASSCODE'=>'WHK-ZWZ-SEKL',
			'CLEVERTAP_TXN_URL' => 'https://api.clevertap.com/1/upload'
		],
		'SERVICES'=>[
			'google' => [
				'redirect'=>'https://www.epicon.in/login/google/callback',
				'GOOGLE_CLIENT_ID'=>'812942192248-c95nfhscgbqrp1lkbpab1841gk1issah.apps.googleusercontent.com',
				'GOOGLE_CLIENT_SECRET'=>'IklyRUQgnQCSSiBoivzhoY3q'
			],
			'facebook' => [
				'redirect'=>'https://www.epicon.in/login/facebook/callback',
				'FACEBOOK_CLIENT_ID'=>'1534199926602841',
				'FACEBOOK_CLIENT_SECRET'=>'72fc40fffd7c00b412d143e6e0a7b3e7'
			],
			'twitter' => [
				'redirect'=>'https://www.epicon.in/login/twitter/callback',
				'TWITTER_CLIENT_ID'=>'nwKbID9Lq9Pzbkg5YCE3Dd8Z7',
				'TWITTER_CLIENT_SECRET'=>'h3hZYGKk8qEbAns5q6YnfRZYMR2vIGDxjEQZffRT9hyIanF9Lx'
			],
		],
		'SUPERCOIN'=>[
			'SUPERCOIN_BRAND_KEY'=>'FHn8UX5FESAYtKFM2uzbVXfRSqwGMBdidqkSjqwPLrW3wUXNcU', // MERCHABT_ID 117245
			'SUPERCOIN_ACCESS_TOKEN'=>'1a25f5f434cf48db96bb4863558ebd323513790695c243ee95c80f669f06f8fa',
			'SUPERCOIN_HMAC'=>'9c02a40a62f54ef58783503892aa61d5d67b8fec6302436f813665b581b0ff2a',
			'CALLBACK_RESPONSE_URL'=>env('APP_URL').'/flipkart/supercoinpay/callback_response',
			'HASH_WEBHOOK_URL'=>env('APP_URL').'/flipkart/supercoinpay/hash_webhook',
			'TRANSACTION_WEBHOOK_URL'=>env('APP_URL').'/flipkart/supercoinpay/transaction_webhook',
            'ANDROID_RESPONSE_URL'=>env('APP_URL').'/flipkart/supercoinpay/androidresponse',
            'TESTMODE'=>false,
            'SUBSCRIPTION_URL'=>'',
            'TWID_API_URL'=>'https://api.twidpay.com/pwa/',
            'TWID_PWA_URL'=>'https://pwa.twidpay.com/pg-init',
		],
		'FLIPKARTULTRA'=>[
			'ULTRA_ENDPOINT'=>'https://platform.flipkart.net/',
			'ULTRA_OMS_ENDPOINT' => 'https://ultra-lite.flipkart.net/ultra/',
		],
		'GOOGLECRAWL'=>[
			'podcast/aawaz-e-kalam/season-1/dushyant-kumar-ye-dhuen-ka-ghire-hai-ki-main-jisme','podcast/aawaz-e-kalam/season-1/ahmad-faraz-junun-e-musaffat-me-ghar-se-nikle-the','podcast/aawaz-e-kalam/season-1/dushyant-kumar-ghar-me-kis-tarah-saheju-man-ko','epic-shorts/international-tiger-day/season-1/e6-a-tale-of-success-12619','podcast/aawaz-e-kalam/season-1/dushyant-kumar-aaj-veeran-apna-ghar-dekha','podcast/aawaz-e-kalam/season-1/kavi-kunvar-narayan-kavita-ke-bahane','podcast/the-next-ten-years/season-1/jo-aggarwal-co-founder-ceo','podcast/aawaz-e-kalam/season-1/luv-tomar-siva-tere','podcast/aawaz-e-kalam/season-1/ahmad-faraz-kam-kam-mila-karo-usse','podcast/aawaz-e-kalam/season-1/ahmad-pharaz-khushbu-ka-safar-dekhega-kaun','podcast/aawaz-e-kalam/season-1/ahmad-faraz-zakhm-na-bharte-koi-aur','podcast/aawaz-e-kalam/season-1/harivanshrai-bachchan-aatmaparichay','podcast/aawaz-e-kalam/season-1/ahmad-faraz-saja-kyu-nahi-dete','podcast/aawaz-e-kalam/season-1/luv-tomar-aksar-tere-ishq-me','podcast/aawaz-e-kalam/season-1'
		],
		'moengage'=>[
			'APP_ID_API'=>'MQA1U2LIXTRNW844CWFLGT1A',
			'APP_ID'=>'MQA1U2LIXTRNW844CWFLGT1A',
			'APP_KEY'=>'oR@YoK2+vK0CyWs8Of5@sSVN',
			'CUSTOMER_TXN_URL' => 'https://api.moengage.com/v1/customer/',
			'EVENT_TXN_URL' => 'https://api.moengage.com/v1/event/'
		]
	];
} else if($environment=='STAGE' ){
	return [
		'EPICCOIN'=>[
			'VIDEO_WATCH_POINT_PER_MIN'=>'2',
			'PLATFORM_SPENT_POINT_PER_MIN'=>'1',
			'SIGNUP_PER_USER'=>'20',
			'SUBSCRIPTION_SPENT_POINT_PER_INR'=>'3',
		],		
		'MISCCONFIG'=>[
			'GAID'=>'UA-127230808-1',
			'ONESIGNAL_APPID'=>'71f3a678-707c-4f27-b722-836e941fab29',
			'JWPLAYER_KEY'=>'KjZLp2bXKLFcL2hCVYkFGYOMt5R/lLYPPlMUHJNj5VI3fqJ2',
			'AD_CONFIGID'=>'AW-848963660',
		],
        'ASSET'=>[
            'ASSET_URL'=>env('APP_URL')
        ],
		'EPICAPI'=>[
			// 'API_DOMAIN'=>'https://stg-njsapi.epicchannel.com/',
			'API_DOMAIN'=>env('API_URL','https://stg-njsapi.epicchannel.com/'),	

			'API_DOMAIN_1'=>'http://contentapistg-njsapi.epicon.in/index/',
			'API_DOMAIN_2' => 'http://userapistg-njsapi.epicon.in/',
			'API_DOMAIN_3' => 'https://njsapi.epicon.in/v2/',

			'API_AUTH_TOKEN'=>'szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH',
			'CONSCENT_API_URL' => 'https://api.conscent.in',
			'CONSCENT_SDK_URL' => 'https://sdk.conscent.in',
			'CONSCENT_CLIENT_ID' => '60d05885b173a174624b2937',

		],
		'CCAVENUE'=>[
			'INDIPAY_MERCHANT_ID'=>'137971',
			'INDIPAY_ACCESS_CODE'=>'AVYF81FJ36CN26FYNC',
			'INDIPAY_WORKING_KEY'=>'B49814CD449D774627AD36F508A086DB',
			'ANDROID_ACCESS_CODE'=>'AVGC82FL05AG21CGGA',
			'ANDROID_WORKING_KEY'=>'C6BF54B2CD0E2F2CFB2E768A5BA0FBC8',
			'ANDROID_GETRSAKEY_URL'=>'https://secure.ccavenue.com/transaction/getRSAKey'
		],
		//test
		'PAYUMONEY'=>[				
			'PAYUMONEY_MERCHANT_KEY'=>'5Z7qv4', // MERCHABT_ID 117245
			'PAYUMONEY_SALT'=>'9S0qvfqO',
			'RESPONSE_URL'=>'https://stg.epicon.in/payumoney/response',
			'ANDROID_RESPONSE_URL'=>'https://stg.epicon.in/payumoney/androidresponse',
			'TESTMODE'=>true,
			'SUBSCRIPTION_URL'=>'https://subscriptiontest.citruspay.com/',
			'ENABLE_RECURRING_API'=>false,
			'ENABLE_RECURRING_AT_FROM_TRANSACTION'=>false,
			'API_URL'=>'https://test.payu.in/merchant/postservice.php?form=2',
		],
		// Production
        /*'PAYUMONEY'=>[
            'PAYUMONEY_MERCHANT_KEY'=>'lkvpv7', // MERCHABT_ID 117245
            'PAYUMONEY_SALT'=>'Rj7KA4rC',
            'RESPONSE_URL'=>'https://stg.epicon.in/payumoney/response',
            'ANDROID_RESPONSE_URL'=>'https://stg.epicon.in/payumoney/androidresponse',
            'TESTMODE'=>false,
            'SUBSCRIPTION_URL'=>'https://subscription.citruspay.com/',
            'ENABLE_RECURRING_API'=>false,
            'ENABLE_RECURRING_AT_FROM_TRANSACTION'=>true,
            'API_URL'=>'https://info.payu.in/merchant/postservice.php?form=2',
        ],*/
        'PAYTMQR'=>[
			'PAYTMQR_MERCHANT_ID'=>'EPICTE67767187383060',
			'PAYTMQR_POS_ID'=>'9683634578',
			'PAYTMQR_SECRET_KEY'=>'I#m_0Z0Wduu8gFgA', //paytm_secret_key
			'PAYTMQR_URL'=>'https://securegw.paytm.in/qr/create', //paytm_secret_key
			'PAYTMQR_STATUS_URL'=>'https://securegw.paytm.in/merchant-status/getTxnStatus', //paytm_secret_key
		],
		'PAYTM'=>[
			'PAYTM_ENVIRONMENT'=>'TEST',
			'PAYTM_STATUS_QUERY_URL'=>'https://securegw-stage.paytm.in/merchant-status/getTxnStatus',
			'PAYTM_STATUS_QUERY_NEW_URL'=>'https://securegw-stage.paytm.in/merchant-status/getTxnStatus',
			'PAYTM_CHANNEL_ID'=>'WEB',
			'PAYTM_MERCHANT_ID'=>'EPICTE95887575931629', // 'EPICTE92166207376016',
			'PAYTM_MERCHANT_KEY'=>'ngjvT1YD3ktF@IhZ',
			'PAYTM_MERCHANT_WEBSITE'=>'WEBPROD', //'WEBSTAGING',
			'PAYTM_TXN_URL'=>'https://securegw.paytm.in/theia/processTransaction',
			'PAYTM_INDUSTRY_TYPE_ID'=>'Retail92',
			'PAYTM_CALLBACK_URL'=> 'https://stg.epicon.epicchannel.com/paytm/response',
			'PAYTM_ANDROID_MERCHANT_ID'=>'EPICTE92166207376016',
			'PAYTM_ANDROID_MERCHANT_KEY'=>'ngjvT1YD3ktF@IhZ',
			'PAYTM_ANDROID_MERCHANT_WEBSITE'=>'APPPROD',
			'PAYTM_ANDROID_STATUS_QUERY_URL'=>'',
			'PAYTM_ANDROID_STATUS_NEW_QUERY_URL'=>'',
			'PAYTM_ANDROID_TXN_URL'=>'https://securegw.paytm.in/theia/processTransaction',
			'PAYTM_ANDROID_CHANNEL_ID'=>'WAP',
			'PAYTM_ANDROID_INDUSTRY_TYPE_ID'=>'Retail92',
			'PAYTM_ANDROID_CALLBACK_URL'=> 'https://securegw.paytm.in/theia/paytmCallback?ORDER_ID=',
			'PAYTM_ANDROID_RESPONSE_URL'=> 'https://stg.epicon.epicchannel.com/ccavep/ptmResponseHandler',
		],
		'CLEVERTAP'=>[
			'CLEVERTAP_ACCOUNT_ID'=>'TEST-W86-596-W75Z',
			'CLEVERTAP_PASSCODE'=>'IYC-JUY-YTKL',
			'CLEVERTAP_TXN_URL' => 'https://api.clevertap.com/1/upload'
		],
		'SERVICES'=>[
			'google' => [
				'redirect'=>'https://stg.epicon.in/login/google/callback',
				'GOOGLE_CLIENT_ID'=>'812942192248-c95nfhscgbqrp1lkbpab1841gk1issah.apps.googleusercontent.com',
				'GOOGLE_CLIENT_SECRET'=>'IklyRUQgnQCSSiBoivzhoY3q'
			],
			'facebook' => [
				'redirect'=>'https://stg.epicon.in/login/facebook/callback',
				'FACEBOOK_CLIENT_ID'=>'1534199926602841',
				'FACEBOOK_CLIENT_SECRET'=>'72fc40fffd7c00b412d143e6e0a7b3e7'
			],
			'twitter' => [
				'redirect'=>'https://stg.epicon.in/login/twitter/callback',
				'TWITTER_CLIENT_ID'=>'nwKbID9Lq9Pzbkg5YCE3Dd8Z7',
				'TWITTER_CLIENT_SECRET'=>'h3hZYGKk8qEbAns5q6YnfRZYMR2vIGDxjEQZffRT9hyIanF9Lx'
			],
		],
		'JUSPAY'=>[
			'API_KEY'=>'E978A1749514E4A8BAB54A9E41E4B3'
		],
		'SUPERCOIN'=>[
			'SUPERCOIN_BRAND_KEY'=>'g8Zhoqef4twyALo2h6wDG3XsnhFpEkg74zGEoZqW2Yp9JUw8', // MERCHABT_ID 117245
			'SUPERCOIN_ACCESS_TOKEN'=>'5d146c5a9b56423c87a8ec6f6dd929a9669a4b3343d749a9b32343a150b16436',
			'SUPERCOIN_HMAC'=>'2f25ebd899e2440e996412772cf7fbcef01ec10acbb449e3b2e4712ff728f39c',
			'CALLBACK_RESPONSE_URL'=>env('APP_URL').'/flipkart/supercoinpay/callback_response',
			'HASH_WEBHOOK_URL'=>env('APP_URL').'/flipkart/supercoinpay/hash_webhook',
			'TRANSACTION_WEBHOOK_URL'=>env('APP_URL').'/flipkart/supercoinpay/transaction_webhook',
            'ANDROID_RESPONSE_URL'=>env('APP_URL').'/flipkart/supercoinpay/androidresponse',
            'TESTMODE'=>true,
            'SUBSCRIPTION_URL'=>'',
            'TWID_API_URL'=>'https://api.beta.twidapp.com/pwa/',
		],
		'FLIPKARTULTRA'=>[
			'ULTRA_ENDPOINT'=>'https://platform.flipkart.net/',
			'ULTRA_OMS_ENDPOINT' => 'https://ultra-lite.flipkart.net/ultra/',
		],
		'GOOGLECRAWL'=>[
			'podcast/aawaz-e-kalam/season-1/dushyant-kumar-ye-dhuen-ka-ghire-hai-ki-main-jisme','podcast/aawaz-e-kalam/season-1/ahmad-faraz-junun-e-musaffat-me-ghar-se-nikle-the','podcast/aawaz-e-kalam/season-1/dushyant-kumar-ghar-me-kis-tarah-saheju-man-ko','epic-shorts/international-tiger-day/season-1/e6-a-tale-of-success-12619','podcast/aawaz-e-kalam/season-1/dushyant-kumar-aaj-veeran-apna-ghar-dekha','podcast/aawaz-e-kalam/season-1/kavi-kunvar-narayan-kavita-ke-bahane','podcast/the-next-ten-years/season-1/jo-aggarwal-co-founder-ceo','podcast/aawaz-e-kalam/season-1/luv-tomar-siva-tere','podcast/aawaz-e-kalam/season-1/ahmad-faraz-kam-kam-mila-karo-usse','podcast/aawaz-e-kalam/season-1/ahmad-pharaz-khushbu-ka-safar-dekhega-kaun','podcast/aawaz-e-kalam/season-1/ahmad-faraz-zakhm-na-bharte-koi-aur','podcast/aawaz-e-kalam/season-1/harivanshrai-bachchan-aatmaparichay','podcast/aawaz-e-kalam/season-1/ahmad-faraz-saja-kyu-nahi-dete','podcast/aawaz-e-kalam/season-1/luv-tomar-aksar-tere-ishq-me','podcast/aawaz-e-kalam/season-1'
		],		
		'moengage'=>[
			'APP_ID_API'=>'MQA1U2LIXTRNW844CWFLGT1A_DEBUG',
			'APP_ID'=>'MQA1U2LIXTRNW844CWFLGT1A_DEBUG',
			'APP_KEY'=>'vrzKEnzU3CQ7DEBkC2hcZETe',
			'CUSTOMER_TXN_URL' => 'https://api.moengage.com/v1/customer/',
			'EVENT_TXN_URL' => 'https://api.moengage.com/v1/event/'
		]
	];
} else if($environment=='DEV'){
	return [
		'EPICCOIN'=>[
			'VIDEO_WATCH_POINT_PER_MIN'=>'2',
			'PLATFORM_SPENT_POINT_PER_MIN'=>'1',
			'SIGNUP_PER_USER'=>'20',
			'SUBSCRIPTION_SPENT_POINT_PER_INR'=>'3',
		],		
		'MISCCONFIG'=>[
			'GAID'=>'UA-127230808-1',
			'ONESIGNAL_APPID'=>'71f3a678-707c-4f27-b722-836e941fab29',
			'JWPLAYER_KEY'=>'KjZLp2bXKLFcL2hCVYkFGYOMt5R/lLYPPlMUHJNj5VI3fqJ2',
			'AD_CONFIGID'=>'AW-848963660',
		],
        'ASSET'=>[
            'ASSET_URL'=>env('APP_URL')
        ],
		'EPICAPI'=>[
			'API_DOMAIN'=>'https://dev-njsapi.epicchannel.com/',

			'API_DOMAIN_1'=>'http://contentapi-njsapi.epicon.in/index/',
			'API_DOMAIN_2' => 'http://userapi-njsapi.epicon.in/',
			'API_DOMAIN_3' => 'https://njsapi.epicon.in/v2/',


			'API_AUTH_TOKEN'=>'szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH',
			'CONSCENT_API_URL' => 'https://sandbox-api.conscent.in',
			'CONSCENT_SDK_URL' => 'https://sandbox-sdk.conscent.in',
			'CONSCENT_CLIENT_ID' => '607fd7557363d85ea01fe64f',

		],
		'CCAVENUE'=>[
			'INDIPAY_MERCHANT_ID'=>'137971',
			'INDIPAY_ACCESS_CODE'=>'AVYF81FJ36CN25FYNC',
			'INDIPAY_WORKING_KEY'=>'ED6877EA67E74C82BF0B12FE30E79097',
			'ANDROID_ACCESS_CODE'=>'AVGC82FL05AG21CGGA',
			'ANDROID_WORKING_KEY'=>'C6BF54B2CD0E2F2CFB2E768A5BA0FBC8',
			'ANDROID_GETRSAKEY_URL'=>'https://secure.ccavenue.com/transaction/getRSAKey'
		],
		//test
		/*'PAYUMONEY'=>[				
			'PAYUMONEY_MERCHANT_KEY'=>'5Z7qv4', // MERCHABT_ID 117245
			'PAYUMONEY_SALT'=>'9S0qvfqO',
			'RESPONSE_URL'=>'https://dev.epicon.in/payumoney/response',
			'ANDROID_RESPONSE_URL'=>'https://dev.epicon.in/payumoney/androidresponse',
			'TESTMODE'=>true,
			'SUBSCRIPTION_URL'=>'https://subscriptiontest.citruspay.com/',
			'ENABLE_RECURRING_API'=>false,
			'ENABLE_RECURRING_AT_FROM_TRANSACTION'=>false,
			'API_URL'=>'https://test.payu.in/merchant/postservice.php?form=2',
		],*/
		//PRODUCTION
        'PAYUMONEY'=>[
            'PAYUMONEY_MERCHANT_KEY'=>'lp1BOz', // MERCHABT_ID 117245 // gtKFFx
            'PAYUMONEY_SALT'=>'Vv7fqdW7VdtV9DxJyunZ2BLsXPnwaBax',//4R38IvwiV57FwVpsgOvTXBdLE4tHUXFW
            'ANDROID_RESPONSE_URL'=>'https://dev.epicon.in/payumoney/androidresponse',
            'TESTMODE'=>true,
            'SUBSCRIPTION_URL'=>'https://test.payu.in/_payment',
            'ENABLE_RECURRING_API'=>true,
            'ENABLE_RECURRING_AT_FROM_TRANSACTION'=>true,
            //'API_URL'=>'https://info.payu.in/merchant/postservice.php?form=2',
			'API_URL'=>'https://test.payu.in/merchant/postservice.php?form=2',
			'CANCEL_RECURRING_URL' =>'https://test.payu.in/merchant/'	
        ],
        'PAYTMQR'=>[
			'PAYTMQR_MERCHANT_ID'=>'EPICTE67767187383060',
			'PAYTMQR_POS_ID'=>'9683634578',
			'PAYTMQR_SECRET_KEY'=>'I#m_0Z0Wduu8gFgA', //paytm_secret_key
			'PAYTMQR_URL'=>'https://securegw.paytm.in/qr/create', //paytm_secret_key
			'PAYTMQR_STATUS_URL'=>'https://securegw.paytm.in/merchant-status/getTxnStatus', //paytm_secret_key
		],
		'PAYTM'=>[
			'PAYTM_ENVIRONMENT'=>'TEST',
			'PAYTM_STATUS_QUERY_URL'=>'https://securegw-stage.paytm.in/merchant-status/getTxnStatus',
			'PAYTM_STATUS_QUERY_NEW_URL'=>'https://securegw-stage.paytm.in/merchant-status/getTxnStatus',
			'PAYTM_CHANNEL_ID'=>'WEB',
			'PAYTM_MERCHANT_ID'=>'EPICTE95887575931629', // 'EPICTE92166207376016',
			'PAYTM_MERCHANT_KEY'=>'ngjvT1YD3ktF@IhZ',
			'PAYTM_MERCHANT_WEBSITE'=>'WEBPROD', //'WEBSTAGING',
			'PAYTM_TXN_URL'=>'https://securegw.paytm.in/theia/processTransaction',
			'PAYTM_INDUSTRY_TYPE_ID'=>'Retail92',
			'PAYTM_CALLBACK_URL'=> 'https://dev.epicon.epicchannel.com/paytm/response',
			'PAYTM_ANDROID_MERCHANT_ID'=>'EPICTE92166207376016',
			'PAYTM_ANDROID_MERCHANT_KEY'=>'ngjvT1YD3ktF@IhZ',
			'PAYTM_ANDROID_MERCHANT_WEBSITE'=>'APPPROD',
			'PAYTM_ANDROID_STATUS_QUERY_URL'=>'',
			'PAYTM_ANDROID_STATUS_NEW_QUERY_URL'=>'',
			'PAYTM_ANDROID_TXN_URL'=>'https://securegw.paytm.in/theia/processTransaction',
			'PAYTM_ANDROID_CHANNEL_ID'=>'WAP',
			'PAYTM_ANDROID_INDUSTRY_TYPE_ID'=>'Retail92',
			'PAYTM_ANDROID_CALLBACK_URL'=> 'https://securegw.paytm.in/theia/paytmCallback?ORDER_ID=',
			'PAYTM_ANDROID_RESPONSE_URL'=> 'https://dev.epicon.epicchannel.com/ccavep/ptmResponseHandler',
		],
		'CLEVERTAP'=>[
			'CLEVERTAP_ACCOUNT_ID'=>'TEST-W86-596-W75Z',
			'CLEVERTAP_PASSCODE'=>'IYC-JUY-YTKL',
			'CLEVERTAP_TXN_URL' => 'https://api.clevertap.com/1/upload'
		],
		'SERVICES'=>[
			'google' => [
				'redirect'=>'https://dev.epicon.in/login/google/callback',
				'GOOGLE_CLIENT_ID'=>'812942192248-c95nfhscgbqrp1lkbpab1841gk1issah.apps.googleusercontent.com',
				'GOOGLE_CLIENT_SECRET'=>'IklyRUQgnQCSSiBoivzhoY3q'
			],
			'facebook' => [
				'redirect'=>'https://dev.epicon.in/login/facebook/callback',
				'FACEBOOK_CLIENT_ID'=>'1534199926602841',
				'FACEBOOK_CLIENT_SECRET'=>'72fc40fffd7c00b412d143e6e0a7b3e7'
			],
			'twitter' => [
				'redirect'=>'https://dev.epicon.in/login/twitter/callback',
				'TWITTER_CLIENT_ID'=>'nwKbID9Lq9Pzbkg5YCE3Dd8Z7',
				'TWITTER_CLIENT_SECRET'=>'h3hZYGKk8qEbAns5q6YnfRZYMR2vIGDxjEQZffRT9hyIanF9Lx'
			],
		],
		'JUSPAY'=>[
			'API_KEY'=>'E978A1749514E4A8BAB54A9E41E4B3'
		],
		'GOOGLECRAWL'=>[
			'podcast/aawaz-e-kalam/season-1/dushyant-kumar-ye-dhuen-ka-ghire-hai-ki-main-jisme','podcast/aawaz-e-kalam/season-1/ahmad-faraz-junun-e-musaffat-me-ghar-se-nikle-the','podcast/aawaz-e-kalam/season-1/dushyant-kumar-ghar-me-kis-tarah-saheju-man-ko','epic-shorts/international-tiger-day/season-1/e6-a-tale-of-success-12619','podcast/aawaz-e-kalam/season-1/dushyant-kumar-aaj-veeran-apna-ghar-dekha','podcast/aawaz-e-kalam/season-1/kavi-kunvar-narayan-kavita-ke-bahane','podcast/the-next-ten-years/season-1/jo-aggarwal-co-founder-ceo','podcast/aawaz-e-kalam/season-1/luv-tomar-siva-tere','podcast/aawaz-e-kalam/season-1/ahmad-faraz-kam-kam-mila-karo-usse','podcast/aawaz-e-kalam/season-1/ahmad-pharaz-khushbu-ka-safar-dekhega-kaun','podcast/aawaz-e-kalam/season-1/ahmad-faraz-zakhm-na-bharte-koi-aur','podcast/aawaz-e-kalam/season-1/harivanshrai-bachchan-aatmaparichay','podcast/aawaz-e-kalam/season-1/ahmad-faraz-saja-kyu-nahi-dete','podcast/aawaz-e-kalam/season-1/luv-tomar-aksar-tere-ishq-me','podcast/aawaz-e-kalam/season-1'
		]
	];
} else if($environment=='LOCAL'){
	return [
		'EPICCOIN'=>[
			'VIDEO_WATCH_POINT_PER_MIN'=>'2',
			'PLATFORM_SPENT_POINT_PER_MIN'=>'1',
			'SIGNUP_PER_USER'=>'20',
			'SUBSCRIPTION_SPENT_POINT_PER_INR'=>'3',
		],		
		'MISCCONFIG'=>[
			'GAID'=>'UA-127230808-1',
			'ONESIGNAL_APPID'=>'71f3a678-707c-4f27-b722-836e941fab29',
			'JWPLAYER_KEY'=>'KjZLp2bXKLFcL2hCVYkFGYOMt5R/lLYPPlMUHJNj5VI3fqJ2'
		],
        'ASSET'=>[
            'ASSET_URL'=>env('APP_URL')//'http://local.revamp-epicon.com/'
        ],
		'EPICAPI'=>[
			'API_DOMAIN'=>env('API_URL'),

			'API_DOMAIN_1'=>'http://contentapi-njsapi.epicon.in/index/',
			'API_DOMAIN_2' => 'http://userapi-njsapi.epicon.in/',
			'API_DOMAIN_3' => 'https://njsapi.epicon.in/v2/',

			//'API_DOMAIN'=>'https://dev-njsapi.epicchannel.com/',
			'API_AUTH_TOKEN'=>'szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH',
			'CONSCENT_API_URL' => 'https://sandbox-api.conscent.in',
			'CONSCENT_SDK_URL' => 'https://sandbox-sdk.conscent.in',
			'CONSCENT_CLIENT_ID' => '607fd7557363d85ea01fe64f',
		],
		'CCAVENUE'=>[
			'INDIPAY_MERCHANT_ID'=>'137971',
			'INDIPAY_ACCESS_CODE'=>'AVYF81FJ36CN25FYNC',
			'INDIPAY_WORKING_KEY'=>'ED6877EA67E74C82BF0B12FE30E79097',
			'ANDROID_ACCESS_CODE'=>'AVGC82FL05AG21CGGA',
			'ANDROID_WORKING_KEY'=>'C6BF54B2CD0E2F2CFB2E768A5BA0FBC8',
			'ANDROID_GETRSAKEY_URL'=>'https://secure.ccavenue.com/transaction/getRSAKey'
		],
        'PAYUMONEY'=>[
            'PAYUMONEY_MERCHANT_KEY'=>'lp1BOz', // MERCHABT_ID 117245 // gtKFFx
            'PAYUMONEY_SALT'=>'Vv7fqdW7VdtV9DxJyunZ2BLsXPnwaBax',//4R38IvwiV57FwVpsgOvTXBdLE4tHUXFW
            'ANDROID_RESPONSE_URL'=>'https://dev.epicon.in/payumoney/androidresponse',
            'TESTMODE'=>true,
            'SUBSCRIPTION_URL'=>'https://test.payu.in/_payment',
            'ENABLE_RECURRING_API'=>true,
            'ENABLE_RECURRING_AT_FROM_TRANSACTION'=>true,
            //'API_URL'=>'https://info.payu.in/merchant/postservice.php?form=2',
			'API_URL'=>'https://test.payu.in/merchant/postservice.php?form=2',
			'CANCEL_RECURRING_URL' =>'https://test.payu.in/merchant/'	
        ],
		'PAYTM'=>[
			'PAYTM_ENVIRONMENT'=>'TEST',
			'PAYTM_STATUS_QUERY_URL'=>'https://securegw-stage.paytm.in/merchant-status/getTxnStatus',
			'PAYTM_STATUS_QUERY_NEW_URL'=>'https://securegw-stage.paytm.in/merchant-status/getTxnStatus',
			'PAYTM_CHANNEL_ID'=>'WEB',

			'PAYTM_MERCHANT_ID'=>'EPICTE95887575931629',//'EPICTE92166207376016', // 'EPICTE92166207376016',
			'PAYTM_MERCHANT_KEY'=>'ngjvT1YD3ktF@IhZ',
			'PAYTM_MERCHANT_WEBSITE'=>'WEBPROD', //'WEBSTAGING',
			'PAYTM_TXN_URL'=>'https://securegw.paytm.in/theia/processTransaction',
			'PAYTM_INDUSTRY_TYPE_ID'=>'Retail92',
			'PAYTM_CALLBACK_URL'=> 'https://dev.epicon.epicchannel.com/paytm/response',
			/*'PAYTM_MERCHANT_ID'=>'EPICTE95887575931629', // 'EPICTE92166207376016',
			'PAYTM_MERCHANT_KEY'=>'7m5EqN!XRNjO3Jw5',
			'PAYTM_MERCHANT_WEBSITE'=>'WEB_STAGING', //'WEBSTAGING',
			'PAYTM_TXN_URL'=>'https://pguat.paytm.com/oltp-web/processTransaction', //https://securegw-stage.paytm.in/theia/processTransaction',
			'PAYTM_INDUSTRY_TYPE_ID'=>'Retail',
			'PAYTM_CALLBACK_URL'=> 'https://dev.epicon.epicchannel.com/paytm/response',*/


			'PAYTM_ANDROID_MERCHANT_ID'=>'EPICTE92166207376016',
			'PAYTM_ANDROID_MERCHANT_KEY'=>'ngjvT1YD3ktF@IhZ',
			'PAYTM_ANDROID_MERCHANT_WEBSITE'=>'APPPROD',
			'PAYTM_ANDROID_STATUS_QUERY_URL'=>'',
			'PAYTM_ANDROID_STATUS_NEW_QUERY_URL'=>'',
			'PAYTM_ANDROID_TXN_URL'=>'https://securegw.paytm.in/theia/processTransaction',
			'PAYTM_ANDROID_CHANNEL_ID'=>'WAP',
			'PAYTM_ANDROID_INDUSTRY_TYPE_ID'=>'Retail92',
			'PAYTM_ANDROID_CALLBACK_URL'=> 'https://securegw.paytm.in/theia/paytmCallback?ORDER_ID=',
			'PAYTM_ANDROID_RESPONSE_URL'=> 'https://dev.epicon.epicchannel.com/ccavep/ptmResponseHandler',
		],
		'CLEVERTAP'=>[
			'CLEVERTAP_ACCOUNT_ID'=>'TEST-W86-596-W75Z',
			'CLEVERTAP_PASSCODE'=>'IYC-JUY-YTKL',
			'CLEVERTAP_TXN_URL' => 'https://api.clevertap.com/1/upload'
		],
		'SERVICES'=>[
			'google' => [
				'redirect'=>'http://local.revamp-epicon.com/login/google/callback',
				'GOOGLE_CLIENT_ID'=>'922986323229-07skjdfn80vsvt6c38prituv0toj7bc1.apps.googleusercontent.com',
				'GOOGLE_CLIENT_SECRET'=>'mo-J6CiIjiF2f14qN-zAbeQr'
			],
			'facebook' => [
				'redirect'=>'http://local.revamp-epicon.com/login/facebook/callback',
				'FACEBOOK_CLIENT_ID'=>'1913090075664068',
				'FACEBOOK_CLIENT_SECRET'=>'ff8f8760c9485a6e9282986977d84e56'
			],
			'twitter' => [
				'redirect'=>'http://local.revamp-epicon.com/login/twitter/callback',
				'TWITTER_CLIENT_ID'=>'nwKbID9Lq9Pzbkg5YCE3Dd8Z7',
				'TWITTER_CLIENT_SECRET'=>'h3hZYGKk8qEbAns5q6YnfRZYMR2vIGDxjEQZffRT9hyIanF9Lx'
			],
		],
		'GOOGLECRAWL'=>[
			'podcast/aawaz-e-kalam/season-1/dushyant-kumar-ye-dhuen-ka-ghire-hai-ki-main-jisme','podcast/aawaz-e-kalam/season-1/ahmad-faraz-junun-e-musaffat-me-ghar-se-nikle-the','podcast/aawaz-e-kalam/season-1/dushyant-kumar-ghar-me-kis-tarah-saheju-man-ko','epic-shorts/international-tiger-day/season-1/e6-a-tale-of-success-12619','podcast/aawaz-e-kalam/season-1/dushyant-kumar-aaj-veeran-apna-ghar-dekha','podcast/aawaz-e-kalam/season-1/kavi-kunvar-narayan-kavita-ke-bahane','podcast/the-next-ten-years/season-1/jo-aggarwal-co-founder-ceo','podcast/aawaz-e-kalam/season-1/luv-tomar-siva-tere','podcast/aawaz-e-kalam/season-1/ahmad-faraz-kam-kam-mila-karo-usse','podcast/aawaz-e-kalam/season-1/ahmad-pharaz-khushbu-ka-safar-dekhega-kaun','podcast/aawaz-e-kalam/season-1/ahmad-faraz-zakhm-na-bharte-koi-aur','podcast/aawaz-e-kalam/season-1/harivanshrai-bachchan-aatmaparichay','podcast/aawaz-e-kalam/season-1/ahmad-faraz-saja-kyu-nahi-dete','podcast/aawaz-e-kalam/season-1/luv-tomar-aksar-tere-ishq-me','podcast/aawaz-e-kalam/season-1'
		],
		'moengage'=>[
			'APP_ID_API'=>'MQA1U2LIXTRNW844CWFLGT1A_DEBUG',
			'APP_ID'=>'MQA1U2LIXTRNW844CWFLGT1A_DEBUG',
			'APP_KEY'=>'vrzKEnzU3CQ7DEBkC2hcZETe',
			'CUSTOMER_TXN_URL' => 'https://api.moengage.com/v1/customer/',
			'EVENT_TXN_URL' => 'https://api.moengage.com/v1/event/'
		]
	];
} else {
	return [
		'EPICCOIN'=>[
			'VIDEO_WATCH_POINT_PER_MIN'=>'2',
			'PLATFORM_SPENT_POINT_PER_MIN'=>'1',
			'SIGNUP_PER_USER'=>'20',
			'SUBSCRIPTION_SPENT_POINT_PER_INR'=>'3',
		],
		'GACONFIG'=>['GAID'=>'UA-127230808-1'],
		'EPICAPI'=>[
			'API_DOMAIN'=>'https://dev-njsapi.epicchannel.com/',

			'API_DOMAIN_1'=>'http://contentapi-njsapi.epicon.in/index/',
			'API_DOMAIN_2' => 'http://userapi-njsapi.epicon.in/',
			'API_DOMAIN_3' => 'https://njsapi.epicon.in/v2/',

			'API_AUTH_TOKEN'=>'szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH',
			'CONSCENT_API_URL' => 'https://sandbox-api.conscent.in',
			'CONSCENT_SDK_URL' => 'https://sandbox-sdk.conscent.in',
			'CONSCENT_CLIENT_ID' => '607fd7557363d85ea01fe64f',
		],
		'CCAVENUE'=>[
			'INDIPAY_MERCHANT_ID'=>'137971',
			'INDIPAY_ACCESS_CODE'=>'AVYF81FJ36CN25FYNC',
			'INDIPAY_WORKING_KEY'=>'ED6877EA67E74C82BF0B12FE30E79097',
			'ANDROID_ACCESS_CODE'=>'AVGC82FL05AG21CGGA',
			'ANDROID_WORKING_KEY'=>'C6BF54B2CD0E2F2CFB2E768A5BA0FBC8',
			'ANDROID_GETRSAKEY_URL'=>'https://secure.ccavenue.com/transaction/getRSAKey'
		],
		'PAYTM'=>[
			'PAYTM_ENVIRONMENT'=>'TEST',
			'PAYTM_STATUS_QUERY_URL'=>'https://securegw-stage.paytm.in/merchant-status/getTxnStatus',
			'PAYTM_STATUS_QUERY_NEW_URL'=>'https://securegw-stage.paytm.in/merchant-status/getTxnStatus',
			'PAYTM_CHANNEL_ID'=>'WEB',

			'PAYTM_MERCHANT_ID'=>'EPICTE92166207376016', // 'EPICTE92166207376016',
			'PAYTM_MERCHANT_KEY'=>'ngjvT1YD3ktF@IhZ',
			'PAYTM_MERCHANT_WEBSITE'=>'WEBPROD', //'WEBSTAGING',
			'PAYTM_TXN_URL'=>'https://securegw.paytm.in/theia/processTransaction',
			'PAYTM_INDUSTRY_TYPE_ID'=>'Retail92',
			'PAYTM_CALLBACK_URL'=> 'https://dev.epicon.epicchannel.com/paytm/response',
			/*'PAYTM_MERCHANT_ID'=>'EPICTE95887575931629', // 'EPICTE92166207376016',
			'PAYTM_MERCHANT_KEY'=>'7m5EqN!XRNjO3Jw5',
			'PAYTM_MERCHANT_WEBSITE'=>'WEB_STAGING', //'WEBSTAGING',
			'PAYTM_TXN_URL'=>'https://pguat.paytm.com/oltp-web/processTransaction', //https://securegw-stage.paytm.in/theia/processTransaction',
			'PAYTM_INDUSTRY_TYPE_ID'=>'Retail',
			'PAYTM_CALLBACK_URL'=> 'https://dev.epicon.epicchannel.com/paytm/response',*/


			'PAYTM_ANDROID_MERCHANT_ID'=>'EPICTE92166207376016',
			'PAYTM_ANDROID_MERCHANT_KEY'=>'ngjvT1YD3ktF@IhZ',
			'PAYTM_ANDROID_MERCHANT_WEBSITE'=>'APPPROD',
			'PAYTM_ANDROID_STATUS_QUERY_URL'=>'',
			'PAYTM_ANDROID_STATUS_NEW_QUERY_URL'=>'',
			'PAYTM_ANDROID_TXN_URL'=>'https://securegw.paytm.in/theia/processTransaction',
			'PAYTM_ANDROID_CHANNEL_ID'=>'WAP',
			'PAYTM_ANDROID_INDUSTRY_TYPE_ID'=>'Retail92',
			'PAYTM_ANDROID_CALLBACK_URL'=> 'https://securegw.paytm.in/theia/paytmCallback?ORDER_ID=',
			'PAYTM_ANDROID_RESPONSE_URL'=> 'https://dev.epicon.epicchannel.com/ccavep/ptmResponseHandler',
		],
		'SERVICES'=>[
			'google' => [
				'redirect'=>'https://dev.epicon.epicchannel.com/login/google/callback',
				'GOOGLE_CLIENT_ID'=>'922986323229-07skjdfn80vsvt6c38prituv0toj7bc1.apps.googleusercontent.com',
				'GOOGLE_CLIENT_SECRET'=>'mo-J6CiIjiF2f14qN-zAbeQr'
			],
			'facebook' => [
				'redirect'=>'https://dev.epicon.epicchannel.com/login/facebook/callback',
				'FACEBOOK_CLIENT_ID'=>'1913090075664068',
				'FACEBOOK_CLIENT_SECRET'=>'ff8f8760c9485a6e9282986977d84e56'
			],
			'twitter' => [
				'redirect'=>'https://dev.epicon.epicchannel.com/login/twitter/callback',
				'TWITTER_CLIENT_ID'=>'nwKbID9Lq9Pzbkg5YCE3Dd8Z7',
				'TWITTER_CLIENT_SECRET'=>'h3hZYGKk8qEbAns5q6YnfRZYMR2vIGDxjEQZffRT9hyIanF9Lx'
			],
		],
		'moengage'=>[
			'APP_ID_API'=>'MQA1U2LIXTRNW844CWFLGT1A_DEBUG',
			'APP_ID'=>'MQA1U2LIXTRNW844CWFLGT1A_DEBUG',
			'APP_KEY'=>'vrzKEnzU3CQ7DEBkC2hcZETe',
			'CUSTOMER_TXN_URL' => 'https://api.moengage.com/v1/customer/',
			'EVENT_TXN_URL' => 'https://api.moengage.com/v1/event/'
		],
		'GOOGLECRAWL'=>[
			'podcast/aawaz-e-kalam/season-1/dushyant-kumar-ye-dhuen-ka-ghire-hai-ki-main-jisme','podcast/aawaz-e-kalam/season-1/ahmad-faraz-junun-e-musaffat-me-ghar-se-nikle-the','podcast/aawaz-e-kalam/season-1/dushyant-kumar-ghar-me-kis-tarah-saheju-man-ko','epic-shorts/international-tiger-day/season-1/e6-a-tale-of-success-12619','podcast/aawaz-e-kalam/season-1/dushyant-kumar-aaj-veeran-apna-ghar-dekha','podcast/aawaz-e-kalam/season-1/kavi-kunvar-narayan-kavita-ke-bahane','podcast/the-next-ten-years/season-1/jo-aggarwal-co-founder-ceo','podcast/aawaz-e-kalam/season-1/luv-tomar-siva-tere','podcast/aawaz-e-kalam/season-1/ahmad-faraz-kam-kam-mila-karo-usse','podcast/aawaz-e-kalam/season-1/ahmad-pharaz-khushbu-ka-safar-dekhega-kaun','podcast/aawaz-e-kalam/season-1/ahmad-faraz-zakhm-na-bharte-koi-aur','podcast/aawaz-e-kalam/season-1/harivanshrai-bachchan-aatmaparichay','podcast/aawaz-e-kalam/season-1/ahmad-faraz-saja-kyu-nahi-dete','podcast/aawaz-e-kalam/season-1/luv-tomar-aksar-tere-ishq-me','podcast/aawaz-e-kalam/season-1'
		]
	];
}
