<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class LiveTvController extends Controller
{
    public function livetv(){
        $request = Request();
        $routenamed = Route::currentRouteName();
        if (empty($routenamed)) {
            $routenamed = "live-tv";
        }
        $livetvArr = CurlAPI("contents/livetv", 'GET', '' , 3, true);
        // dd($livetvArr);
        $pagetitle = "LIVETV";
        $pagetype = ($routenamed == 'home') ? 'HOME' : "LIVETV";
        if($livetvArr && @$livetvArr['success'] == true){
            $response = $livetvArr['content'];
            $displayLanguageParam = setLanguageParameter();
            // dd($displayLanguageParam);
            $meta = $this->getMeta($routenamed);
            $meta_title = $meta['title'];
            return view('pages.livetv.live-tv', compact('response','meta_title', 'displayLanguageParam'));
        }else{
            return view('pages.error.data-error');
        }
        // dd($response);
    }

    public function getMeta($routenamed)
    {
        // dd($routenamed);
        $meta = [];
        $meta['keywords'] = '';
        $meta['image'] = env('APP_URL') . '/epiconlogo.png';
        $meta['url'] = url()->current();
        $meta['title'] = env('APP_NAME');
        $meta['description'] = env('APP_NAME');
        $displang = app()->getLocale();
        if ($routenamed == 'favourites') {
            $meta['title'] = 'My Favourites | EPIC ON';
            $meta['description'] = '';
        } else if ($routenamed == 'watchlater') {
            $meta['title'] = 'Watch Later | EPIC ON';
            $meta['description'] = '';
        } else if ($routenamed == 'viewprofile' || $routenamed == 'editprofile' || $routenamed == 'profile') {
            $meta['title'] = ($routenamed == 'editprofile') ? 'My Account Update | EPIC On' : 'My Account | EPIC ON';
            $meta['description'] = '';
        } else if ($routenamed == 'chpwd') {
            $meta['title'] = 'Change Password | EPIC ON';
            $meta['description'] = '';
        } else if ($routenamed == 'subscriptions') {
            $meta['title'] = 'Subscription Plans | EPIC ON';
            $meta['description'] = 'Subscribe to EPIC ON an all-new avatar! Welcome to India’s first platform that offers multiform content, giving users an unparalleled experience.';
            $meta['keywords'] = 'EPIC ON, EPIC ON Subscription';
        } else if ($routenamed == 'checkout-subscriptions') {
            $meta['title'] = 'Checkout Subscription Plans | EPIC ON';
            $meta['description'] = '';
        } else if ($routenamed == 'generatepin') {
            $meta['title'] = 'Generate Pin | EPIC ON';
            $meta['description'] = '';
        } else if ($routenamed == 'QRPROMOTIONS') {
            $meta['title'] = 'EPIC ON | Watch TV Shows, Specials, Shorts & Video Books';
            $meta['description'] = 'EPIC ON is your companion for India-centric TV shows, short videos, documentaries, & specials across the genres of sports, food, history, mythology, travel, & more';
            $meta['keywords'] = 'tv shows, tv series, recipe shows, travel shows, historic places, mythology, festivals of India, best tv shows, best tv series, history of India';
        } else if ($routenamed == 'live-tv') {
            if ($displang == 'hi') {
                $meta['title'] = 'देखें लाइव टीवी कभी भी ईपीक ऑन पर';
                $meta['description'] = 'देखें ईपीक चैनल लाइव टीवी, फिलमची लाइव टीवी और शोबॉक्स लाइव टीवी कभी भी ईपीक ऑन पर';
                $meta['keywords'] = 'लाइव टीवी, लाइव टीवी शो, लाइव टीवी चैनल, पब्लिक टीवी लाइव, लाइव टीवी ऐप, ईपीक लाइव टीवी, ईपीक चैनल टीवी, शोबॉक्स लाइव टीवी, फिलमची लाइव टीवी';
            } else {
                $meta['title'] = 'Watch Live TV anytime on EPIC ON';
                $meta['description'] = 'Watch live tv channels of EPIC TV, Filamchi live tv and ShowBox live tv streaming on EPIC ON';
                $meta['keywords'] = 'live tv, live tv shows, live tv channel, public tv live, live tv app, EPIC ON live tv, epic channel tv, showbox live tv, filamchi live tv';
            }
        } else {
            $meta['title'] = 'EPIC ON';
            $meta['description'] = '';
        }
        return $meta;
    }

}
