<?php

declare(strict_types=1);

use App\Http\Controllers\ProfileController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Detection\MobileDetect;
use Illuminate\Support\Facades\Log;

if (!function_exists('getUserAgent')) {
    function getUserAgent()
    {   
        if( Cookie::get('user_agent_10') ){
            // Log::info("Cookie - ".Cookie::get('user_agent_10'));
            session()->put('device-detail', Cookie::get('user_agent_10') );

            return Cookie::get('user_agent_10');
        }

        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $ub = 'Unknown';
        $platform = 'Unknown';

        // First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $ub = "Netscape";
        }
        $o_system = $platform . " X" . time();
        $deviceDetail = "$ub ($o_system)";
        session()->put('device-detail', $deviceDetail);

        Cookie::queue('user_agent_10', $deviceDetail, 525600);

        return $deviceDetail;
    }
}

if (!function_exists('JSONResponse')) {
    function JSONResponse(int $statusCode, string $message, array $data = []): JsonResponse
    {
        return response()->json(
            data: [
                'message' => $message,
                'payload' => $data,
            ],
            status: $statusCode,
        );
    }
}

if (!function_exists('d')) {

    function d($data, $die = false)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        if ($die) {
            exit;
        }
    }
}
function setLanguageParameter()
{
    $displaylangParameter = app()->getLocale();
    // dd($displaylangParameter);
    if ($displaylangParameter == 'hi') {
        $displayLanguage = "HINDI";
    } elseif ($displaylangParameter == 'en') {
        $displayLanguage = "ENGLISH";
    } elseif ($displaylangParameter == 'ta') {
        $displayLanguage = "TAMIL";
    } elseif ($displaylangParameter == 'ma') {
        $displayLanguage = "MARATHI";
    } elseif ($displaylangParameter == 'te') {
        $displayLanguage = "TELUGU";
    } else {
        $displayLanguage = "ENGLISH";
    }
    return $displayLanguage;
}

function setLanguageParameterMore()
{
    $request = Request();
    if ($request->session()->get('displayLanguage') == 'hindi') {
        $displaylangParameter = 'hi';
    } else {
        $displaylangParameter = 'en';
    }
    // dd($displaylangParameter);
    if ($displaylangParameter == 'hi') {
        $displayLanguage = "HINDI";
    } elseif ($displaylangParameter == 'en') {
        $displayLanguage = "ENGLISH";
    } elseif ($displaylangParameter == 'ta') {
        $displayLanguage = "TAMIL";
    } elseif ($displaylangParameter == 'ma') {
        $displayLanguage = "MARATHI";
    } elseif ($displaylangParameter == 'te') {
        $displayLanguage = "TELUGU";
    } else {
        $displayLanguage = "ENGLISH";
    }
    return $displayLanguage;
}

function getDispLangContent($content, $displayLanguageParam, $item)
{
    $displaylangContent = '';

    if ($item == "description") {
        if ($displayLanguageParam == "ENGLISH") {
            return $content['description'];
        } elseif ($displayLanguageParam == "HINDI") {
            return !empty($content['description_ln']['HINDI']) ? $content['description_ln']['HINDI'] : @$content['description'];
        } elseif ($displayLanguageParam == "TAMIL") {
            return !empty($content['description_ln']['TAMIL']) ? $content['description_ln']['TAMIL'] : $content['description'];
        } elseif ($displayLanguageParam == "MARATHI") {
            return !empty($content['description_ln']['MARATHI']) ? $content['description_ln']['MARATHI'] : $content['description'];
        } else {
            return $content['description_ln']['ENGLISH'];
        }
    } elseif ($item == "title") {
        if ($displayLanguageParam == "ENGLISH") {
            return @$content['title'];
        } elseif ($displayLanguageParam == "HINDI") {
            return !empty($content['title_ln']['HINDI']) ? $content['title_ln']['HINDI'] : @$content['title'];
        } elseif ($displayLanguageParam == "TAMIL") {
            return !empty($content['title_ln']['TAMIL']) ? $content['title_ln']['TAMIL'] : $content['title'];
        } elseif ($displayLanguageParam == "MARATHI") {
            return !empty($content['title_ln']['MARATHI']) ? $content['title_ln']['MARATHI'] : $content['title'];
        } else {
            return $content['title_ln']['ENGLISH'];
        }
    } elseif ($item == "coverimage") {
        if ($displayLanguageParam == "ENGLISH") {
            return @$content['cover_image'];
        } elseif ($displayLanguageParam == "HINDI") {
            return !empty($content['cover_image_v2_ln']['HINDI']) ? $content['cover_image_v2_ln']['HINDI'] : @$content['cover_image'];
        } elseif ($displayLanguageParam == "TAMIL") {
            return !empty($content['cover_image_v2_ln']['TAMIL']) ? $content['cover_image_v2_ln']['TAMIL'] : $content['cover_image'];
        } elseif ($displayLanguageParam == "MARATHI") {
            return !empty($content['cover_image_v2_ln']['MARATHI']) ? $content['cover_image_v2_ln']['MARATHI'] : $content['cover_image'];
        } else {
            return $content['title_ln']['ENGLISH'];
        }
    } elseif ($item == "shortdesc") {
        if ($displayLanguageParam == "ENGLISH") {
            return @$content['short_description'];
        } elseif ($displayLanguageParam == "HINDI") {
            return !empty($content['short_description_ln']['HINDI']) ? $content['short_description_ln']['HINDI'] : @$content['short_description'];
        } elseif ($displayLanguageParam == "TAMIL") {
            return !empty($content['short_description_ln']['TAMIL']) ? $content['short_description_ln']['TAMIL'] : $content['short_description'];
        } elseif ($displayLanguageParam == "MARATHI") {
            return !empty($content['short_description_ln']['MARATHI']) ? $content['short_description_ln']['MARATHI'] : $content['short_description'];
        } else {
            return $content['short_description_ln']['ENGLISH'];
        }
    } elseif ($item == "bannerimg") {
        if ($displayLanguageParam == "ENGLISH") {
            // print_r($content['banner_image']); echo "Testing by sneha"; exit();
            // return $content['banner_image']['original'];
            return @$content['banner_image'];
        } elseif ($displayLanguageParam == "HINDI") {
            return !empty($content['banner_image_v2_ln']['HINDI']) ? $content['banner_image_v2_ln']['HINDI'] : @$content['banner_image'];
        } elseif ($displayLanguageParam == "TAMIL") {
            return !empty($content['banner_image_v2_ln']['TAMIL']) ? $content['banner_image_v2_ln']['TAMIL'] : $content['banner_image'];
        } elseif ($displayLanguageParam == "MARATHI") {
            return !empty($content['banner_image_v2_ln']['MARATHI']) ? $content['banner_image_v2_ln']['MARATHI'] : $content['banner_image'];
        } else {
            return $content['banner_image_v2_ln']['ENGLISH'];
        }
    } elseif ($item == "bannerimg-vertical") {
        if ($displayLanguageParam == "ENGLISH") {
            return @$content['vertical_cover_image'];
        } elseif ($displayLanguageParam == "HINDI") {
            return !empty($content['banner_image_v2_ln']['HINDI']) ? $content['banner_image_v2_ln']['HINDI'] : @$content['vertical_cover_image'];
        } elseif ($displayLanguageParam == "TAMIL") {
            return !empty($content['banner_image_v2_ln']['TAMIL']) ? $content['banner_image_v2_ln']['TAMIL'] : $content['vertical_cover_image'];
        } elseif ($displayLanguageParam == "MARATHI") {
            return !empty($content['banner_image_v2_ln']['MARATHI']) ? $content['banner_image_v2_ln']['MARATHI'] : $content['vertical_cover_image'];
        } else {
            return @$content['vertical_cover_image']['ENGLISH'];
        }
    }
}

function getContentLanguage()
{
    $request = Request();
    if ($request->session()->has('listLanguage')) {
        $listLanguage = $request->session()->get('listLanguage');
    } else {
        $listLanguage = "all";
    }
    return $listLanguage;
}

function getPlayText($value)
{
    if (isset($value['user_duration']) && $value['user_duration'] > 0) {
        return 'RESUME';
    }
    return 'PLAY';
    // return $value['asset_type'] ?? 'WATCH';
}


function getImage($image, $size = 'original')
{

    if (is_array($image)) {
        if ($size == 'original') {
            //return $image['original'];
            $return_src = $image['original'];
        }
        if ($size == 'small' && isset($image['small'])) {
            //return $image['small'];
            $return_src = $image['small'];
        }
        if ($size == 'medium' && isset($image['medium'])) {
            //return $image['medium'];
            $return_src = $image['medium'];
        }
        if ($size == 'large' && isset($image['large'])) {
            //return $image['large'];
            $return_src = $image['large'];
        }
        //return $image['original'];
        if (empty($return_src)) {
            $return_src = $image['original'];
        }
        if (env("IS_S3_IMAGE_PATH") == "YES") {
            $return_src = str_replace("st2.epicon.in", "epcms.epicon.in", $return_src);
        }

        return $return_src;
    } else if (is_string($image)) {
        //return $image;
        $return_src = $image;
        if (env("IS_S3_IMAGE_PATH") == "YES") {
            $return_src = str_replace("st2.epicon.in", "epcms.epicon.in", $return_src);
        }
        return $return_src;
    } else {
        return null;
    }
}

function freePremiumDiv($val)
{
    echo (@$val['free_premium'] == true) ? '<span class="crown position-absolute"><img src="' . env('AWS_S3_domain') . 'epicon/assets/images/crown.svg" alt="premium"></span>' : '';
}

// function isPopularDiv($val)
// {
//     echo (@$val['is_popular'] == true) ? '<span><img src="' . env('AWS_S3_domain').'epicon/assets/images/fire-emoji.png' . '" alt=""></span>' : '';
// }


function topTenDiv($val)
{
    if (@$val['is_top10'] == true) {
        echo '<div class="top-ten position-absolute">
        <ul class="list-unstyled text-white">
        <li>Top</li>
        <li>10</li>
        </ul>
        </div>';
    }
}

