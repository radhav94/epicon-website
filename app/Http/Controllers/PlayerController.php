<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;

class PlayerController extends Controller
{
    public function __construct()
    {
    }

    public function getVideoUrl(Request $request): JsonResponse
    {   
        $param = ['content_id' => $request->cid];

        $isIPhone = is_numeric(strpos(strtolower(@$_SERVER["HTTP_USER_AGENT"]), "iphone")); 
        $isIPad = is_numeric(strpos(strtolower(@$_SERVER["HTTP_USER_AGENT"]), "ipad")); 

        if($isIPhone || $isIPad){
            $param['safari'] = 1;
        }
        
        $result = CurlAPI("pages/play_url", "POST", $param, 1, true);
        // dd($result);
        if ($result && @$result['success'] ==  true) {

            $subtitles = $result['subtitles'] ?? [];
            $temp = [];
            $html = '';
            if ($subtitles) {
                foreach ($subtitles as $key => $value) {
                    $src = @$value['file'];

                    $extension = pathinfo($src, PATHINFO_EXTENSION);

                    // Check if the extension is 'srt'
                    // if (strtolower($extension) === 'srt') {
                        $srtContent = @file_get_contents($src);

                        // Convert .srt to .vtt format
                        $vttContent = "WEBVTT\n\n";
                        $vttContent .= preg_replace("/,/", '.', $srtContent);
                        $src = 'data:text/vtt;base64,' . base64_encode($vttContent);
                    // }


                    $temp[] = [
                        'language' =>   strtolower(substr(@$value['lang'], 0, 2)),
                        'label' => @$value['lang'],
                        'src' => @$value['file'],
                        // 'kind' => 'subtitles',
                        // 'srclang' => 'en'
                    ];
                    $default = ($key == 0) ? "default" : "";
                    $html .= '<track kind="subtitles" label="' . @$value['lang'] . '" src="' . $src . '" srclang="' . strtolower(substr(@$value['lang'], 0, 2)) . '" ' . $default . '>';
                }
            }

            $data = [
                'video_url' => @$result['url']['video_url'] ?? '',
                'promo_url' => @$result['url']['promo_url'] ?? '',
                'subtitles' => $temp,
                'html' => $html,
            ];
            // $data = ['data' => json_encode($data)];

            return JSONResponse(200, 'success.', $data);
        } else {

        \Log::channel('error_404')->debug('--------------(pages/play_url)  Error ('.date('h:i:s A').')----------------------');
        \Log::channel('error_404')->debug('Error =>'.json_encode($result));
        
            return JSONResponse(400,  $result['message'] ?? 'failed');
        }
    }

    public function setplayTracking(Request $request)
    {
        
        $param = [
            'content_id' => $request->cid,
            'duration' => ! empty($request->elapsed) ? $request->elapsed : 1,
            'title' => $request->title,
            'type' => $request->tp,
            'completed' => $request->completed ?? false,
        ];

        if (isUserLoggedIn()) {
            $param['profile_id'] = getProfileId();
        }else{
            $param['user_id'] = '';
            $param['playtrackingid'] = generateGuestUserId();
        }
       
        $result = CurlAPI("pages/setplaytracking", "POST", $param, 1, true, true);
        
        if ($result && @$result['success'] ==  true) {
            return JSONResponse(200, 'success.');
        }
        \Log::channel('error_404')->debug('--------------(pages/setplaytracking)  Error ('.date('h:i:s A').')----------------------');
        \Log::channel('error_404')->debug('Error =>'.json_encode($result));
        return JSONResponse(400, 'Error',$result);
        // return JSONResponse(400, 'Error');
    }
}
