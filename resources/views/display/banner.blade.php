<section class="hero-banner w-100">
    <div class="banner-carousel">
        @foreach ($value['content'] as $key => $val)
            <?php
            $card = getItemCardData($val, $displayLanguageParam);
            ?>
            <div class="carousel-card">
                <button class="mute-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path
                            d="M15 11.3333L16.6667 9.66667M16.6667 9.66667L18.3333 8M16.6667 9.66667L15 8M16.6667 9.66667L18.3333 11.3333"
                            stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path
                            d="M1 11.3332V8.2382C1 7.79617 1.17559 7.37225 1.48816 7.05968C1.80072 6.74712 2.22464 6.57153 2.66667 6.57153H5.08333C5.24627 6.57149 5.40562 6.52368 5.54167 6.43403L10.5417 3.13736C10.6673 3.05463 10.813 3.00744 10.9632 3.00081C11.1135 2.99418 11.2628 3.02834 11.3952 3.09968C11.5277 3.17102 11.6383 3.27688 11.7154 3.40602C11.7926 3.53516 11.8333 3.68277 11.8333 3.8332V15.7382C11.8333 15.8886 11.7926 16.0362 11.7154 16.1654C11.6383 16.2945 11.5277 16.4004 11.3952 16.4717C11.2628 16.543 11.1135 16.5772 10.9632 16.5706C10.813 16.5639 10.6673 16.5168 10.5417 16.434L5.54167 13.1374C5.40562 13.0477 5.24627 12.9999 5.08333 12.9999H2.66667C2.22464 12.9999 1.80072 12.8243 1.48816 12.5117C1.17559 12.1991 1 11.7752 1 11.3332Z"
                            stroke="white" stroke-width="1.5"></path>
                    </svg>
                </button>
                {!! freePremiumDiv($val) !!}
                <div class="carousel-items position-relative w-100">
                    <img src="{{ $card['banner_img'] }}" alt="">
                    <div class="carousel-items-content position-absolute">
                        <h2>{{ $card['sub_text'] }}</h2>
                        <p> {{ $card['short_desc'] }} </p>
                        <ul class="w-100 d-flex justify-content-between align-items-center list-unstyled mb-0">
                            <li class="d-flex">
                                <a href="{{ getContentUrl($val) }}">
                                    <button class="big-play d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                            viewBox="0 0 28 28" fill="none">
                                            <path
                                                d="M26.25 14.0005C26.2507 14.2976 26.1745 14.5899 26.0289 14.8488C25.8832 15.1077 25.673 15.3246 25.4188 15.4782L9.66 25.1185C9.39431 25.2812 9.09001 25.37 8.77852 25.3758C8.46703 25.3816 8.15965 25.3041 7.88813 25.1513C7.61918 25.001 7.39515 24.7817 7.23905 24.516C7.08296 24.2503 7.00045 23.9479 7 23.6398V4.36133C7.00045 4.0532 7.08296 3.75076 7.23905 3.48509C7.39515 3.21943 7.61918 3.00014 7.88813 2.84976C8.15965 2.69702 8.46703 2.61953 8.77852 2.6253C9.09001 2.63107 9.39431 2.71989 9.66 2.88258L25.4188 12.5229C25.673 12.6765 25.8832 12.8934 26.0289 13.1523C26.1745 13.4112 26.2507 13.7035 26.25 14.0005Z"
                                                fill="#272727" />
                                        </svg>&nbsp; {{__('Play')}}</button>
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
