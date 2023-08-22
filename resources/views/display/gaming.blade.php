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
                 <a href="">
                     <img src="{{ $card['banner_img'] }}" alt="game">
                     <h1>{{ $card['title'] }}</h1>
                     <span>Strategy</span>
                 </a>
             </div>
             @endforeach
         </div>
     </div>
 </section>