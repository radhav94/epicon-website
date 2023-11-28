<section class="carousel-main mt-0">
    <div class="carousel-title-n-arrow px-2 mb-2">
        <h1 class="text-white small">{{ $title }}</h1>
        @if (@$value['show_more'])
            <a onclick="click_cta(this)" data-event_context="{{ @$title }}" data-element_text="SEE ALL" href="{{ getMidPageUrl($value) }}">
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
            $cover_img = isset($val['images']['small']) ? $val['images']['small'] : $card['banner_img'];
            
            ?>
            <div class="plang">
                <a onclick="click_tile(this)" data-title ="{{ @$val['name'] }}" data-type="{{@$title}}" href="{{ getUrl('explore/' . @$val['slug']) }}">
                    <img src="{{ isset($cover_img) ? $cover_img : ''}}">
                    <!-- <div class="language">
                        <h1>{{ @$val['name'] }}</h1>
                        <span>{{ @$val['name'] }}</span>
                    </div> -->
                </a>
            </div>
        @endforeach

    </div>
</section>
