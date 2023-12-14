<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
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
        // dd(session()->get('user_token'));
        $pageslug = strtolower($slug);

        SilentLoginFunction();

        profileActive();
        $data = $this->homepageData($slug);
        $result = $data['result'];

        $pagetitle = @$result['data']['name'];
        $pagetype = in_array($pageslug, ['homepage', 'home', 'home-v2']) ? 'HOME' : 'CATALOG';

        if ($result && @$result['success'] ==  true) {
            $displayLanguageParam = $data['displayLanguageParam'];
            $stories = $data['stories'];
            if ($displayLanguageParam == 'HINDI') {
                $meta = $this->getHindiMeta($pagetype, $pagetitle, $pageslug);
            } else {
                $meta = $this->getMeta($pagetype, $pagetitle, $pageslug);
            }
            // dd($meta);
            return view('pages.homepage', compact('result', 'displayLanguageParam', 'stories', 'meta', 'slug'));
        }

        $whichLogic = 2;

        if ($whichLogic === 1) {

            $pageCheckArr = array_map('strtolower', array('epicoins-faq', 'listen&pid=15', 'getSubscription', 'login', 'documentaries', 'verifyotp', 'watch', 'loginwithpwd', 'resetpwdapi', 'sendotp', 'sendforgototp', 'verifyforgototp', 'amar-chitra-katha', 'catalog', 'index.php'));
            if (in_array(strtolower($pageslug), $pageCheckArr)) {
                return redirect('/', 301);
            } else {
                return view('pages.error.404');
            }
        } else {

            $pageCheckArr = array_map('strtolower', array('about-us', 'movies', 'tv-shows', 'podcast', 'explore', 'premium', 'live-tv', 'distro-tv', 'kids', 'new-popular', 'coming-soon', 'feedback', 'privacy', 'terms-of-use'));
            if (!in_array(strtolower($pageslug), $pageCheckArr)) {
                return redirect('/', 301);
            } else {
                return view('pages.error.404');
            }
        }
    }

    public function loadMore(Request $request)
    {
        $slug = ($request->route == '/' || $request->route == 'hi') ? 'home-v2' : $request->route;
        $data = $this->homepageData($slug, $request->page);
        $result = $data['result'];
        if ($result && @$result['success'] ==  true) {
            $displayLanguageParam = $data['displayLanguageParam'];
            $stories = $data['stories'];

            $view = view('display.display-default', compact('result', 'displayLanguageParam', 'stories', 'slug'))->render();

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
        SilentLoginFunction();
        $result = CurlAPI("pages/explorepage", "GET", [], 1);

        $slug = 'explore';

        if ($result && @$result['success'] ==  true) {
            $pagetitle = @$result['data']['name'];

            $data = $this->homepageData($slug);
            $displayLanguageParam = $data['displayLanguageParam'];

            $pagetype = "CATALOG";

            if ($displayLanguageParam == 'HINDI') {
                $meta = $this->getHindiMeta($pagetype, $pagetitle, $slug);
            } else {
                $meta = $this->getMeta($pagetype, $pagetitle, $slug);
            }

            return view('pages.explore', compact('result', 'meta'));
        }

        return view('pages.error.data-error');
    }

    public function explore_details($slug)
    {
        SilentLoginFunction();
        $page = 1;
        $limit = 20;
        $params = [
            'limit' => $limit,
            'page' => $page,
        ];
        $data = $this->homepageData($slug);
        $displayLanguageParam = $data['displayLanguageParam'];
        $result = CurlAPI("pages/midpage/" . $slug, "GET", $params, 1);

        if ($result && @$result['success'] ==  true) {
            $result = $result['data'] ?? [];

            $meta['title'] = ($displayLanguageParam == 'HINDI') ? 'विवरण खोजें' : 'Explore - ' . ucfirst($slug);

            return view('pages.explore_details', compact('result', 'slug', 'page', 'meta', 'limit'));
        } else {
            return view('pages.error.data-error');
        }
    }

    public function getSpinnerContent(Request $request)
    {
        $result = CurlAPI("pages/spinnerContent", "POST", ['genre' => $request->genre], 1, false, true);


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
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 28 28" fill="none"><path d="M21.0026 15.1678H15.1693V21.0011C15.1693 21.6428 14.6443 22.1678 14.0026 22.1678C13.3609 22.1678 12.8359 21.6428 12.8359 21.0011V15.1678H7.0026C6.36094 15.1678 5.83594 14.6428 5.83594 14.0011C5.83594 13.3595 6.36094 12.8345 7.0026 12.8345H12.8359V7.00114C12.8359 6.35947 13.3609 5.83447 14.0026 5.83447C14.6443 5.83447 15.1693 6.35947 15.1693 7.00114V12.8345H21.0026C21.6443 12.8345 22.1693 13.3595 22.1693 14.0011C22.1693 14.6428 21.6443 15.1678 21.0026 15.1678Z" fill="white" /></svg>';
                } else {
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 22 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20.8161 0.272093C21.2325 0.65643 21.2584 1.30553 20.8741 1.72189L7.999 15.6699C7.80961 15.8751 7.54478 15.9942 7.26561 15.9998C6.98644 16.0054 6.71706 15.8969 6.51962 15.6995L1.155 10.3349C0.754324 9.9342 0.754324 9.28458 1.155 8.88391C1.55567 8.48324 2.20529 8.48324 2.60596 8.88391L7.2155 13.4935L19.3663 0.330085C19.7506 -0.086281 20.3997 -0.112245 20.8161 0.272093Z" fill="white"/>
                    </svg>';
                }


                $html = '<button class="big-add-list addToList" data-id="' . $request->content_id . '" data-action="' . $wishAction . '" data-type="1">  ' . $icon . '</button>';
            }

            return JSONResponse(200, ($request->action == 'add') ? 'Added to wishlist' : 'Removed from wishlist', ['icon' => $html]);
        } else {
            return JSONResponse(400, 'Something went wrong. Please try again!');
        }
    }

    public function showmidpagedetail(Request $request, $pageslug, $catalog = null)
    {
        $page = 1;
        $slug = $pageslug;
        $limit = 48;

        $hybidData = $request->all();
        if ($request->is_hybrid) {

            $genre_viewall = json_encode(explode(",", $request->genre_viewall));
            $catalog_viewall = json_encode(explode(",", $request->catalog_viewall));
            $list_language_viewall = json_encode(explode(",", $request->list_language_viewall));
            $params = [
                'is_hybrid' => 'true',
                'catalog_viewall' => $catalog_viewall,
                'genre_viewall' => $genre_viewall,
                'list_language_viewall' => $list_language_viewall,
                'limit' => $limit,
                'page' => 1
            ];
            $epicwebArr = $this->hybridCurl($params);
        } else {
            $epicwebArr = CurlAPI("pages/midpageData", "POST", ['catalogId' => $catalog, 'limit' => $limit, 'page' => 1], 1);
        }
        if (isset($epicwebArr) && @$epicwebArr['success'] == true) {
            $epicwebArr = $epicwebArr['data'];
            return view('pages.midpage', compact('epicwebArr', 'pageslug', 'catalog', 'page', 'hybidData'));
        } else {
            return view('pages.error.data-error');
        }
    }

    public function channelsmidpagedetail($slug)
    {
        $title = $slug;
        $slug = "live|" . $slug;
        $page = 1;
        $epicwebArr = CurlAPI("pages/midpageData", "POST", ['slug' => $slug, 'page' => 1, 'limit' => 48], 1);

        if (isset($epicwebArr) && @$epicwebArr['success'] == true) {
            $epicwebArr = $epicwebArr['data'];
            return view('pages.chanel.channelmidpage', compact('epicwebArr', 'title', 'slug', 'page'));
        } else {
            return view('pages.error.data-error');
        }
    }

    public function paginatecontent()
    {
        $request = Request();
        $page = $request->page;
        $catalog = "";
        $limit = 48;
        $dataCount = "";
        if ($request->is_hybrid) {

            $genre_viewall = json_encode(explode(",", $request->genre_viewall));
            $catalog_viewall = json_encode(explode(",", $request->catalog_viewall));
            $list_language_viewall = json_encode(explode(",", $request->list_language_viewall));
            $params = [
                'is_hybrid' => 'true',
                'catalog_viewall' => $catalog_viewall,
                'genre_viewall' => $genre_viewall,
                'list_language_viewall' => $list_language_viewall,
                'limit' => $limit,
                'page' => $page
            ];
            $epicwebArr = $this->hybridCurl($params);
        } else {
            $catalog = $request->catalogid;
            $epicwebArr = CurlAPI("pages/midpageData", "POST", ['catalogId' => $catalog, 'limit' => $limit, 'page' => $page], 1);
        }
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
        $epicwebArr = CurlAPI("pages/midpageData", "POST", ['slug' => $slug, 'limit' => $limit, 'page' => $page], 1);
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
        $limit = 20;
        $params = [
            'page' => $page,
            'limit' => $limit,
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

        return JSONResponse(
            200,
            'Success.',
            [
                'html' => $view,
            ]
        );
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

        if (isUserLoggedIn()) {
            $params['user_id'] = getUserId();
            $params['profile_id'] = getProfileId();
        }

        $result = CurlAPI("pages/homepage", "GET", $params, 1);
        // dd($result);
        if ($result && @$result['success'] ==  true) {
            $data = $result['data'] ?? [];
            $lists = $data['list'] ?? [];
            foreach ($lists as $list) {
                if ($list['display_type'] == "shortandsweet") {
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
            'stories' => $stories,
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
                if (@$val['status']) {
                    $stories = key_exists('stories', $val) ? $val['stories'] : [];
                    foreach ($stories as $story) {
                        if (!empty($story_id) && @$story['ID'] == $story_id) {
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
        $meta = [];
        $meta['keywords'] = '';
        $meta['url'] = url()->current();
        $meta['title'] = "Welcome to EPIC ON - India Ka Apna Infotainment";
        $meta['description'] = "EPIC ON - India Ka Apna Infotainment | Watch TV Shows, Documentaries, Epic Shorts, Epic Specials Online at EPIC ON";
        if ($pagetype == 'HOME') {
            /******Changed as per SEO Person
            $meta['title'] = 'Welcome to EPIC On - India Ka Apna Infotainment';
            $meta['description'] = 'EPIC On - India Ka Apna Infotainment | Watch TV Shows, Documentaries, Epic Shorts, Epic Specials Online at EPIC On';*/
            $meta['title'] = 'Watch Indian and Hollywood Movies & TV Shows Online | Epic On';
            $meta['description'] = 'Watch Indian and Hollywood movies & TV shows online at Epic On, India\'s premier OTT platform in India. With a wide selection of new and classic shows and Movies.';
            $meta['keywords'] = 'movies, film, online videos, tv series, games, ebooks, podcast, tv shows, recipe shows, travel shows, historic places, mythology, festivals of India, best tv shows, best tv series, history of India';
        } else if ($pagetype == 'login') {
            $meta['title'] = 'EPIC ON | TV Shows, Movies, Podcast, Games, Rewards';
            $meta['keywords'] = 'movies, film, online videos, tv series, games, ebooks, podcast, tv shows, recipe shows, travel shows, historic places, mythology, festivals of India, best tv shows, best tv series, history of India';
            $meta['description'] = 'Enjoy the best of content across movie, tv shows, videos, podcasts, gaming & e-books on-the-go, on multiple devices. Explore, discover, and be inspired with all in one entertainment stop on EPIC ON';
        } else if ($pagetype == 'CATALOG') {
            //$meta['title'] = 'Watch EPIC On '.$pagetitle.', Episodes, Promos Online | EPIC On';
            if ($pagetitle == 'watch' || $pagetitle == 'tv-shows' || $pagetitle == 'epic-shorts' || $pagetitle == 'documentaries' || $pagetitle == 'video-books' || $pagetitle == 'movies' || $pagetitle == 'amar-chitra-katha') {
                // dd($pageslug);
                if ($pageslug == 'tv-shows') {
                    $meta['title'] = 'Watch Indian TV Shows Online at Epic On | Streaming Now';
                    $meta['description'] = 'Watch your favorite TV show online at Epic On. Best OTT Platforms for TV shows in Hindi and English. Subscribe to our platform today!.';
                    $meta['keywords'] = 'originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries, EPIC ON,films,hollywood movies, bollywood movies, hindi movies,originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries,amazon prime movies';
                } else if ($pageslug == 'epic-shorts') {
                    $meta['title'] = 'Watch Short Clip Online in India at Epic On';
                    $meta['description'] = 'Enjoy a wide range of short clips online at Epic On. From funny videos to educational clips to inspiring stories, there\'s something for everyone. Watch now!';
                    $meta['keywords'] = 'originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries, EPIC ON,films,hollywood movies, bollywood movies, hindi movies,originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries,amazon prime movies';
                } else if ($pageslug == 'movies') {
                    $meta['title'] = 'Best OTT Platform for Movies | Watch Online Movie Now';
                    $meta['description'] = 'Watch your favorite online movies on Epic On, Indias best OTT platform for movies. With a wide selection of movies to choose from, including new releases.';
                    $meta['keywords'] = 'originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries, EPIC ON,films,hollywood movies, bollywood movies, hindi movies,originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries,amazon prime movies';
                } else {
                    $meta['title'] = 'Best Ott Platforms for kids Online in India | Watch Now';
                    $meta['description'] = 'Keep your kids entertained with the best OTT platforms for kids in India, featuring a wide range of content. Subscribe and Enjoy ad-free streaming';
                    $meta['keywords'] = 'originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries, EPIC ON,films,hollywood movies, bollywood movies, hindi movies,originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries,amazon prime movies';
                }
            } else if ($pagetitle == 'listen' || $pagetitle == 'podcast') {

                $meta['title'] = 'Podcast to Listen in India at Epic On';
                $meta['description'] = 'Listen to the best podcasts in India on Epic On. With a wide variety of podcasts to choose from, you\'re sure to find something you\'ll love. Start listening today!';
                $meta['keywords'] = 'free podcast, download podcast, free popular podcasts, free podcast downloads, free podcasts online';
            } else if ($pagetitle == 'play' || $pagetitle == 'games') {
                // print_r("Play Music");exit();
                if ($pageslug == 'gamepix') {
                    $meta['title'] = 'Epic On - Online Gaming Platform for Kids | Check Today';
                    $meta['description'] = 'Enjoy fun and educational online games with kids of all ages! These games will keep you entertained and learning at the same time';
                    $meta['keywords'] = 'games, games free download, subway surfers, onilne games, car games, coin master free spins, games to play, play online games, gamezop, snake game, bubble shooter, onilne chess, bubble shooter, free games, new games, games, games free download, subway surfers, onilne games, car games, coin master free spins, games to play, play online games, gamezop, snake game, bubble shooter, onilne chess, bubble shooter, free games, new games,free online, kids games';
                } else if ($pageslug == 'gamezop') {
                    $meta['title'] = 'Online Gaming OTT Platform | Play Now';
                    $meta['description'] = 'Experience the future of online gaming with Epic On, India\'s premier OTT gaming platform. Play your favorite games instantly, without any installation.';
                    $meta['keywords'] = 'games, games free download, subway surfers, onilne games, car games, coin master free spins, games to play, play online games, gamezop, snake game, bubble shooter, onilne chess, bubble shooter, free games, new games, games, games free download, subway surfers, onilne games, car games, coin master free spins, games to play, play online games, gamezop, snake game, bubble shooter, onilne chess, bubble shooter, free games, new games,free online, kids games';
                } else {
                    $meta['title'] = 'Online Gaming Platform | Play Games At Epic On';
                    $meta['description'] = 'Play your favorite online games on Epic On. With a wide selection of games to choose from, Enjoy smooth and seamless gaming edxperience. Sign up for a free trial!';
                    $meta['keywords'] = 'games, games free download, subway surfers, onilne games, car games, coin master free spins, games to play, play online games, gamezop, snake game, bubble shooter, onilne chess, bubble shooter, free games, new games, games, games free download, subway surfers, onilne games, car games, coin master free spins, games to play, play online games, gamezop, snake game, bubble shooter, onilne chess, bubble shooter, free games, new games,free online, kids games';
                }
            } else if ($pagetitle == 'read' || $pagetitle == 'ebooks') {
                $meta['title'] = 'EBooks | Download free Fiction, Love Stories, Romance, English Ebook, Horror and many more on EPIC ON';
                $meta['description'] = 'You cannot stop reading as EPIC ON has unlimited ebooks from popular publications. Read your favourite ebooks free online, available at EPIC ON';
                $meta['keywords'] = 'kindle ebook, ebook reading, ebooks, ebook library, read ebooks online, onlinebooks, free ebooks, free ebook download, read ebooks online free, free onlinebooks, kindle ebook, ebook reading, ebooks, ebook library, read ebooks online, onlinebooks, free ebooks, free ebook download, read ebooks online free, free onlinebooks';
            } else if ($pagetitle == 'offers') {
                $meta['title'] = 'Earn Rewards of Epicoins and Redeem on Offers | EPIC ON';
                $meta['description'] = 'Get rewarded for binge-watching, playing games, reading books, and more. Redeem your EPIC coins on available offers at reward store';
                $meta['keywords'] = 'flipkart offers, dominos coupons, myntra coupons, offers, dominos coupon codes, dominos offer, coupons, myntra coupon code, myntra offers, discounts, crossword, deals, vouchers';
            } else if ($pageslug == 'explore') {
                $meta['title'] = 'Explore';
            } else if ($pageslug == 'premium') {
                $meta['title'] = 'Premium | EPIC ON';
                $meta['description'] = 'EPIC ON - India Ka Apna Infotainment | Watch TV Shows, Documentaries, Epic Shorts, Epic Specials Online at EPIC ON ';
                $meta['keywords'] = 'free podcast, download podcast, free popular podcasts, free podcast downloads, free podcasts online';
            } else {
                $meta['title'] = 'Top Podcasts Platform in India | Listen Now';
                $meta['description'] = 'Discover the top podcasts in India on Epic On, Indias premier OTT platform. With a wide range of genres to choose from, there is something for everyone. Start listening today!';
                $meta['keywords'] = 'free podcast, download podcast, free popular podcasts, free podcast downloads, free podcasts online';
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
            } else {
                $meta['title'] = 'Watch Live Tv | Best OTT Platforms for Live TV | EPIC ON';
                $meta['description'] = 'Catch all the live action with EPIC ON, India\'s premier OTT platform for live TV. Stream your favorite news, sports, and entertainment channels from anywhere.';
                $meta['keywords'] = 'live tv, movies online, live tv channel, public tv live, live tv app, filamchi tv, filamchi live tv, free live tv, bhojpuri movies, bhojpuri video, bhojpuri film, bhojpuri cinema, bhojpuri film video';
            }
        } else if ($pagetype == 'HISTORY') {
            //$meta['title'] = 'Watch popular '.$pagetitle.' Shows, Episodes, Promos Online | EPIC On';
            $meta['title'] = 'Watch EPICON for your favourite Tv Shows, Episodes - Podcast - Ebook - Games - Rewards';
            $meta['description'] = 'Watch ' . $pagetitle . ' Shows online. Latest ' . $pagetitle . ' Shows Episodes, Promos online at EPIC ON.';
            // } else if (strtolower($pagetype) == 'coming-soon') {
            //     $meta['title'] = 'Get to Know About Upcoming OTT New Web Series and Movies';
            //     $meta['description'] = 'Exciting collection of upcoming web series and movies on OTT platforms. Watch wide range of Hindi and English TV show and movies online.';
            // } else if (strtolower($pagetype) == 'about-us') {
            //     $meta['title'] = 'About Us - Epic On a Seamless Streaming Experience';
            //     $meta['description'] = 'Experience entertainment like never before with the Epic On OTT Platform. Enjoy an extensive collection of movies, TV shows, and live shows all in one place.';
        } else if (strtolower($pagetype) == 'contact-us') {
            $meta['title'] = 'Contact Us - Epic On';
            $meta['description'] = 'Epic On contact us feature offers seamless and convenient communication for our valued users. For more details on our OTT platform fill the form.';
        }
        return $meta;
    }

    public function getHindiMeta($pagetype, $pagetitle, $pageslug = '')
    {

        $meta = [];
        $meta['keywords'] = '';
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

    public function hybridCurl($param)
    {

        $data = http_build_query($param);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => config('epicconfig.EPICAPI.API_DOMAIN_1') . '/pages/midpageData',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH',
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }
}