function getWishListAction($val, $wishlist, $type = 1)
{
    if (!in_array(@$val['asset_type'], ['WATCH', 'LISTEN'])) {
        return '';
    }
    if (!isUserLoggedIn()) {
        $logClass = "loginwish";
        $addToList = "";
    } else {
        $logClass = "";
        $addToList = "addToList";
    }

    $wishlist_ids = $wishlist['ids'] ?? [];

    $wishAction = (in_array(@$val['ID'], $wishlist_ids)) ? 'delete' : 'add';

    if ($type == 1) {
        if ($wishAction == 'add') {
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 28 28" fill="none"><path d="M21.0026 15.1678H15.1693V21.0011C15.1693 21.6428 14.6443 22.1678 14.0026 22.1678C13.3609 22.1678 12.8359 21.6428 12.8359 21.0011V15.1678H7.0026C6.36094 15.1678 5.83594 14.6428 5.83594 14.0011C5.83594 13.3595 6.36094 12.8345 7.0026 12.8345H12.8359V7.00114C12.8359 6.35947 13.3609 5.83447 14.0026 5.83447C14.6443 5.83447 15.1693 6.35947 15.1693 7.00114V12.8345H21.0026C21.6443 12.8345 22.1693 13.3595 22.1693 14.0011C22.1693 14.6428 21.6443 15.1678 21.0026 15.1678Z" fill="white" /></svg>';
        } else {
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 22 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M20.8161 0.272093C21.2325 0.65643 21.2584 1.30553 20.8741 1.72189L7.999 15.6699C7.80961 15.8751 7.54478 15.9942 7.26561 15.9998C6.98644 16.0054 6.71706 15.8969 6.51962 15.6995L1.155 10.3349C0.754324 9.9342 0.754324 9.28458 1.155 8.88391C1.55567 8.48324 2.20529 8.48324 2.60596 8.88391L7.2155 13.4935L19.3663 0.330085C19.7506 -0.086281 20.3997 -0.112245 20.8161 0.272093Z" fill="white"/>
            </svg>';
        }
        // return '<button class="big-add-list addToList ' . $wishAction . '-icon" data-id="' . @$val['ID'] . '" data-action="' . $wishAction . '" data-type="1"> </button>';
        return '<button class="big-add-list ' . $logClass . $addToList . '" aria-label="wishlist" data-id="' . @$val['ID'] . '" data-action="' . $wishAction . '" data-type="1">  ' . $icon . '</button>';
    } else {
        // $icon = ($wishAction == 'add') ? 'delete-icon' : 'add-icon';
        return '<button class="small-btn ' . $wishAction . '-icon mx-2 mt-0 ' . $logClass . $addToList . '" aria-label="wishlist" data-id="' . @$val['ID'] . '" data-action="' . $wishAction . '" data-type="2"></button>';
    }
}

function getWishlist()
{
    /*
    if (Session::has('user_wishlist')) {
        return  session()->get('user_wishlist');
    } else {
        $params = [
            'action' => 'view'
        ];
        $result = CurlAPI("pages/wishlist", "POST", $params);

        if ($result && @$result['success'] ==  true) {
            $data =  ['data' => $result['contents'], 'ids' => array_column($result['contents'], 'ID')];
        } else {
            $data =  [];
        }
        Session::put('user_wishlist', $data);
        return $data
    }
    */
    if (!isUserLoggedIn()) {
        return [];
    }

    return Cache::remember('getWishlist', 300, function () {
        $params = [
            'action' => 'view'
        ];
        $result = CurlAPI("pages/wishlist", "POST", $params, 1, true);

        if ($result && @$result['success'] ==  true) {

            $watch = array_column($result['contents']['WATCH'] ?? [], 'ID');
            $listen = array_column($result['contents']['LISTEN'] ?? [], 'ID');

            $new = array_merge($watch, $listen);
            return ['data' => $result['contents'], 'ids' => $new];
        } else {
            return [];
        }
    });

    // $params = [
    //     'action' => 'view'
    // ];
    // $result = CurlAPI("pages/wishlist", "POST", $params);
    // dd($result);
    // if ($result && @$result['success'] ==  true) {
    //     return JSONResponse(200,  'Success.');
    // }
}

function isMobliDevice()
{   
    $detect = new MobileDetect();
    $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

    return ($deviceType == 'phone') ? true : false;

    /*
    $ua = strtolower($_SERVER["HTTP_USER_AGENT"] ?? '');
    $isMob = is_numeric(strpos($ua, "mobile"));
    $isIPhone = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"] ?? ''), "iphone"));
    return (isset($isMob) && $isMob == true) || (isset($isIPhone) && $isIPhone == true) || (isset($_SERVER['HTTP_X_MOBILE']) && $_SERVER['HTTP_X_MOBILE'] == true) ? true : false;
    */
}

function getItemCardData($val, $language)
{
    $title = getDispLangContent($val, $language, 'title');
    $shortdescription = getDispLangContent($val, $language, 'shortdesc');

    if (isMobliDevice()) {
        $bannerimagcond = getDispLangContent($val, $language, 'bannerimg-vertical');
    } else {
        $bannerimagcond = getDispLangContent($val, $language, 'bannerimg');
    }

    if (empty($bannerimagcond)) {
        $bannerimagcond = getDispLangContent($val, $language, 'coverimage');
    }
    $bannerimage = getImage($bannerimagcond, "large");

    $generes = array_column($val['genres_assign'] ?? [], 'name');

    $sub_text = [];

    if (isset($val['publish_start_date'])) {
        $sub_text[] = date('Y', strtotime($val['publish_start_date']));
    }
    // $sub_text[] = '3 Language';

    if ($generes) {
        $sub_text[] = implode(" . ", $generes);
    }
    if (isset($val['age_limit'])) {
        $sub_text[] = $val['age_limit'];
    }

    $sub_points = (@$val['age_limit']) ? '<li class="ps-1">' . @$val['age_limit'] . '</li>' : '';

    if ($generes) {
        $count = 1;
        foreach ($generes as $key => $genre) {
            if ($count++ > 2) {
                break;
            }
            $sub_points .= '<li>' . $genre . '</li>';
        }
    }

    return [
        'title' => $title,
        'short_desc' => sanitizeData($shortdescription),
        'banner_img' => $bannerimage,
        'sub_text' => implode(" . ", $sub_text),
        'sub_points' => $sub_points,
    ];
}

if (!function_exists('uploadFile')) {

    function uploadFile(string $key, string $folder, $subkey = '', array $size = []): string
    {
        $file = (gettype($subkey) === 'integer') ? request()->file($key)[$subkey] : request()->file($key);

        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        if ($size) {
            $name = time() . '-' . mt_rand() . '-' . $size[0] . 'x' . $size[1] . '.' . $file->getClientOriginalExtension();

            $image_resize = Image::make($file->getRealPath());
            $image_resize->resize($size[0], $size[1]);
            $image_resize->save(public_path('uploads/' . $folder . '/' . $name));
        } else {
            $name = time() . '-' . mt_rand() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/' . $folder), $name);
        }

        return url('/') . '/uploads/' . $folder . '/' . $name;
    }
}


if (!function_exists('timestamp_to_date_format')) {

    function timestampToDate(object|string $time = null, ?string $format = 'Y-m-d')
    {
        if (is_null($time)) {
            return null;
        }
        if (is_object($time)) {
            $temp = $time->toDateTime()->setTimezone(new \DateTimeZone('Asia/Kolkata'));

            return $temp->format($format);
        } else {
            return date($format, strtotime($time));
        }
    }
}






function convertSecondsToReadable($seconds, $show_seconds = false)
{
    if ($seconds > 0) {
        $day = floor($seconds / 86400);
        $hours = floor(($seconds - ($day * 86400)) / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $seconds = $seconds % 60;
        $sec = '';
        if ($show_seconds && $seconds) {
            $sec = $seconds . ' sec ';
        }

        if ($hours) {
            return $hours . ' hr ' . $minutes . ' min ' . $sec;
        } elseif ($minutes) {
            return $minutes . ' min ' . $sec;
        }
    }
    // return Carbon::now()->addSeconds($seconds)->diffForHumans(null, true, true, 2);
    // return  CarbonInterval::seconds($seconds)->cascade()->forHumans();
}

function getSeasonEpisodeNum($val)
{
    $result = [
        // 'season' => '',
        // 'episode' => ''
    ];
    if (@$val['content_type'] == 'EPISODE') {
        if (isset($val['parent_name'])) {
            $parent_name = trim($val['parent_name']);
            $wordToFind = 'Season';

            $lastPosition = strrpos($parent_name, $wordToFind);

            if ($lastPosition !== false) {
                // $wordLength = strlen($wordToFind);
                // $lastWord = substr($parent_name, $lastPosition, $wordLength);

                $lastSpacePosition = strrpos($parent_name, ' ');

                if ($lastSpacePosition !== false) {
                    $valueAfterLastSpace = substr($parent_name, $lastSpacePosition + 1);

                    $result['season'] = 'S' . $valueAfterLastSpace;
                }
            }
        }
        if (isset($val['content_order'])) {
            $result['episode'] = 'E' . $val['content_order'];
        }
    }
    return $result;
}


function isUserLoggedIn()
{
    return Session::has('user_id') && Session::has('user_token') ? true : false;
}

function getUserId()
{
    return Session::get('user_id') ?? '';
}

function getProfileId()
{
    return session()->get('active_profile') ?? '';
}

function getContentUrl($value)
{
    $prefix = '/';
    if (session()->has('kidsMode') && session()->get('kidsMode')) {
        $prefix = '/kids/';
    }
    if (isset($value['url'])) {
        return getUrl($prefix . $value['url']);
    }

    return getUrl($prefix);
}

function getplayanchorhtml($value)
{
    $loginclass = isKidsPage() && !isActiveSubscription() ? "allAccessBtn" : "";
    $data_url = (isActiveSubscription() && $value['free_premium']) || !$value['free_premium'] ? @$value['game_url'] : '';
    $html = '<a  onclick="click_tile(this)" data-title="'.$value['title'].'" data-type="'.$value['content_type'].'" href="javascript:void(0)" target="_blank" data-url="' . $data_url . '" data-premium="' . $value['free_premium'] . '" data-activesubscriber="' . isActiveSubscription() . '" check-login="' . $loginclass . '" class="main-card check-content-url">';
    return $html;
}

function getMidPageUrl($value)
{
    $midpage_prefix = '/midpage/';
    if (session()->has('kidsMode') && session()->get('kidsMode')) {
        $midpage_prefix = '/kids/midpage/';
    }
    return getUrl($midpage_prefix . ($value['slug'] ?? 'slug') . '/' . @$value['catalog']);
}

function getProfileData()
{
    if (session()->get('profile_data')) {
        return session()->get('profile_data');
    }
    $controller = new ProfileController();
    $result = $controller->getProfileData();
    return $result;
}

function getDays($startDate, $endDate, $timezone = '')
{
    $startTimeStamp = strtotime($startDate);
    //echo date("d-m-Y H:i:s",$startTimeStamp)."<br>";
    $endTimeStamp = strtotime($endDate);
    //echo date("d-m-Y H:i:s",$endTimeStamp)."<br>";echo "<br>";

    if ($timezone == 'IST' && function_exists('date_default_timezone_set')) {
        date_default_timezone_set("Asia/Kolkata");
    }
    $startTimeStamp = strtotime($startDate);
    //echo date("d-m-Y H:i:s",$startTimeStamp)."<br>";
    $endTimeStamp = strtotime($endDate);
    //echo date("d-m-Y H:i:s",$endTimeStamp)."<br>";echo "<br>";

    $timeDiff = abs($endTimeStamp - $startTimeStamp);
    //echo $timeDiff."<br>";
    $numberDays = $timeDiff / 86400;  // 86400 seconds in one day
    //echo $numberDays."<br>";
    // and you might want to convert to integer
    //$numberDays = intval($numberDays);
    $numberDays = round($numberDays);
    return $numberDays;
}

function generateTransactionID()
{
    return substr(hash('sha256', mt_rand() . microtime()), 0, 20);
}

function getConvertedPrice($source_currency, $destination_currency, $amount = '')
{
    return false;
    if ($source_currency != '' && $destination_currency != '') {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.exchangeratesapi.io/latest?base=" . $source_currency . "&symbols=" . $destination_currency,
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
            $rates = json_decode($response, true);
            return $rates['rates'][$destination_currency];
        }
    } else {
        return false;
    }
}

