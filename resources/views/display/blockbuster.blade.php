 <section class="carousel-main mt-0">
     <div class="gaming-galore-main">
         <div class="galore-title">
             <h1>{{ $title }}</h1>
             @if (@$value['show_more'])
                 <a href="{{ getMidPageUrl($value) }}">
                     <button>Explore More</button>
                 </a>
             @endif
         </div>
         <div class="gaming-galore">
    
             @foreach ($value['content'] as $key => $val)
                 <?php

                 $imgKey = (@$val['asset_type'] == 'PLAY') ? 'cover_image' : 'vertical_cover_image'; 

                 $card = getItemCardData($val, $displayLanguageParam);
                 $cover_img = getCardImage($val, $imgKey, 'medium');
                 
                 ?>

                 <div>
                    @if(@$val['asset_type'] == 'PLAY')
                                {!! getplayanchorhtml($val) !!}
                    @else
                    <a href="{{ getContentUrl($val) }}">
                    @endif
                         <img src="{{ $cover_img }}" alt="{{ $val['title'] }}">
                     </a>
                 </div>
             @endforeach
         </div>
     </div>
 </section>
