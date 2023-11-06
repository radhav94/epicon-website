 <section class="carousel-main mt-0">
     <div class="gaming-galore-main">
         <div class="galore-title">
             <h1>{{ $title }}</h1>
             @if (@$value['show_more'])
                 <a onclick="click_cta(this)" data-event_context="{{ @$title }}" data-element_text="SEE ALL" href="{{ getMidPageUrl($value) }}">
                     <button>Explore More</button>
                 </a>
             @endif
         </div>
         <div class="gaming-galore">

             @foreach ($value['content'] as $key => $val)
                 <?php
                 $card = getItemCardData($val, $displayLanguageParam);
                 $cover_img = getCardImage($val, 'vertical_cover_image', 'medium', ['cover_image', 'banner_image']);
                 
                 ?>

                 <div>
                    @if(@$val['asset_type'] == 'PLAY')
                                {!! getplayanchorhtml($val) !!}
                    @else
                    <a onclick="click_tile(this)" data-title ="{{ @$val['title'] }}" data-type="{{@$title}}" href="{{ getContentUrl($val) }}">
                    @endif
                         <img src="{{ $cover_img }}" alt="{{ $val['title'] }}">
                     </a>
                 </div>
             @endforeach
         </div>
     </div>
 </section>