function si_transaction($url, $data = null)
{
    //dd($url);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $headers = array("Content-Type: application/x-www-form-urlencoded",);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, 1);
    $resp = curl_exec($ch);
    curl_close($ch);
    return $resp;

    $curl = curl_init();
}
function EventPush($user_id, $eventName, $properties, $is_moengage = true, $is_clevertap = true)
{
    $properties['Source'] = @$_GET['utm_source'];
    $properties['Medium'] = @$_GET['utm_medium'];
    $properties['Campaign'] = @$_GET['utm_campaign'];
    if (!empty($user_id)) {

        if ((empty(env('CLEVERTAP')) || strtoupper(env("CLEVERTAP")) == "ON") && $is_clevertap == true) {

            $txn_url = config('epicconfig.CLEVERTAP.CLEVERTAP_TXN_URL');

            $postData['identity'] = $user_id;
            $postData['evtName'] = $eventName;    /* Data type String */
            $postData['evtData'] = $properties; /* Data type array */
            $postData['type'] = 'event';
            $postData['ts'] = time();

            /* Log::info("-----CLEVERTAP CURL Parameters: ".$txn_url."----\n");
			Log::debug(json_encode($postData));
			Log::info("-----END----------------------");*/

            $responseClevertap = CURLFOREVENTPUSH($txn_url, $postData, 'CLEVERTAP');

            /*Log::info("-----CLEVERTAP CURL response");
			Log::debug($responseClevertap);
			Log::info("-----END----------------------");*/
        }

        if ((empty(env('MOENGAGE')) || strtoupper(env("MOENGAGE")) == "ON") && $is_moengage == true) {
            $txn_url = config('epicconfig.moengage.EVENT_TXN_URL') . '' . config('epicconfig.moengage.APP_ID_API');

            $postDataMoengage['type'] = 'event';
            $postDataMoengage['customer_id'] = $user_id;
            $postDataMoengage['actions'][0]['action'] = $eventName;    /* Data type String */
            $postDataMoengage['actions'][0]['attributes'] = $properties;   /* Data type List */

            /*			Log::info("-----MOENGAGE CURL Parameters: ".$txn_url."----\n");
			Log::debug(json_encode($postDataMoengage));
			Log::info("-----END----------------------");*/

            $responseMoengage = CURLFOREVENTPUSH($txn_url, $postDataMoengage, 'MOENGAGE');

            /*			Log::info("-----MOENGAGE CURL response");
			Log::debug($responseMoengage);
			Log::info("-----END----------------------");*/
        }

        if (empty(env('MOENGAGE')) || strtoupper(env("MOENGAGE")) == "ON") {
            $return = @$responseMoengage;
        } else if (empty(env('CLEVERTAP')) || strtoupper(env("CLEVERTAP")) == "ON") {
            $return = @$responseClevertap;
        } else if (!empty(env('CLEVERTAP')) && strtoupper(env("CLEVERTAP")) == "ON" && !empty(env('MOENGAGE')) && strtoupper(env("MOENGAGE")) == "ON") {
            $return = array_merge($responseClevertap, $responseMoengage);
        }

        return $return;
    }
}

function CURLFOREVENTPUSH($txn_url, $postData, $headerType)
{

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $txn_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $headers = array();
    $headers[] = 'Content-Type: application/json; charset=utf-8';


    if ($headerType == 'CLEVERTAP') {

        $headers[] = 'X-CleverTap-Account-Id: ' . config('epicconfig.CLEVERTAP.CLEVERTAP_ACCOUNT_ID');
        $headers[] = 'X-CleverTap-Passcode: ' . config('epicconfig.CLEVERTAP.CLEVERTAP_PASSCODE');

        curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"d\": [ " . json_encode($postData, JSON_PRETTY_PRINT) . " ] }");
    }

    if ($headerType == 'MOENGAGE') {

        $headers[] = 'Authorization: Basic ' . base64_encode(config('epicconfig.moengage.APP_ID_API') . ':' . config('epicconfig.moengage.APP_KEY'));
        $headers[] = 'MOE-APPKEY: ' . config('epicconfig.moengage.APP_KEY');

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData, JSON_PRETTY_PRINT));
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    Log::info("----- CURL Header: ----\n");
    Log::debug(json_encode($headers));
    Log::info("-----END----------------------");

    curl_setopt($ch, CURLOPT_POST, 1);

    $response = curl_exec($ch);

    return $response;
}

function checkSubscription()
{
    $userDetail = session()->get('user') ?? [];
    $sub_plan = $userDetail['subscriptions'] ?? [];
    $subscription_end_date = $sub_plan['subscription_end_date'] ?? '';
    $result['status'] = !empty($subscription_end_date) && $subscription_end_date > date("Y-m-d") ? 'active' : '';
    return $result;
}

// old logic
function SilentLoginFunction_old(){
    $request = Request();
    $user = isUserLoggedIn();

    if(!empty($request->get('source'))){
        if (($user) != false && strtolower($request->get('source') != "dishtv")) {
        } elseif ($user != false && strtolower($request->get('source') == "dishtv")) {
            $request->session()->forget('user');
            $request->session()->forget('api_session');
            $request->session()->forget('authenticated');
            $request->session()->forget('redirectto');
            $request->session()->forget('utm_source');
            $request->session()->forget('utm_campaign');
            $request->session()->forget('utm_medium');
            $request->session()->forget('usercounponplan');
            $request->session()->forget('qrpromotionsselected');
            $request->session()->forget('promotionkey');
            $request->session()->forget('qrpromocodekey');
            $request->session()->forget('watchVa');
            $request->session()->forget('listenVa');
            $request->session()->forget('playVa');
            $request->session()->forget('readVa');
            $request->session()->forget('homeVa');
            $request->session()->forget('customer_hash');
            $request->session()->forget('skip_login');
            $request->session()->flush();
            session_unset();
            silentLogin($request->get('user_id'), $request->get('source'));
        } else {
            $user_id = $request->get('user_id');
            $source = $request->get('source');
            if (isset($user_id) && isset($source)) {
                silentLogin($user_id, $source);
            } else {
                if (!empty($request->session()->get('skip_login')) && $request->session()->get('skip_login') == 'true') {
                } else if (@$_POST['skip'] != 1) {
                    $request->session()->put('skip_login', 'true');
                    $container = app();
                    return redirect('/');
                    // return $container->call('App\Http\Controllers\Auth\LoginController@getSignin');
                }
            }
        }
    }
}

function SilentLoginFunction(){
    $request = Request();

    $user = isUserLoggedIn();
    $user_id = $request->get('user_id');
    $source = $request->get('source');

    if ((isUserLoggedIn()) == false) {
        if (isset($user_id) && isset($source)) {
            silentLogin($user_id, $source);
        }
    }
}

// Silent Login API
function silentLogin($user_id, $source)
{
    $request = Request();
    
    $request_parameter = [
        'user_id' =>  $user_id,
        'source' =>   $source,
        'user_agent' => getUserAgent(),
    ];
    $epicwebArr =  CurlAPI("users/silent-login", 'POST', $request_parameter, 2, true);
    // if ($epicwebArr['success'] == true && isset($epicwebArr['session_id']) && !empty($epicwebArr['user_data'])) {
    if ($epicwebArr['success'] == true && !empty($epicwebArr['user_data'])) {
        $userdata = $epicwebArr['user_data'];
        $maxDevice = $epicwebArr['max_device_reached'] ?? false;
        $url =  $request->url();

        $trakcingData = ['Name' => $userdata['name'], 'Identity' => $userdata['user_id'], 'Email' => $userdata['user_id'], 'MSG-email' => true, 'MSG-push' => true];
        $request->session()->put('authenticated', time());
            // $request->session()->put('api_session', $epicwebArr['session_id']);
            // $request->session()->put('user', $user);
        $request->session()->put('user_id', $userdata['user_id']);
        $request->session()->put('user', $userdata);
        $request->session()->put('user_token', $epicwebArr['token']);
        $request->session()->put('maxDevice', $maxDevice);
        $request->session()->put('device_id', @$userdata['device_id']);
        $request->session()->put('logintracking', $trakcingData);
        $request->session()->put('logintrackingType', "Login");
        $request->session()->put('authEventTrack', 'Login successfull');
        $request->session()->put('eventCat', 'Login');
        $request->session()->put('silentUrl', $url);

        if($maxDevice === true)
        {
            header("Location:".url('/max-device'));
        }
    }
}


