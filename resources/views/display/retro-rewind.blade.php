 <section class="carousel-main mt-0">
     <div class="punjab">
         <div class="punjab-da-swaad align-items-center" style="background: none;">
             <div class="punjab-title">
                 <img class="w-100 mb-4" src="{{ asset('assets/img/retro-rewind.svg') }}" alt="">
                 @if (@$value['show_more'])
                     <a href="{{ getMidPageUrl($value) }}">
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
                     <a href="{{ route('retro-list', $val['slug']) }}" class="main-card">
                         <div class="main-img mt-0">
                             <img src="{{ $cover_img }}" alt="retro">
                         </div>
                     </a>
                 </li>
             @endforeach

         </ul>
     </div>
 </section>
