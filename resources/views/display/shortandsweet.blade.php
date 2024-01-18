<div class="carousel-main">
    <div class="carousel-title-n-arrow px-2">
        <h5 class="text-white">{{ $title }}</h5>
        @if (@$value['show_more'])
            <a href="{{ getMidPageUrl($value) }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        @endif
    </div>
    <ul class="short-sweet-carousel p-0">
        @foreach ($value['content'] as $key => $val)
            <?php
            $card = getItemCardData($val, $displayLanguageParam);
            
            $cover_img = getCardImage($val, 'cover_image', 'medium', ['epic_shorts_image', 'banner_image']);
            
            ?>
            <li>
                <div class="short-sweet-card">
                    <div class="ss-card-img">
                        <img src="{{ $card['banner_img'] }}" width="100%" alt="">
                    </div>
                </div>
                <div class="short-sweet-shots">
                    <a href="">
                        <img src="{{ $cover_img }}" alt="">
                    </a>
                </div>
            </li>
        @endforeach


    </ul>
</div>