function check_Tv_Activation_Code()
{
    $request = Request();
    $activetvcode = $request->session()->get('activetvcode');
    $tv_verify = $request->session()->get('tv_verify');
    $user_id = $request->session()->get('user_id');
    $maxDevice = $request->session()->get('maxDevice');
    if ((isset($user_id) && !empty($user_id)) && (isset($tv_verify) && $tv_verify == true) && (isset($maxDevice) && $maxDevice === false)) {
        header("Location:" . url('activatetv/' . $activetvcode));
    }
}


function formatDate($date, $format = 'd F Y')
{
    return date($format, strtotime($date));
}

function getCardImage($content, $key, $size = 'medium', $fallback = [])
{
    // if (empty($fallback)) {
    $fallback = [
        'banner_image'                  => 'default-830x400.png',
        'banner_image_v2'               => 'default-830x400.png',        
        'cover_image'                   => 'default-830x400.png',
        'cover_image_special'           => 'default-200x200.png',
        'spotlight_epic_shorts_image'   => 'default-200x200.png',
        'epic_shorts_image'             => 'default-200x200.png',
        'vertical_cover_image'          => 'default-200x300.png',
        'culinary_delights_image'       => 'default-290.5x365.png',
        'wildlife_image'                => 'default-288x324.png',
        'sports_image'                  => 'default-198x284.png',
        'travel_image'                  => 'default-297x197.png',
        'imageUrl'                      => 'default-200x200.png',
    ];
    // }
    $img_url = '';
    if ($content) {
        if (isset($content[$key]) && !empty($content[$key])) {
            $img_url = $content[$key][$size] ?? '';
        }

        if (empty($img_url)) {

            $img_url = isset($fallback[$key]) ? env('AWS_S3_domain').'epicon/assets/images/' . $fallback[$key] : env('AWS_S3_domain').'epicon/assets/images/default-200x200.png';

            /*foreach ($fallback as $k => $img_key) {
                if (isset($content[$img_key]) && !empty($content[$img_key])) {
                    $img_url = $content[$img_key][$size] ?? '';
                }
                if (!empty($img_url)) {
                    break;
                }
            }*/
        }
    }
    // $match = 'st2.epicon.epicchannel.com';
    // $replaceWith = 'st2.epicon.in';
    // $img_url = str_replace($match, $replaceWith, $img_url);
    return $img_url;
}

if (!function_exists('getUrl')) {
    function getUrl($path = '')
    {
        if (!empty($path) && substr($path, 0, 1) != '/') {
            $path = "/" . $path;
        }
        $request = Request();
        $displayLanguage = $request->session()->has('displayLanguage') ? $request->session()->get('displayLanguage') : 'en';
        $lang = ($displayLanguage != 'en') ? $displayLanguage : '';
        if ($displayLanguage != 'en') {
            return url($lang . $path);
        } else {
            return url($path);
        }
    }
}

if (!function_exists('getUrlWithPrefix')) {
    function getUrlWithPrefix($path = '', $id = '')
    {
        $request = Request();
        $displayLanguage = $request->session()->has('displayLanguage') ? $request->session()->get('displayLanguage') : 'en';
        $lang = ($displayLanguage != 'en') ? $displayLanguage : '';
        if ($displayLanguage != 'en') {
            return !empty($id) ? route($lang . "." . $path, $id) : route($lang . "." . $path);
        } else {
            return !empty($id) ? route($path, $id) : route($path);
        }
    }
}

if (!function_exists('getUrlWithoutPrefix')) {
    function getUrlWithoutPrefix($path = '', $id = '')
    {
        $request = Request();
        $displayLanguage = $request->session()->has('displayLanguage') ? $request->session()->get('displayLanguage') : 'en';
        $lang = ($displayLanguage != 'en') ? $displayLanguage : '';
        if ($displayLanguage != 'en') {
            return !empty($id) ? route($lang . "/" . $path, $id) : route($lang . "/" . $path);
        } else {
            return !empty($id) ? route($path, $id) : route($path);
        }
    }
}

function isActiveSubscription()
{
    if (isUserLoggedIn()) {
        $user = session()->get('user');
        if (array_key_exists('subscriptions', $user)) {
            $today = strtotime(date("Y-m-d")); //date("Y-m-d")."T".date("H:i:s")."Z";
            if (array_key_exists('subscription_end_date', $user['subscriptions'])) {
                @$endtime = strtotime(@$user['subscriptions']['subscription_end_date']);
                if ((!empty(@$user['subscriptions']['subscription_end_date'])) && $today < $endtime) {
                    return true;
                }
            }
        }
    }

    return false;
}

if (!function_exists("getAllEpisodesFromSeason")) {
    function getAllEpisodesFromSeason($season)
    {
        $episode_list = [];
        if (array_key_exists('episodes', $season)) {
            if (is_array($season['episodes'])) {
                foreach ($season['episodes'] as $episode) {
                    if (array_key_exists('ID', $episode) && !empty($episode['ID'])) {
                        $episode_list[] = [
                            "ID" => $episode['ID'],
                            "file_url_original" => $episode["file_url_original"]
                        ];
                    } else {
                        continue;
                    }
                }
            }
        }
        return $episode_list;
    }
}

if (!function_exists("update_user_session")) {
    function update_user_session()
    {
        $profile_detail = CurlAPI("users/viewProfile", "POST", [], 2, true, true);
        if (is_array($profile_detail) && array_key_exists('success', $profile_detail)) {
            if ($profile_detail['success']) {
                if (array_key_exists('user_data', $profile_detail)) { // Old Logic
                // if ( // New Logic
                //     array_key_exists('user_data', $profile_detail) &&
                //     array_key_exists('user_id', $profile_detail['user_data']) &&
                //     array_key_exists('profiles', $profile_detail['user_data']) &&
                //     is_array($profile_detail['user_data']['profiles']) &&
                //     count($profile_detail['user_data']['profiles']) > 0
                // ) {
                    $user_data = @$profile_detail['user_data'];
                    session()->put('user', $user_data);
                }
            } else {
                $infoMsg = "\n------------viewProfile(Start)--------------
                            \n user_token: ". (Session::get('user_token') ?? ''). 
                            "\n user id: ". getUserId() . 
                            "\n profile Response : " .json_encode($profile_detail).
                            "\n ------------viewProfile(End)--------------";
                Log::channel('user')->info($infoMsg);
                return false;
            }
        }
        return true;
    }
}
function checkLang($lang)
{
    if ($lang == 'en') {
        $res = 'ENGLISH';
    } else if ($lang == 'hi') {
        $res = 'HINDI';
    } else {
        $res = 'ALL';
    }

    return $res;
}

function checkNumDays($date)
{
    $today = date_create(date('Y-m-d'));
    $enddate = date_create(date('Y-m-d', strtotime($date)));
    //$dateDiff = date_diff($enddate,$today);
    $dateDiff = date_diff($today, $enddate);
    $numOfDays = $dateDiff->format('%r%a');
    return $numOfDays;
}

function getNewTitle($value)
{
    $html = '';
    $cls = '';

    if (isset($value['is_new']) && $value['is_new']) {
        $html = '<div class="new-show-title">New</div>';
        $cls = 'eod-darlings';
        // if (isset($value['catalog_slug'])) {
        //     if ($value['catalog_slug'] == 'movies') {
        //         $html = '<div class="new-show-title">New</div>';
        //         $cls = 'eod-darlings';
        //     } elseif ($value['catalog_slug'] == 'tv-shows' && isset($value['content_type'])) {
        //         if ($value['content_type'] == 'SHOW') {
        //             $html = '<div class="new-show-title">New</div>';
        //             $cls = 'eod-darlings';
        //         } elseif ($value['content_type'] == 'SEASON') {
        //             $html = '<div class="new-show-title">New</div>';
        //             $cls = 'eod-darlings';
        //         } elseif ($value['content_type'] == 'EPISODE') {
        //             $html = '<div class="new-show-title">New</div>';
        //             $cls = 'eod-darlings';
        //         }
        //     }
        // }
    }

    return ['cls' => $cls, 'html' => $html];
}

if (!function_exists('profileActive')) {
    function profileActive($profile_id = "")
    {
        if (!isUserLoggedIn()) {
            return;
        }
        if ($profile_id != "") {
            session()->put('active_profile', $profile_id);
        } else {
            if ($profile_id == "" && !session()->has('active_profile')) {
                $default_profile = getDefaultProfile();
                session()->put('active_profile', $default_profile);
            }
        }
        return;
    }
}

if (!function_exists('getDefaultProfile')) {
    function getDefaultProfile($type = 'all_access')
    {
        $profile_id = '';
        $user = session()->get('user') ?? [];
        $profiles = $user['profiles'] ?? [];
        foreach ($profiles as $profile) {
            if (array_key_exists('is_default', $profile) && $profile['is_default'] == 1) {
                if ($type == 'kids' && $profile['kids'] == 1) {
                    $profile_id = $profile['id'];
                } else if ($type != 'kids' && $profile['kids'] != 1) {
                    $profile_id = $profile['id'];
                }
            }
        }
        return $profile_id;
    }
}

if (!function_exists('displayLang')) {
    function displayLang()
    {
        return session()->has('displayLanguageParam') ? session()->get('displayLanguageParam') : 'en';
    }
}

if (!function_exists('isKidsProfile')) {
    function isKidsProfile($profile_id)
    {
        $user = session()->get('user');
        $profiles = $user['profiles'];
        foreach ($profiles as $profile) {
            if ($profile['id'] == $profile_id && $profile['kids'] == 1) {
                return true;
            }
        }
        return false;
    }
}

function getFirstSegment()
{

    if (session()->has('displayLanguage') && session('displayLanguage') != 'en') {
        $segment = request()->segment(2);
    } else {
        $segment = request()->segment(1);
    }
    return $segment;
}

