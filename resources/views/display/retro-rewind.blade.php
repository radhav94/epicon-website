 <section class="carousel-main mt-0">
     <div class="punjab">
         <div class="punjab-da-swaad align-items-center" style="background: none;">
             <div class="punjab-title">
                 <img class="w-100 mb-4" src="{{ asset('assets/img/retro-rewind.svg') }}" alt="">
                 @if (@$value['show_more'])
                     <a onclick="click_cta(this)" data-event_context="Retro Rewind" data-element_text="Explore More" href="{{ getMidPageUrl($value) }}">
                         <button>Explore More</button>
                     </a>
                 @endif
             </div>
         </div>
         <ul class="vertical-carousel-retro p-0 mb-0 mt-4">

             @foreach ($value['content'] as $key => $val)
                 <?php
                 $card = getItemCardData($val, $displayLanguageParam);
                 $cover_img = isset($val['vertical_cover_image']) ? $val['vertical_cover_image']['large'] : @$val['image'];
                 
                 ?>
                 <li>
                     <a aria-label="item-main" onclick="click_tile(this)" data-title ="{{ @$val['title'] }}" data-type="{{@$title}}"  href="{{ route('retro-list', $val['slug']) }}" class="main-card">
                         <div class="main-img mt-0">
                             <img src="{{ $cover_img }}" alt="retro">
                         </div>
                     </a>
                 </li>
             @endforeach

         </ul>
     </div>
 </section>
