<div class="carousel-main">
     <div class="carousel-title-n-arrow px-2 mb-2">
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
     <ul class="vertical-carousel-initilize top-ten p-0">

         @foreach ($value['content'] as $key => $val)
             <?php
             $card = getItemCardData($val, $displayLanguageParam);
             
             $cover_img = getCardImage($val, 'vertical_cover_image', 'small', ['cover_image', 'banner_image']);
             
             $extra = ['hide_top10' => 1];
             ?>

             <li>
                 @include('components.item-hover-card', [
                     'extra' => $extra,
                 ])
                 @if(@$val['asset_type'] == 'PLAY')
                    {!! getplayanchorhtml($val) !!}
                @else
                    <a class="main-card" href="{{ getContentUrl($val) }}">
                @endif
                     {!! freePremiumDiv($val) !!}
                     <div class="main-img mt-0">
                         <img src="{{ $cover_img }}" alt="">
                         <div class="top-10-number"><img src="public/img/{{ $key + 1 }}.svg" alt="1"></div>
                     </div>
                 </a>
             </li>
         @endforeach

     </ul>
 </div>
