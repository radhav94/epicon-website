<?php 

$addClass = isKidsPage() ? "allAccessBtn" : "";
$loginclass ="";
if (!isUserLoggedIn()) {
    $loginclass = "checklogin";
}else{
    $loginclass = $addClass;
}
?> 
 
 <div class="carousel-main">
     <div class="carousel-title-n-arrow px-2">
         <h1 class="text-white small">{{ $title }}</h1>
         @if (@$value['show_more'])
             <a href="{{ getMidPageUrl($value) }}">
                 <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                     <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round" />
                 </svg>
             </a>
         @endif
     </div>
     {{--
     <ul class="vertical-carousel-initilize p-0 mb-0">

         @foreach ($value['content'] as $key => $val)
             <?php
             $card = getItemCardData($val, $displayLanguageParam);
             
             $cover_img = getCardImage($val, 'cover_image', 'medium', ['epic_shorts_image', 'banner_image']);
             
             ?>
             <li>
                 <a href="{{ isset($val['game_url']) ? @$val['game_url'] : $val['url'] }}" class="main-card">
                     <div class="main-img eod-darlings pb-0">
                         <img src="{{ $cover_img }}" alt="">
                     </div>
                 </a>
             </li>
         @endforeach

     </ul> --}}


     {{-- <ul class="carousel-initilize p-0"> --}}

     <ul class="games p-0 mb-0">
         @foreach ($value['content'] as $key => $val)
             <?php
            //  print_r($val);
             $card = getItemCardData($val, $displayLanguageParam);
             $cover_img = isset($val['cover_image']) ? $val['cover_image']['small'] : $card['banner_img'];
             ?>
             <li class="me-3">

                 <a href="{{ isset($val['game_url']) ? 'javascript:void(0)' : $val['url'] }}" data-url="{{ isset($val['game_url']) ? @$val['game_url'] : $val['url'] }}" data-premium="{{ @$val['free_premium'] }}" data-activesubscriber="{{ isActiveSubscription() }}" check-login="{{$loginclass}}" class="main-card {{ isset($val['game_url']) ? 'check-content-url' : '' }}">
                     {!! freePremiumDiv($val) !!}
                     @if (@$extra['hide_top10'] != 1)
                         {!! topTenDiv($val) !!}
                     @endif
                     <div class="main-img eod-darlings">
                         <img src="{{ $cover_img }}" alt="">
                         {{-- <div class="new-show-title">New Show</div> --}}
                     </div>
                 </a>
             </li>
         @endforeach

     </ul>

 </div>
