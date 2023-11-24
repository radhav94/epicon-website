<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class PageDetailController extends Controller
{
    public function detail($pageslug, $contentslug, $season = null, $episode = null)
    {
        SilentLoginFunction();
        $url = "pages/episode/{$pageslug}/{$contentslug}";
        $params = [];
        if ($season && $episode) {
            $url .= "/{$season}/{$episode}";
        } else if ($season) {
            $url .= "/{$season}";
        }
        // && !empty(getProfileId()) -> handle for old user
        if (isUserLoggedIn() && !empty(getProfileId())) {
            $params['user_id'] = getUserId();
            $params['profile_id'] = getProfileId();
        }
        $pagetype = in_array($pageslug, ['homepage', 'home', 'home-v2']) ? 'HOME' : 'CATALOG';
        $result = CurlAPI($url, "GET", $params, 1);
        if ($result && @$result['success'] ==  true) {
            $displayLanguageParam = setLanguageParameter();
            if ($displayLanguageParam == 'HINDI') {
                $meta = $this->getHindiMeta($pagetype, $contentslug, $pageslug);
            } else {
                $meta = $this->getMeta($pagetype, $contentslug, $pageslug);
            }
            $content = $result['content'] ?? [];

            if(empty($content)){
                return view('pages.error.404');
            }

            $trailers = [];
            $morelike = [];

            //get trailers tab data
            $params = ['content_id' => @$content['ID']];

            $trailers_curl = CurlAPI("pages/trailers-and-more", "POST", $params, 1);
            if ($trailers_curl && @$trailers_curl['success'] ==  true) {
                $trailers = $trailers_curl['data'] ?? [];
            }

            //get more like this tab  data
            $params = ['catalog_slug' => @$content['catalog_slug']];
            $morelike_curl = CurlAPI("v2Content/related/" . @$content['ID'], "GET", $params, 1);
            if ($morelike_curl && @$morelike_curl['success'] ==  true) {

                $morelike_curlID = count(@$morelike_curl['data']) == 1 && @$morelike_curl['data'][0]['ID'] ? @$morelike_curl['data'][0]['ID'] : '';
                //check most like content and active content are same 
                if ($morelike_curlID && $morelike_curlID == @$content['ID']) {
                    //if most like content has only one content and is same then set empty most like content
                    $morelike = [];
                } else {
                    $morelike = $morelike_curl['data'] ?? [];
                }
            }

            //get about tab data
            $params = ['content_id' => @$content['ID']];
            $about_curl = CurlAPI("pages/about", "POST", $params, 1);
            if ($about_curl && @$about_curl['success'] ==  true) {
                $about = $about_curl['data'] ?? [];
            }


            if (request()->get('v') != '') {
                // dd($about);
                echo '--------Trailers --------';
                d($trailers);
                echo '--------morelike --------';

                d($morelike);
                echo '--------about --------';

                d($about);
                echo '--------result --------';

                dd($result);
                die;
            }

            $template = 'pages.detail.page-detail';
            if (@$content['asset_type'] == 'LISTEN') {
                $template = 'pages.detail.podcast';
            }
            return view($template, compact('content', 'displayLanguageParam', 'trailers', 'morelike','meta', 'about', 'pageslug'));
        }

        return view('pages.error.404');
    }

    public function clap(Request $request)
    {
        $params = [
            'content_id' => $request->content_id,
        ];
        $result = CurlAPI("pages/clap", "POST", $params);

        if ($result && @$result['success'] ==  true) {
            return JSONResponse(200, 'Success', ['claps' => countConvert(@$result['claps'])]);
        } else {
            return JSONResponse(400, 'Some error occured');
        }
    }

    public function getMeta($pagetype, $pagetitle, $pageslug = '')
    {
        $meta = [];
        $meta['keywords'] = '';
        $meta['url'] = url()->current();
        $meta['title'] = "Welcome to EPIC ON - India Ka Apna Infotainment";
        $meta['description'] = "EPIC ON - India Ka Apna Infotainment | Watch TV Shows, Documentaries, Epic Shorts, Epic Specials Online at EPIC ON";
        // dd($pagetype ."==============".$pagetitle."=================".$pageslug);
        if ($pagetype == 'HOME') {
            /******Changed as per SEO Person
            $meta['title'] = 'Welcome to EPIC On - India Ka Apna Infotainment';
            $meta['description'] = 'EPIC On - India Ka Apna Infotainment | Watch TV Shows, Documentaries, Epic Shorts, Epic Specials Online at EPIC On';*/
            $meta['title'] = 'Watch Indian and Hollywood Movies and TV Shows Online';
            $meta['description'] = 'Watch Indian and Hollywood movies and TV shows online at Epic On, Indias premier OTT platform in India. With a wide selection of new and classic shows and Movies.';
            $meta['keywords'] = 'movies, film, online videos, tv series, games, ebooks, podcast, tv shows, recipe shows, travel shows, historic places, mythology, festivals of India, best tv shows, best tv series, history of India';
        } else if ($pagetype == 'login') {
            $meta['title'] = 'EPIC ON | TV Shows, Movies, Podcast, Games, Rewards';
            $meta['keywords'] = 'movies, film, online videos, tv series, games, ebooks, podcast, tv shows, recipe shows, travel shows, historic places, mythology, festivals of India, best tv shows, best tv series, history of India';
            $meta['description'] = 'Enjoy the best of content across movie, tv shows, videos, podcasts, gaming & e-books on-the-go, on multiple devices. Explore, discover, and be inspired with all in one entertainment stop on EPIC ON';
        } else if ($pagetype == 'CATALOG') {
            //$meta['title'] = 'Watch EPIC On '.$pagetitle.', Episodes, Promos Online | EPIC On';
            if ($pagetitle == 'watch' || $pagetitle == 'tv-shows' || $pagetitle == 'epic-shorts' || $pagetitle == 'documentaries' || $pagetitle == 'video-books' || $pagetitle == 'movies' || $pagetitle == 'amar-chitra-katha') {
                // dd($pageslug);
                if($pageslug == 'tv-shows'){
                    $meta['title'] = 'Watch Indian TV Shows Online at Epic On | Streaming Now';
                    $meta['description'] = 'Watch your favorite TV show online at Epic On. Best OTT Platforms for TV shows in Hindi and English. Subscribe to our platform today!';
                    $meta['keywords'] = 'originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries, EPIC ON,films,hollywood movies, bollywood movies, hindi movies,originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries,amazon prime movies';
                }else if($pageslug == 'epic-shorts'){
                    $meta['title'] = 'Watch Short Clip Online in India at Epic On';
                    $meta['description'] = 'Enjoy a wide range of short clips online at Epic On. From funny videos to educational clips to inspiring stories, theres something for everyone. Watch now!';
                    $meta['keywords'] = 'originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries, EPIC ON,films,hollywood movies, bollywood movies, hindi movies,originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries,amazon prime movies';
                }else if($pageslug == 'movies'){
                    $meta['title'] = 'Best OTT Platform for Movies | Watch Online Movie Now';
                    $meta['description'] = 'Watch your favorite online movies on Epic On, Indias best OTT platform for movies. With a wide selection of movies to choose from, including new releases.';
                    $meta['keywords'] = 'originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries, EPIC ON,films,hollywood movies, bollywood movies, hindi movies,originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries,amazon prime movies';
                }else{
                $meta['title'] = 'Best Ott Platforms for kids Online in India | Watch Now';
                $meta['description'] = 'Keep your kids entertained with the best OTT platforms for kids in India, featuring a wide range of content. Subscribe and Enjoy ad-free streaming';
                $meta['keywords'] = 'originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries, EPIC ON,films,hollywood movies, bollywood movies, hindi movies,originals, new movies, mp4moviez, movies, moviezwap, film, online videos, tv series, tv shows, best netflix series, web series, shows, best web series, documentaries,amazon prime movies';
                }
            } else if ($pagetitle == 'listen' || $pagetitle == 'podcast') {

                    $meta['title'] = 'Podcast to Listen in India at Epic On';
                    $meta['description'] = 'Listen to the best podcasts in India on Epic On. With a wide variety of podcasts to choose from, you are sure to find something you will love. Start listening today!';
                    $meta['keywords'] = 'free podcast, download podcast, free popular podcasts, free podcast downloads, free podcasts online';
                
            } else if ($pagetitle == 'play') {
                // print_r("Play Music");exit();
                if($pageslug == 'gamepix'){
                    $meta['title'] = 'Epic On - Online Gaming Platform for Kids | Check Today';
                    $meta['description'] = 'Enjoy fun and educational online games with kids of all ages! These games will keep you entertained and learning at the same time';
                    $meta['keywords'] = 'games, games free download, subway surfers, onilne games, car games, coin master free spins, games to play, play online games, gamezop, snake game, bubble shooter, onilne chess, bubble shooter, free games, new games, games, games free download, subway surfers, onilne games, car games, coin master free spins, games to play, play online games, gamezop, snake game, bubble shooter, onilne chess, bubble shooter, free games, new games,free online, kids games';
                }else if($pageslug == 'gamezop'){
                    $meta['title'] = 'Online Gaming OTT Platform | Play Now';
                    $meta['description'] = 'Experience the future of online gaming with Epic On, Indias premier OTT gaming platform. Play your favorite games instantly, without any installation.';
                    $meta['keywords'] = 'games, games free download, subway surfers, onilne games, car games, coin master free spins, games to play, play online games, gamezop, snake game, bubble shooter, onilne chess, bubble shooter, free games, new games, games, games free download, subway surfers, onilne games, car games, coin master free spins, games to play, play online games, gamezop, snake game, bubble shooter, onilne chess, bubble shooter, free games, new games,free online, kids games';
                }else{
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
