
<section class="carousel-main mt-0">
    <div class="carousel-title-n-arrow px-2 pb-2">
        <h1 class="text-white">{{ $title }}</h1>

        @if (@$value['show_more'])
            <a onclick="click_cta(this)" data-event_context="{{ @$title }}" data-element_text="SEE ALL" href="{{ getUrl('live-tv') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        @endif
    </div>
    <div class="gaming-galore-main">
        <div class="carousel-initilize w-100">
            @foreach ($value['content'] as $key => $val)

            <?php 
            	 $banner_img = getCardImage($val, 'cover_image', 'medium');
            ?>
                <div class="live-trey-content">
                    <a onclick="click_tile(this)" aria-label="{{ @$val['content_owner'] }}" data-title ="{{ @$val['content_owner'] }}" data-type="{{@$title}}" href="{{ getUrl(@$val['url']) }}">
                        <img src="{{ $banner_img }}" alt="">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>