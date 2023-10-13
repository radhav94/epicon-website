<?php
if (session()->has('displayLanguage') && session('displayLanguage') != 'en') {
    $segment = Request::segment(2);
} else {
    $segment = Request::segment(1);
}
$kids_page = $segment == 'kids' ? true : false;

$action = app('request')->route()->getAction();
$subplan = checkSubscription();
//print_r($action);
//session()->flush();
if (isUserLoggedIn()) {
    $profile = getProfileData();
}
?>
<!-- Side Menu Start-->
<div class="side-menu-main" id="side-menu">
    <div class="side-menu">
        <div class="main-header-left d-flex ps-3 pt-4">
            <a href="#" class="menu-close me-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 32 32" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M25.1334 8.60204C25.2474 8.48816 25.3379 8.35293 25.3997 8.20408C25.4614 8.05524 25.4933 7.89568 25.4934 7.73453C25.4935 7.57338 25.4618 7.41378 25.4003 7.26486C25.3387 7.11593 25.2484 6.9806 25.1345 6.86657C25.0206 6.75255 24.8854 6.66208 24.7365 6.60031C24.5877 6.53855 24.4281 6.50671 24.267 6.50661C24.1058 6.50651 23.9462 6.53816 23.7973 6.59974C23.6484 6.66132 23.513 6.75162 23.399 6.86551L15.9985 14.266L8.60009 6.86551C8.36981 6.63523 8.05748 6.50586 7.73182 6.50586C7.40616 6.50586 7.09383 6.63523 6.86355 6.86551C6.63328 7.09579 6.50391 7.40811 6.50391 7.73377C6.50391 8.05944 6.63328 8.37176 6.86355 8.60204L14.2641 16.0004L6.86355 23.3988C6.74953 23.5129 6.65908 23.6482 6.59738 23.7972C6.53567 23.9462 6.50391 24.1059 6.50391 24.2671C6.50391 24.4284 6.53567 24.588 6.59738 24.737C6.65908 24.886 6.74953 25.0213 6.86355 25.1354C7.09383 25.3657 7.40616 25.495 7.73182 25.495C7.89307 25.495 8.05275 25.4633 8.20172 25.4015C8.3507 25.3398 8.48607 25.2494 8.60009 25.1354L15.9985 17.7348L23.399 25.1354C23.6293 25.3654 23.9415 25.4945 24.267 25.4943C24.5924 25.4941 24.9045 25.3646 25.1345 25.1343C25.3645 24.904 25.4936 24.5918 25.4934 24.2664C25.4932 23.9409 25.3637 23.6288 25.1334 23.3988L17.7329 16.0004L25.1334 8.60204Z"
                        fill="white" />
                </svg>
            </a>
            <a class="navbar-brand me-3" href="{{ getUrlWithPrefix('homepage') }}"><img height="28"
                    src="{{ asset('assets/img/epicon-logo.png') }}" alt=""></a>

                @if(@$subplan['status'] != 'active')
                <a class="subscribe-btn" href="#">{{__('Subscribe')}}</a>
            @endif
        </div>
        <ul class="ps-3">
            <li>
                <a href="{{ getUrl($kids_page ? '/kids/games' : 'games') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 32 32"
                        fill="none">
                        <path
                            d="M20.5689 5.3335C23.3671 5.33213 26.0538 6.43038 28.0498 8.39148C30.0458 10.3526 31.1912 13.0195 31.2392 15.8173C31.2872 18.6151 30.2338 21.3197 28.3062 23.3481C26.3786 25.3764 23.7312 26.5662 20.9346 26.6607L20.5689 26.6668H11.4321C8.63392 26.6682 5.94724 25.5699 3.95124 23.6088C1.95525 21.6477 0.8098 18.9808 0.761824 16.183C0.713848 13.3853 1.76719 10.6806 3.69477 8.65226C5.62236 6.62388 8.26981 5.43417 11.0664 5.33959L11.4306 5.3335H20.5674H20.5689ZM20.5689 6.96489H11.4306C9.23395 6.96025 6.61533 8.41642 5.04491 9.95235C3.47449 11.4883 2.6854 13.615 2.64126 15.8112C2.59712 18.0075 3.32715 20.1625 4.83459 21.7603C6.34203 23.3581 8.85306 24.9155 11.0481 24.9991L11.3849 25.0052H20.5689C22.7655 25.0098 25.5881 23.5366 27.1585 22.0006C28.7289 20.4647 29.4579 18.1933 29.502 15.9971C29.5462 13.8009 28.9063 11.7304 27.3989 10.1326C25.8914 8.53483 23.1007 7.05462 20.9056 6.97098L20.5689 6.96489ZM9.90527 11.4287C10.2084 11.4287 10.4991 11.5491 10.7134 11.7635C10.9277 11.9778 11.0481 12.2685 11.0481 12.5716V14.8543H13.3338C13.6369 14.8543 13.9276 14.9747 14.142 15.189C14.3563 15.4033 14.4767 15.694 14.4767 15.9971C14.4767 16.3002 14.3563 16.5909 14.142 16.8052C13.9276 17.0196 13.6369 17.14 13.3338 17.14H11.0481V19.4287C11.0481 19.7318 10.9277 20.0225 10.7134 20.2369C10.4991 20.4512 10.2084 20.5716 9.90527 20.5716C9.60216 20.5716 9.31147 20.4512 9.09715 20.2369C8.88282 20.0225 8.76241 19.7318 8.76241 19.4287V17.14H6.4767C6.32661 17.14 6.178 17.1104 6.03934 17.053C5.90069 16.9955 5.7747 16.9114 5.66857 16.8052C5.56245 16.6991 5.47827 16.5731 5.42083 16.4345C5.3634 16.2958 5.33384 16.1472 5.33384 15.9971C5.33384 15.847 5.3634 15.6984 5.42083 15.5598C5.47827 15.4211 5.56245 15.2951 5.66857 15.189C5.7747 15.0829 5.90069 14.9987 6.03934 14.9413C6.178 14.8838 6.32661 14.8543 6.4767 14.8543H8.76241V12.5716C8.76241 12.2685 8.88282 11.9778 9.09715 11.7635C9.31147 11.5491 9.60216 11.4287 9.90527 11.4287ZM20.191 16.7621C20.6962 16.7621 21.1806 16.9627 21.5378 17.32C21.8951 17.6772 22.0957 18.1617 22.0957 18.6668C22.0957 19.172 21.8951 19.6565 21.5378 20.0137C21.1806 20.3709 20.6962 20.5716 20.191 20.5716C19.6858 20.5716 19.2013 20.3709 18.8441 20.0137C18.4869 19.6565 18.2862 19.172 18.2862 18.6668C18.2862 18.1617 18.4869 17.6772 18.8441 17.32C19.2013 16.9627 19.6858 16.7621 20.191 16.7621ZM23.2386 11.4287C23.7438 11.4287 24.2283 11.6294 24.5855 11.9866C24.9427 12.3438 25.1434 12.8283 25.1434 13.3335C25.1434 13.8387 24.9427 14.3232 24.5855 14.6804C24.2283 15.0376 23.7438 15.2383 23.2386 15.2383C22.7334 15.2383 22.2489 15.0376 21.8917 14.6804C21.5345 14.3232 21.3338 13.8387 21.3338 13.3335C21.3338 12.8283 21.5345 12.3438 21.8917 11.9866C22.2489 11.6294 22.7334 11.4287 23.2386 11.4287Z"
                            fill="white" />
                    </svg>{{__('Games')}}
                </a>
            </li>
            <li>
                <a href="{{ getUrl('live-tv') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 32 32"
                        fill="none">
                        <path
                            d="M2.6665 26.6668V12.0002C2.6665 11.2929 2.94746 10.6146 3.44755 10.1145C3.94765 9.61445 4.62593 9.3335 5.33317 9.3335H26.6665C27.3737 9.3335 28.052 9.61445 28.5521 10.1145C29.0522 10.6146 29.3332 11.2929 29.3332 12.0002V26.6668C29.3332 27.3741 29.0522 28.0524 28.5521 28.5524C28.052 29.0525 27.3737 29.3335 26.6665 29.3335H5.33317C4.62593 29.3335 3.94765 29.0525 3.44755 28.5524C2.94746 28.0524 2.6665 27.3741 2.6665 26.6668Z"
                            stroke="white" stroke-width="1.5" />
                        <path d="M11.333 3.3335L15.9997 8.00016L20.6663 3.3335" stroke="white" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>{{__('Live TV')}}
                </a>
            </li>
            <li>
                <a href="{{ getUrl('upcoming-epicon') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 32 32"
                        fill="none">
                        <path d="M10.6665 2.6665V6.6665" stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M21.3335 2.6665V6.6665" stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M4.6665 12.1201H27.3332" stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M28 11.3332V22.6665C28 26.6665 26 29.3332 21.3333 29.3332H10.6667C6 29.3332 4 26.6665 4 22.6665V11.3332C4 7.33317 6 4.6665 10.6667 4.6665H21.3333C26 4.6665 28 7.33317 28 11.3332Z"
                            stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M15.9938 18.2668H16.0058" stroke="white" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M11.0592 18.2668H11.0712" stroke="white" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M11.0592 22.2668H11.0712" stroke="white" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>{{__('Upcoming on Epic On')}}
                </a>
            </li>
            <li>
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 32 32"
                        fill="none">
                        <path
                            d="M29.3332 19.9998V11.9998C29.3332 5.33317 26.6665 2.6665 19.9998 2.6665H11.9998C5.33317 2.6665 2.6665 5.33317 2.6665 11.9998V19.9998C2.6665 26.6665 5.33317 29.3332 11.9998 29.3332H19.9998C26.6665 29.3332 29.3332 26.6665 29.3332 19.9998Z"
                            stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M3.35986 9.47998H28.6399" stroke="white" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M11.3599 2.81348V9.29348" stroke="white" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M20.6401 2.81348V8.69348" stroke="white" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path
                            d="M13 19.2667V17.6667C13 15.6133 14.4533 14.7733 16.2267 15.8L17.6133 16.6L19 17.4C20.7733 18.4267 20.7733 20.1067 19 21.1333L17.6133 21.9333L16.2267 22.7333C14.4533 23.76 13 22.92 13 20.8667V19.2667V19.2667Z"
                            stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>{{__('Epic Shots')}}
                </a>
            </li>
            <li>
                <a href="{{ getUrl('new-popular') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 32 32"
                        fill="none">
                        <path
                            d="M16.3408 4.764C16.8444 4.50467 17.3758 4.30338 17.9248 4.164C17.9728 5.244 18.3088 6.312 18.7648 7.332C19.4128 8.774 20.3648 10.246 21.2928 11.672L21.4008 11.836C22.3108 13.23 23.2008 14.592 23.8768 15.96C24.5768 17.378 25.0068 18.718 25.0068 20C25.0068 22.306 24.3168 24.294 23.0228 25.696C21.7428 27.086 19.7748 28 17.0068 28C14.2128 28 12.2708 27.192 10.9148 25.95C9.5408 24.694 8.6708 22.904 8.19881 20.782C7.75481 18.786 8.14681 16.996 8.66881 15.682C8.75281 15.468 8.84081 15.268 8.92881 15.082L9.17881 15.584C9.35966 15.9463 9.61013 16.2694 9.9159 16.5348C10.2217 16.8003 10.5768 17.0029 10.9609 17.131C11.345 17.2592 11.7505 17.3104 12.1544 17.2817C12.5584 17.2531 12.9526 17.1451 13.3148 16.964C15.0068 16.118 15.4748 14.044 14.7588 12.492C14.0148 10.878 13.4348 8.872 13.9528 7.316C14.3428 6.148 15.2688 5.316 16.3388 4.764H16.3408ZM8.22081 12.378L8.2168 12.386L8.20681 12.398L8.1748 12.438L8.0728 12.58C7.9868 12.7 7.86881 12.874 7.73281 13.092C7.3721 13.6816 7.06295 14.3012 6.80881 14.944C6.18881 16.504 5.6888 18.714 6.2468 21.218C6.7768 23.598 7.79681 25.806 9.56481 27.426C11.3488 29.058 13.7988 30 17.0068 30C20.2428 30 22.7748 28.914 24.4928 27.054C26.1988 25.206 27.0068 22.694 27.0068 20C27.0068 18.282 26.4368 16.622 25.6688 15.072C24.9388 13.596 23.9888 12.144 23.0988 10.778C23.0554 10.7114 23.0121 10.6447 22.9688 10.578C22.0228 9.128 21.1608 7.788 20.5888 6.512C20.0188 5.238 19.7948 4.152 19.9848 3.196C20.0138 3.05098 20.0103 2.90133 19.9744 2.75784C19.9386 2.61435 19.8714 2.48059 19.7777 2.3662C19.684 2.25181 19.566 2.15963 19.4324 2.0963C19.2987 2.03298 19.1527 2.00009 19.0048 2C18.1608 2 16.7548 2.296 15.4208 2.986C14.0748 3.684 12.6668 4.852 12.0568 6.684C11.2768 9.024 12.1748 11.664 12.9428 13.33C13.2848 14.07 12.9868 14.89 12.4208 15.174C12.2937 15.2376 12.1553 15.2755 12.0135 15.2856C11.8717 15.2957 11.7294 15.2778 11.5945 15.2328C11.4597 15.1879 11.335 15.1168 11.2277 15.0237C11.1203 14.9305 11.0323 14.8171 10.9688 14.69L9.8988 12.552C9.82358 12.4016 9.71164 12.2726 9.57334 12.1769C9.43503 12.0812 9.27483 12.0219 9.10755 12.0046C8.94027 11.9873 8.77131 12.0124 8.61632 12.0776C8.46132 12.1429 8.32529 12.2462 8.22081 12.378Z"
                            fill="white" />
                    </svg>{{__('New & Popular')}}
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- Side Menu End-->

