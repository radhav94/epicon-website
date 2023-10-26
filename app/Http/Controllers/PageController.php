<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    private  $limit;
    public function  __construct()
    {
        $this->limit = 10;
    }

    public function index($slug = 'home-v2')
    {
        $pageslug = strtolower($slug);

        $routenamed = $pageslug;

        if (empty($routenamed)) {
            $routenamed = $pageslug;
        }
        profileActive();
        $data = $this->homepageData($slug);
        $result = $data['result'];

        if (request()->v == 2) {
            foreach ($result['data']['list'] as $key => $value) {
                d($value);
            }
            dd($result);
        }
        // dd($result);
        $pagetitle = @$result['data']['name'];
        $pagetype = ($routenamed == 'homepage' || $routenamed == 'home' || $routenamed == 'home-v2') ? 'HOME' : "CATALOG";
        if ($result && @$result['success'] ==  true) {
            $displayLanguageParam = $data['displayLanguageParam'];
            $stories = $data['stories'];
            if ($displayLanguageParam == 'HINDI') {
                $meta = $this->getHindiMeta($pagetype, $pagetitle, $routenamed);
            } else {
                $meta = $this->getMeta($pagetype, $pagetitle, $routenamed);
            }
            $meta_title = $meta['title'];
            // dd($meta);
            // $meta_title = strtoupper($slug);
            return view('pages.homepage', compact('result', 'displayLanguageParam', 'stories', 'meta_title'));
                    }
        return view('pages.error.404');
    }

    public function loadMore(Request $request)
    {
        $slug = ($request->route == '/' || $request->route == 'hi') ? 'home-v2' : $request->route;
        $data = $this->homepageData($slug, $request->page);
        $result = $data['result'];
        if ($result && @$result['success'] ==  true) {
            $displayLanguageParam = $data['displayLanguageParam'];
            $stories = $data['stories'];

            $view = view('display.display-default', compact('result', 'displayLanguageParam', 'stories'))->render();

            return JSONResponse(
                200,
                'Success.',
                [
                    'html' => $view,
                ]
            );
        }
    }

    public function explore()
    {
        $result = CurlAPI("pages/explorepage", "GET", [], 1);
        $pagetitle = @$result['data']['name'];

        $slug = 'explore';

        if ($result && @$result['success'] ==  true) {
            $data = $this->homepageData($slug);
            $displayLanguageParam = $data['displayLanguageParam'];
            if ($displayLanguageParam == 'HINDI') {
                $routenamed = 'explore';
                $pagetype = ($routenamed == 'homepage' || $routenamed == 'home' || $routenamed == 'home-v2') ? 'HOME' : "CATALOG";
                $meta = $this->getHindiMeta($pagetype, $pagetitle, $routenamed);
            } else {
                $routenamed = 'explore';
                $pagetype = ($routenamed == 'homepage' || $routenamed == 'home' || $routenamed == 'home-v2') ? 'HOME' : "CATALOG";
                $meta = $this->getMeta($pagetype, $pagetitle, $routenamed);
            }
            $meta_title = $meta['title'];
            // dd($meta_title);
            return view('pages.explore', compact('result','meta_title'));
        }

        return view('pages.error.data-error');
    }

    public function explore_details($slug)
    {
        $page = 1;
        $limit = 18;
        $params = [
            'limit' => $limit,
            'page' => $page,
        ];
        $data = $this->homepageData($slug);
        $displayLanguageParam = $data['displayLanguageParam'];
        $result = CurlAPI("pages/midpage/" . $slug, "GET", $params, 1);

        if ($result && @$result['success'] ==  true) {
            $result = $result['data'];
            if ($displayLanguageParam == 'HINDI') {
                $meta_title = 'विवरण खोजें';
            }else{
                $meta_title = 'Explore Details';
            }
            return view('pages.explore_details', compact('result', 'slug', 'page','meta_title', 'limit'));
        } else {
            return view('pages.error.data-error');
        }
    }

    public function getSpinnerContent(Request $request)
    {
        $result = CurlAPI("pages/spinnerContent", "POST", ['genre' => $request->genre]);
        // die($result['success']);
        // dd($result);

        if ($result && @$result['success'] ==  true) {
            return JSONResponse(
                200,
                'Success.',
                [
                    'image' => @$result['data']['vertical_cover_image']['large'],
                    'url' => url(@$result['data']['url'])
                ]
            );
        } else {
            return JSONResponse(400, 'Error.');
        }
    }

    public function wishlist(Request $request)
    {
        // dd($request->all());
        $params = [
            'content_id' => $request->content_id,
            'action' => $request->action,
            'profile_id' => session()->get('active_profile') ?? ''
        ];
        $result = CurlAPI("pages/wishlist", "POST", $params, 1, true);

        if ($result && @$result['success'] ==  true) {
            Cache::forget('getWishlist');
            // session()->forget('user_wishlist');
            $html = '';

            if ($request->type == '1') {
                $wishAction = ($request->action == 'add') ? 'delete' : 'add';

                if ($wishAction == 'add') {
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none"><path d="M21.0026 15.1678H15.1693V21.0011C15.1693 21.6428 14.6443 22.1678 14.0026 22.1678C13.3609 22.1678 12.8359 21.6428 12.8359 21.0011V15.1678H7.0026C6.36094 15.1678 5.83594 14.6428 5.83594 14.0011C5.83594 13.3595 6.36094 12.8345 7.0026 12.8345H12.8359V7.00114C12.8359 6.35947 13.3609 5.83447 14.0026 5.83447C14.6443 5.83447 15.1693 6.35947 15.1693 7.00114V12.8345H21.0026C21.6443 12.8345 22.1693 13.3595 22.1693 14.0011C22.1693 14.6428 21.6443 15.1678 21.0026 15.1678Z" fill="white" /></svg>';
                } else {
                    $icon = '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.1422 11.1919H11.1898C11.1898 11.1919 10.6541 11.1919 9.99934 11.1919C9.34458 11.1919 8.80887 11.1919 8.80887 11.1919H2.85649C2.20173 11.1919 1.66602 10.6562 1.66602 10.0014C1.66602 9.34665 2.20173 8.81094 2.85649 8.81094H8.80887C8.80887 8.81094 9.34458 8.81096 9.99934 8.81096C10.6541 8.81096 11.1898 8.81094 11.1898 8.81094H17.1422C17.797 8.81094 18.3327 9.34665 18.3327 10.0014C18.3327 10.6562 17.797 11.1919 17.1422 11.1919Z" fill="white"/></svg>';
                }


                $html = '<button class="big-add-list addToList" data-id="' . $request->content_id . '" data-action="' . $wishAction . '" data-type="1">  ' . $icon . '</button>';
            }

            return JSONResponse(200, ($request->action == 'add') ? 'Added to wishlist' : 'Removed from wishlist', ['icon' => $html]);
        } else {
            return JSONResponse(400, 'Something went wrong. Please try again!');
        }
    }

    public function showmidpagedetail($pageslug, $catalog)
    {
        $page = 1;
        $slug = $pageslug;
        $epicwebArr = CurlAPI("pages/midpageData", "POST", ['catalogId' => $catalog, 'limit' => 48, 'page' => 1], 1);
        if (isset($epicwebArr) && $epicwebArr['success'] == true) {
            $epicwebArr = $epicwebArr['data'];
            return view('pages.midpage', compact('epicwebArr', 'pageslug', 'catalog', 'page'));
        } else {
            return view('pages.error.data-error');
        }
    }

    public function channelsmidpagedetail($slug)
    {
        // dd($slug);
        $page = 1;
        $epicwebArr = CurlAPI("pages/midpageData", "POST", ['slug' => $slug, 'page' => 1,'limit' => 48], 1);
        
        if (isset($epicwebArr) && $epicwebArr['success'] == true) {
            $epicwebArr = $epicwebArr['data'];
            return view('pages.chanel.channelmidpage', compact('epicwebArr', 'slug', 'page'));
        } else {
            return view('pages.error.data-error');
        }
    }

    public function paginatecontent()
    {
        $request = Request();
        $page = $request->page;
        $limit = 48;
        $catalog = $request->catalogid;
        $epicwebArr = CurlAPI("pages/midpageData", "POST", ['catalogId' => $catalog, 'limit' => 48, 'page' => $page], 1);
        $catalogue_blade = "paginatecontent";
        if ($epicwebArr && @$epicwebArr['success'] == true) {
            $epicwebArr = $epicwebArr['data'];
            $dataCount = count($epicwebArr);
            $paginateHTML = (string) view('pages.' . $catalogue_blade, compact('epicwebArr', 'page', 'catalog'));
        } else {
            $paginateHTML = "false";
        }
        return json_encode(['paginateHTML' => $paginateHTML, 'dataCount' => $dataCount, 'limit' => $limit]);
    }

    public function channelpaginatecontent()
    {
        $request = Request();
        $page = $request->page;
        $limit = 48;
        $slug = $request->slug;
        $epicwebArr = CurlAPI("pages/midpageData", "POST", ['slug' => $slug, 'limit' => 48, 'page' => $page], 1);
        $catalogue_blade = "chanel.channelpaginatecontent";
        if ($epicwebArr && @$epicwebArr['success'] == true) {
            $epicwebArr = $epicwebArr['data'];
            $dataCount = count($epicwebArr);
            $paginateHTML = (string) view('pages.' . $catalogue_blade, compact('epicwebArr', 'page', 'slug'));
        } else {
            $paginateHTML = "false";
        }
        return json_encode(['paginateHTML' => $paginateHTML, 'dataCount' => $dataCount, 'limit' => $limit]);
    }

    public function explorecontent()
    {
        $request = Request();
        // dd($request->all());
        $page = $request->page;
        $slug = $request->slug;
        $limit = 18;
        $params = [
            'page' => $page,
            'limit' => 18,
        ];
        $dataCount = 0;
        $result = CurlAPI("pages/midpage/" . $slug, "GET", $params, 1);
        $explore_blade = "explorecontent";
        if ($result && @$result['success'] == true) {
            $result = $result['data'];
            $dataCount = count($result);
            $paginateHTML = (string) view('pages.' . $explore_blade, compact('result', 'page'));
        } else {
            $paginateHTML = "false";
        }
        return json_encode(['paginateHTML' => $paginateHTML, 'dataCount' => $dataCount, 'limit' => $limit]);
    }

    public function ajaxStoryData(Request $request)
    {
        $story_id = $request->id;
        $story_list = $this->epicShots($story_id);

        $view = view('components.epic-story-popup', compact('story_list'))->render();
        // d($view);
        return JSONResponse(
            200,
            'Success.',
            [
                'html' => $view,
            ]
        );
        dd($story_list);
    }

    private function homepageData($slug = 'home-v2', $page = 1)
    {
        $stories = [];
        $listlang = Session::has('listLanguage') ? Session::get('listLanguage') : 'all';
        $displang = Session::has('displayLanguage') ? Session::get('displayLanguage') : 'en';
        $params = [
            'slug' => $slug,
            'list_language' => checkLang($listlang),
            'display_language' => checkLang($displang),
            'page' => $page,
            'limit' => $this->limit,
        ];
        $result = CurlAPI("pages/homepage", "GET", $params, 1);

        if ($result && @$result['success'] ==  true) {
            $data = $result['data'] ?? [];
            $lists = $data['list'] ?? [];
            foreach ($lists as $list) {
                if (@$list['slug'] == "uniquely-yours") {
                    $stories = $this->epicShots();
                    break;
                }
                continue;
            }
        }
        $displayLanguageParam = setLanguageParameter();
        return [
            'result' => $result,
            'displayLanguageParam' => $displayLanguageParam,
            'stories' => $stories
        ];
    }

    private function epicShots($story_id = "")
    {
        $stories_arr = [];
        $response = CurlAPI("pages/stories", "GET", null, 1);
        if ($response && @$response['success'] == true) {
            $data = $response['data'] ?? [];
            $list = $data['list'] ?? [];
            foreach ($list as $val) {
                if ($val['status']) {
                    $stories = key_exists('stories', $val) ? $val['stories'] : [];
                    foreach ($stories as $story) {
                        if (!empty($story_id) && $story['ID'] == $story_id) {
                            $stories_arr = $story;
                            break;
                        } else {
                            $stories_arr[] = [
                                'id' => @$story['ID'],
                                'title' => @$story['title'],
                                'img_url' => getCardImage($story, 'imageUrl', 'small', [])
                            ];
                        }
                    }
                }
            }
        }
        return $stories_arr;
    }

    public function getMeta($pagetype, $pagetitle, $pageslug = '')
    {
        // dd($pagetype . '====' .$pageslug);
        // echo $pageslug;die;
        $meta = [];
        $meta['keywords'] = '';
        $meta['image'] = env('APP_URL') . '/epiconlogo.png';
        $meta['url'] = url()->current();
        $meta['title'] = "Welcome to EPIC ON - India Ka Apna Infotainment";
        $meta['description'] = "EPIC ON - India Ka Apna Infotainment | Watch TV Shows, Documentaries, Epic Shorts, Epic Specials Online at EPIC ON";
        if ($pagetype == 'HOME') {
            /******Changed as per SEO Person
            $meta['title'] = 'Welcome to EPIC On - India Ka Apna Infotainment';
            $meta['description'] = 'EPIC On - India Ka Apna Infotainment | Watch TV Shows, Documentaries, Epic Shorts, Epic Specials Online at EPIC On';*/
            $meta['title'] = 'EPIC ON | TV Shows, Movies, Podcast, Games, Rewards';
            $meta['description'] = 'EPIC ON premium OTT service where you can stream movies, tv shows, food shows, podcasts, play games, & read ebooks on multiple devices. Download EPIC ON APP and subscribe to get unlimited access.';
            $meta['keywords'] = 'movies, film, online videos, tv series, games, ebooks, podcast, tv shows, recipe shows, travel shows, historic places, mythology, festivals of India, best tv shows, best tv series, history of India';
        } else if ($pagetype == 'CATALOG') {
            //$meta['title'] = 'Watch EPIC On '.$pagetitle.', Episodes, Promos Online | EPIC On';
            if ($pageslug == 'watch' || $pageslug == 'tv-shows' || $pageslug == 'epic-shorts' || $pageslug == 'documentaries' || $pageslug == 'video-books' || $pageslug == 'movies' || $pageslug == 'amar-chitra-katha') {
                $meta['title'] = 'Watch TV Shows, Episodes, Movies, Originals Online | EPIC ON';
                $meta['description'] = 'Watch Movies Online - Explore New Bollywood Movies, Hollywood Movies and Regional Cinema,TV Shows and more across the genres of comedy, romance, action, drama, food, travel. More on EPIC ON';
                $meta['keywords'] = 'originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries, EPIC ON,films,hollywood movies, bollywood movies, hindi movies,originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries,amazon prime movies';
            } else if ($pageslug == 'listen' || $pageslug == 'podcast') {
                $meta['title'] = 'Listen to Popular Podcast Online Available on EPIC ON';
                $meta['description'] = 'Listen to Latest and Trending Podcast online for free with EPIC ON anytime, anywhere. Download or listen to unlimited podcast available online';
                $meta['keywords'] = 'free podcast, download podcast, free popular podcasts, free podcast downloads, free podcasts online';
            } else if ($pageslug == 'play' || $pageslug == 'games') {
                // print_r("Play Music");exit();
                $meta['title'] = 'Free Kids Games | Online Games for Kids | Play Multiple Online Games | Now Available on EPIC ON';
                $meta['description'] = 'Play the Coolest Online Games for Kids, Play Action Games, Arcade and Board Games. Choose from over 100 Free Kids Games at EPIC ON!';
                $meta['keywords'] = 'games, games free download, subway surfers, onilne games, car games, coin master free spins, games to play, play online games, gamezop, snake game, bubble shooter, onilne chess, bubble shooter, free games, new games, games, games free download, subway surfers, onilne games, car games, coin master free spins, games to play, play online games, gamezop, snake game, bubble shooter, onilne chess, bubble shooter, free games, new games,free online, kids games';
            } else if ($pageslug == 'read' || $pageslug == 'ebooks') {
                $meta['title'] = 'EBooks | Download free Fiction, Love Stories, Romance, English Ebook, Horror and many more on EPIC ON';
                $meta['description'] = 'You cannot stop reading as EPIC ON has unlimited ebooks from popular publications. Read your favourite ebooks free online, available at EPIC ON';
                $meta['keywords'] = 'kindle ebook, ebook reading, ebooks, ebook library, read ebooks online, onlinebooks, free ebooks, free ebook download, read ebooks online free, free onlinebooks, kindle ebook, ebook reading, ebooks, ebook library, read ebooks online, onlinebooks, free ebooks, free ebook download, read ebooks online free, free onlinebooks';
            } else if ($pageslug == 'offers') {
                $meta['title'] = 'Earn Rewards of Epicoins and Redeem on Offers | EPIC ON';
                $meta['description'] = 'Get rewarded for binge-watching, playing games, reading books, and more. Redeem your EPIC coins on available offers at reward store';
                $meta['keywords'] = 'flipkart offers, dominos coupons, myntra coupons, offers, dominos coupon codes, dominos offer, coupons, myntra coupon code, myntra offers, discounts, crossword, deals, vouchers';
            }else if ($pageslug == 'explore') {
                $meta['title'] = 'Explore';
                $meta['description'] = 'Get rewarded for binge-watching, playing games, reading books, and more. Redeem your EPIC coins on available offers at reward store';
                $meta['keywords'] = 'flipkart offers, dominos coupons, myntra coupons, offers, dominos coupon codes, dominos offer, coupons, myntra coupon code, myntra offers, discounts, crossword, deals, vouchers';
            }else if ($pageslug == 'premium') {
                $meta['title'] = 'Premium';
                $meta['description'] = 'Get rewarded for binge-watching, playing games, reading books, and more. Redeem your EPIC coins on available offers at reward store';
                $meta['keywords'] = 'flipkart offers, dominos coupons, myntra coupons, offers, dominos coupon codes, dominos offer, coupons, myntra coupon code, myntra offers, discounts, crossword, deals, vouchers';
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

    public function getHindiMeta($pagetype, $pagetitle, $pageslug = '')
    {
        // dd($pagetype . '====' .$pageslug);
        //echo $pageslug;die;
        $meta = [];
        $meta['keywords'] = '';
        $meta['image'] = env('APP_URL') . '/epiconlogo.png';
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
            } else if ($pageslug == 'play' || $pageslug == 'games') {
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
            } else if ($pageslug == 'explore') {
                $meta['title'] = 'अन्वेषण';
                $meta['description'] = 'देखना, खेल खेलना, किताबें पढ़ना, और बहुत कुछ से ईपीक कोईन प्राप्त करें और रिवॉर्ड स्टोर पर उपलब्ध ऑफर्स पर रिडीम करें';
                $meta['keywords'] = 'फ्लिपकार्ट ऑफर, डोमिनोज़ कूपन, कूपन, ऑफ़र, डोमिनोज़ कूपन कोड, डोमिनोज़ ऑफ़र, कूपन कोड, ऑफ़र, छूट, क्रॉसवर्ड, डील्स, वाउचर';
            } else if ($pageslug == 'premium') {
                $meta['title'] = 'अधिमूल्य';
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


}
