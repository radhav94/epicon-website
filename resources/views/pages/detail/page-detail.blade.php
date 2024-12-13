<?php 
$isMoblile      = isMobliDevice();

$loadPlayer = @$content['free_premium'] == false || isActiveSubscription() ? true : false;

if (@$content['content_type'] == 'SHOW' || $content['content_type'] == 'SEASON') {
    $loadPlayer = true;
}
$loadPlayer = true;
$share_img = getCardImage($content, 'cover_image', 'medium');
if($isMoblile){
    $cover_img = getCardImage($content, 'banner_image', 'medium');
}else{

    if(isset($content['airtel_feature_imageHD']) && !empty($content['airtel_feature_imageHD'])){
        $cover_img = $content['airtel_feature_imageHD'];
    }
    else if(isset($content['trending_movie_buzz_image']) && !empty($content['trending_movie_buzz_image'])){

        $cover_img = getCardImage($content, 'trending_movie_buzz_image', 'large');
    }
    else if(@$content['content_type'] == 'EPISODE'){
        $cover_img = getCardImage($content, 'cover_image', 'large');
    }
    else{
        $cover_img = getCardImage($content, 'banner_image', 'large');
    }
    // dd($content);
}

$meta['image'] = $share_img;
?>

@extends('layouts.default')
@section('title', @$meta['title'])

@section('style')
    <link type="text/css" rel="stylesheet" href="{{ env('AWS_S3_domain').'epicon/assets/images/socialSharing.css' }}?v={{ assetTime() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
    @if ($loadPlayer)
        <link rel="stylesheet" type="text/css" href="{{ env('AWS_S3_domain') }}epicon/assets/images/plyr.css?v={{ assetTime() }}">
    @endif
    <style>
        .hide {
            display: none;
        }
    </style>
@stop

@section('content')
<?php

    // dd($trailers);
    // dd($trailers['list'][0]['content'][0]['ID']);
    $trailer_id = @$trailers['list'][0]['content'][0]['ID'] ?? '';

?>
    <input type="hidden" id="cont_id" value="{{ $content['ID'] }}">

    @if ($loadPlayer)
        @include('pages.detail.video-player')
    @endif

    <section class="content-detail-banner position-relative">
        <div class="banner-main position-relative hide-vid-element">
            <img src="{{ $cover_img }}" alt="img">
        </div>
        <div class="loaderImg" style="display:none">
            <img class=""  src="{{ env('AWS_S3_domain').'epicon/assets/images/Spin.gif' }}" alt="img">
        </div>
        @if(!isActiveSubscription() && $trailer_id)
        <a href="javascript:playContentVideo('{{ $trailer_id }}','trailer', this)" class="TrailerLink" style="display: none;"></a>
        @endif
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
            $addToList = "subscription-login";
        }else{
            $addToList = "addToList";
        }    
            // for play Video 
            $watchClass = @$content['free_premium'] == true && @$subplan['status'] != 'active' ? $addClass : "";
            $watchid = @$content['free_premium'] != true || (@$content['free_premium'] == true && @$subplan['status'] == 'active') ? "watchVideo" : "";
        
        $dispnone = "";
