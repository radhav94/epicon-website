<div class="carousel-main">
    <div class="carousel-title-n-arrow px-2">
        <h1 class="text-white">{{ $title }}</h1>
        @if (@$value['show_more'])
            <a onclick="click_cta(this)" data-event_context="{{ @$title }}" data-element_text="SEE ALL" href="{{ getMidPageUrl($value) }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        @endif
    </div>
    <ul class="vertical-carousel-initilize p-0">
        @foreach ($value['content'] as $key => $val)
            <?php
            $card = getItemCardData($val, $displayLanguageParam);
            
            $cover_img = getCardImage($val, 'cover_image', 'medium', ['epic_shorts_image', 'banner_image']);
            
            ?>
            <li>
                @if(@$val['asset_type'] == 'PLAY')
                {!! getplayanchorhtml($val) !!}
                @else
                <a aria-label="item-main" onclick="click_tile(this)" data-title ="{{ @$val['title'] }}" data-type="{{@$title}}" href="{{ getContentUrl($val) }}" class="main-card">
                @endif
                    <div class="main-img eod-darlings">
                        {!! freePremiumDiv($val) !!}
                        <img src="{{ $cover_img }}" alt="">
                        <div class="new-show-title"><img src="{{env('AWS_S3_domain')}}epicon/assets/images/sound-equalizer.svg" alt="">
                        </div>
                        @if (@$val['duration'])
                            <div class="sound-time">{{ convertSecondsToReadable($val['duration']) }}</div>
                        @endif
                    </div>
                </a>
            </li>
        @endforeach

    </ul>
</div>
