<section class="carousel-main new-release mt-0">
    <div class="carousel-title-n-arrow px-2 mb-4">
        <h1 class="text-white small">{{ $title }}</h1>
        @if (@$value['show_more'])
            <a onclick="click_cta(this)" data-event_context="{{ $title }}" data-element_text="SEE ALL" href="{{ getMidPageUrl($value) }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </a>
        @endif
    </div>
    <div class="delights-display">

        @foreach ($value['content'] as $key => $val)
            <?php
            $card = getItemCardData($val, $displayLanguageParam);
            $cover_img = getCardImage($val, 'culinary_delights_image', 'medium');
            ?>
            <div>
                @if(@$val['asset_type'] == 'PLAY')
                    {!! getplayanchorhtml($val) !!}
                @else
                <a onclick="click_tile(this)" data-title ="{{ @$val['title'] }}" data-type="{{@$title}}" href="{{ getContentUrl($val) }}" class="content">
                @endif
                    <div class="top">
                        <img src="{{ $cover_img }}" alt="img">
                    </div>
                    <div class="bottom">
                        <h1>{{ $card['title'] }}</h1>
                        <p>{{ $card['short_desc'] }}</p>
                    </div>
                </a>
            </div>
        @endforeach


    </div>
</section>
