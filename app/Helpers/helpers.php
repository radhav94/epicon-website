<?php

declare(strict_types=1);

use App\Http\Controllers\ProfileController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;

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
            return !empty($content['description_ln']['HINDI']) ? $content['description_ln']['HINDI'] : $content['description'];
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
            return !empty($content['title_ln']['HINDI']) ? $content['title_ln']['HINDI'] : $content['title'];
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
            return !empty($content['cover_image_v2_ln']['HINDI']) ? $content['cover_image_v2_ln']['HINDI'] : $content['cover_image'];
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
            return !empty($content['short_description_ln']['HINDI']) ? $content['short_description_ln']['HINDI'] : $content['short_description'];
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
            return !empty($content['banner_image_v2_ln']['HINDI']) ? $content['banner_image_v2_ln']['HINDI'] : $content['banner_image'];
        } elseif ($displayLanguageParam == "TAMIL") {
            return !empty($content['banner_image_v2_ln']['TAMIL']) ? $content['banner_image_v2_ln']['TAMIL'] : $content['banner_image'];
        } elseif ($displayLanguageParam == "MARATHI") {
            return !empty($content['banner_image_v2_ln']['MARATHI']) ? $content['banner_image_v2_ln']['MARATHI'] : $content['banner_image'];
        } else {
            return $content['banner_image_v2_ln']['ENGLISH'];
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
    $wishlist_ids = $wishlist['ids'] ?? [];

    $wishAction = (in_array(@$val['ID'], $wishlist_ids)) ? 'delete' : 'add';

    if ($type == 1) {
        if ($wishAction == 'add') {
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none"><path d="M21.0026 15.1678H15.1693V21.0011C15.1693 21.6428 14.6443 22.1678 14.0026 22.1678C13.3609 22.1678 12.8359 21.6428 12.8359 21.0011V15.1678H7.0026C6.36094 15.1678 5.83594 14.6428 5.83594 14.0011C5.83594 13.3595 6.36094 12.8345 7.0026 12.8345H12.8359V7.00114C12.8359 6.35947 13.3609 5.83447 14.0026 5.83447C14.6443 5.83447 15.1693 6.35947 15.1693 7.00114V12.8345H21.0026C21.6443 12.8345 22.1693 13.3595 22.1693 14.0011C22.1693 14.6428 21.6443 15.1678 21.0026 15.1678Z" fill="white" /></svg>';
        } else {
            $icon = '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.1422 11.1919H11.1898C11.1898 11.1919 10.6541 11.1919 9.99934 11.1919C9.34458 11.1919 8.80887 11.1919 8.80887 11.1919H2.85649C2.20173 11.1919 1.66602 10.6562 1.66602 10.0014C1.66602 9.34665 2.20173 8.81094 2.85649 8.81094H8.80887C8.80887 8.81094 9.34458 8.81096 9.99934 8.81096C10.6541 8.81096 11.1898 8.81094 11.1898 8.81094H17.1422C17.797 8.81094 18.3327 9.34665 18.3327 10.0014C18.3327 10.6562 17.797 11.1919 17.1422 11.1919Z" fill="white"/></svg>';
        }
        // return '<button class="big-add-list addToList ' . $wishAction . '-icon" data-id="' . @$val['ID'] . '" data-action="' . $wishAction . '" data-type="1"> </button>';
        return '<button class="big-add-list addToList" data-id="' . @$val['ID'] . '" data-action="' . $wishAction . '" data-type="1">  ' . $icon . '</button>';
    } else {
        // $icon = ($wishAction == 'add') ? 'delete-icon' : 'add-icon';

        return '<button class="small-btn ' . $wishAction . '-icon mx-2 addToList" data-id="' . @$val['ID'] . '" data-action="' . $wishAction . '" data-type="2"></button>';
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
        $result = CurlAPI("pages/wishlist", "POST", $params);

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

function getItemCardData($val, $language)
{
    $title = getDispLangContent($val, $language, 'title');
    $shortdescription = getDispLangContent($val, $language, 'shortdesc');

    $bannerimagcond = getDispLangContent($val, $language, 'bannerimg');

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
    $day = floor($seconds / 86400);
    $hours = floor(($seconds - ($day * 86400)) / 3600);
    $minutes = floor(($seconds / 60) % 60);
    $seconds = $seconds % 60;

    if ($hours) {
        return $hours . ' hour ' . $minutes . ' min ';
    } elseif ($minutes) {
        return $minutes . ' min ';
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
    if ($val['content_type'] == 'EPISODE') {
        if (isset($val['parent_name'])) {
            $parent_name = trim($val['parent_name']);
            $wordToFind = 'season';

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
    return Session::get('user_id') ? true : false;
}


function getContentUrl($value)
{
    if (isset($value['url'])) {
        return url($value['url']);
    }

    return url('/');
}


function getMidPageUrl($value)
{
    return url('/midpage/' . ($value['slug'] ?? 'slug') . '/' . @$value['catalog']);
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

function formatDate($date, $format = 'd F Y')
{
    return date($format, strtotime($date));
}

function generateCategoryResponse($result)
{
    if (empty($result) || !isset($result['topResult'])) {
        return '';
    }

    $topResult = $result['topResult'];

    $premium = ($topResult['free_premium'] == true) ? '<img class="crown" src="' . asset('assets/img/crown.svg') . '" alt="icon">' : '';
    $dateText = isset($topResult['release_date']) ? date('Y-m-d', strtotime($topResult['release_date'])) : '';
    $wishlist = getWishlist();
    $wishlistAction = getWishListAction($topResult, $wishlist, 2);
    $url = getContentUrl($topResult);

    return '<div class="pik"><img src="' . $topResult['cover_image']['medium'] . '" alt="img">' . $premium . '</div>'
        . '<div class="episode-text-details">'
        . '<h6>' . $topResult['title'] . '</h6>'
        . '<span>' . @$dateText . ' | ' . @$topResult['duration'] . '</span>'
        . '<p class="search-top mt-2">' . $topResult['description'] . '</p>'
        . '<div class="d-flex align-items-center"><a href="' . $url . '"><button class="fill-btn em ms-0">Watch</button></a>' . $wishlistAction . '</div></div>';
}

function getCardImage($content, $key, $size = 'medium', $fallback = [])
{
    if (empty($fallback)) {
        $fallback = ['banner_image', 'cover_image', 'cover_image_special', 'spotlight_epic_shorts_image', 'epic_shorts_image', 'vertical_cover_image'];
    }
    $img_url = '';
    if ($content) {
        if (isset($content[$key]) && !empty($content[$key])) {
            $img_url = $content[$key][$size] ?? '';
        }

        if (empty($img_url)) {
            foreach ($fallback as $k => $img_key) {
                if (isset($content[$img_key]) && !empty($content[$img_key])) {
                    $img_url = $content[$img_key][$size] ?? '';
                }
                if (!empty($img_url)) {
                    break;
                }
            }
        }
    }
    return $img_url;
}
