@extends('layouts.default')
@section('title', @$content['title'])

@section('style')
<link type="text/css" rel="stylesheet" href="{{ asset('assets/css/socialSharing.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    li.pod-main.episode-active {
        background: linear-gradient(270deg, #342857 0%, #232342 47.92%, #201F31 100%);
    }

    .episode-active .progress-main {
        display: block !important;
    }
    .hide {
        display: none;
    }
</style>
@stop

@section('content')
<input type="hidden" id="cont_id" value="{{ $content['ID'] }}">

<?php
$cover_img = getCardImage($content, 'cover_image', 'large');

$episode_list = [];
if (array_key_exists('season', $content)) {
    $seasons = $content['season'];
    // $season = is_array($seasons) && isset($seasons[0]) ? $seasons[0] : [];
    foreach ($seasons as $season) {
        $episode_list = array_merge($episode_list, getAllEpisodesFromSeason($season));
    }
// } else if (array_key_exists('episodes', $content)) {
    // $episode_list = getAllEpisodesFromSeason($content);
} else {
    if (array_key_exists('file_url_original', $content) && !empty($content['file_url_original'])) {
        $episode_list[] = $content['ID'];
    }
}
$episode_json = json_encode($episode_list);
?>
<?php
    $subplan = checkSubscription();
    if(isKidsPage()){
        $addClass = "allAccessBtn-sub";
    }else{
        $addClass = "subscription";
    }
        $watchClass = "";
        $watchid = "";
        $addToList = "";
        $href = "javascript:void(0);";

        if (!isUserLoggedIn()) {
            $watchClass = @$content['free_premium'] == true ? "login-with-subscription" : "";
            $watchid = @$content['free_premium'] != true ? "playButton" : "";
            $addToList = "login-with-subscription";
        } else {
            $addToList = "addToList";
            // for play Video 
            $watchClass = @$content['free_premium'] == true && @$subplan['status'] != 'active' ? $addClass : "";
            $watchid = @$content['free_premium'] != true || (@$content['free_premium'] == true && @$subplan['status'] == 'active') ? "playButton" : "";
        }

        $playBtn = $watchClass == "" ? "playBtn" : "";
?>

