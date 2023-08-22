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
                ?>

             <div>
                 <a href="{{ url($val['url']) }}">
                     <img src="{{ $card['banner_img'] }}" alt="game">
                 </a>
             </div>
             @endforeach
         </div>
     </div>
 </section>