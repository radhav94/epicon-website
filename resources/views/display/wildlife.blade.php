<section class="carousel-main new-release mt-0">
    <div class="carousel-title-n-arrow px-2 mb-2">
        <h5 class="text-white">{{ $title }}</h5>
        @if (@$value['show_more'])
            <a onclick="click_cta(this)" data-event_context="{{@$title}}" data-element_text="SEE ALL" href="{{ getMidPageUrl($value) }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        @endif
    </div>
    <div class="wildlife">
        <?php
        $chunks = array_chunk($value['content'], 2);
        
        ?>
        @foreach ($chunks as $key => $val)
            <div class="wildlife-wrapper d-flex">

                @foreach ($val as $k => $v)
                    <?php
                    $card = getItemCardData($v, $displayLanguageParam);
                    
                    $cover_img = getCardImage($v, 'wildlife_image', 'large');
                    ?>
                    <div>
                        @if(@$v['asset_type'] == 'PLAY')
                        {!! getplayanchorhtml($v) !!}
                        @else
                        <a onclick="click_tile(this)" data-title ="{{ @$v['title'] }}" data-type="{{@$title}}" href="{{ getContentUrl($v) }}" class="{{ $k == 0 ? 'left' : 'right' }}">
                        @endif
                            <img fetchpriority="low" src="{{ $cover_img }}" alt="{{ @$v['title'] }}">
                        </a>
                    </div>
                @endforeach

            </div>
        @endforeach

    </div>
</section>
