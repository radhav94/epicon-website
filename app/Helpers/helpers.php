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

if (!function_exists('getUserAgent')) {
    function getUserAgent()
    {
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
        return "$ub ($o_system)";
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
    echo (@$val['free_premium'] == true) ? '<span class="crown position-absolute"><img src="' . asset('assets/img/crown.svg') . '" alt=""></span>' : '';
}

// function isPopularDiv($val)
// {
//     echo (@$val['is_popular'] == true) ? '<span><img src="' . asset('assets/img/fire-emoji.png') . '" alt=""></span>' : '';
// }


function topTenDiv($val)
{
    if (@$val['is_top10'] == true) {
        echo '<span class="top-ten position-absolute">
                <ul class="list-unstyled text-white">
                    <li>Top</li>
                    <li>10</li>
                </ul>
            </span>';
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
            $icon = '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.1422 11.1919H11.1898C11.1898 11.1919 10.6541 11.1919 9.99934 11.1919C9.34458 11.1919 8.80887 11.1919 8.80887 11.1919H2.85649C2.20173 11.1919 1.66602 10.6562 1.66602 10.0014C1.66602 9.34665 2.20173 8.81094 2.85649 8.81094H8.80887C8.80887 8.81094 9.34458 8.81096 9.99934 8.81096C10.6541 8.81096 11.1898 8.81094 11.1898 8.81094H17.1422C17.797 8.81094 18.3327 9.34665 18.3327 10.0014C18.3327 10.6562 17.797 11.1919 17.1422 11.1919Z" fill="white"/></svg>';
        }
        // return '<button class="big-add-list addToList ' . $wishAction . '-icon" data-id="' . @$val['ID'] . '" data-action="' . $wishAction . '" data-type="1"> </button>';
        return '<button class="big-add-list ' . $logClass . $addToList . '" data-id="' . @$val['ID'] . '" data-action="' . $wishAction . '" data-type="1">  ' . $icon . '</button>';
    } else {
        // $icon = ($wishAction == 'add') ? 'delete-icon' : 'add-icon';
        return '<button class="small-btn ' . $wishAction . '-icon mx-2 ' . $logClass . $addToList . '" data-id="' . @$val['ID'] . '" data-action="' . $wishAction . '" data-type="2"></button>';
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
    $ua = strtolower($_SERVER["HTTP_USER_AGENT"]);
    $isMob = is_numeric(strpos($ua, "mobile"));
    $isIPhone = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "iphone"));
    return (isset($isMob) && $isMob == true) || (isset($isIPhone) && $isIPhone == true) ? true : false;
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
        foreach ($generes as $key => $genre) {
            $sub_points .= '<li>' . $genre . '</li>';
        }
    }

    return [
        'title' => $title,
        'short_desc' => $shortdescription,
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






function convertSecondsToReadable($seconds)
{
    if ($seconds > 0) {
        $day = floor($seconds / 86400);
        $hours = floor(($seconds - ($day * 86400)) / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $seconds = $seconds % 60;

        if ($hours) {
            return $hours . ' hr ' . $minutes . ' min ';
        } elseif ($minutes) {
            return $minutes . ' min ';
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
    $data_url = (isActiveSubscription() && $value['free_premium']) || !$value['free_premium'] ? $value['game_url'] : '';
    $html = '<a href="javascript:void(0)" target="_blank" data-url="' . $data_url . '" data-premium="' . $value['free_premium'] . '" data-activesubscriber="' . isActiveSubscription() . '" check-login="' . $loginclass . '" class="main-card check-content-url">';
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

    $offerCount = 0;
    $result['status'] = [];
    $today = date("Y-m-d") . "T" . date("H:i:s") . "Z";
    $todayStrToTime = strtotime($today);
    $usedDays = 0;
    $activePlan = [];
    $subscriptionPurchases = CurlAPI("users/purchases", "POST", "", 2, true);
    if (!empty(@$subscriptionPurchases['success']) && @$subscriptionPurchases['success'] == true) {
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
        if (isset($activePlan['remainingDays']) && $activePlan['remainingDays'] > 1) {
            $result['status'] = 'active';
        }


        return $result;
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
        'banner_image' => 'default-830x400.png',
        'cover_image' => 'default-830x400.png',
        'cover_image_special' => 'default-200x200.png',
        'spotlight_epic_shorts_image' => 'default-200x200.png',
        'epic_shorts_image' => 'default-200x200.png',
        'vertical_cover_image' => 'default-200x300.png'
    ];
    // }
    $img_url = '';
    if ($content) {
        if (isset($content[$key]) && !empty($content[$key])) {
            $img_url = $content[$key][$size] ?? '';
        }

        if (empty($img_url)) {

            $img_url = isset($fallback[$key]) ? asset('assets/img/' . $fallback[$key]) : asset('assets/img/default-200x200.png');

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
                        $episode_list[] = $episode['ID'];
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
        $profile_detail = CurlAPI("users/viewProfile", "POST", [], 2, true);
        if (is_array($profile_detail) && array_key_exists('success', $profile_detail)) {
            if ($profile_detail['success']) {
                if (array_key_exists('user_data', $profile_detail)) {
                    $user_data = @$profile_detail['user_data'];
                    session()->put('user', $user_data);
                }
            } else if (!$profile_detail['success'] && array_key_exists('errorcode', $profile_detail) && $profile_detail['errorcode'] == 2012) {
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

function getCountryStateData()
{
    $filepath = asset('json/countrystate.json');
    $countrystate = getJsonDataFromFile($filepath);
    return $countrystate;
}

function getCountryStateDataInHtml()
{
    $countrycode = (!empty($_SERVER['HTTP_X_CC']) ? $_SERVER['HTTP_X_CC'] : 'IN');
    $countrystate = getCountryStateData();
    $countryisdhtml = "";

    if( $countrystate){
            foreach ($countrystate['countries'] as $i => $value) {
                if ($countrycode == $value['code'] || $countrycode == $value['countryisdcode']) {
                    $selectvar = "selected";
                } else {
                    $selectvar = "";
                }
                $countryisdhtml .= '<option value="' . $value['countryisdcode'] . '" ' . $selectvar . '>' . $value['displayisdcode'] . '</option>';
            }
        }
    return $countryisdhtml;
}

if (!function_exists('assetTime')) {
    function assetTime() {
        return time();
    }
}

if (!function_exists('countConvert')) {
    function countConvert($count = 0) {
        return $count >= 1000 ? ceil($count/1000) . "K" : $count;
    }
}