<div class="podcast-background w-100">
    <section class="container w-100 mt-2">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="podcast-top w-100 align-items-lg-start">
                    <div class="thumb">
                        {{-- <h6 class="pod-title">EPIC ON ORIGINAL</h6> --}}
                        {{-- <h5 class="pod-series">CASO.63</h5> --}}
                        {{-- <img src="{{ @$content['cover_image']['large'] }}" alt="thumb"> --}}
                        <img src="{{ $cover_img }}" alt="thumb">
                        <img class="podcast-top-icon" src="{{ asset('assets/img/podcast-top-icon.svg') }}" alt="podcast icon">
                    </div>
                    <input type="hidden" name="subUrl" class="subUrl" id="subUrl" value="{{ getUrl('subscription') }}">
                    <input type="hidden" name="sitemode" class="sitemode" id="sitemode" value="{{ $addClass }}">
                    <div class="thumb-detail text-white">
                        <h1>{{ @$content['title'] }}</h1>

                        {{-- <p class="with-whom">with Shailja Saraswati</p> --}}
                        <div class="drama">
                            <span>
                                @include('pages.detail.detail-components.sub-bullets', [
                                'v_content' => $content,
                                ])
                            </span>
                            <div class="d-flex">

                                @if (@$content['percentage_match'])
                                <button class="border-btn me-3 my-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path d="M16.2475 6.25104L13.7559 8.74271L11.2559 6.24271L13.7475 3.75104C14.0975 3.40104 14.5475 3.23438 14.9975 3.23438C15.4475 3.23438 15.8975 3.40104 16.2475 3.75104C16.9392 4.44271 16.9392 5.55937 16.2475 6.25104Z" fill="white" />
                                        <path d="M14.4255 8.07812L5.41719 17.0781C4.72552 17.7698 3.60885 17.7698 2.91719 17.0781C2.22552 16.3865 2.22552 15.2698 2.91719 14.5781L11.9255 5.57812L14.4255 8.07812Z" fill="#B04CF1" />
                                        <path d="M8.29274 2.91448L8.6344 1.75615C8.66774 1.64782 8.63441 1.53115 8.55941 1.44782C8.48441 1.36448 8.35107 1.33115 8.24274 1.36448L7.08441 1.70615L5.92607 1.36448C5.81774 1.33115 5.70107 1.36448 5.61774 1.43948C5.53441 1.52282 5.50941 1.63948 5.54274 1.74782L5.87607 2.91448L5.53441 4.07282C5.50107 4.18115 5.53441 4.29782 5.60941 4.38115C5.69274 4.46448 5.80941 4.48948 5.91774 4.45615L7.08441 4.12282L8.24274 4.46448C8.27607 4.47282 8.30107 4.48115 8.33441 4.48115C8.41774 4.48115 8.49274 4.44782 8.55941 4.38948C8.64274 4.30615 8.66774 4.18948 8.6344 4.08115L8.29274 2.91448Z" fill="#FFAC33" />
                                        <path d="M4.95875 7.91448L5.30042 6.75615C5.33375 6.64782 5.30042 6.53115 5.22542 6.44782C5.14209 6.36448 5.02542 6.33948 4.91709 6.37282L3.75042 6.70615L2.59209 6.36448C2.48375 6.33115 2.36709 6.36448 2.28375 6.43948C2.20042 6.52282 2.17542 6.63948 2.20875 6.74782L2.54209 7.91448L2.20042 9.07282C2.16709 9.18115 2.20042 9.29782 2.27542 9.38115C2.35875 9.46448 2.47542 9.48948 2.58375 9.45615L3.74209 9.11448L4.90042 9.45615C4.92542 9.46448 4.95875 9.46448 4.99209 9.46448C5.07542 9.46448 5.15042 9.43115 5.21709 9.37282C5.30042 9.28948 5.32542 9.17282 5.29209 9.06448L4.95875 7.91448Z" fill="#FFAC33" />
                                        <path d="M17.4591 12.0872L17.8007 10.9289C17.8341 10.8205 17.8007 10.7039 17.7257 10.6205C17.6424 10.5372 17.5257 10.5122 17.4174 10.5455L16.2591 10.8872L15.1007 10.5455C14.9924 10.5122 14.8757 10.5455 14.7924 10.6205C14.7091 10.7039 14.6841 10.8205 14.7174 10.9289L15.0591 12.0872L14.7174 13.2455C14.6841 13.3539 14.7174 13.4705 14.7924 13.5539C14.8757 13.6372 14.9924 13.6622 15.1007 13.6289L16.2591 13.2872L17.4174 13.6289C17.4424 13.6372 17.4757 13.6372 17.5091 13.6372C17.5924 13.6372 17.6674 13.6039 17.7341 13.5455C17.8174 13.4622 17.8424 13.3455 17.8091 13.2372L17.4591 12.0872Z" fill="#FFAC33" />
                                    </svg>
                                    {{ $content['percentage_match'] }}% match</button>
                                @endif
                                <button class="border-btn me-3 my-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <g clip-path="url(#clip0_474_11010)">
                                            <path d="M7.53006 5.50049C7.25662 5.0083 6.75818 4.11143 7.21912 3.51143C7.63006 2.97705 8.33318 3.14893 8.89881 3.73174L9.23006 4.09111C9.23006 4.09111 8.95037 3.06299 9.76756 2.7833C10.316 2.5958 10.7707 2.79424 11.5066 3.67705C12.8332 5.26768 15.6472 10.1224 15.6472 10.1224C15.7785 10.338 15.9082 10.5333 16.0035 10.5005C16.0801 10.4739 16.2879 9.70987 16.2879 9.70987C16.2722 8.65674 16.3488 7.4333 16.716 6.75986C17.0926 6.06924 17.7722 5.81924 18.2457 5.97236C18.6597 6.10674 18.8769 6.43174 18.7457 7.15361C18.6347 7.76612 18.6019 9.32393 18.7347 10.8442C18.841 12.0646 18.891 12.8583 18.8019 13.838C18.6316 15.6989 17.8957 17.5364 15.7769 18.6521C14.6066 19.2692 13.3519 19.3927 12.1847 19.2052C12.1832 19.2067 7.63631 5.69111 7.53006 5.50049Z" fill="#D69513" />
                                            <path d="M12.2684 8.49365C11.8356 7.5374 11.3418 6.80146 10.7981 5.96865C10.4106 5.3749 9.73089 4.37802 9.51996 3.87802C9.37464 3.53427 9.37777 3.25927 9.39652 3.1124C9.40121 3.08115 9.36058 3.06552 9.34183 3.09052C9.16996 3.33896 9.07933 3.74208 9.2559 4.1749C9.52621 4.83115 10.1075 5.66865 10.5012 6.27021C11.0762 7.1499 11.4778 7.79052 11.845 8.6749L12.445 9.12802C12.4465 9.12958 12.4293 8.85146 12.2684 8.49365Z" fill="#FFB300" />
                                            <path d="M8.34561 18.4946C7.92686 18.2258 6.82843 17.404 5.64874 16.1196C3.89874 14.2133 3.0503 12.2446 2.69405 11.5055C2.35186 10.7946 2.26749 9.95083 2.67686 9.66177C3.1378 9.33677 3.56593 9.66333 3.56593 9.66333C3.16905 9.04302 2.91124 8.43208 2.84405 7.93677C2.75186 7.24614 3.17218 6.92583 3.24874 6.88364C3.61124 6.68364 3.93936 6.93989 3.93936 6.93989C3.93936 6.93989 3.50655 6.33208 3.39561 5.68208C3.32686 5.28208 3.47686 4.86958 3.81593 4.63521C4.24561 4.33989 4.65186 4.42583 5.28624 4.98521L5.54405 5.18208C5.54405 5.18208 5.4253 4.84927 5.42374 4.49771C5.42218 4.17739 5.5753 3.81802 5.9503 3.67271C6.43311 3.48521 6.80186 3.60864 7.46436 4.29302C8.05811 4.90708 10.0316 6.94302 11.3909 8.04302C12.3487 8.81958 13.4112 9.59302 13.9612 9.92114C14.1362 10.0258 14.2847 9.88677 14.2362 9.63989C13.9347 8.11646 13.8175 6.94146 14.105 6.05239C14.3925 5.16177 14.9409 4.67583 15.5581 4.72427C15.8487 4.74771 16.1378 4.92114 16.2628 5.25864C16.3737 5.56177 16.3769 6.06646 16.3909 6.38677C16.4409 7.62583 17.4628 11.1821 17.6722 12.1602C18.0722 14.0165 17.9159 16.0227 16.1987 17.7477C13.8972 20.0665 10.2378 19.7071 8.34561 18.4946Z" fill="#FFCA28" />
                                            <path d="M6.93773 14.2625C6.87367 14.4797 6.75492 14.7234 6.58929 14.5844C6.36273 14.3938 6.39398 14.1984 6.14085 13.9375C5.41273 13.1859 4.06117 11.2469 3.75023 10.4719C3.53617 9.9375 3.56585 9.65938 3.56585 9.65938C3.56585 9.65938 5.32679 12.3625 6.91742 13.8422C7.05804 13.9734 6.94554 14.2375 6.93773 14.2625ZM7.88148 12.4641C7.64554 12.3734 7.5971 12.0094 7.4221 11.8406C6.56429 11.0188 4.7221 8.75313 4.17367 7.70313C3.95023 7.27344 3.9471 7.07344 3.93148 6.92656C3.93148 6.92656 6.51273 10.1578 7.88929 11.4125C7.97679 11.4922 8.25179 11.5813 8.31117 11.7125C8.42523 11.9656 8.0721 12.5359 7.88148 12.4641ZM9.71898 9.66875C8.25335 8.44375 5.51429 5.16406 5.51429 5.16406C5.51429 5.16406 5.57054 5.625 5.8971 6.12969C6.46429 7.00938 8.1096 9.05 9.20804 10.0875C9.41898 10.2875 9.40648 10.5328 9.62992 10.5516C9.86898 10.5719 10.1596 10.2891 10.1752 10.0734C10.1893 9.88906 9.96273 9.87188 9.71898 9.66875Z" fill="#D69513" />
                                            <path d="M0.78125 14.6688L2.77813 14.5266M4.75469 16.9344L4.1 18.8266M0.984375 17.6953L3.5875 15.8688M18.9016 2.89844L17.3594 4.175M14.3516 3.36563L13.7844 1.44531M16.975 0.554688L15.9203 3.55313" stroke="#B0BEC5" stroke-width="0.625" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M16.9414 8.93437C16.757 8.18281 16.5727 7.36094 16.5133 6.80469C16.4664 6.36563 16.4367 5.65312 16.3945 5.49687C16.2461 4.93437 15.9195 4.83594 15.9195 4.83594C15.9195 4.83594 16.1258 5.05313 16.1305 5.65469C16.1352 6.29219 16.1539 7.54063 16.5195 8.92188C16.7602 9.83125 17.1508 11.1406 17.3289 12.1875C17.7055 14.3922 17.3617 15.9438 16.0445 17.5781C15.2805 18.525 13.6289 19.2234 13.6289 19.2234C13.6289 19.2234 14.9867 19.1375 16.1727 17.9969C17.7477 16.4812 18.318 14.5156 17.8117 12.1594C17.6398 11.3609 17.0008 9.17812 16.9414 8.93437Z" fill="#D69513" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_474_11010">
                                                <rect width="20" height="20" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>&nbsp;&nbsp;
                                    <span class="claps_num">{{ countConvert(@$content['claps']) }}</span></button>

                                @if (@$content['is_popular'])
                                <button class="border-btn my-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path d="M16.2498 12.0869C16.2498 15.8994 13.0935 18.965 9.28102 18.7375C5.3629 18.5037 2.68102 14.7356 3.18602 10.7969C3.49165 8.40123 4.61478 6.34685 5.83728 4.7531C6.04978 4.47498 6.2679 6.7131 6.48603 6.46685C6.70478 6.21373 8.73228 2.70498 9.43727 1.47248C9.46759 1.41811 9.50926 1.37091 9.55944 1.33408C9.60962 1.29725 9.66714 1.27165 9.72809 1.25902C9.78904 1.24639 9.852 1.24703 9.91268 1.26089C9.97336 1.27475 10.0304 1.30151 10.0798 1.33935C11.496 2.4081 16.2498 6.42248 16.2498 12.0869Z" fill="#FF6723" />
                                        <path d="M14.3752 13.6569C14.3752 16.1831 12.1758 18.2138 9.50085 18.1219C6.61335 18.0244 4.63335 15.3819 5.0571 12.66C5.66897 8.7575 9.67522 6.25 9.67522 6.25C9.67522 6.25 14.3752 9.19188 14.3752 13.6569Z" fill="#FFB02E" />
                                    </svg>
                                    {{__('Most Popular')}}
                                </button>
                                @endif
                            </div>
                        </div>
                        <div class="seemore">
                        <p class="pod-detail-text mt-3 descText mb-0">{!! sanitizeData(@$content['description']) !!}</p>
                        <?php //echo strlen(@$content['description']); exit; ?>
                        <span class="read-button d-block mb-3"> </span>
                        </div>
                        <div class="podcast-btns d-flex align-items-center" data-id="{{ @$content['ID'] }}">
                            <div class="pod-btns">
                                <button class="fill-btn ms-0 mt-0 {{$watchClass}}" id="{{ $watchid }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="29" height="28" viewBox="0 0 29 28" fill="none">
                                        <path d="M26.75 14.0005C26.7507 14.2976 26.6745 14.5899 26.5289 14.8488C26.3832 15.1077 26.173 15.3246 25.9188 15.4782L10.16 25.1185C9.89431 25.2812 9.59001 25.37 9.27852 25.3758C8.96703 25.3816 8.65965 25.3041 8.38813 25.1513C8.11918 25.001 7.89515 24.7817 7.73905 24.516C7.58296 24.2503 7.50045 23.9479 7.5 23.6398V4.36133C7.50045 4.0532 7.58296 3.75076 7.73905 3.48509C7.89515 3.21943 8.11918 3.00014 8.38813 2.84976C8.65965 2.69702 8.96703 2.61953 9.27852 2.6253C9.59001 2.63107 9.89431 2.71989 10.16 2.88258L25.9188 12.5229C26.173 12.6765 26.3832 12.8934 26.5289 13.1523C26.6745 13.4112 26.7507 13.7035 26.75 14.0005Z" fill="#272727" />
                                    </svg> &nbsp;
                                    Listen
                                </button>
                           
                                @if (@$content['free_premium'] == true && !isActiveSubscription())
                                <a href="{{ $href }}" class="subcription-btn m-0 {{$watchClass}}">
                                    <img src="{{ asset('assets/img/crown.svg') }}" alt="crown"> Subscribe Now
                                    </a>
                                @endif
                            </div>

                            <?php
                            $wishlist = getWishlist();

                            $wishlist_ids = $wishlist['ids'] ?? [];

                            $wishAction = in_array($content['ID'], $wishlist_ids) ? 'delete' : 'add';

                            $share_title = @$content['title'];
                            if ($content['content_type'] == 'SEASON') {
                                $share_title = @$content['parent_name'] . ' - ' . @$content['title'];
                            }
                            ?>

                            <button class="rounded-grey-btn m-0 addToList" data-id="{{ $content['ID'] }}" data-action="{{ $wishAction }}" data-type="3">
                                <img class="wl_add" src="{{ asset('assets/img/add-icon.svg') }}" alt="icon" @if ($wishAction=='delete' ) style="display: none" @endif>
                                <img class="wl_remove" src="{{ asset('assets/img/subs-icon.svg') }}" alt="icon" @if ($wishAction=='add' ) style="display: none" @endif>
                            </button>

                            <button class="rounded-grey-btn m-0 clapButton" data-id="{{ @$content['ID'] }}">
                                <img src="{{ asset('assets/img/clap-icon.svg') }}" alt="icon">
                            </button>
                            <button class="rounded-grey-btn shareThis" data-url="{{ getContentUrl($content) }}" data-title="{{ $share_title }}">
                                <img src="{{ asset('assets/img/share-icon.svg') }}" alt="icon">
                            </button>
                        </div>

                        


                    </div>
                </div>
            </div>

        </div>
    </section>
    {{-- @if (@$content['free_premium'] == false || (@$content['free_premium'] == true && isActiveSubscription())) --}}
    @include('pages.detail.detail-components.tabs')
    {{-- @endif --}}

</div>

<div class="podcast-bottom-player">
    <div class="container m-auto">
        <div class="podcast-wrapper-main">
            <div class="pod-cast-wrapper d-flex">
                <div class="pod-main">
                    <div class="pik position-relative">
                        <a href="{{asset('podcast/rahim-ke-dohe/season-1/introduction')}}" class="pik-img">
                            <img src="{{ $cover_img }}" alt="img">
                        </a>
                        <img class="podcast-top-icon" src="{{asset('assets/img/podcast-top-icon.svg')}}" alt="podcast icon">
                    </div>
                </div>
                <div class="pod-pik-detals d-flex align-items-center w-100">
                    <div class="w-100">
                        <h5>{{ @$content['title'] }}</h5>
                        @if (count($episode_list) > 0) {{-- && (@$content['free_premium'] == false || (@$content['free_premium'] == true && isActiveSubscription()))) --}}
                        
                        <div class="audio-player">
                            <audio id="audioPlayer" w-100 controls>
                                <source id="audioSource" src="" type="audio/mpeg">
                            </audio>
                            {{-- <div id="episodeControls">
                                @if (count($episode_list) > 1)
                                <button id="prevEpisode1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 54 54" fill="none">
                                        <path d="M9.96423 43.7151C9.96423 44.1413 9.79491 44.5501 9.49351 44.8515C9.19211 45.1529 8.78333 45.3222 8.35709 45.3222C7.93085 45.3222 7.52207 45.1529 7.22067 44.8515C6.91927 44.5501 6.74995 44.1413 6.74995 43.7151L6.74995 8.35798C6.74995 7.93173 6.91927 7.52295 7.22067 7.22155C7.52207 6.92016 7.93085 6.75083 8.35709 6.75083C8.78333 6.75083 9.19212 6.92016 9.49351 7.22155C9.79491 7.52295 9.96423 7.93173 9.96423 8.35798L9.96423 43.7151ZM45.3262 41.298C45.3262 44.5155 41.7326 46.428 39.0631 44.6296L16.5583 29.471C16.0146 29.1044 15.5688 28.6103 15.26 28.0318C14.9511 27.4533 14.7886 26.808 14.7865 26.1522C14.7844 25.4964 14.9429 24.85 15.2481 24.2696C15.5533 23.6892 15.996 23.1923 16.5374 22.8223L39.0423 7.45798C41.7101 5.6387 45.3262 7.54798 45.3262 10.7783L45.3262 41.2947L45.3262 41.298ZM40.8583 41.9633C40.9792 42.045 41.1199 42.0922 41.2656 42.1C41.4112 42.1078 41.5562 42.0757 41.6851 42.0073C41.8139 41.939 41.9217 41.8368 41.9969 41.7119C42.0721 41.5869 42.1118 41.4438 42.1119 41.298L42.1119 10.7751C42.1116 10.629 42.0716 10.4858 41.996 10.3608C41.9204 10.2357 41.8121 10.1337 41.6829 10.0656C41.5536 9.99751 41.4083 9.96594 41.2624 9.97429C41.1166 9.98263 40.9757 10.0306 40.8551 10.113L18.3503 25.4756C18.2418 25.5495 18.153 25.6489 18.0917 25.765C18.0305 25.8812 17.9986 26.0106 17.9989 26.1419C17.9992 26.2732 18.0317 26.4024 18.0935 26.5182C18.1554 26.6341 18.2446 26.733 18.3535 26.8064L40.8583 41.9633Z" fill="black"/>
                                    </svg>
                                </button>
                                <button id="nextEpisode1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 88 88" fill="none">
                                        <path d="M19.7656 72.9475V15.6493C19.7656 14.1599 21.4099 13.2573 22.6665 14.0569L67.6865 42.706C68.852 43.4477 68.852 45.1491 67.6865 45.8909L22.6665 74.5399C21.4099 75.3396 19.7656 74.4369 19.7656 72.9475Z" fill="black" stroke="black" stroke-width="3.775" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>  
                                </button>
                                @endif
                               <!--  <button id="playButton1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 54 54" fill="none">
                                        <path d="M42.1119 8.35717C42.1119 7.93093 42.2813 7.52214 42.5827 7.22075C42.8841 6.91935 43.2928 6.75002 43.7191 6.75002C44.1453 6.75002 44.5541 6.91935 44.8555 7.22075C45.1569 7.52214 45.3262 7.93093 45.3262 8.35717V43.7143C45.3262 44.1405 45.1569 44.5493 44.8555 44.8507C44.5541 45.1521 44.1453 45.3214 43.7191 45.3214C43.2928 45.3214 42.8841 45.1521 42.5827 44.8507C42.2813 44.5493 42.1119 44.1405 42.1119 43.7143V8.35717ZM6.75 10.7743C6.75 7.55681 10.3436 5.64431 13.013 7.4427L35.5178 22.6013C36.0616 22.9679 36.5074 23.462 36.8162 24.0405C37.1251 24.619 37.2876 25.2643 37.2897 25.9201C37.2917 26.5759 37.1332 27.2222 36.828 27.8027C36.5228 28.3831 36.0802 28.88 35.5387 29.25L13.0339 44.6143C10.3661 46.4336 6.75 44.5243 6.75 41.2939V10.7775V10.7743ZM11.2179 10.109C11.097 10.0273 10.9562 9.98003 10.8106 9.97227C10.665 9.96451 10.5199 9.99654 10.3911 10.0649C10.2623 10.1333 10.1545 10.2354 10.0793 10.3604C10.0041 10.4854 9.96436 10.6285 9.96428 10.7743V41.2971C9.96454 41.4432 10.0046 41.5865 10.0802 41.7115C10.1558 41.8365 10.264 41.9386 10.3933 42.0067C10.5225 42.0748 10.6679 42.1063 10.8138 42.098C10.9596 42.0896 11.1004 42.0417 11.2211 41.9593L33.7259 26.5966C33.8344 26.5227 33.9232 26.4234 33.9845 26.3072C34.0457 26.1911 34.0776 26.0617 34.0773 25.9304C34.0769 25.7991 34.0445 25.6699 33.9826 25.554C33.9208 25.4382 33.8316 25.3393 33.7227 25.2659L11.2179 10.109Z" fill="black"/>
                                    </svg>
                                </button>
                                <button id="pauseButton1" style="display: none;">pause</button> -->
                                <button id="volumeUpButton"><i class='fa fa-volume-up'></i></button>
                                <button id="volumeDownButton">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 54 54" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M30.9494 7.19104C31.6351 7.51334 32.0713 8.19149 32.0713 8.9355V45.0645C32.0713 45.8085 31.6351 46.4867 30.9494 46.809C30.2636 47.1313 29.4496 47.0406 28.8555 46.5759L16.2022 36.6774H8.97931C7.88617 36.6774 7 35.8109 7 34.7419V19.2581C7 18.1891 7.88617 17.3226 8.97931 17.3226H16.2022L28.8555 7.42414C29.4496 6.95936 30.2636 6.86875 30.9494 7.19104ZM28.1126 12.9625L18.133 20.7694C17.7821 21.044 17.346 21.1936 16.8966 21.1936H10.9586V32.8064H16.8966C17.346 32.8064 17.7821 32.956 18.133 33.2306L28.1126 41.0375V12.9625Z" fill="black"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M39.2487 15.3088C40.0217 14.553 41.2749 14.553 42.0479 15.3089C45.2187 18.4096 47 22.615 47 27C47 31.385 45.2187 35.5904 42.0479 38.6911C41.2749 39.447 40.0217 39.447 39.2487 38.6912C38.4757 37.9354 38.4757 36.7099 39.2487 35.954C41.6771 33.5792 43.0414 30.3584 43.0414 27C43.0414 23.6416 41.6771 20.4208 39.2487 18.046C38.4757 17.2901 38.4757 16.0646 39.2487 15.3088Z" fill="black"/>
                                    </svg>
                                </button>
                            </div> --}}
                        </div>
                        @endif
                        <!-- <div class="podcast-bottom-progress d-flex">
                            <span class="me-3">05:00</span>
                            <div class="progress-main">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <span class="ms-3">30:08</span>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="podcast-controls">
                <div class="controll-inner">
                    <button class="tenx-prev">
                        <img src="{{asset('img/10x-prev.svg')}}" alt="icons">
                    </button>
                    <button class="podcast-play"  style="display:none">
                        <img src="{{asset('img/podcast-play.svg')}}" alt="icons">
                    </button>
                    <button class="podcast-pause" >
                        <img src="{{asset('img/podcast-pause.svg')}}" alt="icons">
                    </button>
                    <button class="tenx-next" >
                        <img src="{{asset('img/10x-next.svg')}}" alt="icons">
                    </button>
                   <!--  <button class="wl_add">
                        <img src="{{asset('img/podcast-add.svg')}}" alt="icons">
                    </button> -->
                      <button class="tenx-next m-0 addToList" data-id="{{ $content['ID'] }}" data-action="{{ $wishAction }}">
                        <img class="wl_add" src="{{ asset('img/podcast-add.svg') }}" alt="icon" @if ($wishAction=='delete' ) style="display: none" @endif>
                        <img class="wl_remove" src="{{ asset('/img/bottom-podcast-add.svg') }}" alt="icon" @if ($wishAction=='add' ) style="display: none" @endif>
                    </button>
                </div>
                <button class="podcast-close">
                    <img src="{{asset('img/podcast-close.svg')}}" alt="icons">
                </button>
            </div>
        </div>
    </div>
