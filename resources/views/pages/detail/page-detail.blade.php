<?php 
$isMoblile      = isMobliDevice();

$loadPlayer = @$content['free_premium'] == false || isActiveSubscription() ? true : false;

if (@$content['content_type'] == 'SHOW' || $content['content_type'] == 'SEASON') {
    $loadPlayer = true;
}
$loadPlayer = true;
// dd($content['catalog_slug']);
?>

@extends('layouts.default')
@section('title', @$content['title'])

@section('style')
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/socialSharing.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css"
        integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @if ($loadPlayer)
        <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    @endif
    <style>
        .hide {
            display: none;
        }
    </style>
@stop

@section('content')
<?php

    if($isMoblile){
        $cover_img = getCardImage($content, 'banner_image', 'medium');
    }else{

        if(isset($content['airtel_feature_imageHD']) && !empty($content['airtel_feature_imageHD'])){
            $cover_img = $content['airtel_feature_imageHD'];
        }
        else if(isset($content['trending_movie_buzz_image']) && !empty($content['trending_movie_buzz_image'])){

            $cover_img = getCardImage($content, 'trending_movie_buzz_image', 'large');
        }
        else{
            $cover_img = getCardImage($content, 'banner_image', 'large');
        }
    }

?>
    <input type="hidden" id="cont_id" value="{{ $content['ID'] }}">

    @if ($loadPlayer)
        @include('pages.detail.video-player')
    @endif

    <section class="content-detail-banner position-relative">
        <div class="banner-main position-relative">
            <img src="{{ $cover_img }}" alt="img">
        </div>
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
            $watchid = @$content['free_premium'] != true ? "watchVideo" : "";
            $addToList = "login-with-subscription";
        } else {
            $addToList = "addToList";
            // for play Video 
            $watchClass = @$content['free_premium'] == true && @$subplan['status'] != 'active' ? $addClass : "";
            $watchid = @$content['free_premium'] != true || (@$content['free_premium'] == true && @$subplan['status'] == 'active') ? "watchVideo" : "";
        }

