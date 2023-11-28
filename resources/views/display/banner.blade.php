<?php 
$firstSegment   = getFirstSegmentWithKids(); 
$isMoblile      = isMobliDevice();
?>

<section class="hero-banner w-100">
    <div class="banner-carousel">
        @foreach ($value['content'] as $key => $val)
            <?php
            $card = getItemCardData($val, $displayLanguageParam);

            if($isMoblile){
                $img =  in_array($firstSegment, ['podcast','games'])  ? 'cover_image' : 'vertical_cover_image';
                $banner_img = getCardImage($val, $img, 'medium');
            }else{
                $banner_img = getCardImage($val, 'banner_image', 'large');
            }
            
            ?>
            <div class="carousel-card">
                {!! freePremiumDiv($val) !!}
                <div class="carousel-items position-relative w-100">
                    <a href="{{ getContentUrl($val) }}" onclick="click_carousel(this)" data-title ="{{ @$val['title'] }}">
                        <img src="{{ $banner_img }}" alt="">
                    </a>
                    <div class="carousel-items-content position-absolute">
                        <h2>{{ $card['sub_text'] }}</h2>
                        <p> {{ @$val['title'] }} </p>
                        <ul class="d-flex justify-content-between align-items-center list-unstyled mb-0">
                            <li class="d-flex">
                                @if(@$val['asset_type'] == 'PLAY')
                                {!! getplayanchorhtml($val) !!}
                                @else
                                <a href="{{ getContentUrl($val) }}" onclick="click_carousel(this)" data-title ="{{ @$val['title'] }}">
                                @endif
                                    <button class="big-play d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                            viewBox="0 0 28 28" fill="none">
                                            <path
                                                d="M26.25 14.0005C26.2507 14.2976 26.1745 14.5899 26.0289 14.8488C25.8832 15.1077 25.673 15.3246 25.4188 15.4782L9.66 25.1185C9.39431 25.2812 9.09001 25.37 8.77852 25.3758C8.46703 25.3816 8.15965 25.3041 7.88813 25.1513C7.61918 25.001 7.39515 24.7817 7.23905 24.516C7.08296 24.2503 7.00045 23.9479 7 23.6398V4.36133C7.00045 4.0532 7.08296 3.75076 7.23905 3.48509C7.39515 3.21943 7.61918 3.00014 7.88813 2.84976C8.15965 2.69702 8.46703 2.61953 8.77852 2.6253C9.09001 2.63107 9.39431 2.71989 9.66 2.88258L25.4188 12.5229C25.673 12.6765 25.8832 12.8934 26.0289 13.1523C26.1745 13.4112 26.2507 13.7035 26.25 14.0005Z"
                                                fill="#272727" />
                                        </svg>&nbsp; {!! getPlayText($val) !!}</button>
                                </a>
                                {!! getWishListAction($val, $wishlist) !!}

                            </li>
                        </ul>
                    </div>
                </div> {{--  a tag end --}}
            </div>
        @endforeach
    </div>
    <!-- carousel control -->

    <div class="slider-controls">
        <button type="button" class="slide-m-prev">prev</button>
        <div class="slide-m-dots"></div>
        <button type="button" class="slide-m-next">next</button>
    </div>
</section>
