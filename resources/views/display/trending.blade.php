<div class="carousel-main">
    <div class="carousel-title-n-arrow px-2">
        <h5 class="text-white">{{ $title }}</h5>
        @if (@$value['show_more'])
            <a onclick="click_cta(this)" data-event_context="{{ @$title }}" data-element_text="SEE ALL" href="{{ getMidPageUrl($value) }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        @endif
    </div>
    <ul class="carousel-initilize p-0">

        @foreach ($value['content'] as $key => $val)
            <?php
            
            $card = getItemCardData($val, $displayLanguageParam);
            
            $cover_img = getCardImage($val, 'cover_image', 'medium', ['epic_shorts_image', 'banner_image']);
            
            $getTitle = getNewTitle($val);
            // dd($test);
            ?>
            <li>
                @include('components.item-hover-card')
                @if(@$val['asset_type'] == 'PLAY')
                    {!! getplayanchorhtml($val) !!}
                @else
                    <a onclick="click_tile(this)" data-title ="{{ @$val['title'] }}" data-type="{{@$title}}" class="main-card" href="{{ getContentUrl($val) }}">
                @endif
                    {{ freePremiumDiv($val) }}
                    {!! topTenDiv($val) !!}
                    <div class="main-img {{$getTitle['cls']}}">
                        <img src="{{ $cover_img }}" alt="">
                        {!! $getTitle['html'] !!}
                    </div>
                </a>
            </li>
        @endforeach

    </ul>
</div>
