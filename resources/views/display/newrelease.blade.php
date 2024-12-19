 <section class="carousel-main new-release mt-0">
     <div class="container">
         <div class="ribbon mb-3">
             <img src="{{ env('AWS_S3_domain').'epicon/assets/images/ribbon.svg' }}" alt="">
             <h1>{{ $title }}</h1>
         </div>
     </div>

     <?php

     $sub_slider_html = '';
     ?>

     <div class="hero-banner-new-release w-100">
         <div class="banner-carousel-new-release">

             @foreach ($value['content'] ?? [] as $key => $val)
                 <?php
                 $card = getItemCardData($val, $displayLanguageParam);

                 $banner_img = getCardImage($val, 'banner_image', 'large', ['cover_image']);
                 $cover_img = getCardImage($val, 'vertical_cover_image', 'medium', ['cover_image', 'banner_image']);

                 $li = '';
                 if (@$val['duration']) {
                     $li .= '<li>' . convertSecondsToReadable($val['duration']) . '</li>';
                 }

                 $se_epi_text = getSeasonEpisodeNum($val);
                 $s_txt = '';

                 $s_txt .= isset($se_epi_text['season']) ? ' ' . $se_epi_text['season'] : '';
                 $s_txt .= isset($se_epi_text['episode']) ? '<b>' . $se_epi_text['episode'] . '</b>' : '';

                 if ($s_txt) {
                     $s_txt = '<li>' . $s_txt . '</li>';
                 }

                 $sub_slider_html .= '<div class="new-release-card"><img src="' . $cover_img . '" alt=""><div class="new-episode-time"> <ul>' . $s_txt . ' ' . $li . '</ul></div></div>';
                 ?>
                 <div class="carousel-card">
                     {!! freePremiumDiv($val) !!}

                     <div class="carousel-items position-relative w-100">
                        <a aria-label="banner" onclick="click_carousel(this)" data-title ="{{ @$val['title'] }}"  href="{{ getContentUrl($val) }}">
                            <img src="{{ $banner_img }}" alt="">
                        </a>
                         <div class="carousel-items-content position-absolute">
                             {{-- <!-- <h1 class="banner-movie-tittle">{{ $card['title'] }}</h1> --> --}}
                             <h2 class="mb-3">{{ $card['sub_text'] }}</h2>
                             <ul class="w-100 d-flex justify-content-between align-items-center list-unstyled mb-0">
                                 <li class="d-flex">
                                     @if (@$val['asset_type'] == 'PLAY')
                                         {!! getplayanchorhtml($val) !!}
                                     @else
                                         <a onclick="click_carousel(this)" data-title ="{{ @$val['title'] }}" class="big-play" href="{{ getContentUrl($val) }}">
                                     @endif
                                     {{-- <button class="big-play d-flex align-items-center"> --}}
                                         <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                             viewBox="0 0 28 28" fill="none">
                                             <path
                                                 d="M26.25 14.0005C26.2507 14.2976 26.1745 14.5899 26.0289 14.8488C25.8832 15.1077 25.673 15.3246 25.4188 15.4782L9.66 25.1185C9.39431 25.2812 9.09001 25.37 8.77852 25.3758C8.46703 25.3816 8.15965 25.3041 7.88813 25.1513C7.61918 25.001 7.39515 24.7817 7.23905 24.516C7.08296 24.2503 7.00045 23.9479 7 23.6398V4.36133C7.00045 4.0532 7.08296 3.75076 7.23905 3.48509C7.39515 3.21943 7.61918 3.00014 7.88813 2.84976C8.15965 2.69702 8.46703 2.61953 8.77852 2.6253C9.09001 2.63107 9.39431 2.71989 9.66 2.88258L25.4188 12.5229C25.673 12.6765 25.8832 12.8934 26.0289 13.1523C26.1745 13.4112 26.2507 13.7035 26.25 14.0005Z"
                                                 fill="#272727" />
                                         </svg>&nbsp; {!! getPlayText($val) !!}
                                        {{-- </button> --}}
                                     </a>

                                     {!! getWishListAction($val, $wishlist) !!}
                                 </li>
                             </ul>
                         </div>
                     </div>
                 </div>
             @endforeach

         </div>
         <!-- carousel control -->

         <div class="slider-controls-new-release">
             <button type="button" class="slide-m-prev-new-release">prev</button>
             <div class="slide-m-dots-new-release"></div>
             <button type="button" class="slide-m-next-new-release">next</button>
         </div>
     </div>

     <section class="carousel-main new-release-bottom-main mt-0">
         <div class="container">
             <div class="new-release-bottom w-100">

                 @foreach ($value['content'] ?? [] as $key => $val)
                     <div class="episode-wrapper-nr-{{ $key }} episode-wrapper-nr {{ ($key ==0) ? 'active' : '' }}">
                         @foreach ($val['episodes'] ?? [] as $epickey => $data)
                             <?php $li = '';
                             if (!isset($data['url']) || (isset($data['status']) && $data['status'] != 1)) {
                                continue;
                             }
                             if (@$data['duration']) {
                                 $li = convertSecondsToReadable($data['duration']);
                             }

                             $se_epi_text = getSeasonEpisodeNum($data);
                             $s_txt = '';

                             $s_txt .= isset($se_epi_text['season']) ? $se_epi_text['season'] : '';
                             $s_txt .= isset($se_epi_text['episode']) ? $se_epi_text['episode'] : '';

                             if ($s_txt) {
                                 $s_txt = $s_txt;
                             }
                             $child_cover_img = getCardImage($data, 'cover_image', 'medium', ['epic_shorts_image', 'banner_image']);
                             ?>
                            @if (isset($data['url']) && !empty($data['url']))
                             <div class="new-release-card new-release-card-{{ $key }}"><a onclick="click_tile(this)" data-title ="{{ @$val['title'] }}" data-type="{{@$title}}"
                                     href="{{ getContentUrl($data) }}"><img src="{{ $child_cover_img }}" alt="">
                                 </a>
                                 <div class="new-episode-time">
                                     <ul><span class="nr_epi">{{ $s_txt }}</span> <span
                                             class="nr_time">{{ $li }}</span> </ul>
                                 </div>
                             </div>
                             @endif

                         @endforeach
                     </div>
                 @endforeach

             </div>
         </div>
     </section>
 </section>