?>
        <div class="overlay mt-4">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-lg-6 col-md-6">
                        <div class="banner-content">
                            <div class="all-btn">
                                <input type="hidden" name="subUrl" class="subUrl" id="subUrl" value="{{ getUrl('subscription') }}">
                                <button class="fill-btn mobile-width {{$watchClass}} m-0 w-25" id="{{$watchid}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                        viewBox="0 0 28 28" fill="none">
                                        <path
                                            d="M26.25 14.0005C26.2507 14.2976 26.1745 14.5899 26.0289 14.8488C25.8832 15.1077 25.673 15.3246 25.4188 15.4782L9.66 25.1185C9.39431 25.2812 9.09001 25.37 8.77852 25.3758C8.46703 25.3816 8.15965 25.3041 7.88813 25.1513C7.61918 25.001 7.39515 24.7817 7.23905 24.516C7.08296 24.2503 7.00045 23.9479 7 23.6398V4.36133C7.00045 4.0532 7.08296 3.75076 7.23905 3.48509C7.39515 3.21943 7.61918 3.00014 7.88813 2.84976C8.15965 2.69702 8.46703 2.61953 8.77852 2.6253C9.09001 2.63107 9.39431 2.71989 9.66 2.88258L25.4188 12.5229C25.673 12.6765 25.8832 12.8934 26.0289 13.1523C26.1745 13.4112 26.2507 13.7035 26.25 14.0005Z"
                                            fill="#272727" />
                                    </svg>&nbsp;
                                    {!! getPlayText($content) !!}
                                </button>
                                <?php 
                                
                                ?>

                                    @if (@$content['free_premium'] == true && !isActiveSubscription())
                                        <a class="subcription-btn {{$watchClass}} m-0 w-25" href="{{$href}}" style="text-decoration: none">
                                            <img src="{{ asset('assets/img/crown.svg') }}" alt="crown"> {{__('Subscribe Now')}}
                                        </a>
                                    @endif
                              
                                    <?php
                                        $wishlist = getWishlist();

                                        $wishlist_ids = $wishlist['ids'] ?? [];

                                        $wishAction = in_array($content['ID'], $wishlist_ids) ? 'delete' : 'add';

                                        $share_title = @$content['title'];
                                        if ($content['content_type'] == 'SEASON') {
                                            $share_title = @$content['parent_name'] . ' - ' . @$content['title'];
                                        }
                                    ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6 col-md-6">
                        <div class="d-flex">
                            <div class="banner-content flex-wrap">
                                <div class="all-btn w-100">
                                    @if (@$content['percentage_match'])
                                        <button class="border-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M19.4978 7.49891L16.5078 10.4889L13.5078 7.48891L16.4978 4.49891C16.9178 4.07891 17.4578 3.87891 17.9978 3.87891C18.5378 3.87891 19.0778 4.07891 19.4978 4.49891C20.3278 5.32891 20.3278 6.66891 19.4978 7.49891Z"
                                                    fill="white" />
                                                <path
                                                    d="M17.3095 9.69531L6.49945 20.4953C5.66945 21.3253 4.32945 21.3253 3.49945 20.4953C2.66945 19.6653 2.66945 18.3253 3.49945 17.4953L14.3095 6.69531L17.3095 9.69531Z"
                                                    fill="#B04CF1" />
                                                <path
                                                    d="M9.95051 3.50051L10.3605 2.11051C10.4005 1.98051 10.3605 1.84051 10.2705 1.74051C10.1805 1.64051 10.0205 1.60051 9.89051 1.64051L8.50051 2.05051L7.11051 1.64051C6.98051 1.60051 6.84051 1.64051 6.74051 1.73051C6.64051 1.83051 6.61051 1.97051 6.65051 2.10051L7.05051 3.50051L6.64051 4.89051C6.60051 5.0205 6.64051 5.16051 6.73051 5.26051C6.83051 5.36051 6.97051 5.39051 7.10051 5.35051L8.50051 4.95051L9.89051 5.36051C9.93051 5.37051 9.96051 5.38051 10.0005 5.38051C10.1005 5.38051 10.1905 5.34051 10.2705 5.27051C10.3705 5.17051 10.4005 5.03051 10.3605 4.90051L9.95051 3.50051Z"
                                                    fill="#FFAC33" />
                                                <path
                                                    d="M5.9505 9.50051L6.3605 8.1105C6.4005 7.9805 6.3605 7.84051 6.2705 7.74051C6.1705 7.64051 6.0305 7.61051 5.9005 7.65051L4.5005 8.05051L3.1105 7.64051C2.9805 7.60051 2.84051 7.64051 2.74051 7.73051C2.64051 7.83051 2.61051 7.97051 2.65051 8.10051L3.0505 9.50051L2.64051 10.8905C2.60051 11.0205 2.64051 11.1605 2.73051 11.2605C2.83051 11.3605 2.9705 11.3905 3.1005 11.3505L4.4905 10.9405L5.8805 11.3505C5.9105 11.3605 5.9505 11.3605 5.9905 11.3605C6.0905 11.3605 6.18051 11.3205 6.2605 11.2505C6.36051 11.1505 6.3905 11.0105 6.3505 10.8805L5.9505 9.50051Z"
                                                    fill="#FFAC33" />
                                                <path
                                                    d="M20.9497 14.5L21.3597 13.11C21.3997 12.98 21.3597 12.84 21.2697 12.74C21.1697 12.64 21.0297 12.61 20.8997 12.65L19.5097 13.06L18.1197 12.65C17.9897 12.61 17.8497 12.65 17.7497 12.74C17.6497 12.84 17.6197 12.98 17.6597 13.11L18.0697 14.5L17.6597 15.89C17.6197 16.02 17.6597 16.16 17.7497 16.26C17.8497 16.36 17.9897 16.39 18.1197 16.35L19.5097 15.94L20.8997 16.35C20.9297 16.36 20.9697 16.36 21.0097 16.36C21.1097 16.36 21.1997 16.32 21.2797 16.25C21.3797 16.15 21.4097 16.01 21.3697 15.88L20.9497 14.5Z"
                                                    fill="#FFAC33" />
                                            </svg> &nbsp;
                                            {{ $content['percentage_match'] }} % match
                                        </button>
                                    @endif

                                    <button class="rounded-transparent-btn {{$addToList}}" data-id="{{ $content['ID'] }}"
                                        data-action="{{ $wishAction }}" data-type="3">
                                        <img class="wl_add" src="{{ asset('assets/img/add-icon.svg') }}" alt="icon"
                                            @if ($wishAction == 'delete') style="display: none" @endif>
                                        <img class="wl_remove" src="{{ asset('assets/img/subs-icon.svg') }}" alt="icon"
                                            @if ($wishAction == 'add') style="display: none" @endif>
                                    </button>
                                    @if(isset($content['catalog_slug']) && $content['catalog_slug'] != 'live-tv')
                                    <button class="rounded-transparent-btn clapButton" data-id="{{ @$content['ID'] }}">
                                        <img src="{{ asset('assets/img/clap-icon.svg') }}" alt="icon">
                                        <span class="claps_num">{{ countConvert(@$content['claps']) }}</span>
                                    </button>
                                    @endif
                                    <button class="rounded-transparent-btn shareThis" data-url="{{ getContentUrl($content) }}"
                                        data-title="{{ $share_title }}">
                                        <img src="{{ asset('assets/img/share-icon.svg') }}" alt="icon">
                                    </button>
                                    @if (@$content['is_popular'])
                                        <button class="border-btn most-pop">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M19.4997 14.5042C19.4997 19.0792 15.7122 22.758 11.1372 22.485C6.43548 22.2045 3.21723 17.6827 3.82323 12.9562C4.18998 10.0815 5.53773 7.61622 7.00473 5.70372C7.25973 5.36997 7.52148 8.05572 7.78323 7.76022C8.04573 7.45647 10.4787 3.24597 11.3247 1.76697C11.3611 1.70174 11.4111 1.6451 11.4713 1.6009C11.5315 1.5567 11.6006 1.52598 11.6737 1.51083C11.7468 1.49567 11.8224 1.49644 11.8952 1.51307C11.968 1.5297 12.0364 1.56181 12.0957 1.60722C13.7952 2.88972 19.4997 7.70697 19.4997 14.5042Z"
                                                    fill="#FF6723" />
                                                <path
                                                    d="M17.2503 16.3883C17.2503 19.4198 14.611 21.8565 11.401 21.7463C7.93602 21.6293 5.56001 18.4583 6.06851 15.192C6.80276 10.509 11.6103 7.5 11.6103 7.5C11.6103 7.5 17.2503 11.0302 17.2503 16.3883Z"
                                                    fill="#FFB02E" />
                                            </svg> &nbsp;
                                            {{__('Most Popular')}}
                                        </button>
                                    @endif
                                </div>
                                
                            </div>
                            </div>
                    </div>
                    <div class="col-12">
                    <p class="ua small mb-2 b7-color">
                            @include('pages.detail.detail-components.sub-bullets', [
                                'v_content' => $content,
                            ])
                        </p>
                    <div class="seemore">
                            <p class="text-white mb-0 descText">{!! sanitizeData(@$content['description']) !!}</p>
                            <span class="read-button"> </span>
                            @if(strlen(@$content['description']) > 300 )
                                <!-- <button class="bg-transparent text-white small readmore-less">Read More</button> -->
                            @endif
                        </div>
                        @if (@$content['cast'])
                        <div class="seemore">
                                <p class="text-white mb-3">Cast:
                                    @foreach ($content['cast'] as $key => $value)
                                        {{ $value }}
                                    @endforeach
                                </p>
                        </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </section>



    @include('pages.detail.detail-components.tabs')

    @include('components.share-modal')
@stop

@section('script')
    <script src="{{ asset('assets/js/homepage.js') }}"></script>
    <script src="{{ asset('assets/js/socialSharing.js') }}"></script>

    <script src="{{ asset('assets/js/detail.js') }}"></script>
    <script src="{{ asset('assets/js/common.js') }}"></script>

    @if ($loadPlayer)
        <script src="{{ asset('assets/js/vendor/plyr.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/hls.min.js') }}"></script>
        <script src="{{ asset('assets/js/webvtt-subtitler.js') }}"></script>
        <script src="{{ asset('assets/js/video-player.js') }}"></script>
    @endif



@stop
