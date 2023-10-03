<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class SupermixController extends Controller
{


    public function superMix(Request $request)
    {
        $params = [];
        if (isUserLoggedIn()) {
            $params = [
                'user_id' => session()->get('user_id'),
            ];
        }

        $result = CurlAPI("pages/superMix", "POST", $params, 1);

        if ($result && @$result['success'] ==  true) {

            $content = $result['data'];
            $displayLanguageParam = setLanguageParameter();
            // return view('components.supermix-content', compact('content', 'displayLanguageParam'));

            $view = view('components.supermix-content', compact('content', 'displayLanguageParam'))->render();

            return JSONResponse(
                200,
                'Success.',
                [
                    'html' => $view,
                ]
            );
        } else {
            return JSONResponse(400, 'Some error occured');
        }
    }
}