function getFirstSegmentWithKids()
{
    $kids_mode = kidsMode();
    if (session()->has('displayLanguage') && session('displayLanguage') != 'en') {
        $segment = $kids_mode ? request()->segment(3) : request()->segment(2);
    } else {
        $segment = $kids_mode ? request()->segment(2) : request()->segment(1);
    }
    return $segment;
}


function isKidsPage()
{
    $segment = getFirstSegment();
    return $segment == 'kids' ? true : false;
}

function kidsMode()
{
    return session()->has('kidsMode') && session()->get('kidsMode') == true ? true : false;
}

function getJsonDataFromFile($filepath)
{
    try {
        $jsonData = file_get_contents($filepath);
        $arrayData = json_decode($jsonData, true);
    } catch (\Throwable $th) {
        $arrayData = [];
    }
    return $arrayData;
}

function getCountryCode() {
    /*
    try {
        if (!session()->get('countrycode')) {
            // Check for the X-Forwarded-For header
            if (isset($_SERVER['HTTP_TRUE_CLIENT_IP'])) {
                $ipAddress = $_SERVER['HTTP_TRUE_CLIENT_IP'];
            } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ipAddress = $_SERVER['REMOTE_ADDR'];
            } else {
                $ipAddress = '';
            }

            // Hardcoded IP for testing
            // $ipAddress = '185.198.240.164';

            if (!empty($ipAddress)) {
                $file = file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ipAddress);
                // Check for both failure and empty response
                if ($file !== false && trim($file) !== "") {
                    $data = @json_decode($file);
                    $countryCode = isset($data->geoplugin_countryCode) ? $data->geoplugin_countryCode : 'IN';

                    session()->put('countrycode', $countryCode);
                    return $countryCode;
                } else {
                    // Handle the case when file_get_contents fails or returns an empty response
                    session()->put('countrycode', 'IN');
                    return "IN";
                }
            } else {
                session()->put('countrycode', 'IN');
                return "IN";
            }
        } else {
            return session()->get('countrycode');
        }
    } catch (Exception $e) {
        session()->put('countrycode', 'IN');
        // Handle any other exceptions that may occur
        return 'IN';
    }*/ // Old Code is Here with API Call Third Party Call

    try {
        if (!session()->get('countrycode')) {
            $countryCode = request()?->header('x-region') ?? 'IN';
            session()->put('countrycode', $countryCode);
            return $countryCode;
        } else {
            return session()->get('countrycode');
        }
    } catch (Exception $e) {
        session()->put('countrycode', 'IN');
        return 'IN';
    }
}

function getCurrency($val){
    if((isset($val)) && ($val == 'INR' || $val == 'inr')){
        return "₹";
    }else{
        return "$";
    }
}

function getCountryStateData()
{
    $filepath = asset('json/countrystate.json');
    $countrystate = getJsonDataFromFile($filepath);
    return $countrystate;
}

function getCountryStateDataInHtml()
{
    // $countrycode = (!empty($_SERVER['HTTP_X_CC']) ? $_SERVER['HTTP_X_CC'] : 'IN');
    $countrycode = getCountryCode();
    $countrystate = getCountryStateData();
    $countryisdhtml = "";

    $selectvar = "";
    if ($countrystate) {
        foreach ($countrystate['countries'] as $i => $value) {
            if ($countrycode == $value['code']) {
                $selectvar = '+'. $value['countryisdcode'];
            } 
            //$countryisdhtml .= '<option value="' . $value['countryisdcode'] . '" ' . $selectvar . '>' . $value['country'] .' (+'. $value['countryisdcode'].')'.'</option>';
            $countryisdhtml .= '<li class="conuntry__code__list__text '.$selectvar.'"><a href="javascript:void(0)" class="conuntry__code__list__text--inner">'. $value['country'] .' (+'. $value['countryisdcode'].')'.'</a></li>';
        }
    }
    $result = [ 'countryisdhtml' => $countryisdhtml,
                'countryCode' => $selectvar
              ];
    return $result;
}

function getCountryList()
{
    $countrycode = getCountryCode();
    $countrystate = getCountryStateData();
    $countryHtml = "";
    if( $countrystate){
        foreach ($countrystate['countries'] as $i => $value) {
            if ($countrycode == $value['code'] || $countrycode == $value['countryisdcode']) {
                $selectvar = "selected";
            } else {
                $selectvar = "";
            }
            $countryHtml .= '<option value="' . $value['country'] . '" ' . $selectvar . '>' . $value['country'] . '</option>';
        }
    }
    return $countryHtml;
}

if (!function_exists('assetTime')) {
    function assetTime() {
        return env('VERSION_CONTROL');
        // return time();
    }
}

if (!function_exists('countConvert')) {
    function countConvert($count = 0) {
        return $count >= 1000 ?
        (
            $count >= 1000000 ?
            (
                $count >= 1000000000 ? 
                round($count/1000000000, 2) . "B" 
                : round($count/1000000, 2) . "M"
            )
            : round($count/1000) . "K"
        ) 
        : $count;
    }
}

if (!function_exists('sanitizeData')) {
    function sanitizeData($data = "")
    {
        return !empty($data) ? nl2br(str_replace("\\r\\n", "\r\n", $data)) : '';
    }
}

if (!function_exists('lastActiveTime')) {
    function lastActiveTime($date = "")
    {
        if (empty($date))
            return false;
        $date = date('Y-m-d', strtotime($date));
        $current_date = date("Y-m-d");
        $previous_date = date("Y-m-d", strtotime('-1 day', strtotime($current_date)));
        $activeDate = '';
        if ($date == $current_date) {
            $activeDate = 'Today';
        } else if ($date == $previous_date) {
            $activeDate = 'Yesturday';
        } else {
            $activeDate = date("j M, Y", strtotime($date));
        }
        return $activeDate;
    }
}


function getDeviceId() {
    return session()->get('device_id') ?? '';
}

function getDefaultMetaTitle(){
    return 'Watch TV Shows, Movies, Podcast, Games, Rewards';
}

if (!function_exists('generateGuestUserId')) {
    function generateGuestUserId()
    {   
        if( Cookie::get('guest_user_id') ){
            return Cookie::get('guest_user_id');
        }
        
        $result = 'guest_' . uniqid().'_'.mt_rand(1, 9999999);
        Cookie::queue('guest_user_id', $result, 43200);

        return $result;
    }
}

