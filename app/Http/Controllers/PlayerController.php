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
        $data = [
            // 'video_url' => 'https://epiconvod.s.llnwi.net/mmd-video/lmpl_test/laal-banarasi/season-1/e1-laal-banarasi/stream.ismd/manifest.m3u8?stream=144p;240p;320p;480p;720p;1080p&s=1695536327&e=1696832327&h=6335870e548a7f7dbef3b6244bc52f6e&hls_force_no_caption_tag=true&filter=(type!=\"audio\"||systemBitrate>128000)',
            'video_url' => urlencode('https://epiconvod.s.llnwi.net/mmd-video/lmpl_test/epicpedia/season-1/e1-mount-everest/stream.ismd/manifest.m3u8?stream=144p;240p;320p;480p;720p;1080p&s=1695536327&e=1696832327&h=6335870e548a7f7dbef3b6244bc52f6e&hls_force_no_caption_tag=true&filter=(type!=\"audio\"||systemBitrate>128000)'),
            'promo_url' => 'https://epiconvod-mmd-cust.lldns.net/lmpl_test/laal-banarasi/promo/stream.ismd/manifest.m3u8?stream=144p;240p;320p;480p;720p;1080p',
            'subtitles' => '',
            'html' => '',
        ];

        // return JSONResponse(200, 'success.', $data);

        $param = ['content_id' => $request->cid];
        // $param = ['content_id' => 63878];

        $result = CurlAPI("pages/play_url", "POST", $param, 1);
        // dd($result);
        if ($result && @$result['success'] ==  true) {

            $subtitles = $result['subtitles'] ?? [];
            $temp = [];
            $html = '';
            if ($subtitles) {
                foreach ($subtitles as $key => $value) {
                    $src = $value['file'];

                    $extension = pathinfo($src, PATHINFO_EXTENSION);

                    // Check if the extension is 'srt'
                    if (strtolower($extension) === 'srt') {
                        $srtContent = file_get_contents($src);

                        // Convert .srt to .vtt format
                        $vttContent = "WEBVTT\n\n";
                        $vttContent .= preg_replace("/,/", '.', $srtContent);
                        $src = 'data:text/vtt;base64,' . base64_encode($vttContent);
                    }


                    $temp[] = [
                        'language' =>   strtolower(substr($value['lang'], 0, 2)),
                        'label' => $value['lang'],
                        'src' => $value['file'],
                        // 'kind' => 'subtitles',
                        // 'srclang' => 'en'
                    ];
                    $default = ($key == 0) ? "default" : "";
                    $html .= '<track kind="subtitles" label="' . $value['lang'] . '" src="' . $src . '" srclang="' . strtolower(substr($value['lang'], 0, 2)) . '" ' . $default . '>';
                }
            }

            $data = [
                'video_url' => $result['url']['video_url'] ?? '',
                'promo_url' => $result['url']['promo_url'] ?? '',
                'subtitles' => $temp,
                'html' => $html,
            ];
            // $data = ['data' => json_encode($data)];

            return JSONResponse(200, 'success.', $data);
        } else {
            return JSONResponse(400,  $result['message'] ?? 'failed');
        }
    }

    public function setplayTracking(Request $request)
    {
        if (isUserLoggedIn()) {
            $param = [
                'content_id' => $request->cid,
                'duration' => $request->elapsed,
                'title' => $request->title,
                'type' => $request->tp,
                'profile_id' => getProfileId(),
                'completed' => $request->completed ?? false,
            ];

            $result = CurlAPI("pages/setplaytracking", "POST", $param, 1, true);

            if ($result && @$result['success'] ==  true) {
                return true;
            }

            return false;
        }
    }
}
