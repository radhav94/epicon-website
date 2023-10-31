
<section class="hero-banner w-100 {{ getFirstSegment() == 'podcast' ? 'podcast-banner' : '' }}">
    <div class="banner-carousel">
        @foreach ($value['content'] as $key => $val)
            <?php
            $card = getItemCardData($val, $displayLanguageParam);

            if(isMobliDevice()){
                $banner_img = getCardImage($val, 'banner_image', 'large');
            }else{
                $banner_img = getCardImage($val, 'vertical_cover_image', 'medium');
            }
            ?>
            <div class="carousel-card">
                {!! freePremiumDiv($val) !!}
                <div class="carousel-items position-relative w-100">
                    <a href="{{ getContentUrl($val) }}">
                        <img src="{{ $banner_img }}" alt="">
                    </a>
                    <div class="carousel-items-content position-absolute">
                        <h2>{{ $card['sub_text'] }}</h2>
                        <p>{{ @$val['title'] }}</p>
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
                                                fill="#272727" />
                                        </svg>&nbsp; {!! getPlayText($val) !!}</button>
                                </a>
                                {!! getWishListAction($val, $wishlist) !!}

                                {{-- <button class="big-add-list">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                                    <path d="M21.0026 15.1678H15.1693V21.0011C15.1693 21.6428 14.6443 22.1678 14.0026 22.1678C13.3609 22.1678 12.8359 21.6428 12.8359 21.0011V15.1678H7.0026C6.36094 15.1678 5.83594 14.6428 5.83594 14.0011C5.83594 13.3595 6.36094 12.8345 7.0026 12.8345H12.8359V7.00114C12.8359 6.35947 13.3609 5.83447 14.0026 5.83447C14.6443 5.83447 15.1693 6.35947 15.1693 7.00114V12.8345H21.0026C21.6443 12.8345 22.1693 13.3595 22.1693 14.0011C22.1693 14.6428 21.6443 15.1678 21.0026 15.1678Z" fill="white" />
                                </svg></button>  --}}
                            </li>
                        </ul>
                    </div>
                </div>
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