</div>

@include('components.share-modal')


@stop

@section('script')
<script src="{{ asset('assets/js/homepage.js') }}"></script>
<script src="{{ asset('assets/js/detail.js') }}"></script>

<script src="{{ asset('assets/js/socialSharing.js') }}"></script>

<script src="{{ asset('assets/js/common.js') }}"></script>
<script>
    // List of episode URLs
    var episodes = <?php echo $episode_json; ?>;
    var currentEpisodeIndex = 0;
    var audio = $("#audioPlayer")[0]; // Get the native audio element
    var isPlayed = false;

    $(".pod-main").hover(function() {
        $(this).addClass("active"); //Add the active class to the area is hovered
    }, function() {
        $(this).removeClass("active");
    });

    $(document).ready(function() {
        // playCurrentEpisode();
        if ($("#audioPlayer").length) {
            audio.volume = 0.25; // Set default volume 25%
        }

        // Next episode button click handler
        $("#nextEpisode,.tenx-next").click(function() {
            currentEpisodeIndex++;
            if (currentEpisodeIndex >= episodes.length) {
                currentEpisodeIndex = 0; // Loop back to the first episode
            }
            playCurrentEpisode();
        });

        // Previous episode button click handler
        $("#prevEpisode,.tenx-prev").click(function() {
            currentEpisodeIndex--;
            if (currentEpisodeIndex < 0) {
                currentEpisodeIndex = episodes.length - 1; // Loop to the last episode
            }
            playCurrentEpisode();
        });

        $("#playButton,.podcast-pause").click(function() {
            $('.podcast-bottom-player').show();
            $(".podcast-pause").hide();
            $('.podcast-play').show();
            isPlayed = true;
            if (audio.currentSrc == '') {
                playCurrentEpisode();
                return false;
            }
            audio.load();
            audio.play().then(() => {
                    console.log('Audio is playing');
                    audioEvents();
                })
                .catch(error => {
                    console.error('Failed to play audio:', error);
                });
            $("#pauseButton").show();            
            $(this).hide();
        });

        $("#pauseButton,.podcast-play").click(function() {
             audio.pause();
             $('.podcast-play').hide();
             $(".podcast-pause").show();
            $("#playButton").show();            
            $(this).hide();
        });

        $("#volumeUpButton").click(function() {
            if (audio.volume < 0.95) {
                audio.volume += 0.05; // Increase volume by 5%
            } else {
                audio.volume = 1;
            }

        });

        $("#volumeDownButton").click(function() {
            if (audio.volume >= 0.06) {
                audio.volume -= 0.05; // Decrease volume by 5%
            } else {
                audio.volume = 0;
            }
        });

        $('.playBtn').click(function() {
            $('.podcast-bottom-player').show();
            isPlayed = true;
            if (episodes == "") {
                var data_url = $(this).attr("data-url");
                if (data_url != "") {
                    window.location.href = data_url;
                }
            } else {
                let episodeID = $(this).attr("data-id");
                currentEpisodeIndex = $.inArray(parseInt(episodeID), episodes) == -1 ? 0 : $.inArray(parseInt(episodeID), episodes);
                playCurrentEpisode();
            }
        })
    });

    // Function to load and play the current episode
    function playCurrentEpisode() {
        $("li.pod-main").removeClass('episode-active');
        let cid = episodes[currentEpisodeIndex];
        if (cid) {
            let requestData = {
                cid: cid
            };

            sendAjaxRequest(APP_URL + '/player', 'POST', JSON.stringify(requestData),
                onPlayerSuccess, onPlayerError, 'application/json');
        }
    }
    async function onPlayerSuccess(response) {
        console.log('response: ', response);
        var audio_url = response.payload.promo_url != "" ? response.payload.promo_url : response.payload.video_url;
        $("#audioSource").attr("src", audio_url);
        let episodeID = episodes[currentEpisodeIndex];
        audio.load();
        console.log("audio is loading")
        if (isPlayed) {
            audio.play().then(() => {
                    console.log('Audio is playing');
                    // $('html, body').animate({
                    //     scrollTop: 0
                    // }, 1000);
                    audioEvents();
                })
                .catch(error => {
                    console.error('Failed to play audio:', error);
                });
        }
        $("li.pod-main[data-id='" + episodeID + "']").addClass('episode-active');

    }

    async function onPlayerError(xhr) {
        var siteMode = $(".sitemode").val();
        try {
            $res = JSON.parse(xhr.responseText);
            if ($res.message != undefined && $res.message != 'failed') {
                //showToaster($res.message, 2);
                /*if(siteMode == 'allAccessBtn-sub'){
                    $(".allAccessBtn-sub").trigger('click');
                }else{
                    $(".subscription").trigger('click'); 
                }*/
                
            }
        } catch (err) {}
    }

    $('.podcast-close').click(function(){    
        audio.pause();
        $('.podcast-bottom-player').hide();
    });

    function podcastProgress() {
        let episodeID = episodes[currentEpisodeIndex];
        let duration = audio.duration;
        let currentTime = audio.currentTime;
        let progress = Math.round((currentTime / duration) * 100) + "%";
        $("li.pod-main[data-id='" + episodeID + "'] .progress-bar").css("width", progress);
        $('.podcast-bottom-player .progress-bar').css("width", progress);
    }

    function audioEvents() {
        audio.addEventListener("timeupdate", podcastProgress);
        // audio.addEventListener("ended", function() {
        //     console.log("currentEpisodeIndex: "+currentEpisodeIndex);
        //     $("#nextEpisode").trigger('click');
        // });
    }
</script>
@stop