if (!function_exists('getMeta')) {

    function getMeta($pagetype, $pagetitle = '', $pageslug = '')

    {

        $lang = setLanguageParameter();

        /******Changed as per SEO Person*/

        $meta = [];

        $meta['keywords'] = '';

        $meta['image'] = env('AWS_S3_domain') . 'epicon/assets/images/epiconlogo.png';

        $meta['url'] = url()->current();

        $meta['title'] = $lang != 'HINDI' ? "Welcome to EPIC ON - India Ka Apna Infotainment" : 'EPIC ON - India Ka Apna Infotainment में आपका स्वागत है';

        $meta['description'] = $lang != 'HINDI' ? "EPIC ON - India Ka Apna Infotainment | Watch TV Shows, Documentaries, Epic Shorts, Epic Specials Online at EPIC ON" : "EPIC ON - India Ka Apna Infotainment | ईपीआईसी ऑन पर टीवी शो, वृत्तचित्र, महाकाव्य शॉर्ट्स, महाकाव्य विशेष ऑनलाइन देखें";

        $meta['Robots'] = "INDEX, FOLLOW";

        $meta['Author'] = "Epicon, epicon.in/";

        $meta['YahooSeeker'] = "INDEX, FOLLOW";

        $meta['msnbot'] = "INDEX, FOLLOW";

        $meta['googlebot'] = "Default, follow";

        $meta['owner'] = "epicon.in";

        $meta['language'] = "English";

        $meta['revisit-after'] = "2 days";

        

        if ($pagetype == 'HOME') {

            $meta['title'] = $lang != 'HINDI' ? 'Watch TV Shows, Web Series, Movies, Podcasts, & Live TV Channels' : 'टीवी शो, वेब सीरीज, फिल्में, पॉडकास्ट और लाइव टीवी चैनल देखें';

            $meta['description'] = $lang != 'HINDI' ? 'Watch TV Shows, Web Series, Movies, Podcasts, Live TV Channels online at Epic On, India\'s premier OTT platform in India. With a wide selection of new and classic shows and Movies' : 'मूवी, टीवी शो, ई-बुक्स, पॉडकास्ट, गेम्स, रिवार्ड्स और अधिक एक से एक मनोरंजन ईपीक ऑन पर';

            $meta['keywords'] = $lang != 'HINDI' ? 'movies, film, online videos, tv series, games, ebooks, podcast, tv shows, recipe shows, travel shows, historic places, mythology, festivals of India, best tv shows, best tv series, history of India' : 'फिल्में, फिल्म, ऑनलाइन वीडियो, टीवी श्रृंखला, खेल, ईबुक, पॉडकास्ट, टीवी शो, रेसिपी शो, यात्रा शो, ऐतिहासिक स्थान, पौराणिक कथाएं, भारत के त्योहार, सर्वश्रेष्ठ टीवी शो, सर्वश्रेष्ठ टीवी श्रृंखला, भारत का इतिहास';

        } else if ($pagetype == 'login') {

            $meta['title'] = 'EPIC ON | TV Shows, Movies, Podcast, Games, Rewards';

            $meta['keywords'] = 'movies, film, online videos, tv series, games, ebooks, podcast, tv shows, recipe shows, travel shows, historic places, mythology, festivals of India, best tv shows, best tv series, history of India';

            $meta['description'] = 'Enjoy the best of content across movie, tv shows, videos, podcasts, gaming & e-books on-the-go, on multiple devices. Explore, discover, and be inspired with all in one entertainment stop on EPIC ON';

        } else if ($pagetype == 'CATALOG') {

            if ($pagetitle == 'watch' || $pagetitle == 'tv-shows' || $pagetitle == 'epic-shorts' || $pagetitle == 'documentaries' || $pagetitle == 'video-books' || $pagetitle == 'movies' || $pagetitle == 'amar-chitra-katha') {

                if ($pageslug == 'tv-shows') {

                    $meta['title'] = $lang != 'HINDI' ? 'Watch Indian TV Shows and Web Series Online at Epic On' : 'देखो टीवी शो, एपिसोड, सिनेमा ऑनलाइन | ईपीक ऑन';

                    $meta['description'] = $lang != 'HINDI' ? 'Watch TV shows and Web Series online at Epic On. Best OTT Platforms for TV shows and Web Series in Hindi and English. Subscribe to our platform today!' : 'कॉमेडी, रोमांस, एक्शन, ड्रामा, भोजन, यात्रा और पौराणिक कथाओं की शैलियों के बीच लोकप्रिय टीवी शो, ब्लॉकबस्टर फिल्में, मूल, वृत्तचित्र, और बहुत कुछ देखें';

                    $meta['keywords'] = $lang != 'HINDI' ? 'originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries, EPIC ON,films,hollywood movies, bollywood movies, hindi movies,originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries,amazon prime movies' : 'नई फिल्में, फिल्में, मूवीज, फिल्म, ऑनलाइन वीडियो, टीवी श्रृंखला, टीवी शो, सर्वश्रेष्ठ नेटफ्लिक्स श्रृंखला, वेब श्रृंखला, शो, सर्वश्रेष्ठ वेब श्रृंखला, वृत्तचित्र';

                } else if ($pageslug == 'epic-shorts') {

                    $meta['title'] = $lang != 'HINDI' ? 'Watch Short Clip Online in India at Epic On' : 'देखो टीवी शो, एपिसोड, सिनेमा ऑनलाइन | ईपीक ऑन';

                    $meta['description'] = $lang != 'HINDI' ? 'Enjoy a wide range of short clips online at Epic On. From funny videos to educational clips to inspiring stories, there\'s something for everyone. Watch now!' : 'कॉमेडी, रोमांस, एक्शन, ड्रामा, भोजन, यात्रा और पौराणिक कथाओं की शैलियों के बीच लोकप्रिय टीवी शो, ब्लॉकबस्टर फिल्में, मूल, वृत्तचित्र, और बहुत कुछ देखें';

                    $meta['keywords'] = $lang != 'HINDI' ? 'originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries, EPIC ON,films,hollywood movies, bollywood movies, hindi movies,originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries,amazon prime movies' : 'नई फिल्में, फिल्में, मूवीज, फिल्म, ऑनलाइन वीडियो, टीवी श्रृंखला, टीवी शो, सर्वश्रेष्ठ नेटफ्लिक्स श्रृंखला, वेब श्रृंखला, शो, सर्वश्रेष्ठ वेब श्रृंखला, वृत्तचित्र';

                } else if ($pageslug == 'movies') {

                    $meta['title'] = $lang != 'HINDI' ? 'Watch Bollywood, Hollywood and South Indian Movies Online' : 'Watch Bollywood, Hollywood and South Indian Movies Online';

                    $meta['description'] = $lang != 'HINDI' ? 'Craving Bollywood blockbusters, Hollywood hits, or South Indian sensations? Stream them all now! Huge library, all your favorite languages.' : 'Craving Bollywood blockbusters, Hollywood hits, or South Indian sensations? Stream them all now! Huge library, all your favorite languages.';

                    $meta['keywords'] = $lang != 'HINDI' ? 'originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries, EPIC ON,films,hollywood movies, bollywood movies, hindi movies,originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries,amazon prime movies' : 'नई फिल्में, फिल्में, मूवीज, फिल्म, ऑनलाइन वीडियो, टीवी श्रृंखला, टीवी शो, सर्वश्रेष्ठ नेटफ्लिक्स श्रृंखला, वेब श्रृंखला, शो, सर्वश्रेष्ठ वेब श्रृंखला, वृत्तचित्र';

                } else {

                    $meta['title'] = $lang != 'HINDI' ? 'Best Ott Platforms for kids Online in India | Watch Now' : 'देखो टीवी शो, एपिसोड, सिनेमा ऑनलाइन | ईपीक ऑन';

                    $meta['description'] = $lang != 'HINDI' ? 'Keep your kids entertained with the best OTT platforms for kids in India, featuring a wide range of content. Subscribe and Enjoy ad-free streaming' : 'कॉमेडी, रोमांस, एक्शन, ड्रामा, भोजन, यात्रा और पौराणिक कथाओं की शैलियों के बीच लोकप्रिय टीवी शो, ब्लॉकबस्टर फिल्में, मूल, वृत्तचित्र, और बहुत कुछ देखें';

                    $meta['keywords'] = $lang != 'HINDI' ? 'originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries, EPIC ON,films,hollywood movies, bollywood movies, hindi movies,originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries,amazon prime movies' : 'नई फिल्में, फिल्में, मूवीज, फिल्म, ऑनलाइन वीडियो, टीवी श्रृंखला, टीवी शो, सर्वश्रेष्ठ नेटफ्लिक्स श्रृंखला, वेब श्रृंखला, शो, सर्वश्रेष्ठ वेब श्रृंखला, वृत्तचित्र';

                }

            } else if ($pagetitle == 'listen' || $pagetitle == 'podcast') {

                $meta['title'] = $lang != 'HINDI' ? 'Listen Podcast in Hindi | Historical Stories in Hindi | Listen Now' : 'Listen Podcast in Hindi | Historical Stories in Hindi | Listen Now';

                $meta['description'] = $lang != 'HINDI' ? 'Immerse yourself in riveting historical stories & podcasts in Hindi. Discover our vast collection of engaging audio content exploring India\'s vibrant heritage.' : 'Immerse yourself in riveting historical stories & podcasts in Hindi. Discover our vast collection of engaging audio content exploring India\'s vibrant heritage.';

                $meta['keywords'] = $lang != 'HINDI' ? 'free podcast, download podcast, free popular podcasts, free podcast downloads, free podcasts online' : 'मुफ्त पॉडकास्ट, पॉडकास्ट डाउनलोड करें, मुफ्त पॉडकास्ट, मुफ्त पॉडकास्ट डाउनलोड, मुफ्त पॉडकास्ट ऑनलाइन';

            } else if ($pagetitle == 'play' || $pagetitle == 'games' || $pagetitle == 'games-all' || $pagetitle == 'Web games') {

                if ($pageslug == 'gamepix') {

                    $meta['title'] = $lang != 'HINDI' ? 'Epic On - Online Gaming Platform for Kids | Check Today' : 'अब खेलें कई ऑनलाइन गेम्स उपलब्ध है ईपीक ऑन पर';

                    $meta['description'] = $lang != 'HINDI' ? 'Enjoy fun and educational online games with kids of all ages! These games will keep you entertained and learning at the same time' :  'अब तम्बोला, लूडो, शूटिंग गेम्स, आर्केड फ्री गेम, रेसिंग कार गेम्स सहित असीमित मुफ्त ऑनलाइन गेम खेलें, जो ईपीक ऑन पर उपलब्ध हैं';

                    $meta['keywords'] = $lang != 'HINDI' ? 'games, games free download, subway surfers, onilne games, car games, coin master free spins, games to play, play online games, gamezop, snake game, bubble shooter, onilne chess, bubble shooter, free games, new games, games, games free download, subway surfers, onilne games, car games, coin master free spins, games to play, play online games, gamezop, snake game, bubble shooter, onilne chess, bubble shooter, free games, new games,free online, kids games' : 'खेल, खेल मुफ्त डाउनलोड, मेट्रो सर्फर्स,ऑनलाइन खेल, कार खेल, सिक्का मुक्त, खेल खेलने के लिए, ऑनलाइन खेल, साँप खेल, बुलबुला शूटर, ऑनलाइन शतरंज, बुलबुला शूटर, मुफ्त खेल, नए खेल खेलने के लिए';

                } else if ($pageslug == 'gamezop') {

                    $meta['title'] = $lang != 'HINDI' ? 'Online Gaming OTT Platform | Play Now' : 'अब खेलें कई ऑनलाइन गेम्स उपलब्ध है ईपीक ऑन पर';

                    $meta['description'] = $lang != 'HINDI' ? 'Experience the future of online gaming with Epic On, India\'s premier OTT gaming platform. Play your favorite games instantly, without any installation.' :  'अब तम्बोला, लूडो, शूटिंग गेम्स, आर्केड फ्री गेम, रेसिंग कार गेम्स सहित असीमित मुफ्त ऑनलाइन गेम खेलें, जो ईपीक ऑन पर उपलब्ध हैं';

                    $meta['keywords'] = $lang != 'HINDI' ? 'games, games free download, subway surfers, onilne games, car games, coin master free spins, games to play, play online games, gamezop, snake game, bubble shooter, onilne chess, bubble shooter, free games, new games, games, games free download, subway surfers, onilne games, car games, coin master free spins, games to play, play online games, gamezop, snake game, bubble shooter, onilne chess, bubble shooter, free games, new games,free online, kids games' : 'खेल, खेल मुफ्त डाउनलोड, मेट्रो सर्फर्स,ऑनलाइन खेल, कार खेल, सिक्का मुक्त, खेल खेलने के लिए, ऑनलाइन खेल, साँप खेल, बुलबुला शूटर, ऑनलाइन शतरंज, बुलबुला शूटर, मुफ्त खेल, नए खेल खेलने के लिए';

                } else {

                    $meta['title'] = $lang != 'HINDI' ? 'Online Gaming Platform | Play Games At Epic On' : 'अब खेलें कई ऑनलाइन गेम्स उपलब्ध है ईपीक ऑन पर';

                    $meta['description'] = $lang != 'HINDI' ? 'Play your favorite online games on Epic On. With a wide selection of games to choose from, Enjoy smooth and seamless gaming edxperience. Sign up for a free trial!' :  'अब तम्बोला, लूडो, शूटिंग गेम्स, आर्केड फ्री गेम, रेसिंग कार गेम्स सहित असीमित मुफ्त ऑनलाइन गेम खेलें, जो ईपीक ऑन पर उपलब्ध हैं';

                    $meta['keywords'] = $lang != 'HINDI' ? 'games, games free download, subway surfers, onilne games, car games, coin master free spins, games to play, play online games, gamezop, snake game, bubble shooter, onilne chess, bubble shooter, free games, new games, games, games free download, subway surfers, onilne games, car games, coin master free spins, games to play, play online games, gamezop, snake game, bubble shooter, onilne chess, bubble shooter, free games, new games,free online, kids games' : 'खेल, खेल मुफ्त डाउनलोड, मेट्रो सर्फर्स,ऑनलाइन खेल, कार खेल, सिक्का मुक्त, खेल खेलने के लिए, ऑनलाइन खेल, साँप खेल, बुलबुला शूटर, ऑनलाइन शतरंज, बुलबुला शूटर, मुफ्त खेल, नए खेल खेलने के लिए';

                }

            } else if ($pagetitle == 'read' || $pagetitle == 'ebooks') {

                $meta['title'] = $lang != 'HINDI' ? 'EBooks | Download free Fiction, Love Stories, Romance, English Ebook, Horror and many more on EPIC ON' : 'अब पढ़ें सबसे लोकप्रिय ईबुक उपलब्ध है ईपीक ऑन पर';

                $meta['description'] = $lang != 'HINDI' ? 'You cannot stop reading as EPIC ON has unlimited ebooks from popular publications. Read your favourite ebooks free online, available at EPIC ON' : 'लोकप्रिय प्रकाशनों से असीमित ईबुक को पढ़ना कभी समाप्त नहीं होगा क्योंकि ईपीक ऑन पर उपलब्ध हैं अपनी पसंदीदा ईबुक मुफ्त, पढ़ें ऑनलाइन';

                $meta['keywords'] = $lang != 'HINDI' ? 'kindle ebook, ebook reading, ebooks, ebook library, read ebooks online, onlinebooks, free ebooks, free ebook download, read ebooks online free, free onlinebooks, kindle ebook, ebook reading, ebooks, ebook library, read ebooks online, onlinebooks, free ebooks, free ebook download, read ebooks online free, free onlinebooks' : 'किंडल ईबुक, ई-बुक पढ़ना, ई-बुक्स, ई-पुस्तक पुस्तकालय, ई-बुक्स ऑनलाइन पढ़ना, ऑनलाइन बुक्स, फ्री ई-बुक्स, मुफ्त ई-बुक डाउनलोड, ई-बुक्स ऑनलाइन फ्री, फ्री ऑनलाइन बुक्स पढ़ना';

            } else if ($pagetitle == 'offers') {

                $meta['title'] = $lang != 'HINDI' ? 'Earn Rewards of Epicoins and Redeem on Offers.' : 'ईपीक कोईन में रिवार्ड कमाएँ और ऑफ़र पर रिडीम करें';

                $meta['description'] = $lang != 'HINDI' ? 'Get rewarded for binge-watching, playing games, reading books, and more. Redeem your EPIC coins on available offers at reward store' : 'देखना, खेल खेलना, किताबें पढ़ना, और बहुत कुछ से ईपीक कोईन प्राप्त करें और रिवॉर्ड स्टोर पर उपलब्ध ऑफर्स पर रिडीम करें';

                $meta['keywords'] = $lang != 'HINDI' ? 'flipkart offers, dominos coupons, myntra coupons, offers, dominos coupon codes, dominos offer, coupons, myntra coupon code, myntra offers, discounts, crossword, deals, vouchers' : 'फ्लिपकार्ट ऑफर, डोमिनोज़ कूपन, कूपन, ऑफ़र, डोमिनोज़ कूपन कोड, डोमिनोज़ ऑफ़र, कूपन कोड, ऑफ़र, छूट, क्रॉसवर्ड, डील्स, वाउचर';

            } else if ($pageslug == 'explore') {

                $meta['title'] = $lang != 'HINDI' ? 'Explore Different Gener And Languages on Our Platform Online' : 'अन्वेषण';

                $meta['description'] = 'Enjoy watching your favorite genres and languages movies and shows  Online with your family. Epic On has a huge collection of entertainment. Watch Now';

            } else if ($pageslug == 'premium') {

                $meta['title'] = $lang != 'HINDI' ? 'Watch Premium Collection Of Movies And Shows Online' : 'अधिमूल्य';

                $meta['description'] = $lang != 'HINDI' ? 'Discover our premium collection of movies & shows to watch online instantly. Stream hit Bollywood, Hollywood, Regional movies, TV shows & more in HD' : 'देखना, खेल खेलना, किताबें पढ़ना, और बहुत कुछ से ईपीक कोईन प्राप्त करें और रिवॉर्ड स्टोर पर उपलब्ध ऑफर्स पर रिडीम करें';

                $meta['keywords'] = $lang != 'HINDI' ? 'free podcast, download podcast, free popular podcasts, free podcast downloads, free podcasts online' : 'फ्लिपकार्ट ऑफर, डोमिनोज़ कूपन, कूपन, ऑफ़र, डोमिनोज़ कूपन कोड, डोमिनोज़ ऑफ़र, कूपन कोड, ऑफ़र, छूट, क्रॉसवर्ड, डील्स, वाउचर';

            } else {

                $meta['title'] = 'Top Podcasts Platform in India | Listen Now';

                $meta['description'] = 'Discover the top podcasts in India on Epic On, Indias premier OTT platform. With a wide range of genres to choose from, there is something for everyone. Start listening today!';

                $meta['keywords'] = 'free podcast, download podcast, free popular podcasts, free podcast downloads, free podcasts online';

            }

        } else if ($pagetype == 'LIVETV') {

            if ($pageslug == 'epic-on-live-tv') {

                $meta['title'] = $lang != 'HINDI' ? 'Watch EPIC Live TV Streaming on EPIC ON' : 'देखें ईपीक लाइव टीवी ईपीक ऑन पर';

                $meta['description'] = $lang != 'HINDI' ? 'Watch EPIC Channel Live TV - India Ka Apna Infotainment, Watch TV Shows, Documentaries, EPIC Shorts, EPIC Specials, EPIC Originals, Online at EPIC On' : 'देखें ईपीक चैनल लाइव टीवी - इंडिया का अपना इन्फोटेनमेंट, टीवी शो, वृत्तचित्र, ईपीक शॉर्ट्स, ईपीक स्पेशल, ऑनलाइन ईपीक ऑन पर';

                $meta['keywords'] = $lang != 'HINDI' ? 'live tv, live tv shows, live tv channel, public tv live, live tv app, epic on live tv, epic channel tv,  tv series, recipe shows, travel shows, historic places, mythology, festivals of India, best tv shows, best tv series, history of India' : 'लाइव टीवी, लाइव टीवी शो, लाइव टीवी चैनल, सार्वजनिक टीवी लाइव, लाइव टीवी ऐप, लाइव टीवी पर महाकाव्य, टीवी चैनल, टीवी श्रृंखला, नुस्खा शो, यात्रा शो, ऐतिहासिक स्थान, पौराणिक कथाएँ, भारत के त्योहार, सर्वश्रेष्ठ टीवी शो, सर्वश्रेष्ठ टीवी श्रृंखला, भारत का इतिहास';

            } else if ($pageslug == 'showbox-live-tv') {

                $meta['title'] = $lang != 'HINDI' ? 'Watch Showbox Live TV Streaming Online on EPIC ON' : 'देखें शोबॉक्स लाइव टीवी ईपीक ऑन पर';

                $meta['description'] = $lang != 'HINDI' ? 'Watch Showbox live music online, bollywood songs, punjabi songs and  popular songs live on Showbox Live TV' : 'ऑनलाइन शोबॉक्स लाइव संगीत देखें, बॉलीवुड गाने, पंजाबी गाने और लोकप्रिय गाने शोबॉक्स लाइव टीवी पर';

                $meta['keywords'] = $lang != 'HINDI' ? 'live tv, music online, live tv channel, public tv live, live tv app, punjabi songs, hindi songs, hindi gana, new punjabi song, video hindi gana, hindi gane, new hindi song, punjabi gane, punjabi song video, bollywood songs' : 'लाइव टीवी, संगीत ऑनलाइन, लाइव टीवी चैनल, सार्वजनिक टीवी लाइव, लाइव टीवी ऐप, पंजाबी गाने, हिंदी गाने, नए पंजाबी गीत, वीडियो हिंदी गाने, नए हिंदी गीत, पंजाबी गीत, पंजाबी गीत वीडियो, बॉलीवुड गीत';

            } else if ($pageslug == 'filamchi-live-tv') {

                $meta['title'] = $lang != 'HINDI' ? 'Watch Filamchi Live TV Streaming on EPIC ON' : 'देखें फिलमची लाइव टीवी ईपीक ऑन पर';

                $meta['description'] = $lang != 'HINDI' ? 'Watch your favourite bhojpuri movies live on filamchi live tv streaming on EPIC On' : 'अपनी पसंदीदा भोजपुरी फिल्में फिलमची लाइव टीवी पर देखें';

                $meta['keywords'] = $lang != 'HINDI' ? 'live tv, movies online, live tv channel, public tv live, live tv app, filamchi tv, filamchi live tv, free live tv, bhojpuri movies, bhojpuri video, bhojpuri film, bhojpuri cinema, bhojpuri film video' : 'लाइव टीवी, फिल्में ऑनलाइन, लाइव टीवी चैनल, पब्लिक टीवी लाइव, लाइव टीवी एप, फिल्ममची टीवी, फिल्ममची लाइव टीवी, फ्री लाइव टीवी, भोजपुरी फिल्में, भोजपुरी वीडियो, भोजपुरी फिल्म, भोजपुरी सिनेमा, भोजपुरी फिल्म वीडियो';

            } else {

                $meta['title'] = 'Watch Live Tv | Best OTT Platforms for Live TV';

                $meta['description'] = 'Catch all the live action with EPIC ON, India\'s premier OTT platform for live TV. Stream your favorite news, sports, and entertainment channels from anywhere';

                $meta['keywords'] = 'live tv, movies online, live tv channel, public tv live, live tv app, filamchi tv, filamchi live tv, free live tv, bhojpuri movies, bhojpuri video, bhojpuri film, bhojpuri cinema, bhojpuri film video';

            }

        } else if ($pagetype == 'HISTORY') {

            $meta['title'] = 'Watch EPICON for your favourite Tv Shows, Episodes - Podcast - Ebook - Games - Rewards';

            $meta['description'] = 'Watch ' . $pagetitle . ' Shows online. Latest ' . $pagetitle . ' Shows Episodes, Promos online at EPIC ON.';

        } else if (strtolower($pagetype) == 'contact-us') {

            $meta['title'] = 'Contact Us - Epic On';

            $meta['description'] = 'Epic On contact us feature offers seamless and convenient communication for our valued users. For more details on our OTT platform fill the form.';

        } else if (strtolower($pagetype) == 'coming-soon') {

            $meta['title'] = 'Get to Know About Upcoming New Web Series and Movies';

            $meta['description'] = 'Exciting collection of upcoming web series and movies on epic on. Watch wide range of Hindi and English TV show and movies online';

            $meta['twitter_title'] = "Get to Know About Upcoming OTT New Web Series and Movies";

        } else if (strtolower($pagetype) == 'subscription') {

            $meta['title'] = 'Subscription Plans - Epic On';

            $meta['description'] = 'Get access to a wide range of TV shows and movies of Epicon by subscribing to our platform. We have best plan for you. Check the Subscription section today!';

        } else if (strtolower($pagetype) == 'about-us') {

            $meta['title'] = 'About Us - Epic On a Seamless Streaming Experience';

            $meta['description'] = 'Experience entertainment like never before with the Epic On OTT Platform. Enjoy an extensive collection of movies, TV shows, and live shows all in one place.';

        } else if (strtolower($pagetype) == 'distro-tv') {

            $meta['title'] = 'Watch Online Distro TV for News, Music, Cartoons';

            $meta['description'] = 'Watch Distro TV with your family for news, music, and many other entertaining shows. Watch Distro TV online for news, music, cartoons, and live channels.';

        } else if (strtolower($pagetype) == 'live-tv') {

            if ($lang != 'HINDI') {

                $meta['title'] = 'Watch Live Tv | Best OTT Platforms for Live TV';

                $meta['description'] = 'Catch all the live action with EPIC ON, Indias premier OTT platform for live TV. Stream your favorite news, sports, and entertainment channels from anywhere.';

                $meta['keywords'] = 'live tv, live tv shows, live tv channel, public tv live, live tv app, EPIC ON live tv, epic channel tv, showbox live tv, filamchi live tv';

            } else {
                $meta['title'] = 'देखें लाइव टीवी कभी भी ईपीक ऑन पर';

                $meta['description'] = 'देखें ईपीक चैनल लाइव टीवी, फिलमची लाइव टीवी और शोबॉक्स लाइव टीवी कभी भी ईपीक ऑन पर';

                $meta['keywords'] = 'लाइव टीवी, लाइव टीवी शो, लाइव टीवी चैनल, पब्लिक टीवी लाइव, लाइव टीवी ऐप, ईपीक लाइव टीवी, ईपीक चैनल टीवी, शोबॉक्स लाइव टीवी, फिलमची लाइव टीवी';
            }
        }

        return $meta;
    }

}

