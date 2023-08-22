<?php

declare(strict_types=1);

use Illuminate\Http\JsonResponse;
use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\UTCDateTime;


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

function CurlAPI($context, $method = 'GET', $data = null)
{
    if (empty($context)) return;

    return ApiHelper::api($context, $method, $data);
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
    echo (@$val['free_premium'] == true) ? '<span class="crown position-absolute"><img src="' . asset('assets/images/crown.svg') . '" alt=""></span>' : '';
}


function getItemCardData($val, $language)
{
    $title = getDispLangContent($val, $language, 'title');
    $shortdescription = getDispLangContent($val, $language, 'shortdesc');

    $bannerimagcond = getDispLangContent($val, $language, 'bannerimg');

    if (empty($bannerimagcond)) {
        $bannerimagcond = getDispLangContent($val, $language, 'coverimage');
    }
    $bannerimage = getImage($bannerimagcond, "original");

    $generes = array_column($val['genres_assign'] ?? [], 'name');

    $sub_text = [];

    if (isset($val['release_date'])) {
        $sub_text[] = date('Y', strtotime($val['release_date']));
    }
    // $sub_text[] = '3 Language';

    if ($generes) {
        $sub_text[] = implode(", ", $generes);
    }
    if (isset($val['age_limit'])) {
        $sub_text[] = $val['age_limit'];
    }

    $sub_points = '<li class="ps-1">' . @$val['age_limit'] . '</li>';

    if ($generes) {
        foreach ($generes as $key => $genre) {
            $sub_points .= '<li>' . $genre . '</li>';
        }
    }

    return [
        'title' => $title,
        'short_desc' => $shortdescription,
        'banner_img' => $bannerimage,
        'sub_text' => implode(". ", $sub_text),
        'sub_points' => $sub_points
    ];
}