<div class="main-header">
    <nav id="navbar_top" class="navbar navbar-expand-lg justify-content-between px-3 py-0">
        <div class="main-header-left d-flex">
            <a class="hamburger" href="javascript:void(0)">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
                    fill="none">
                    <path d="M5.5 24.5H26.5M5.5 16.5H26.5M5.5 8.5H26.5" stroke="white" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
            <a class="navbar-brand" href="{{ getUrlWithPrefix('homepage') }}"><img src="{{ asset('assets/img/epicon-logo.png') }}"
                    alt=""></a>
            @if(!$kids_page)
            @loggedin

            @if(@$subplan['status'] != 'active')

            <a class="subscribe-btn" href="{{ getUrl('subscription') }}">{{__('Subscribe')}}</a>
            @endif
            @elseloggedin

            <a class="subscribe-btn login" href="javascript:void(0);">{{__('Subscribe')}}</a>

            @endloggedin
            @endif
        </div>

        <?php

if ($kids_page) {
    $links = [
        'kids' => 'Home',
        'kids/movies' => 'Movies',
        'kids/shows' => 'Shows',
        'kids/podcast' => 'Podcasts',
    ];
} else {
    $links = [
        '/' => 'Home',
        'movies' => 'Movies',
        'tv-shows' => 'Shows',
        'podcast' => 'Podcasts',
        'explore' => 'Explore',
        'premium' => 'Premium',
    ];
}