?>
       @if ($trailers && isset($trailers['list']) && !empty($trailers['list'] && @$content['free_premium'] == true))
        @if(!isUserLoggedIn() || @$subplan['status'] != 'active')
        <?php $dispnone = "display:none1"; ?>
        @endif
    @endif
        <div class="overlay mt-4 content-div" style="{{$dispnone}}">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-lg-6 col-md-6">
                        <div class="banner-content">
                            <div class="all-btn">
                                <input type="hidden" name="subsuser" id="subsuser" value="{{$watchid}}">
                                <input type="hidden" name="subUrl" class="subUrl" id="subUrl" value="{{ getUrl('subscription') }}">
                                <button class="hide-vid-element fill-btn mobile-width {{$watchClass}} m-0 w-25" id="{{$watchid}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                        viewBox="0 0 28 28" fill="none">
                                        <path
                                            d="M26.25 14.0005C26.2507 14.2976 26.1745 14.5899 26.0289 14.8488C25.8832 15.1077 25.673 15.3246 25.4188 15.4782L9.66 25.1185C9.39431 25.2812 9.09001 25.37 8.77852 25.3758C8.46703 25.3816 8.15965 25.3041 7.88813 25.1513C7.61918 25.001 7.39515 24.7817 7.23905 24.516C7.08296 24.2503 7.00045 23.9479 7 23.6398V4.36133C7.00045 4.0532 7.08296 3.75076 7.23905 3.48509C7.39515 3.21943 7.61918 3.00014 7.88813 2.84976C8.15965 2.69702 8.46703 2.61953 8.77852 2.6253C9.09001 2.63107 9.39431 2.71989 9.66 2.88258L25.4188 12.5229C25.673 12.6765 25.8832 12.8934 26.0289 13.1523C26.1745 13.4112 26.2507 13.7035 26.25 14.0005Z"
                                            fill="#272727" />
                                    </svg>&nbsp;
                                    @if($pageslug == 'live-tv')
                                        PLAY
                                    @else
                                        {!! getPlayText($content) !!}
                                    @endif
                                </button>
                                @if(($content['user_duration'] ?? 0) >= 1)
                                <button class="fill-btn mobile-width" id="video-start-from-beginning">Play from beginning</button>
                                @endif

                                    @if (@$content['free_premium'] == true && !isActiveSubscription())
                                        <a class="subcription-btn {{$watchClass}} m-0 w-25" href="{{$href}}" style="text-decoration: none">
                                            <img src="{{ env('AWS_S3_domain') }}epicon/assets/images/crown.svg" alt="crown"> {{__('Subscribe Now')}}
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
                                        <img class="wl_add" src="{{ env('AWS_S3_domain') }}epicon/assets/images/add-icon.svg" alt="icon"
                                            @if ($wishAction == 'delete') style="display: none" @endif>
                                        <img class="wl_remove" src="{{ env('AWS_S3_domain').'epicon/assets/images/subs-icon.svg' }}" alt="icon"
                                            @if ($wishAction == 'add') style="display: none" @endif>
                                    </button>
                                    @if(isset($content['catalog_slug']) && $content['catalog_slug'] != 'live-tv')
                                    <button class="rounded-transparent-btn clapButton" data-id="{{ @$content['ID'] }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="20" viewBox="0 0 19 20" fill="none">
                                            <path d="M12.0652 1.87206V0.624019C12.0652 0.458519 12.1309 0.299797 12.2479 0.182771C12.365 0.0657446 12.5237 0 12.6892 0C12.8547 0 13.0134 0.0657446 13.1304 0.182771C13.2475 0.299797 13.3132 0.458519 13.3132 0.624019V1.87206C13.3132 2.03756 13.2475 2.19628 13.1304 2.31331C13.0134 2.43033 12.8547 2.49608 12.6892 2.49608C12.5237 2.49608 12.365 2.43033 12.2479 2.31331C12.1309 2.19628 12.0652 2.03756 12.0652 1.87206ZM14.86 3.1981C14.9581 3.25713 15.0708 3.28765 15.1853 3.28624C15.2924 3.28641 15.3977 3.25902 15.4911 3.2067C15.5846 3.15437 15.663 3.07888 15.7188 2.98749L16.3428 1.96488C16.3862 1.8949 16.4154 1.81702 16.4286 1.73573C16.4417 1.65443 16.4387 1.57133 16.4196 1.49122C16.4005 1.41111 16.3658 1.33556 16.3173 1.26895C16.2689 1.20233 16.2078 1.14596 16.1375 1.10308C16.0672 1.06021 15.9891 1.03167 15.9077 1.01912C15.8263 1.00657 15.7432 1.01026 15.6632 1.02997C15.5833 1.04968 15.508 1.08503 15.4418 1.13397C15.3755 1.18291 15.3196 1.24448 15.2773 1.31512L14.6533 2.33695C14.61 2.40698 14.581 2.48489 14.568 2.56617C14.555 2.64745 14.5582 2.7305 14.5774 2.81055C14.5966 2.89059 14.6315 2.96604 14.68 3.03256C14.7285 3.09907 14.7897 3.15533 14.86 3.1981ZM18.5604 4.18015C18.5353 4.10214 18.495 4.02984 18.4419 3.9674C18.3889 3.90495 18.324 3.85357 18.2511 3.81619C18.1781 3.77882 18.0985 3.75618 18.0168 3.74956C17.9351 3.74295 17.8529 3.7525 17.7749 3.77765L16.6049 4.15596C16.4631 4.20132 16.3421 4.29591 16.2639 4.42264C16.1857 4.54938 16.1554 4.69991 16.1785 4.84704C16.2015 4.99417 16.2765 5.12819 16.3897 5.22489C16.503 5.3216 16.6471 5.37462 16.796 5.37436C16.8612 5.37411 16.9259 5.36385 16.9879 5.34394L18.1579 4.96563C18.2363 4.94051 18.3089 4.90014 18.3716 4.84684C18.4343 4.79354 18.4858 4.72837 18.5233 4.65507C18.5607 4.58178 18.5832 4.5018 18.5896 4.41976C18.596 4.33772 18.5861 4.25522 18.5604 4.17703V4.18015ZM16.2204 7.29556C16.9103 8.4823 17.1881 9.86401 17.0105 11.2252C16.8328 12.5864 16.2097 13.8505 15.2383 14.8205C14.9013 15.9983 14.2249 17.0509 13.2937 17.847C12.3624 18.6431 11.2174 19.1474 10.0015 19.2971C8.78553 19.4469 7.5524 19.2353 6.45585 18.6889C5.3593 18.1425 4.44785 17.2854 3.83515 16.2245L1.10506 11.4952C0.938376 11.2061 0.845615 10.8803 0.835009 10.5467C0.824403 10.2132 0.89628 9.88212 1.04426 9.58298C1.19225 9.28385 1.41177 9.02586 1.68335 8.8319C1.95493 8.63793 2.27019 8.51399 2.60115 8.47105L2.28914 7.92972C2.12504 7.64547 2.03238 7.32563 2.01912 6.99768C2.00585 6.66972 2.07239 6.34345 2.213 6.04688C2.35362 5.75031 2.56412 5.49229 2.82642 5.29499C3.08872 5.09769 3.39499 4.967 3.71892 4.91415C3.55644 4.46677 3.55649 3.9765 3.71906 3.52916C3.88163 3.08181 4.19635 2.7059 4.60815 2.46721C4.98575 2.25 5.42316 2.15989 5.85587 2.21017C6.28857 2.26045 6.69366 2.44846 7.0114 2.74646C7.20601 2.46554 7.46845 2.23835 7.77436 2.086C8.08026 1.93364 8.41971 1.86105 8.76117 1.87498C9.10263 1.88891 9.43503 1.9889 9.72751 2.16567C10.02 2.34244 10.2631 2.59025 10.4341 2.88609L11.3702 4.50776C11.5728 4.24238 11.8379 4.03115 12.1418 3.89282C12.4457 3.75449 12.7791 3.69333 13.1123 3.71479C13.4455 3.73624 13.7683 3.83964 14.0519 4.0158C14.3356 4.19196 14.5714 4.43543 14.7383 4.7246L16.2204 7.29556ZM8.00281 4.29013L8.46536 5.09121C8.61981 5.23226 8.75138 5.39647 8.85537 5.57795L9.7914 7.1965C10.099 6.79694 10.5436 6.52523 11.0394 6.43363L9.35381 3.51011C9.25037 3.33096 9.08 3.20023 8.88018 3.14669C8.68036 3.09315 8.46745 3.12118 8.2883 3.22462C8.10915 3.32806 7.97842 3.49843 7.92489 3.69825C7.87135 3.89807 7.89938 4.11097 8.00281 4.29013ZM4.94668 4.61384L5.40923 5.4157L5.43419 5.43832C5.58552 5.21921 5.77864 5.03214 6.00244 4.88784C6.22625 4.74354 6.47635 4.64486 6.73839 4.59746L6.29768 3.83382C6.22056 3.7002 6.10554 3.59245 5.96718 3.5242C5.82882 3.45594 5.67333 3.43025 5.52037 3.45038C5.36741 3.4705 5.22385 3.53553 5.10785 3.63724C4.99185 3.73895 4.90862 3.87278 4.86868 4.0218C4.84181 4.12073 4.83487 4.22401 4.84826 4.32565C4.86166 4.42728 4.89511 4.52524 4.94668 4.61384ZM14.0612 14.3969C14.2326 13.7638 14.2767 13.1029 14.191 12.4526C14.1053 11.8023 13.8915 11.1755 13.562 10.6083L12.08 8.04126C11.9792 7.86845 11.8159 7.74098 11.6237 7.68519C11.4316 7.62941 11.2254 7.64957 11.0477 7.74151C10.87 7.83345 10.7345 7.99015 10.6691 8.17921C10.6037 8.36826 10.6134 8.57523 10.6962 8.75732L11.587 10.2963C11.6698 10.4398 11.6921 10.6103 11.6492 10.7702C11.6063 10.9302 11.5015 11.0665 11.3581 11.1493C11.2146 11.232 11.0441 11.2544 10.8842 11.2115C10.7242 11.1685 10.5879 11.0638 10.5051 10.9203L7.77504 6.20353C7.66793 6.03392 7.49961 5.9121 7.30502 5.86337C7.11044 5.81464 6.90457 5.84274 6.73017 5.94184C6.55576 6.04094 6.42624 6.20342 6.36851 6.39552C6.31077 6.58762 6.32927 6.79458 6.42014 6.97341L8.34134 10.2963C8.3849 10.3674 8.4138 10.4464 8.42632 10.5288C8.43885 10.6112 8.43474 10.6952 8.41425 10.776C8.39376 10.8568 8.3573 10.9326 8.30702 10.9991C8.25675 11.0655 8.19367 11.1212 8.12151 11.1629C8.04935 11.2046 7.96958 11.2314 7.88689 11.2418C7.80421 11.2521 7.72029 11.2458 7.64008 11.2232C7.55988 11.2006 7.48501 11.1621 7.41991 11.1101C7.3548 11.0581 7.30077 10.9936 7.26101 10.9203L4.72047 6.52568C4.66963 6.43625 4.6016 6.35776 4.5203 6.29474C4.439 6.23171 4.34603 6.18539 4.24676 6.15843C4.14748 6.13148 4.04386 6.12443 3.94184 6.13769C3.83983 6.15095 3.74145 6.18426 3.65236 6.23569C3.56328 6.28713 3.48524 6.35568 3.42276 6.43739C3.36027 6.51911 3.31457 6.61238 3.28827 6.71183C3.26198 6.81128 3.25562 6.91495 3.26955 7.01688C3.28349 7.1188 3.31745 7.21695 3.36947 7.3057L6.17755 12.1699C6.21853 12.2409 6.24512 12.3193 6.25581 12.4006C6.2665 12.4818 6.26108 12.5644 6.23985 12.6436C6.21863 12.7227 6.18202 12.7969 6.13212 12.862C6.08222 12.927 6.01999 12.9815 5.94901 13.0225C5.87802 13.0635 5.79966 13.0901 5.7184 13.1008C5.63713 13.1114 5.55456 13.106 5.47539 13.0848C5.39622 13.0636 5.32201 13.027 5.25699 12.9771C5.19197 12.9272 5.13742 12.8649 5.09644 12.794L3.5364 10.092C3.43222 9.91425 3.262 9.78497 3.06286 9.73232C2.86372 9.67967 2.65184 9.70793 2.47346 9.81092C2.29508 9.91391 2.16468 10.0833 2.11071 10.2821C2.05674 10.4809 2.08359 10.6929 2.1854 10.872L4.91548 15.6013C5.40913 16.4565 6.14532 17.1461 7.03093 17.5828C7.91653 18.0196 8.91178 18.1839 9.89078 18.055C10.8698 17.9261 11.7886 17.5097 12.5309 16.8586C13.2732 16.2074 13.8058 15.3508 14.0612 14.3969ZM15.1392 7.91646L13.6572 5.3494C13.553 5.17171 13.3828 5.04243 13.1837 4.98978C12.9845 4.93713 12.7726 4.96539 12.5943 5.06838C12.4159 5.17137 12.2855 5.34074 12.2315 5.53952C12.1775 5.7383 12.2044 5.95036 12.3062 6.12942L12.7672 6.92895C12.9216 7.07064 13.0531 7.23535 13.1572 7.41724L14.6392 9.9843C15.0557 10.704 15.3243 11.4996 15.4294 12.3244C15.7235 11.6169 15.8504 10.851 15.8 10.0865C15.7497 9.32191 15.5236 8.5793 15.1392 7.91646Z" fill="white"/>
                                        </svg>&nbsp;
                                        <span class="claps_num">{{ countConvert(@$content['claps']) }}</span>
                                    </button>
                                    @endif
                                    <button class="rounded-transparent-btn shareThis" data-url="{{ getContentUrl($content) }}"
                                        data-title="{{ $share_title }}" data-type="{{@$content['catalog_slug']}}">
                                        <img src="{{ env('AWS_S3_domain').'epicon/assets/images/share-icon.svg' }}" alt="icon">
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
                        <h1 class="titleText text-white">{{@$content['title']}}</h1>
                        <p class="ua small mb-2 b7-color">
                            @include('pages.detail.detail-components.sub-bullets', [
                                'v_content' => $content,
                            ])
                        </p>
                        <div class="seemore">
                            <p class="text-white mb-0 descText">{!! sanitizeData(@$content['description']) !!}</p>
                            <span class="read-button"> </span>
                        </div>
                        @if (@$content['cast'])
                        <div class="seemore">
                            @foreach ($content['cast'] as $key => $value)
                                <p class="text-white mb-3">{{ ucwords(strtolower($key)) }}:
                                    {{ ucwords(strtolower($value)) }}
                                </p>
                            @endforeach
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
    <script src="{{ env('AWS_S3_domain') }}epicon/assets/images/homepage.js?v={{ assetTime() }}"></script>
    <script src="{{ env('AWS_S3_domain').'epicon/assets/images/socialSharing.js' }}?v={{ assetTime() }}"></script>

    <script src="{{ env('AWS_S3_domain').'epicon/assets/images/detail.js' }}?v={{ assetTime() }}"></script>
    <script src="{{ env('AWS_S3_domain') }}epicon/assets/images/common.js?v={{ assetTime() }}"></script>

    @if ($loadPlayer)
        {{-- <script src="{{ env('AWS_S3_domain').'epicon/assets/images/vendor/plyr.js' }}"></script> --}}
        {{-- <script src="{{ env('AWS_S3_domain').'epicon/assets/images/vendor/hls.min.js' }}"></script> --}}
        <script src="{{ env('AWS_S3_domain') }}epicon/assets/images/webvtt-subtitler.js"></script>
        <script src="{{ asset('assets/js/video-player.js') }}?v={{ assetTime() }}"></script>
    @endif

    <script>
        $(document).ready(function(){
            $("#video-start-from-beginning").click(function(){
                user_duration = 0;
                if (player) {
                    if (!$(".videoContainer").is(":visible")) {
                        $(".videoContainer").show();
                        $(".hide-vid-element").hide();
                    }
                    
                    player.currentTime=0;
                    player.play();
                } else {
                    if (!$(".videoContainer").is(":visible")) {
                        $(".videoContainer").show();
                    }
                    $(".loaderImg").hide();
                    $("#watchVideo").trigger("click");
                }
            })
        })
    </script>

@stop
