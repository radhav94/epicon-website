<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class KidsController extends Controller
{
    private  $limit;
    public function  __construct()
    {
        $this->limit = 50;
    }

    public function index($slug = 'home')
    {
        $pageslug = strtolower($slug);
        // dd($pageslug);
        $pagetitle = 'EPIC ON Kids | Kids Shows, Cartoon, Podcast, Ebook, Games';
        if ($this->isKidsSectionEnabled()) {
            setcookie("KidsMode", true, time() + 60 * 60 * 24 * 30, '/');
            session()->put('kidsMode', true);
            session()->forget('nextmovieArray');
            $kid_profile = getDefaultProfile('kids');
            if ($kid_profile != "") {
                profileActive($kid_profile);
            }
            
            $params = [
                'slug' => 'kids-' . $slug,
                'list_language' => 'ALL',
                'display_language' => 'ENGLISH',
                'page' => 1,
                'limit' => $this->limit,
            ];

            if (isUserLoggedIn()) {
                $params['user_id'] = getUserId();
                $params['profile_id'] = getProfileId();
            }

            $result = CurlAPI("pages/homepage", "GET", $params, 1);

            if ($result && @$result['success'] ==  true) {
                $displayLanguageParam = setLanguageParameter();
                $pagetitle = @$result['data']['name'];

                $pagetype = ($pageslug == 'home' || $pageslug == 'home-v2') ? 'HOME' : "CATALOG";
                if ($displayLanguageParam == 'HINDI') {
                    $meta = $this->getHindiMeta($pagetype, $pagetitle, $pageslug);
                } else {
                    $meta = $this->getMeta($pagetype, $pagetitle, $pageslug);
                }

                return view('pages.homepage', compact('result','slug', 'displayLanguageParam', 'meta'));
            }
            return response()->view('pages.error.404', [], 404);
        } else {
            return redirect(getUrl('settings?status=ispin'));
        }
    }

    public function verifyKidsPin()
    {
        $request = Request();
        $kidsPin = $request->post('kidsPin') ? implode("", $request->post('kidsPin')) : '';

        $curlData = ["pin" => $kidsPin];
        $response = CurlAPI("users/verifyChildPin", "POST", $curlData, 2, true, true);
        if (!$response) {
            return JSONResponse(400, "Something went wrong. Please try again!");
        }
        if ($response && @$response['success']) {
            $profile_data = $request->session()->get('profile_data');
            $profile_data['result']['user_data']['kidSection'] = true;
            $request->session()->put('profile_data', $profile_data);
            setcookie("KidsMode", false, time() + 60 * 60 * 24 * 30, '/');
            session()->put('kidsMode', false);
            session()->forget('nextmovieArray');
            $default_profile = getDefaultProfile();
            if ($default_profile != "") {
                profileActive($default_profile);
            }
        }
        return JSONResponse(200, '', ['message' => @$response['message'], 'success' => @$response['success'], 'redirect' => getUrlWithPrefix('homepage')]);
    }

    private function isKidsSectionEnabled()
    {
        $user = session()->has('user') ? session()->get('user') : [];
        if (array_key_exists('kidSection', $user) && @$user['kidSection']) {
            return true;
        } else {
            return false;
        }
    }

    // Get Meta Data
    public function getMeta($pagetype, $pagetitle, $pageslug = '')
    {
        // dd($pagetype . '====' .$pageslug);
        //echo $pageslug;die;
        $meta = [];
        $meta['keywords'] = '';
        // $meta['image'] = env('APP_URL') . '/epiconlogo.png';
        $meta['url'] = url()->current();
        $meta['title'] = "EPIC ON Kids | Kids Shows, Cartoon, Podcast, Ebook, Games";
        $meta['description'] = "EPIC ON - India Ka Apna Infotainment | Watch TV Shows, Documentaries, Epic Shorts, Epic Specials Online at EPIC ON";
        $meta['keywords'] = 'kids shows, kids cartoon,  cartoons, cartoon movies, fairy tales for kids, fairy tales stories, animated movies,  tv shows for kids, entertainment for kids, cartoon channel, comic books, ebooks, ebooks for kids, podcast for kids, podcast, games for kids, puzzles for kids. EPIC ON Kids';

        if ($pageslug == 'home') {
            /******Changed as per SEO Person
            $meta['title'] = 'Welcome to EPIC On - India Ka Apna Infotainment';
            $meta['description'] = 'EPIC On - India Ka Apna Infotainment | Watch TV Shows, Documentaries, Epic Shorts, Epic Specials Online at EPIC On';*/
            $meta['title'] = 'EPIC ON Kids | Kids Shows, Cartoon, Podcast, Ebook, Games';
            $meta['description'] = 'Lets kids have their fun with EPIC ON Kids, a complete set of learning with entertainment. Explore popular kids shows, Cartoon, Podcast, Ebooks and Games.';
            
        } else if ($pageslug == 'movies') {
            $meta['title'] = 'Watch TV Shows, Episodes, Movies, Originals Online';
            $meta['description'] = 'Watch popular TV shows, blockbuster movies, originals, documentaries, & more, across the genres of comedy, romance, action, drama, food, travel & mythology.';
            $meta['keywords'] = 'originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries';
        }else if ($pageslug == 'shows') {
            $meta['title'] = 'Best Ott Platforms for kids Online in India | Watch Now';
            $meta['description'] = 'Keep your kids entertained and engaged with the best OTT platforms for kids in India! From educational shows to animated movies, there\'s something for everyone';
        }
        else if ($pageslug == 'podcast') {
            $meta['title'] = 'Listen to Popular Podcast Online Available on EPIC ON';
            $meta['description'] = 'Listen to Latest and Trending Podcast online for free with EPIC ON anytime, anywhere. Download or listen to unlimited podcast available online';
            $meta['keywords'] = 'free podcast, download podcast, free popular podcasts, free podcast downloads, free podcasts online';
        }
        else if ($pageslug == 'games') {
            $meta['title'] = 'Play Multiple Online Games Now Available on EPIC ON';
            $meta['description'] = 'Play unlimited free online games now, including tambola, ludo, shooting games, arcade free games, racing car games available on EPIC ON';
            $meta['keywords'] = 'games, games free download, subway surfers, onilne games, car games, coin master free spins, games to play, play online games, gamezop, snake game, bubble shooter, onilne chess, bubble shooter, free games, new games';
        }
         
        return $meta;
    }
    // #Get Meta Data

    // Get Hindi Meta Data
    public function getHindiMeta($pagetype, $pagetitle, $pageslug = '')
    {

        $meta = [];
        $meta['keywords'] = '';
        // $meta['image'] = env('APP_URL') . '/epiconlogo.png';
        $meta['url'] = url()->current();
        $meta['title'] = "EPIC ON - India Ka Apna Infotainment में आपका स्वागत है";

        $meta['description'] = "EPIC ON - India Ka Apna Infotainment | ईपीआईसी ऑन पर टीवी शो, वृत्तचित्र, महाकाव्य शॉर्ट्स, महाकाव्य विशेष ऑनलाइन देखें";
        $meta['keywords'] = 'नई फिल्में, फिल्में, मूवीज, फिल्म, ऑनलाइन वीडियो, टीवी श्रृंखला, टीवी शो, सर्वश्रेष्ठ नेटफ्लिक्स श्रृंखला, वेब श्रृंखला, शो, सर्वश्रेष्ठ वेब श्रृंखला, वृत्तचित्र';

        if ($pageslug == 'home') {
            /******Changed as per SEO Person*/
            $meta['title'] = 'ईपीक ऑन | टीवी शो, सिनेमा, पॉडकास्ट, ईबुक, गेम्स, रिवार्ड्स';
            $meta['description'] = 'मूवी, टीवी शो, ई-बुक्स, पॉडकास्ट, गेम्स, रिवार्ड्स और अधिक एक से एक मनोरंजन ईपीक ऑन पर';
        } 
        else if ($pageslug == 'movies') {
            $meta['title'] = 'देखो टीवी शो, एपिसोड, सिनेमा ऑनलाइन | ईपीक ऑन';
            $meta['description'] = 'कॉमेडी, रोमांस, एक्शन, ड्रामा, भोजन, यात्रा और पौराणिक कथाओं की शैलियों के बीच लोकप्रिय टीवी शो, ब्लॉकबस्टर फिल्में, मूल, वृत्तचित्र, और बहुत कुछ देखें';
            $meta['keywords'] = 'नई फिल्में, फिल्में, मूवीज, फिल्म, ऑनलाइन वीडियो, टीवी श्रृंखला, टीवी शो, सर्वश्रेष्ठ नेटफ्लिक्स श्रृंखला, वेब श्रृंखला, शो, सर्वश्रेष्ठ वेब श्रृंखला, वृत्तचित्र';
        }else if ($pageslug == 'shows') {
            $meta['title'] = 'देखो टीवी शो, एपिसोड, सिनेमा ऑनलाइन';
            $meta['description'] = 'कॉमेडी, रोमांस, एक्शन, ड्रामा, भोजन, यात्रा और पौराणिक कथाओं की शैलियों के बीच लोकप्रिय टीवी शो, ब्लॉकबस्टर फिल्में, मूल, वृत्तचित्र, और बहुत कुछ देखें';
            $meta['keywords'] = 'नई फिल्में, फिल्में, मूवीज, फिल्म, ऑनलाइन वीडियो, टीवी श्रृंखला, टीवी शो, सर्वश्रेष्ठ नेटफ्लिक्स श्रृंखला, वेब श्रृंखला, शो, सर्वश्रेष्ठ वेब श्रृंखला, वृत्तचित्र';
        }
        else if ($pageslug == 'podcast') {
            $meta['title'] = 'सुनें लोकप्रिय पॉडकास्ट ऑनलाइन जो है ईपीक ऑन पर उपलब्ध';
            $meta['description'] = 'कहीं भी, कभी भी ईपीक ऑन के साथ ऑनलाइन नवीनतम और ट्रेंडिंग पॉडकास्ट सुनें। डाउनलोड करें या असीमित उपलब्ध पॉडकास्ट ऑनलाइन सुनें';
            $meta['keywords'] = 'मुफ्त पॉडकास्ट, पॉडकास्ट डाउनलोड करें, मुफ्त पॉडकास्ट, मुफ्त पॉडकास्ट डाउनलोड, मुफ्त पॉडकास्ट ऑनलाइन';
        }
        else if ($pageslug == 'games') {
            $meta['title'] = 'अब खेलें कई ऑनलाइन गेम्स उपलब्ध है ईपीक ऑन पर';
            $meta['description'] = 'अब तम्बोला, लूडो, शूटिंग गेम्स, आर्केड फ्री गेम, रेसिंग कार गेम्स सहित असीमित मुफ्त ऑनलाइन गेम खेलें, जो ईपीक ऑन पर उपलब्ध हैं';
            $meta['keywords'] = 'खेल, खेल मुफ्त डाउनलोड, मेट्रो सर्फर्स,ऑनलाइन खेल, कार खेल, सिक्का मुक्त, खेल खेलने के लिए, ऑनलाइन खेल, साँप खेल, बुलबुला शूटर, ऑनलाइन शतरंज, बुलबुला शूटर, मुफ्त खेल, नए खेल खेलने के लिए';
        }
 
        return $meta;
    }
    // #Get Hindi Meta Data
}