if (request()->path() == "hi") {
    $current_route = "/";
} else {
    $path = explode("/", request()->path());
    $finalPath = [];
    foreach ($path as $value) {
        if ($value == "hi") {
            continue;
        } else {
            $finalPath[] = $value;
        }
    }
    $current_route = implode("/", $finalPath);
}
?>
        <ul class="menu-item list-unstyled d-flex mb-0">
            @foreach ($links as $key => $value)
                <li><a href="{{ getUrl($key) }}"
                        @if ($current_route == $key) class="active" @endif>{{ __($value) }}</a></li>
            @endforeach

        </ul>
        <div class="main-header-right d-flex align-items-center">
            @php $isactive = ""; @endphp
            @if (session()->has('kidsMode') && session()->get('kidsMode'))
            @php $isactive = "checked"; @endphp
            @endif
            <!-- <button id="allAccessBtn">All access</button> -->
            <div class="form-check form-switch">
            <input class="form-check-input" name ="kidscheckbox" id="allAccessBtn" type="checkbox" role="switch" {{$isactive}}>

            </div>
                <input type="hidden" name="kidsUrl" id="kidsUrl" value="{{ $kids_page ? getUrlWithPrefix('homepage') : getUrlWithPrefix('kidsIndex') }}"
            <a href="{{ $kids_page ? getUrlWithPrefix('homepage') : getUrlWithPrefix('kidsIndex') }}" id="kidsUrl" class="p-2 me-2">
                </a><img src="{{ asset('assets/img/kidz-icon.svg') }}" alt="">
            <a href="{{ getUrl('search') }}" class="p-2 me-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <circle cx="11.6842" cy="11.6842" r="7.71929" stroke="white" stroke-width="1.92982" />
                    <path
                        d="M20.6536 22.0153C21.0305 22.3921 21.6414 22.3921 22.0182 22.0153C22.3951 21.6385 22.3951 21.0275 22.0182 20.6507L20.6536 22.0153ZM22.0182 20.6507L18.1586 16.7911L16.794 18.1557L20.6536 22.0153L22.0182 20.6507Z"
                        fill="white" />
                </svg>
            </a>
            @if (!session()->has('kidsMode') || (session()->has('kidsMode') && !session()->get('kidsMode')))
            <div class="notification p-2 me-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <path
                        d="M20.7927 16.4944C20.2724 15.5981 19.4989 13.0622 19.4989 9.75C19.4989 7.76088 18.7087 5.85322 17.3022 4.4467C15.8957 3.04018 13.988 2.25 11.9989 2.25C10.0098 2.25 8.10214 3.04018 6.69561 4.4467C5.28909 5.85322 4.49891 7.76088 4.49891 9.75C4.49891 13.0631 3.72454 15.5981 3.20423 16.4944C3.07135 16.7222 3.00091 16.9811 3.00001 17.2449C2.9991 17.5086 3.06776 17.768 3.19907 17.9967C3.33037 18.2255 3.51968 18.4156 3.74789 18.5478C3.9761 18.6801 4.23515 18.7498 4.49891 18.75H8.32485C8.49789 19.5967 8.95806 20.3577 9.62754 20.9042C10.297 21.4507 11.1347 21.7492 11.9989 21.7492C12.8631 21.7492 13.7008 21.4507 14.3703 20.9042C15.0398 20.3577 15.4999 19.5967 15.673 18.75H19.4989C19.7626 18.7496 20.0215 18.6798 20.2496 18.5475C20.4777 18.4151 20.6669 18.225 20.7981 17.9963C20.9292 17.7676 20.9978 17.5083 20.9969 17.2446C20.9959 16.9809 20.9255 16.7222 20.7927 16.4944ZM11.9989 20.25C11.5337 20.2499 11.0801 20.1055 10.7003 19.8369C10.3205 19.5683 10.0333 19.1886 9.87829 18.75H14.1195C13.9645 19.1886 13.6773 19.5683 13.2975 19.8369C12.9178 20.1055 12.4641 20.2499 11.9989 20.25ZM4.49891 17.25C5.22079 16.0088 5.99891 13.1325 5.99891 9.75C5.99891 8.1587 6.63105 6.63258 7.75627 5.50736C8.88149 4.38214 10.4076 3.75 11.9989 3.75C13.5902 3.75 15.1163 4.38214 16.2416 5.50736C17.3668 6.63258 17.9989 8.1587 17.9989 9.75C17.9989 13.1297 18.7752 16.0059 19.4989 17.25H4.49891Z"
                        fill="white" />
                </svg>
                <div class="notification-drop-down">
                    <div class="notif-header">
                        <h1>{{__('Notification')}}</h1><a href="#/">{{__('Clear All')}}</a>
                    </div>
                    <ul class="list-unstyled">
                        <li class="content active mb-3">
                            <span class="notif-dot"></span>
                            <div class="notif-img">
                                <img src="{{ asset('assets/img/welcom.jpeg') }}" alt="">
                            </div>
                            <div>
                                <h3>Upcoming Show</h3>
                                <h4>Rajvansh</h4>
                                <p>10 June</p>
                            </div>
                        </li>
                        <li class="content mb-3">
                            <span class="notif-dot"></span>
                            <div class="notif-img">
                                <img src="{{ asset('assets/img/welcom.jpeg') }}" alt="">
                            </div>
                            <div>
                                <h3>Upcoming Show</h3>
                                <h4>Rajvansh</h4>
                                <p>10 June</p>
                            </div>
                        </li>
                        <li class="content mb-3">
                            <span class="notif-dot"></span>
                            <div class="notif-img">
                                <img src="{{ asset('assets/img/welcom.jpeg') }}" alt="">
                            </div>
                            <div>
                                <h3>Upcoming Show</h3>
                                <h4>Rajvansh</h4>
                                <p>10 June</p>
                            </div>
                        </li>
                        <li class="content mb-3">
                            <span class="notif-dot"></span>
                            <div class="notif-img">
                                <img src="{{ asset('assets/img/welcom.jpeg') }}" alt="">
                            </div>
                            <div>
                                <h3>Upcoming Show</h3>
                                <h4>Rajvansh</h4>
                                <p>10 June</p>
                            </div>
                        </li>
                        <li class="content mb-3">
                            <span class="notif-dot"></span>
                            <div class="notif-img">
                                <img src="{{ asset('assets/img/welcom.jpeg') }}" alt="">
                            </div>
                            <div>
                                <h3>Upcoming Show</h3>
                                <h4>Rajvansh</h4>
                                <p>10 June</p>
                            </div>
                        </li>
                        <li class="content mb-3">
                            <span class="notif-dot"></span>
                            <div class="notif-img">
                                <img src="{{ asset('assets/img/welcom.jpeg') }}" alt="">
                            </div>
                            <div>
                                <h3>Upcoming Show</h3>
                                <h4>Rajvansh</h4>
                                <p>10 June</p>
                            </div>
                        </li>
                    </ul>
                    <div class="no-notification">
                        <img src="{{ asset('assets/img/no-notification.svg') }}" alt="">
                        <span class="small text-white">{{__('You do not have any notifications')}}</span>
                        <button>{{__('Explore Now')}}</button>
                    </div>
                </div>
            </div>
            <div class="profile p-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <path
                        d="M7 8C7 5.23858 9.23858 3 12 3C14.7614 3 17 5.23858 17 8C17 10.7614 14.7614 13 12 13C9.23858 13 7 10.7614 7 8ZM12 11C13.6569 11 15 9.65685 15 8C15 6.34315 13.6569 5 12 5C10.3431 5 9 6.34315 9 8C9 9.65685 10.3431 11 12 11Z"
                        fill="white" />
                    <path
                        d="M6.34315 16.3431C5.0799 17.6064 4.28276 19.2486 4.06239 21.0026C3.99355 21.5505 4.44772 22 5 22C5.55228 22 5.9915 21.5492 6.08312 21.0046C6.28871 19.7825 6.86956 18.6452 7.75736 17.7574C8.88258 16.6321 10.4087 16 12 16C13.5913 16 15.1174 16.6321 16.2426 17.7574C17.1304 18.6452 17.7113 19.7825 17.9169 21.0046C18.0085 21.5492 18.4477 22 19 22C19.5523 22 20.0065 21.5505 19.9376 21.0026C19.7172 19.2486 18.9201 17.6064 17.6569 16.3431C16.1566 14.8429 14.1217 14 12 14C9.87827 14 7.84344 14.8429 6.34315 16.3431Z"
                        fill="white" />
                </svg>
                <ul class="profile-drop-down list-unstyled">
                    @loggedin
                        <?php
