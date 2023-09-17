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
             $cover_img = isset($val['cover_image']) ? $val['cover_image']['small'] : $card['banner_img'];
             ?>
             <li>
                 <a href="{{ @$val['game_url'] }}" class="main-card">
                     <div class="main-img eod-darlings pb-0">
                         <img src="{{ $cover_img }}" alt="">
                     </div>
                 </a>
             </li>
         @endforeach

     </ul> --}}


     {{-- <ul class="carousel-initilize p-0"> --}}

     <ul class="vertical-carousel-initilize p-0 mb-0">
         @foreach ($value['content'] as $key => $val)
             <?php
             $card = getItemCardData($val, $displayLanguageParam);
             $cover_img = isset($val['cover_image']) ? $val['cover_image']['small'] : $card['banner_img'];
             ?>
             <li>

                 <a href="{{ @$val['game_url'] }}" class="main-card">
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
