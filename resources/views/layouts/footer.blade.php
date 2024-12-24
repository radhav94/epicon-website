<?php
$request = Request();
$webview = "";
if ($request->has('type')) {
    $webview = $request->input('type');
 }
 if (isUserLoggedIn()) {
    $subplan = checkSubscription();
 }
 ?>
@if($webview !='webview')
<div class="footer w-100">
    <div class="container text-center">
        <a aria-label="logo" onclick="click_menu(this)" data-event_context="footer" data-element_text="Home" href="{{ getUrlWithPrefix('homepage') }}"><img width="150" height="44" class="epicon-footer-logo" src="{{env('AWS_S3_domain')}}epicon/assets/images/epicon-logo.png" alt=""></a>
        <div class="row middle-footer">
            <div class="col-lg-3">
                <div class="connect-with">
                    <h2>{{__('Connect With Us')}}</h2>
                    <div class="w-100 f-share-icons">
                        <a onclick="click_social(this)" aria-label="facebook" data-title="facebook" data-event_context="Epic on" target="_blank" href="https://www.facebook.com/theepicon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                                fill="none">
                                <circle cx="20" cy="20" r="20" fill="white"
                                    fill-opacity="0.08" />
                                <path
                                    d="M27.348 12H12.6395C12.2858 12 12 12.286 12 12.64V27.36C12 27.714 12.2858 28 12.6395 28H27.348C27.7018 28 27.9875 27.714 27.9875 27.36V12.64C27.9875 12.286 27.7018 12 27.348 12ZM25.5015 16.67H24.2245C23.2232 16.67 23.0294 17.146 23.0294 17.846V19.388H25.4195L25.1078 21.802H23.0294V28H20.5373V21.804H18.453V19.388H20.5373V17.608C20.5373 15.542 21.7984 14.416 23.6409 14.416C24.5242 14.416 25.2816 14.482 25.5035 14.512V16.67H25.5015Z"
                                    fill="white" />
                            </svg>
                        </a>
                        <a  onclick="click_social(this)" aria-label="twitter"  data-title="twitter" data-event_context="Epic on" target="_blank" href="https://twitter.com/theepicon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                                fill="none">
                                <circle cx="20" cy="20" r="20" fill="white"
                                    fill-opacity="0.08" />
                                <path
                                    d="M24.683 12.6875H27.164L21.7437 18.8825L28.1202 27.3125H23.1275L19.217 22.1997L14.7425 27.3125H12.26L18.0575 20.6862L11.9405 12.6875H17.06L20.5947 17.3607L24.683 12.6875ZM23.8122 25.8275H25.187L16.313 14.0945H14.8377L23.8122 25.8275Z"
                                    fill="white" />
                            </svg>
                        </a>
                        <a  onclick="click_social(this)" aria-label="linkedin" data-title="linkedin" data-event_context="Epic on" target="_blank" href="https://www.linkedin.com/company/theepicon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                                fill="none">
                                <circle cx="20" cy="20" r="20" fill="white"
                                    fill-opacity="0.08" />
                                <path
                                    d="M27.348 12H12.6395C12.2858 12 12 12.286 12 12.64V27.36C12 27.714 12.2858 28 12.6395 28H27.348C27.7018 28 27.9875 27.714 27.9875 27.36V12.64C27.9875 12.286 27.7018 12 27.348 12ZM16.7423 25.634H14.3702V17.998H16.7423V25.634ZM15.5572 16.954C15.2853 16.954 15.0195 16.8733 14.7934 16.7221C14.5673 16.5709 14.391 16.356 14.287 16.1046C14.1829 15.8531 14.1557 15.5765 14.2087 15.3096C14.2618 15.0426 14.3927 14.7975 14.585 14.605C14.7773 14.4126 15.0223 14.2815 15.289 14.2284C15.5557 14.1753 15.8322 14.2026 16.0834 14.3067C16.3346 14.4109 16.5494 14.5873 16.7004 14.8135C16.8515 15.0398 16.9322 15.3059 16.9322 15.578C16.9302 16.338 16.3146 16.954 15.5572 16.954ZM25.6234 25.634H23.2532V21.92C23.2532 21.034 23.2372 19.896 22.0202 19.896C20.7871 19.896 20.5973 20.86 20.5973 21.856V25.634H18.2291V17.998H20.5034V19.042H20.5353C20.8511 18.442 21.6245 17.808 22.7796 17.808C25.1817 17.808 25.6234 19.39 25.6234 21.446V25.634Z"
                                    fill="white" />
                            </svg>
                        </a>
                        <a  onclick="click_social(this)" aria-label="youtube"  data-title="youtube" data-event_context="Epic on" target="_blank" href="https://www.youtube.com/channel/UC6TRCmHt1MZeArqN0efBhWQ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                                fill="none">
                                <circle cx="20" cy="20" r="20" fill="white"
                                    fill-opacity="0.08" />
                                <path
                                    d="M27.6946 15.8745C27.6034 15.5115 27.4245 15.1805 27.1758 14.9146C26.9272 14.6487 26.6175 14.4572 26.2778 14.3592C25.0273 14 20.0146 14 20.0146 14C20.0146 14 15.0019 14 13.7514 14.3573C13.4115 14.4549 13.1017 14.6463 12.853 14.9123C12.6043 15.1783 12.4255 15.5095 12.3345 15.8726C12 17.2102 12 20 12 20C12 20 12 22.7898 12.3345 24.1255C12.5188 24.8631 13.0626 25.4439 13.7514 25.6408C15.0019 26 20.0146 26 20.0146 26C20.0146 26 25.0273 26 26.2778 25.6408C26.9683 25.4439 27.5104 24.8631 27.6946 24.1255C28.0292 22.7898 28.0292 20 28.0292 20C28.0292 20 28.0292 17.2102 27.6946 15.8745ZM18.4224 22.5605V17.4395L22.5728 19.9809L18.4224 22.5605Z"
                                    fill="white" />
                            </svg>
                        </a>
                        <a  onclick="click_social(this)" aria-label="instagram" data-title="instagram" data-event_context="Epic on" target="_blank" href="https://www.instagram.com/theepicon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                                fill="none">
                                <circle cx="20" cy="20" r="20" fill="white"
                                    fill-opacity="0.08" />
                                <path
                                    d="M19.9918 17.3322C18.5239 17.3322 17.326 18.531 17.326 20C17.326 21.469 18.5239 22.6678 19.9918 22.6678C21.4596 22.6678 22.6575 21.469 22.6575 20C22.6575 18.531 21.4596 17.3322 19.9918 17.3322ZM27.9869 20C27.9869 18.8953 27.9969 17.8005 27.9349 16.6978C27.8729 15.4169 27.581 14.2801 26.6451 13.3435C25.7072 12.4049 24.5733 12.1147 23.2934 12.0526C22.1895 11.9906 21.0956 12.0006 19.9938 12.0006C18.8899 12.0006 17.796 11.9906 16.6941 12.0526C15.4142 12.1147 14.2784 12.4069 13.3425 13.3435C12.4046 14.2821 12.1146 15.4169 12.0526 16.6978C11.9906 17.8025 12.0006 18.8973 12.0006 20C12.0006 21.1027 11.9906 22.1995 12.0526 23.3022C12.1146 24.5831 12.4066 25.7199 13.3425 26.6565C14.2804 27.5951 15.4142 27.8853 16.6941 27.9474C17.798 28.0094 18.8919 27.9994 19.9938 27.9994C21.0976 27.9994 22.1915 28.0094 23.2934 27.9474C24.5733 27.8853 25.7092 27.5931 26.6451 26.6565C27.583 25.7179 27.8729 24.5831 27.9349 23.3022C27.9989 22.1995 27.9869 21.1047 27.9869 20ZM19.9918 24.1048C17.722 24.1048 15.8902 22.2715 15.8902 20C15.8902 17.7285 17.722 15.8952 19.9918 15.8952C22.2615 15.8952 24.0933 17.7285 24.0933 20C24.0933 22.2715 22.2615 24.1048 19.9918 24.1048ZM24.2613 16.6858C23.7314 16.6858 23.3034 16.2575 23.3034 15.7271C23.3034 15.1968 23.7314 14.7685 24.2613 14.7685C24.7913 14.7685 25.2192 15.1968 25.2192 15.7271C25.2194 15.853 25.1947 15.9778 25.1466 16.0942C25.0985 16.2105 25.028 16.3163 24.939 16.4053C24.85 16.4944 24.7444 16.565 24.6281 16.6131C24.5118 16.6612 24.3872 16.6859 24.2613 16.6858Z"
                                    fill="white" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 link-pos">
                <div class="f-link d-flex">
                    <!-- <ul class="d-flex mb-0"> -->
                        @if(isKidsPage())
                        <a onclick="click_menu(this)" data-event_context="footer" data-element_text="{{__('About Us')}}" href="{{getUrl('kids/about-us')}}">{{__('About Us')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" data-element_text="{{__('Terms of Use')}}" href="{{route('kids-terms-of-use')}}">{{__('Terms of Use')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" data-element_text="{{__('Privacy Policy')}}" href="{{route('kids-privacy')}}">{{__('Privacy Policy')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" data-element_text="{{__('Help Centre')}}" href="{{getUrl('kids/feedback')}}">{{__('Help Centre')}}</a>
                        @else
                        <a onclick="click_menu(this)" data-event_context="footer" data-element_text="{{__('About Us')}}" href="{{getUrl('about-us')}}">{{__('About Us')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" data-element_text="{{__('Terms of Use')}}" href="{{route('terms-of-use')}}">{{__('Terms of Use')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" data-element_text="{{__('Privacy Policy')}}" href="{{route('privacy')}}">{{__('Privacy Policy')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" data-element_text="{{__('Help Centre')}}" href="{{getUrl('feedback')}}">{{__('Help Centre')}}</a>
                        @endif
                    <!-- </ul> -->
                </div>
            </div>
            <div class="col-lg-3">
                <div class="download-store">
                    <h1>{{__('Download App')}}</h1>
                    <div class="w-100 download-store-logo">
                        <a onclick="outbound_click(this)" aria-label="app android" data-event_context="app" data-element_text="android" href="https://play.google.com/store/apps/details?id=com.epicchannel.epicon&amp;hl=en" target="_blank"><img class="me-3" src="{{ env('AWS_S3_domain') }}epicon/assets/images/google-store-logo-proper.svg"
                                alt="google store"></a>
                        <a onclick="outbound_click(this)" aria-label="app ios" data-event_context="app" data-element_text="ios" href="https://apps.apple.com/in/app/epic-on/id1252513341" target="_blank"><img src="{{ env('AWS_S3_domain') }}epicon/assets/images/apple-store-logo.svg" alt="app store"></a>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <ul class="footer__menu">
                    <li>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('tv-shows') }}" data-element_text="{{__('Popular Tv Show')}}"><h3>{{__('Popular Tv Show')}}</h3></a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('tv-shows/dahej-dasi') }}" data-element_text="{{__('Dahej Dasi') }}">{{__('Dahej Dasi') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('tv-shows/dharmakshetra') }}" data-element_text="{{__('Dharmakshetra') }}">{{__('Dharmakshetra') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('tv-shows/dhartiputra-nandini') }}" data-element_text="{{__('Dhartiputra Nandini') }}">{{__('Dhartiputra Nandini') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('tv-shows/laal-banarasi') }}" data-element_text="{{__('Laal Banarasi') }}">{{__('Laal Banarasi') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('tv-shows/paapnaashini-ganga') }}" data-element_text="{{__('Papnashni Ganga') }}">{{__('Papnashni Ganga') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('tv-shows/crime-files') }}" data-element_text="{{__('Crime Files') }}">{{__('Crime Files') }}</a>
                        {{-- <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('tv-shows/laal-banarasi') }}" data-element_text="{{__('Laal Banarasi') }}">{{__('Laal Banarasi') }}</a> --}}
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('tv-shows/bhabhi-ke-pyare-pritam-hamare') }}" data-element_text="{{__('Bhabhi Ke Pyare Pritam Hamare') }}">{{__('Bhabhi Ke Pyare Pritam Hamare') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('tv-shows/do-chutki-sindoor') }}" data-element_text="{{__('Do Chutki Sindoor') }}">{{__('Do Chutki Sindoor') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('tv-shows/beti-hamari-anmol') }}" data-element_text="{{__('Beti Hamari Anmol') }}">{{__('Beti Hamari Anmol') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('tv-shows/janani') }}" data-element_text="{{__('Janani') }}">{{__('Janani') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('tv-shows/hum-kadam') }}" data-element_text="{{__('Hum Kadam') }}">{{__('Hum Kadam') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('tv-shows/faraar-kab-tak') }}" data-element_text="{{__('Faraar Kab Tak') }}">{{__('Faraar Kab Tak') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('tv-shows/agni-vayu') }}" data-element_text="{{__('Agni Vayu') }}">{{__('Agni Vayu') }}</a>
                    </li>
                    <li>
                        <a onclick="click_menu(this)" data-event_context="footer"  href="{{ getUrl('movies') }}" data-element_text="{{__('Premium Movies')}}"><h3>{{__('Premium Movies')}}</h3></a>
                        <a onclick="click_menu(this)" data-event_context="footer"  href="{{ getUrl('movies/phir-hera-pheri') }}" data-element_text="{{__('Phir Hera Pheri')}}">{{__('Phir Hera Pheri')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer"  href="{{ getUrl('movies/jab-we-met') }}" data-element_text="{{__('Jab we met') }}">{{__('Jab we met') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer"  href="{{ getUrl('movies/queen') }}" data-element_text="{{__('Queen') }}">{{__('Queen') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer"  href="{{ getUrl('movies/piku') }}" data-element_text="{{__('Piku') }}">{{__('Piku') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer"  href="{{ getUrl('movies/gandhi') }}" data-element_text="{{__('Gandhi') }}">{{__('Gandhi') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer"  href="{{ getUrl('movies/guest-in-london') }}" data-element_text="{{__('Guest In London') }}">{{__('Guest In London') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer"  href="{{ getUrl('movies/aakrosh') }}" data-element_text="{{__('Aakrosh') }}">{{__('Aakrosh') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer"  href="{{ getUrl('movies/aarakshan') }}" data-element_text="{{__('Aarakshan') }}">{{__('Aarakshan') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer"  href="{{ getUrl('movies/chameli') }}" data-element_text="{{__('Chameli') }}">{{__('Chameli') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer"  href="{{ getUrl('movies/firangi') }}" data-element_text="{{__('Firangi') }}">{{__('Firangi') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer"  href="{{ getUrl('movies/bhagam-bhag') }}" data-element_text="{{__('Bhagam Bagh') }}">{{__('Bhagam Bagh') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer"  href="{{ getUrl('movies/awara-paagal-deewana') }}" data-element_text="{{__('Awara Pagal Deewana') }}">{{__('Awara Pagal Deewana') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer"  href="{{ getUrl('movies/dhamaal') }}" data-element_text="{{__('Dhamaal') }}">{{__('Dhamaal') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer"  href="{{ getUrl('movies/gangs-of-wasseypur-1') }}" data-element_text="{{__('Gangs Of Wasseypur 1') }}">{{__('Gangs Of Wasseypur 1') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer"  href="{{ getUrl('movies/fida') }}" data-element_text="{{__('Fida') }}">{{__('Fida') }}</a>
                        <a onclick="click_menu(this)" data-event_context="footer"  href="{{ getUrl('movies/jaan-e-mann') }}" data-element_text="{{__('Jaan-E-Mann') }}">{{__('Jaan-E-Mann') }}</a>
                    </li>
                    <li>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('live-tv') }}" data-element_text="{{__('Top LIVE Channels')}}"><h3>{{__('Top LIVE Channels')}}</h3></a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('live-tv/ishara-live-tv') }}" data-element_text="{{__('Ishara')}}">{{__('Ishara')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('live-tv/nazara-live-tv') }}" data-element_text="{{__('Nazara')}}">{{__('Nazara')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('live-tv/filamchi-live-tv') }}" data-element_text="{{__('Filamchi')}}">{{__('Filamchi')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('live-tv/showbox-live-tv') }}" data-element_text="{{__('Show Box')}}">{{__('Show Box')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('live-tv/epic-on-live-tv') }}" data-element_text="{{__('Epic')}}">{{__('Epic')}}"</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('live-tv/gubbare-live-tv') }}" data-element_text="{{__('Gubbare')}}">{{__('Gubbare')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('distro-tv') }}" data-element_text="{{__('Dishtro')}}">{{__('Dishtro')}}</a>
                    </li>
                    <li>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('/') }}" data-element_text="{{__('Popular Originals')}}"><h3>{{__('Popular Originals')}}</h3></a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('tv-shows/tatlubaaz') }}" data-element_text="{{__('Tatlubaaz')}}">{{__('Tatlubaaz')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('tv-shows/video-cam-scam') }}" data-element_text="{{__('Video Cam Scam')}}">{{__('Video Cam Scam')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('tv-shows/family-table') }}" data-element_text="{{__('Family Table')}}">{{__('Family Table')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('tv-shows/plot-1-by-2') }}" data-element_text="{{__('Plot 1 by 2')}}">{{__('Plot 1 by 2')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('tv-shows/bluetick') }}" data-element_text="{{__('Bluetick')}}">{{__('Bluetick')}}</a>
                    </li>
                    <li>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('movies') }}" data-element_text="{{__('Top Bollywood Picks')}}"><h3>{{__('Top Bollywood Picks')}}</h3></a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('movies/gangs-of-wasseypur-1') }}" data-element_text="{{__('Gangs Of Wasseypur 1')}}">{{__('Gangs Of Wasseypur 1')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('movies/khatta-meetha') }}" data-element_text="{{__('Khatta Meetha')}}">{{__('Khatta Meetha')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('movies/alone') }}" data-element_text="{{__('Alone')}}">{{__('Alone')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('movies/shabd') }}" data-element_text="{{__('Shabd')}}">{{__('Shabd')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('movies/gangs-of-wasseypur-2') }}" data-element_text="{{__('Gangs Of Wasseypur 2')}}">{{__('Gangs Of Wasseypur 2')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('movies/piku') }}" data-element_text="{{__('Piku')}}">{{__('Piku')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('movies/queen') }}" data-element_text="{{__('Queen')}}">{{__('Queen')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('movies/phir-hera-pheri') }}" data-element_text="{{__('Phir Hera Pheri')}}">{{__('Phir Hera Pheri')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('movies/akaash-vani') }}" data-element_text="{{__('Akaash Vani')}}">{{__('Akaash Vani')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('movies/guest-in-london') }}" data-element_text="{{__('Guest In London')}}">{{__('Guest In London')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('movies/welcome') }}" data-element_text="{{__('Welcome')}}">{{__('Welcome')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('movies/dhol') }}" data-element_text="{{__('Dhol')}}">{{__('Dhol')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('movies/golmaal-fun-unlimited') }}" data-element_text="{{__('Golmaal - Fun Unlimited')}}">{{__('Golmaal - Fun Unlimited')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('movies/golmaal-returns') }}" data-element_text="{{__('Golmaal Returns')}}">{{__('Golmaal Returns')}}</a>
                    </li>
                    <li>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('distro-tv') }}" data-element_text="{{__('Dishtro Tv')}}"><h3>{{__('Dishtro Tv')}}</h3></a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('distro-tv/5202') }}" data-element_text="{{__('India News')}}">{{__('India News')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('distro-tv/2889') }}" data-element_text="{{__('ABP News')}}">{{__('ABP News')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('distro-tv/5199') }}" data-element_text="{{__('News Nation')}}">{{__('News Nation')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('distro-tv/5256') }}" data-element_text="{{__('Sudarshan News')}}">{{__('Sudarshan News')}}</a>
                    </li>
                    <li>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('distro-tv') }}" data-element_text="{{__('Live Sports')}}"><h3>{{__('Live Sports')}}</h3></a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('distro-tv/5246') }}" data-element_text="{{__('Sports TV plus')}}">{{__('Sports TV plus')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('distro-tv/1186') }}" data-element_text="{{__('Adventure Sports')}}">{{__('Adventure Sports')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('distro-tv/3166') }}" data-element_text="{{__('Skate surf snow')}}">{{__('Skate surf snow')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('distro-tv/661') }}" data-element_text="{{__('MMA Junkie')}}">{{__('MMA Junkie')}}</a>
                        <a onclick="click_menu(this)" data-event_context="footer" href="{{ getUrl('distro-tv/1239') }}" data-element_text="{{__('Sports grid')}}">{{__('Sports grid')}}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="w-100 text-center small text-white pt-3 pb-4 copy-right">
            Best viewed on Google Chrome 80+, Microsoft Edge 81+, Mozilla Firefox 75+, Safari 5.1.5+<br>
            Copyright © {{ date('Y') }} IN10 Media
            Private
            Limited. All Rights Reserved.</div>
    </div>
</div>

<!-- successfully logged  start-->
<div class="modal fade" id="successfully-loged" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered px-3">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <div class="successfully-loged w-100">
                        <img width="100" class="{{ @$subplan['status'] }}"
                            src="{{env('AWS_S3_domain')}}epicon/assets/images/success-tick.png" alt="">
                        <h4 class="text-center text-white mt-3">Awesome! You have successfully logged in to EPIC ON
                            {{ @$subplan_status }}
                        </h4>
                        @if(@$subplan['status'] != 'active')
                        <div class="no-subscription-user">
                            <input type="hidden" id="redi-val" value="">
                            <button class="no-active-subscription mt-4 mb-4">No Active Subscription</button>
                            <button class="login-btn subscription-btn mt-4 redi-subs" style="width: 280px;">
                                Buy Subscription
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                                        fill="#070707" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z"
                                        fill="#070707" />
                                </svg>
                            </button>
                            <button class="login-btn skip-btn mt-0 bg-transparent text-white">Skip for now</button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- successfully logged  start-->

    <?php
    $kids_page = isKidsPage();
   if ($kids_page) {
       $links = [
            [   'name'=>'Home',
                'url'=>'kids',
                'logoimg'=>'',
                'class'=>'home'
            ],
           [    'name'=>'Movies',
                'url'=>'kids/movies',
                'logoimg'=>'',
                'class'=>'home'
            ],
            [   'name'=>'Shows',
                'url'=>'kids/shows',
                'logoimg'=>'',
                'class'=>'home'
                    ],
            [   'name'=>'Podcasts',
                'url'=>'kids/podcast',
                'logoimg'=>'',
                'class'=>'home'
            ],
            [   'name'=>'Games',
                'url'=>'kids/games',
                'logoimg'=>'',
                'class'=>'home'
            ],
       ];
       $current_route = request()->path();
       $kidsClass = "kids";
   } else {
       $links = [
         [  'name'=>'Home',
            'url'=>'',
            'logoimg'=>'',
            'class'=>'home'
         ],
         [ 'name'=>'Premium',
         'url'=>'premium',
         'logoimg'=>'',
         'class'=>'premium'
          ],

         [  'name'=>'Explore',
            'url'=>'explore',
            'logoimg'=>'',
            'class'=>'explore'
         ],

         [  'name'=>'Search',
            'url'=>'search',
            'logoimg'=>'',
            'class'=>'search'
         ],
         [  'name'=>'Hot & New',
            'url'=>'spotlight',
            'logoimg'=>'',
            'class'=>'spotlight'
         ],
    ];
       $current_route = getFirstSegment();
       $kidsClass = "";
   }

?>
    <div class="footer-mobile {{$kidsClass}}">
        <nav class="mob-nav">
        @foreach ($links as $key => $value)

            <a class="footer-{{@$value['class']}} {{ $current_route == @$value['url'] ? 'active' : '' }}" href="{{getUrl(@$value['url'])}}">
                <p></p>
                <span>{{@$value['name']}}</span>
            </a>

        @endforeach
        </nav>
    </div>
@endif
@notloggedin
    @include('auth.login-reg-popup')
@endnotloggedin
