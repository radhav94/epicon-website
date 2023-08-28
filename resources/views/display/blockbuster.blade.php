 <section class="carousel-main mt-0">
     <div class="gaming-galore-main">
         <div class="galore-title">
             <h1>{{ $title }}</h1>
             <button>Explore More</button>
         </div>
         <div class="gaming-galore">

             @foreach($value['content'] as $key => $val)
             <?php
                $card = getItemCardData($val, $displayLanguageParam);
                $cover_img =  isset($val['vertical_cover_image']) ? $val['vertical_cover_image']['large'] : $card['banner_img'];

                ?>

             <div>
                 <a href="{{ url($val['url']) }}">
                     <img src="{{ $cover_img }}" alt="{{ $val['title'] }}">
                 </a>
             </div>
             @endforeach
         </div>
     </div>
 </section>