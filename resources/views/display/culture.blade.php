   <section class="carousel-main mt-5">
       <div class="punjab">
           <div class="punjab-da-swaad">
               <div class="punjab-title arvr-text">
                   @if (@$value['background_image'])
                       <img src="{{ $value['background_image'] }}" alt="">
                   @endif
                   <div class="text">
                       <!-- <h1>{{ $title }}</h1> -->
                       @if (@$value['show_more'])
                           <a href="{{ getMidPageUrl($value) }}">
                               <button>Explore More</button>
                           </a>
                       @endif
                   </div>
               </div>
           </div>
           <ul class="{{ @$slug == 'games' ? 'ar-vr' : 'bollywood-tray' }} p-0 mb-0">
               @foreach ($value['content'] as $key => $val)
                   <?php
                   $card = getItemCardData($val, $displayLanguageParam);
                   $cover_img = getCardImage($val, 'cover_image', 'medium', ['epic_shorts_image', 'banner_image']);
                   
                   ?>
                   <li>
                       {{-- @include('components.item-hover-card') --}}
                       @if(@$val['asset_type'] == 'PLAY')
                            {!! getplayanchorhtml($val) !!}
                        @else
                            <a href="{{ getContentUrl($val) }}" class="main-card">
                        @endif
                           {!! freePremiumDiv($val) !!}
                           {!! topTenDiv($val) !!}
                           <div class="main-img eod-darlings">
                               <img src="{{ $cover_img }}" alt="">
                           </div>
                       </a>
                   </li>
               @endforeach

           </ul>
       </div>
   </section>
