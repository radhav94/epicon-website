 <section class="carousel-main mt-0">
     <div class="gaming-galore-main">
         <div class="galore-title">
             <h1>{{ $title }}</h1>
             @if (@$value['show_more'])
                 <button>Explore More</button>
             @endif
         </div>
         <div class="gaming-galore">

             @foreach ($value['content'] as $key => $val)
                 <?php
                 $card = getItemCardData($val, $displayLanguageParam);
                 $cover_img = isset($val['cover_image']) ? $val['cover_image']['small'] : $card['banner_img'];
                 ?>

                 <div>
                     <a href="{{ getContentUrl($val) }}">
                         <img src="{{ $cover_img }}" alt="game">
                         <h1>{{ $card['title'] }}</h1>
                         <span>{{ @$val['content_type'] }}</span>
                     </a>
                 </div>
             @endforeach
         </div>
     </div>
 </section>