if (!function_exists('exploreGetMeta')) {
    function exploreGetMeta($pageslug = ''){
        $lang = setLanguageParameter();
        if ($pageslug == 'hindi') {
            $meta['title'] = $lang != 'HINDI' ? 'Explore Hindi Movie and Shows Online on Epic ON':'Explore Hindi Movie and Shows Online on Epic ON';
            $meta['description'] = $lang != 'HINDI' ? 'Explore Hindi movies, shows & more on Epic ON. Enjoy a vast library of entertainment across genres. Sign up for our premium subscription & watch online now!':'Explore Hindi movies, shows & more on Epic ON. Enjoy a vast library of entertainment across genres. Sign up for our premium subscription & watch online now!';
        } else if ($pageslug == 'mythology') {
            $meta['title'] = $lang != 'HINDI' ? 'Explore - Mythology Shows Online in Hindi on Epic ON':'Explore - Mythology Shows Online in Hindi on Epic ON';
            $meta['description'] = $lang != 'HINDI' ? 'Dive into Epic tales! Explore mythology shows in Hindi on Epic ON. Classics & fresh takes on Devlok, Papnashni Ganga & more. Watch Now!':'Dive into Epic tales! Explore mythology shows in Hindi on Epic ON. Classics & fresh takes on Devlok, Papnashni Ganga & more. Watch Now!';
        } else if ($pageslug == 'history') {
            $meta['title'] = $lang != 'HINDI' ? 'Explore - Hindi Shows Online Based on History on Epic ON':'Explore - Hindi Shows Online Based on History on Epic ON';
            $meta['description'] = $lang != 'HINDI' ? 'Unveil India\'s past! Explore captivating historical dramas & shows in Hindi. Stream now on Epic ON for an immersive journey.':'Unveil India\'s past! Explore captivating historical dramas & shows in Hindi. Stream now on Epic ON for an immersive journey.';
        } else if ($pageslug == 'travel') {
            $meta['title'] = $lang != 'HINDI' ? 'Explore - Real Life Travel Show in Hindi on Epic ON':'Explore - Real Life Travel Show in Hindi on Epic ON';
            $meta['description'] = $lang != 'HINDI' ? 'Travel the world from your couch! Explore real-life travel show in Hindi on Epic ON. Breathtaking journeys & cultural insights. Watch Now!':'Travel the world from your couch! Explore real-life travel show in Hindi on Epic ON. Breathtaking journeys & cultural insights. Watch Now!';
        }else if ($pageslug == 'comedy') {
            $meta['title'] = $lang != 'HINDI' ? 'Watch Comedy Shows, Movies and Series in Hindi | Explore Now':'Watch Comedy Shows, Movies and Series in Hindi | Explore Now';
            $meta['description'] = $lang != 'HINDI' ? 'Laugh out loud with our diverse collection of Hindi comedy shows, movies, and series. Explore hilarious content across genres from standup to sitcoms.':'Laugh out loud with our diverse collection of Hindi comedy shows, movies, and series. Explore hilarious content across genres from standup to sitcoms.';
        }
        else if ($pageslug == 'fiction') {
            $meta['title'] = $lang != 'HINDI' ? 'Watch Fictional Shows, Movies and Series in Hindi | Explore Now':'Watch Fictional Shows, Movies and Series in Hindi | Explore Now';
            $meta['description'] = $lang != 'HINDI' ? 'Escape into the captivating world of Hindi fictional shows, movies, and series. Explore a vast collection spanning diverse genres like fantasy, sci-fi, and more.':'Escape into the captivating world of Hindi fictional shows, movies, and series. Explore a vast collection spanning diverse genres like fantasy, sci-fi, and more.';
        
        }else if ($pageslug == 'adventure') {
            $meta['title'] = $lang != 'HINDI' ? 'Watch Adventurous Movie, Shows and Series in Hindi':'Watch Adventurous Movie, Shows and Series in Hindi';
            $meta['description'] = $lang != 'HINDI' ? 'Crave action & thrills? Stream Hindi adventure movies, shows & series. Explore epic journeys & heart-pounding stories. Watch Now on Epic ON':'Crave action & thrills? Stream Hindi adventure movies, shows & series. Explore epic journeys & heart-pounding stories. Watch Now on Epic ON';
        
        }else if ($pageslug == 'romance') {
            $meta['title'] = $lang != 'HINDI' ? 'Watch Romantic Movie, Shows and Series | Explore Now':'Watch Romantic Movie, Shows and Series | Explore Now';
            $meta['description'] = $lang != 'HINDI' ? 'Watch our collection of romantic Hindi movies, shows, and series. Explore heartwarming tales and Drama Sign up now for unlimited romantic entertainment!':'Watch our collection of romantic Hindi movies, shows, and series. Explore heartwarming tales and Drama Sign up now for unlimited romantic entertainment!';
        
        }else if ($pageslug == 'mystery') {
            $meta['title'] = $lang != 'HINDI' ? 'Watch Mystery Show, Movies and Series Online | Explore Now':'Watch Mystery Show, Movies and Series Online | Explore Now';
            $meta['description'] = $lang != 'HINDI' ? 'Unravel the clues! Stream captivating Hindi mystery shows, movies & series. Keep you guessing till the end. Watch Now on Epic ON':'Unravel the clues! Stream captivating Hindi mystery shows, movies & series. Keep you guessing till the end. Watch Now on Epic ON';
        
        }else if ($pageslug == 'social-issues') {
            $meta['title'] = $lang != 'HINDI' ? 'Watch Hindi Shows, Movies and Series Based on Social Issues':'Watch Hindi Shows, Movies and Series Based on Social Issues';
            $meta['description'] = $lang != 'HINDI' ? 'Spark conversations! Explore Hindi shows, movies & series tackling social issues. Thought-provoking stories that matter. Watch Now on Epic ON':'Spark conversations! Explore Hindi shows, movies & series tackling social issues. Thought-provoking stories that matter. Watch Now on Epic ON';
        
        }else{
            $meta = [];
        }

        return $meta;
    }
}

function generateUUIDv4() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}


function generateDeviceId() {
    // Gather available information
    $navigatorInfo = [
        $_SERVER['HTTP_USER_AGENT'] ?? "",
        $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? "",
        $_SERVER['REMOTE_ADDR'] ?? "", // IP address
        date_default_timezone_get(), // Timezone
    ];
    // Combine and hash the information to create a unique identifier
    $deviceId = json_encode($navigatorInfo);
    $deviceId = md5($deviceId);
    setcookie('deviceId', $deviceId, time() + (10 * 365 * 24 * 60 * 60), '/'); 
    return $deviceId;
}

function sortEpisodes($temp)
{
    if (count($temp) > 0) {
        usort($temp, function ($a, $b) {
            return @$a['content_order'] - @$b['content_order'];
        });
        return $temp;
    }
}
function checkReleaseDate($newrelease_date)
{
    $currentDate = date("Y-m-d");
    $releaseDate = date("Y-m-d", strtotime($newrelease_date));
    $curdate = strtotime($currentDate);
    $maindate = strtotime($releaseDate);
    $days = ($curdate - $maindate) / (60 * 60 * 24);
    if ($days >= 0 && $days < 4) {
        return true;
    }
    return false;
}