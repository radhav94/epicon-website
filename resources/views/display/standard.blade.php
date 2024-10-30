 <div class="carousel-main">
     <div class="carousel-title-n-arrow px-2">
         <h5 class="text-white">{{ $title }}</h5>
         @include('components.view-more')
     </div>
     <ul class="vertical-carousel-initilize p-0">
         @foreach ($value['content'] as $key => $val)
             <?php
             $card = getItemCardData($val, $displayLanguageParam);
             
             $cover_img = getCardImage($val, 'vertical_cover_image', 'medium');
             
             $getTitle = getNewTitle($val);
             ?>
             <li>
                @include('components.item-hover-card')
                @if(@$val['asset_type'] == 'PLAY')
                    {!! getplayanchorhtml($val) !!}
                @else
                    <a class="main-card" onclick="click_tile(this)" aria-label="{{ @$val['title'] }}" data-title ="{{ @$val['title'] }}" data-type="{{@$title}}" href="{{ getContentUrl($val) }}">
                @endif
                     {!! freePremiumDiv($val) !!}
                     {!! topTenDiv($val) !!}
                     <div class="main-img {{$getTitle['cls']}}">
                         <img src="{{ $cover_img }}" alt="{{ @$val['title'] }}">
                         {!! $getTitle['html'] !!}
                     </div>
                 </a>
             </li>
         @endforeach
     </ul>
 </div>
