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
        
        $pagetitle = 'EPIC ON Kids | Kids Shows, Cartoon, Podcast, Ebook, Games';
        if ($this->isKidsSectionEnabled()) {
            setcookie("KidsMode", true, time() + 60 * 60 * 24 * 30, '/');
            session()->put('kidsMode', true);
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

            if (request()->v == 2) {
                foreach ($result['data']['list'] as $key => $value) {
                    d($value);
                }
                dd($result);
            }

            if ($result && @$result['success'] ==  true) {
                $displayLanguageParam = setLanguageParameter();
                $pagetitle = @$result['data']['name'];

                $pagetype = ($pageslug == 'home' || $pageslug == 'home-v2') ? 'HOME' : "CATALOG";
                if ($displayLanguageParam == 'HINDI') {
                    $meta = $this->getHindiMeta($pagetype, $pagetitle, $pageslug);
                } else {
                    $meta = $this->getMeta($pagetype, $pagetitle, $pageslug);
                }

                return view('pages.homepage', compact('result', 'slug', 'displayLanguageParam', 'meta'));
            }
            return view('pages.error.404');
        } else {
            return redirect(getUrl('settings?status=ispin'));
        }
    }

    public function verifyKidsPin()
    {
        $request = Request();
        $kidsPin = $request->post('kidsPin') ? implode("", $request->post('kidsPin')) : '';

        $curlData = ["pin" => $kidsPin];
        $response = CurlAPI("users/verifyChildPin", "POST", $curlData, 2, true);
        if (!$response) {
            return JSONResponse(400, "Something went wrong. Please try again!");
        }
        if ($response && @$response['success']) {
            $profile_data = $request->session()->get('profile_data');
            $profile_data['result']['user_data']['kidSection'] = true;
            $request->session()->put('profile_data', $profile_data);
            setcookie("KidsMode", false, time() + 60 * 60 * 24 * 30, '/');
            session()->put('kidsMode', false);
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
        if ($pagetype == 'HOME') {
            /******Changed as per SEO Person
            $meta['title'] = 'Welcome to EPIC On - India Ka Apna Infotainment';
            $meta['description'] = 'EPIC On - India Ka Apna Infotainment | Watch TV Shows, Documentaries, Epic Shorts, Epic Specials Online at EPIC On';*/
            $meta['title'] = 'EPIC ON Kids | Kids Shows, Cartoon, Podcast, Ebook, Games';
            $meta['description'] = 'Lets kids have their fun with EPIC ON Kids, a complete set of learning with entertainment. Explore popular kids shows, Cartoon, Podcast, Ebooks and Games.';
            $meta['keywords'] = 'kids shows, kids cartoon,  cartoons, cartoon movies, fairy tales for kids, fairy tales stories, animated movies,  tv shows for kids, entertainment for kids, cartoon channel, comic books, ebooks, ebooks for kids, podcast for kids, podcast, games for kids, puzzles for kids. EPIC ON Kids';
        } else if ($pagetype == 'CATALOG') {
            //$meta['title'] = 'Watch EPIC On '.$pagetitle.', Episodes, Promos Online | EPIC On';
            if ($pageslug == 'watch' || $pageslug == 'tv-shows' || $pageslug == 'epic-shorts' || $pageslug == 'documentaries' || $pageslug == 'video-books' || $pageslug == 'movies' || $pageslug == 'amar-chitra-katha') {
                $meta['title'] = 'Watch TV Shows, Episodes, Movies, Originals Online | EPIC ON';
                $meta['description'] = 'Watch popular TV shows, blockbuster movies, originals, documentaries, & more, across the genres of comedy, romance, action, drama, food, travel & mythology.';
                $meta['keywords'] = 'originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries';
            } else if ($pageslug == 'listen' || $pageslug == 'podcast') {
                $meta['title'] = 'Listen to Popular Podcast Online Available on EPIC ON';
                $meta['description'] = 'Listen to Latest and Trending Podcast online for free with EPIC ON anytime, anywhere. Download or listen to unlimited podcast available online';
                $meta['keywords'] = 'free podcast, download podcast, free popular podcasts, free podcast downloads, free podcasts online';
            } else if ($pageslug == 'play' || $pageslug == 'games') {
                $meta['title'] = 'Play Multiple Online Games Now Available on EPIC ON';
                $meta['description'] = 'Play unlimited free online games now, including tambola, ludo, shooting games, arcade free games, racing car games available on EPIC ON';
                $meta['keywords'] = 'games, games free download, subway surfers, onilne games, car games, coin master free spins, games to play, play online games, gamezop, snake game, bubble shooter, onilne chess, bubble shooter, free games, new games';
            } else if ($pageslug == 'read' || $pageslug == 'ebooks') {
                $meta['title'] = 'Read Most Popular Ebooks for Kids Now Available on EPIC ON Kids';
                $meta['description'] = 'Read comic books like panchatantra stories, fairy tales stories, bedtime stories, animal stories and more favourite ebooks for kids available at EPIC ON kids';
                $meta['keywords'] = 'Read, Reading, comic books, ebooks, ebooks for kids, story books for kids, pancha tantra stories, online books for kids, fairy tales stories, reading books for kids, panchatantra stories for kids,  children story books, story books online, storytelling for kids, kids stories, kids story in hindi, short stories for kids, bedtime stories, bedtime stories for kids, children stories, animal stories for kids';
            } else if ($pageslug == 'offers') {
                $meta['title'] = 'Earn Rewards of Epicoins and Redeem on Offers | EPIC ON';
                $meta['description'] = 'Get rewarded for binge-watching, playing games, reading books, and more. Redeem your EPIC coins on available offers at reward store';
                $meta['keywords'] = 'flipkart offers, dominos coupons, myntra coupons, offers, dominos coupon codes, dominos offer, coupons, myntra coupon code, myntra offers, discounts, crossword, deals, vouchers';
            } else if ($pageslug == "kids-watch") {
                $meta['title'] = 'Watch Kids Shows, Cartoon Movies, Fairy Tales for Kids on EPIC ON Kids';
                $meta['description'] = 'Watch popular Kids shows, cartoon movies, fairy tales storeis, suppandi and friends, anu club which has entertainment for kids and more only on EPIC ON Kids';
                $meta['keywords'] = 'kids shows, kids cartoon,  cartoons, cartoon movies, fairy tales for kids, fairy tales stories,  animated movies,  tv shows for kids, entertainment for kids, leo & tig, the dabangg girls, my bhoot friends, marcus khiladi, billa jasoos, suppandi and friends, anu club,  cinderella cartoon, tom and jerry, motu patlu, chhota bheem, doremon, new cartoon movies, cartoon cat, cartoon channel';
            } else if ($pageslug == "kids-listen") {
                $meta['title'] = 'Listen to Popular Podcast and Storytelling for Kids on EPIC ON Kids';
                $meta['description'] = 'Listen to podcast for kids which has storytelling, audio stories for kids, short stories for kids, bedtime stories and more available on EPIC ON Kids';
                $meta['keywords'] = 'kids shows, podcast for kids, podcast, audio stories for kids, audible stories, storytelling for kids, kids stories, kids story in hindi, short stories for kids, bedtime stories, bedtime stories for kids, children stories';
            } else if ($pageslug == "kids-play") {
                $meta['title'] = "Play Children Games Now Available on EPIC ON Kids";
                $meta['description'] = 'Play online childern games which including  sudoku for kids, puzzle games for kids, mind games for kids  available on EPIC ON kids';
                $meta['keywords'] = 'games for kids, online games for kids, puzzles for kids, children games, video game for kids, fun games for kids, sudoku for kids, puzzle games for kids, best games for kids, mind games for kids';
            } else if ($pageslug == "kids-read") {
                $meta['title'] = 'Read Most Popular Ebooks for Kids Now Available on EPIC ON Kids';
                $meta['description'] = 'Read comic books like panchatantra stories, fairy tales stories, bedtime stories, animal stories and more favourite ebooks for kids available at EPIC ON kids';
                $meta['keywords'] = 'Read, Reading, comic books, ebooks, ebooks for kids, story books for kids, pancha tantra stories, online books for kids, fairy tales stories, reading books for kids, panchatantra stories for kids,  children story books, story books online, storytelling for kids, kids stories, kids story in hindi, short stories for kids, bedtime stories, bedtime stories for kids, children stories, animal stories for kids';
            }
        } else if ($pagetype == 'LIVETV') {
            if ($pageslug == 'epic-on-live-tv') {
                $meta['title'] = 'Watch EPIC Live TV Streaming on EPIC ON';
                $meta['description'] = 'Watch EPIC Channel Live TV - India Ka Apna Infotainment, Watch TV Shows, Documentaries, EPIC Shorts, EPIC Specials, EPIC Originals, Online at EPIC On';
                $meta['keywords'] = 'live tv, live tv shows, live tv channel, public tv live, live tv app, epic on live tv, epic channel tv,  tv series, recipe shows, travel shows, historic places, mythology, festivals of India, best tv shows, best tv series, history of India';
            } else if ($pageslug == 'showbox-live-tv') {
                $meta['title'] = 'Watch Showbox Live TV Streaming Online on EPIC ON';
                $meta['description'] = 'Watch Showbox live music online, bollywood songs, punjabi songs and  popular songs live on Showbox Live TV';
                $meta['keywords'] = 'live tv, music online, live tv channel, public tv live, live tv app, punjabi songs, hindi songs, hindi gana, new punjabi song, video hindi gana, hindi gane, new hindi song, punjabi gane, punjabi song video, bollywood songs';
            } else if ($pageslug == 'filamchi-live-tv') {
                $meta['title'] = 'Watch Filamchi Live TV Streaming on EPIC ON';
                $meta['description'] = 'Watch your favourite bhojpuri movies live on filamchi live tv streaming on EPIC On';
                $meta['keywords'] = 'live tv, movies online, live tv channel, public tv live, live tv app, filamchi tv, filamchi live tv, free live tv, bhojpuri movies, bhojpuri video, bhojpuri film, bhojpuri cinema, bhojpuri film video';
            }
        } else if ($pagetype == 'HISTORY') {
            //$meta['title'] = 'Watch popular '.$pagetitle.' Shows, Episodes, Promos Online | EPIC On';
            $meta['title'] = 'Watch EPICON for your favourite Tv Shows, Episodes - Podcast - Ebook - Games - Rewards';
            $meta['description'] = 'Watch ' . $pagetitle . ' Shows online. Latest ' . $pagetitle . ' Shows Episodes, Promos online at EPIC ON.';
        }
        return $meta;
    }
    // #Get Meta Data

    // Get Hindi Meta Data
    public function getHindiMeta($pagetype, $pagetitle, $pageslug = '')
    {
        // dd($pagetype . '====' .$pageslug);
        //echo $pageslug;die;
        $meta = [];
        $meta['keywords'] = '';
        // $meta['image'] = env('APP_URL') . '/epiconlogo.png';
        $meta['url'] = url()->current();
        $meta['title'] = "EPIC ON - India Ka Apna Infotainment में आपका स्वागत है";
        //echo $pageslug; exit();
        $meta['description'] = "EPIC ON - India Ka Apna Infotainment | ईपीआईसी ऑन पर टीवी शो, वृत्तचित्र, महाकाव्य शॉर्ट्स, महाकाव्य विशेष ऑनलाइन देखें";
        if ($pagetype == 'HOME') {
            /******Changed as per SEO Person*/
            $meta['title'] = 'ईपीक ऑन | टीवी शो, सिनेमा, पॉडकास्ट, ईबुक, गेम्स, रिवार्ड्स';
            $meta['description'] = 'मूवी, टीवी शो, ई-बुक्स, पॉडकास्ट, गेम्स, रिवार्ड्स और अधिक एक से एक मनोरंजन ईपीक ऑन पर';
            $meta['keywords'] = 'फिल्में, फिल्म, ऑनलाइन वीडियो, टीवी श्रृंखला, खेल, ईबुक, पॉडकास्ट, टीवी शो, रेसिपी शो, यात्रा शो, ऐतिहासिक स्थान, पौराणिक कथाएं, भारत के त्योहार, सर्वश्रेष्ठ टीवी शो, सर्वश्रेष्ठ टीवी श्रृंखला, भारत का इतिहास';
        } else if ($pagetype == 'CATALOG') {
            if ($pageslug == 'watch' || $pageslug == 'tv-shows' || $pageslug == 'epic-shorts' || $pageslug == 'documentaries' || $pageslug == 'video-books' || $pageslug == 'movies' || $pageslug == 'amar-chitra-katha') {
                $meta['title'] = 'देखो टीवी शो, एपिसोड, सिनेमा ऑनलाइन | ईपीक ऑन';
                $meta['description'] = 'कॉमेडी, रोमांस, एक्शन, ड्रामा, भोजन, यात्रा और पौराणिक कथाओं की शैलियों के बीच लोकप्रिय टीवी शो, ब्लॉकबस्टर फिल्में, मूल, वृत्तचित्र, और बहुत कुछ देखें';
                $meta['keywords'] = 'नई फिल्में, फिल्में, मूवीज, फिल्म, ऑनलाइन वीडियो, टीवी श्रृंखला, टीवी शो, सर्वश्रेष्ठ नेटफ्लिक्स श्रृंखला, वेब श्रृंखला, शो, सर्वश्रेष्ठ वेब श्रृंखला, वृत्तचित्र';
            } else if ($pageslug == 'listen' || $pageslug == 'podcast') {
                $meta['title'] = 'सुनें लोकप्रिय पॉडकास्ट ऑनलाइन जो है ईपीक ऑन पर उपलब्ध';
                $meta['description'] = 'कहीं भी, कभी भी ईपीक ऑन के साथ ऑनलाइन नवीनतम और ट्रेंडिंग पॉडकास्ट सुनें। डाउनलोड करें या असीमित उपलब्ध पॉडकास्ट ऑनलाइन सुनें';
                $meta['keywords'] = 'मुफ्त पॉडकास्ट, पॉडकास्ट डाउनलोड करें, मुफ्त पॉडकास्ट, मुफ्त पॉडकास्ट डाउनलोड, मुफ्त पॉडकास्ट ऑनलाइन';
            } else if ($pageslug == 'play') {
                $meta['title'] = 'अब खेलें कई ऑनलाइन गेम्स उपलब्ध है ईपीक ऑन पर';
                $meta['description'] = 'अब तम्बोला, लूडो, शूटिंग गेम्स, आर्केड फ्री गेम, रेसिंग कार गेम्स सहित असीमित मुफ्त ऑनलाइन गेम खेलें, जो ईपीक ऑन पर उपलब्ध हैं';
                $meta['keywords'] = 'खेल, खेल मुफ्त डाउनलोड, मेट्रो सर्फर्स,ऑनलाइन खेल, कार खेल, सिक्का मुक्त, खेल खेलने के लिए, ऑनलाइन खेल, साँप खेल, बुलबुला शूटर, ऑनलाइन शतरंज, बुलबुला शूटर, मुफ्त खेल, नए खेल खेलने के लिए';
            } else if ($pageslug == 'read' || $pageslug == 'ebooks') {
                $meta['title'] = 'अब पढ़ें सबसे लोकप्रिय ईबुक उपलब्ध है ईपीक ऑन पर';
                $meta['description'] = 'लोकप्रिय प्रकाशनों से असीमित ईबुक को पढ़ना कभी समाप्त नहीं होगा क्योंकि ईपीक ऑन पर उपलब्ध हैं अपनी पसंदीदा ईबुक मुफ्त, पढ़ें ऑनलाइन';
                $meta['keywords'] = 'किंडल ईबुक, ई-बुक पढ़ना, ई-बुक्स, ई-पुस्तक पुस्तकालय, ई-बुक्स ऑनलाइन पढ़ना, ऑनलाइन बुक्स, फ्री ई-बुक्स, मुफ्त ई-बुक डाउनलोड, ई-बुक्स ऑनलाइन फ्री, फ्री ऑनलाइन बुक्स पढ़ना';
            } else if ($pageslug == 'offers') {
                $meta['title'] = 'ईपीक कोईन में रिवार्ड कमाएँ और ऑफ़र पर रिडीम करें';
                $meta['description'] = 'देखना, खेल खेलना, किताबें पढ़ना, और बहुत कुछ से ईपीक कोईन प्राप्त करें और रिवॉर्ड स्टोर पर उपलब्ध ऑफर्स पर रिडीम करें';
                $meta['keywords'] = 'फ्लिपकार्ट ऑफर, डोमिनोज़ कूपन, कूपन, ऑफ़र, डोमिनोज़ कूपन कोड, डोमिनोज़ ऑफ़र, कूपन कोड, ऑफ़र, छूट, क्रॉसवर्ड, डील्स, वाउचर';
            }
        } else if ($pagetype == 'LIVETV') {
            if ($pageslug == 'epic-on-live-tv') {
                $meta['title'] = 'देखें ईपीक लाइव टीवी ईपीक ऑन पर';
                $meta['description'] = 'देखें ईपीक चैनल लाइव टीवी - इंडिया का अपना इन्फोटेनमेंट, टीवी शो, वृत्तचित्र, ईपीक शॉर्ट्स, ईपीक स्पेशल, ऑनलाइन ईपीक ऑन पर';
                $meta['keywords'] = 'लाइव टीवी, लाइव टीवी शो, लाइव टीवी चैनल, सार्वजनिक टीवी लाइव, लाइव टीवी ऐप, लाइव टीवी पर महाकाव्य, टीवी चैनल, टीवी श्रृंखला, नुस्खा शो, यात्रा शो, ऐतिहासिक स्थान, पौराणिक कथाएँ, भारत के त्योहार, सर्वश्रेष्ठ टीवी शो, सर्वश्रेष्ठ टीवी श्रृंखला, भारत का इतिहास';
            } else if ($pageslug == 'showbox-live-tv') {
                $meta['title'] = 'देखें शोबॉक्स लाइव टीवी ईपीक ऑन पर';
                $meta['description'] = 'ऑनलाइन शोबॉक्स लाइव संगीत देखें, बॉलीवुड गाने, पंजाबी गाने और लोकप्रिय गाने शोबॉक्स लाइव टीवी पर';
                $meta['keywords'] = 'लाइव टीवी, संगीत ऑनलाइन, लाइव टीवी चैनल, सार्वजनिक टीवी लाइव, लाइव टीवी ऐप, पंजाबी गाने, हिंदी गाने, नए पंजाबी गीत, वीडियो हिंदी गाने, नए हिंदी गीत, पंजाबी गीत, पंजाबी गीत वीडियो, बॉलीवुड गीत';
            } else if ($pageslug == 'filamchi-live-tv') {
                $meta['title'] = 'देखें फिलमची लाइव टीवी ईपीक ऑन पर';
                $meta['description'] = 'अपनी पसंदीदा भोजपुरी फिल्में फिलमची लाइव टीवी पर देखें';
                $meta['keywords'] = 'लाइव टीवी, फिल्में ऑनलाइन, लाइव टीवी चैनल, पब्लिक टीवी लाइव, लाइव टीवी एप, फिल्ममची टीवी, फिल्ममची लाइव टीवी, फ्री लाइव टीवी, भोजपुरी फिल्में, भोजपुरी वीडियो, भोजपुरी फिल्म, भोजपुरी सिनेमा, भोजपुरी फिल्म वीडियो';
            }
        } else if ($pagetype == 'HISTORY') {
            //$meta['title'] = 'Watch popular '.$pagetitle.' Shows, Episodes, Promos Online | EPIC On';
            $meta['title'] = 'Watch EPICON for your favourite Tv Shows, Episodes - Podcast - Ebook - Games - Rewards';
            $meta['description'] = 'Watch ' . $pagetitle . ' Shows online. Latest ' . $pagetitle . ' Shows Episodes, Promos online at EPIC ON.';
        }
        return $meta;
    }
    // #Get Hindi Meta Data
}
