<section class="carousel-main mt-0">
    <div class="carousel-title-n-arrow px-2 pb-3">
        <h1 class="text-white small">{{ $title }}</h1>
        @if (@$value['show_more'])
            <a href="{{ url($value['slug'] ?? '/') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        @endif
    </div>
    <div class="popular-language">

        @foreach ($value['content'] as $key => $val)
            <?php
            $card = getItemCardData($val, $displayLanguageParam);
            $cover_img = isset($val['vertical_cover_image']) ? $val['vertical_cover_image']['large'] : $card['banner_img'];
            
            ?>
            <div class="plang">
                <a href="#/">
                    <img src="public/img/language-bg-1.svg" alt="shots">
                    <div class="language">
                        <h1>मराठी</h1>
                        <span>Marathi</span>
                    </div>
                </a>
            </div>
        @endforeach

    </div>
</section>
