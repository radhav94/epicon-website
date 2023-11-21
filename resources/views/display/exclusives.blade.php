<section class="carousel-main pt-3 mb-3" id="tranding">
    <div class="container-fluid">
        <div class="carousel-title-n-arrow mb-3">
            <h1 class="text-white small">{{ $title }}</h1>
            @if (@$value['show_more'])
                <a href="{{ getMidPageUrl($value) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
                        fill="none">
                        <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            @endif
        </div>
        <div class="tranding-slider {{ getFirstSegment() == 'podcast' ? 'podcast-height' : '' }}">
            <div class="swiper-wrapper">
                @foreach ($value['content'] as $key => $val)
                    <?php
                    $card = getItemCardData($val, $displayLanguageParam);

                    if(isMobliDevice()){
                        $img =  in_array(@$slug, ['podcast','games'])  ? 'cover_image' : 'vertical_cover_image';
                        $cover_img = getCardImage($val, $img, 'medium');
                        // $cover_img = getCardImage($val, 'vertical_cover_image', 'medium');
                    }else{
                        $cover_img = getCardImage($val, 'banner_image', 'large');
                    }

                    ?>
                    <div class="swiper-slide tranding-slide">
                        <div class="tranding-slide-img position-relative">
                            <a href="{{ getContentUrl($val) }}">
                                <img src="{{ $cover_img }}" />
                            </a>
                            <div class="carousel-items-content position-absolute">
                                <h1>{{ $card['title'] }}</h1>
                                <h2>{{ $card['sub_text'] }}</h2>
                                <ul class="w-100 d-flex justify-content-between align-items-center list-unstyled mb-0">
                                    <li class="d-flex">

                                        @if(@$val['asset_type'] == 'PLAY')
                                        {!! getplayanchorhtml($val) !!}
                                        @else
                                        <a href="{{ getContentUrl($val) }}">
                                        @endif
                                            <button class="big-play d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                                    viewBox="0 0 28 28" fill="none">
                                                    <path
                                                        d="M26.25 14.0005C26.2507 14.2976 26.1745 14.5899 26.0289 14.8488C25.8832 15.1077 25.673 15.3246 25.4188 15.4782L9.66 25.1185C9.39431 25.2812 9.09001 25.37 8.77852 25.3758C8.46703 25.3816 8.15965 25.3041 7.88813 25.1513C7.61918 25.001 7.39515 24.7817 7.23905 24.516C7.08296 24.2503 7.00045 23.9479 7 23.6398V4.36133C7.00045 4.0532 7.08296 3.75076 7.23905 3.48509C7.39515 3.21943 7.61918 3.00014 7.88813 2.84976C8.15965 2.69702 8.46703 2.61953 8.77852 2.6253C9.09001 2.63107 9.39431 2.71989 9.66 2.88258L25.4188 12.5229C25.673 12.6765 25.8832 12.8934 26.0289 13.1523C26.1745 13.4112 26.2507 13.7035 26.25 14.0005Z"
                                                        fill="#272727"></path>
                                                </svg>&nbsp; {!! getPlayText($val) !!}</button>
                                        </a>
                                        {!! getWishListAction($val, $wishlist) !!}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="tranding-slider-control">
        <div class="swiper-button-prev slider-arrow">
            <img src="{{ asset('assets/img/hero-left-arrow.svg') }}" alt="arrow">
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next slider-arrow">
            <img src="{{ asset('assets/img/hero-right-arrow.svg') }}" alt="arrow">
        </div>
    </div>
</section>
