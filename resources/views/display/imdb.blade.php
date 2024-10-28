<section class="carousel-main new-release mt-0">
    <div class="carousel-title-n-arrow px-2 mb-2">
        <h5 class="text-white">{{ $title }}</h5>

        @if (@$value['show_more'])
            <a onclick="click_cta(this)" data-event_context="{{ $title }}" data-element_text="SEE ALL" href="{{ getMidPageUrl($value) }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </a>
        @endif

    </div>
    <div class="imdb">

        <?php
        $chunks = array_chunk($value['content'], 2);
        ?>

        @foreach ($chunks as $key => $val)
            <div class="imdb-cards">
                @foreach ($val as $k => $v)
                    <?php
                    //dd($v);
                    $card = getItemCardData($v, $displayLanguageParam);
                    
                    $cover_img = getCardImage($v, 'banner_image', 'medium');
                    
                    ?>

                    <div class="{{ $k == 0 ? 'imdb-top' : 'imdb-bottom' }}">
                        @if(@$v['asset_type'] == 'PLAY')
                            {!! getplayanchorhtml($v) !!}
                        @else
                        <a onclick="click_tile(this)" data-title ="{{ @$v['title'] }}" data-type="{{@$title}}" href="{{ getContentUrl($v) }}">
                        @endif
                            <img src="{{ $cover_img }}" alt="img">
                            <div class="content">
                                @if (@$v['free_premium'] == true)
                                    <img class="crown" src="{{ env('AWS_S3_domain') }}epicon/assets/images/crown.svg" alt="">
                                @endif
                                <div class="content-overlay">

                                    {{-- <!--
                                        <div class="imdb-rating">
                                            <ul>
                                                <li>8.5</li>
                                                <li><img src="{{ asset('assets/img/imdb-icon.png') }}" alt="img"></li>
                                            </ul>
                                        </div>
                                    --> --}}

                                    <div>
                                        <h1>{{ $card['title'] }}</h1>
                                        <ul>
                                            {!! $card['sub_points'] !!}
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endforeach


        {{--    <div class="imdb-cards">
        <div class="imdb-top position-relative">
            <a href="">
                <img src="public/img/imdb-banner.png" alt="img">
                <div class="content">
                    <img class="crown" src="public/img/crown.svg" alt="">
                    <div class="content-overlay">

                        <div class="imdb-rating">
                            <ul>
                                <li>8.5</li>
                                <li><img src="public/img/imdb-icon.png" alt="img"></li>
                            </ul>
                        </div>

                        <div>
                            <h1>Lal Banarsi</h1>
                            <ul>
                                <li>2023</li>
                                <li>● 3 Languages</li>
                                <li>● Mystery</li>
                            </ul>
                        </div>

                    </div>
                </div>
            </a>
        </div>
        <div class="imdb-bottom">
            <a href="">
                <img src="public/img/imdb-bottom-banner.png" alt="img">
                <div class="content">
                    <img class="crown" src="public/img/crown.svg" alt="">
                    <div class="content-overlay">

                        <div class="imdb-rating">
                            <ul>
                                <li>8.5</li>
                                <li><img src="public/img/imdb-icon.png" alt="img"></li>
                            </ul>
                        </div>

                        <div>
                            <h1>Lal Banarsi</h1>
                            <ul>
                                <li>2023</li>
                                <li>● 3 Languages</li>
                                <li>● Mystery</li>
                            </ul>
                        </div>

                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="imdb-cards">
        <div class="imdb-top">
            <a href="">
                <img src="public/img/imdb-banner.png" alt="img">
                <div class="content">
                    <img class="crown" src="public/img/crown.svg" alt="">
                    <div class="content-overlay">

                        <div class="imdb-rating">
                            <ul>
                                <li>8.5</li>
                                <li><img src="public/img/imdb-icon.png" alt="img"></li>
                            </ul>
                        </div>

                        <div>
                            <h1>Lal Banarsi</h1>
                            <ul>
                                <li>2023</li>
                                <li>● 3 Languages</li>
                                <li>● Mystery</li>
                            </ul>
                        </div>

                    </div>
                </div>
            </a>
        </div>
        <div class="imdb-bottom">
            <a href="">
                <img src="public/img/imdb-bottom-banner.png" alt="img">
                <div class="content">
                    <img class="crown" src="public/img/crown.svg" alt="">
                    <div class="content-overlay">

                        <div class="imdb-rating">
                            <ul>
                                <li>8.5</li>
                                <li><img src="public/img/imdb-icon.png" alt="img"></li>
                            </ul>
                        </div>

                        <div>
                            <h1>Lal Banarsi</h1>
                            <ul>
                                <li>2023</li>
                                <li>● 3 Languages</li>
                                <li>● Mystery</li>
                            </ul>
                        </div>

                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="imdb-cards">
        <div class="imdb-top">
            <a href="">
                <img src="public/img/imdb-banner.png" alt="img">
                <div class="content">
                    <img class="crown" src="public/img/crown.svg" alt="">
                    <div class="content-overlay">

                        <div class="imdb-rating">
                            <ul>
                                <li>8.5</li>
                                <li><img src="public/img/imdb-icon.png" alt="img"></li>
                            </ul>
                        </div>

                        <div>
                            <h1>Lal Banarsi</h1>
                            <ul>
                                <li>2023</li>
                                <li>● 3 Languages</li>
                                <li>● Mystery</li>
                            </ul>
                        </div>

                    </div>
                </div>
            </a>
        </div>
        <div class="imdb-bottom">
            <a href="">
                <img src="public/img/imdb-bottom-banner.png" alt="img">
                <div class="content">
                    <img class="crown" src="public/img/crown.svg" alt="">
                    <div class="content-overlay">

                        <div class="imdb-rating">
                            <ul>
                                <li>8.5</li>
                                <li><img src="public/img/imdb-icon.png" alt="img"></li>
                            </ul>
                        </div>

                        <div>
                            <h1>Lal Banarsi</h1>
                            <ul>
                                <li>2023</li>
                                <li>● 3 Languages</li>
                                <li>● Mystery</li>
                            </ul>
                        </div>

                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="imdb-cards">
        <div class="imdb-top">
            <a href="">
                <img src="public/img/imdb-banner.png" alt="img">
                <div class="content">
                    <img class="crown" src="public/img/crown.svg" alt="">
                    <div class="content-overlay">

                        <div class="imdb-rating">
                            <ul>
                                <li>8.5</li>
                                <li><img src="public/img/imdb-icon.png" alt="img"></li>
                            </ul>
                        </div>

                        <div>
                            <h1>Lal Banarsi</h1>
                            <ul>
                                <li>2023</li>
                                <li>● 3 Languages</li>
                                <li>● Mystery</li>
                            </ul>
                        </div>

                    </div>
                </div>
            </a>
        </div>
        <div class="imdb-bottom">
            <a href="">
                <img src="public/img/imdb-bottom-banner.png" alt="img">
                <div class="content">
                    <img class="crown" src="public/img/crown.svg" alt="">
                    <div class="content-overlay">

                        <div class="imdb-rating">
                            <ul>
                                <li>8.5</li>
                                <li><img src="public/img/imdb-icon.png" alt="img"></li>
                            </ul>
                        </div>

                        <div>
                            <h1>Lal Banarsi</h1>
                            <ul>
                                <li>2023</li>
                                <li>● 3 Languages</li>
                                <li>● Mystery</li>
                            </ul>
                        </div>

                    </div>
                </div>
            </a>
        </div>
    </div>
    --}}
    </div>
</section>