$profile = getProfileData();
//echo "Testing"; dd($profile);
?>
                        <li class="profile-main p-3">
                            @if ($profile)
                                @foreach ($profile['profiles'] as $key => $value)
                                    <?php
$profile_img = trim(@$value['profile_img']) != '' ? @$value['profile_img'] : asset('assets/img/edit-profile-pik.png');
?>

                                    <a href="#/">
                                        <div class="profile-pik girl-bg active">
                                            <img src="{{ $profile_img }}" alt="">
                                        </div>
                                        <span class="pro-name">{{ ucfirst(@$value['name']) }}</span>
                                    </a>
                                @endforeach

                                @if (count($profile['profiles']) < config('global.max_profile_limit'))
                                    <a href="{{ getUrlWithPrefix('profile.add') }}">
                                        <div class="profile-pik pro-add">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="49" height="48"
                                                viewBox="0 0 49 48" fill="none">
                                                <path
                                                    d="M24.3906 9C24.7884 9 25.17 9.15804 25.4513 9.43934C25.7326 9.72064 25.8906 10.1022 25.8906 10.5V22H37.3906C37.7885 22 38.17 22.158 38.4513 22.4393C38.7326 22.7206 38.8906 23.1022 38.8906 23.5C38.8906 23.8978 38.7326 24.2794 38.4513 24.5607C38.17 24.842 37.7885 25 37.3906 25H25.8906V36.5C25.8906 36.8978 25.7326 37.2794 25.4513 37.5607C25.17 37.842 24.7884 38 24.3906 38C23.9928 38 23.6113 37.842 23.33 37.5607C23.0487 37.2794 22.8906 36.8978 22.8906 36.5V25H11.3906C10.9928 25 10.6113 24.842 10.33 24.5607C10.0487 24.2794 9.89062 23.8978 9.89062 23.5C9.89062 23.1022 10.0487 22.7206 10.33 22.4393C10.6113 22.158 10.9928 22 11.3906 22H22.8906V10.5C22.8906 10.1022 23.0487 9.72064 23.33 9.43934C23.6113 9.15804 23.9928 9 24.3906 9Z"
                                                    fill="white" />
                                            </svg>
                                        </div>
                                        <span class="pro-name">{{__('ADD')}}</span>
                                    </a>
                                @endif
                            @endif

                        </li>
                        <li class="exclusive-subc w-100">
                            <p class="m-0 small">{{__('Get access to exclusive content, with no ad breaks.')}}</p>

                            @if(@$subplan['status'] != 'active')
                                <button> <img class="me-1" width="18" src="{{ asset('assets/img/crown.svg') }}"
                                    alt=""> {{__('Subscribe')}}1</button>
                            @endif
                        </li>
                        <li class="subc-text"><a href="{{ getUrlWithPrefix('profile.index') }}">{{__('Manage Profiles')}}</a></li>
                        <li class="subc-text"><a href="{{ getUrl('library') }}">{{__('Library')}}</a></li>
                        <li class="subc-text"><a href="{{ getUrl('my-account') }}">{{__('My Account')}}</a></li>
                        <li class="subc-text"><a href="{{ getUrl('my-rewards') }}">{{__('My Rewards')}}</a></li>
                        <li class="subc-text"><a href="{{ getUrl('settings?status=ispin') }}">{{__('Settings')}}</a></li>
                        <li class="subc-text"><a href="{{ getUrl('feedback') }}">{{__('Help & Feedback')}}</a></li>
                        <li class="subc-text logout"><a href="javascript:void(0);">{{__('Log out')}}</a></li>
                        <li class="subc-text atp">
                            <a href="{{ getUrl('about') }}">{{__('About Us')}}</a>
                            <a href="{{ route('terms-of-use') }}">{{__('Terms of Use')}}</a>
                            <a href="{{ route('privacy') }}">{{__('Privacy Policy')}}</a>
                        </li>
                    @elseloggedin
                        <li class="subc-text login"><a href="javascript:void(0);">{{__('Login')}}</a></li>
                    @endloggedin

                </ul>
            </div>
            @endif
        </div>

    </nav>
</div>
