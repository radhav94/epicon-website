<section class="carousel-main mt-0">
    <div class="carousel-title-n-arrow px-2 pb-3">
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
    <div class="gaming-galore-main">
        <div class="epic-channel">
            @foreach ($value['content'] as $key => $val)
            <?php $slug = urldecode(@$val['slug']);
             $slug = explode("|", $slug);
                if (count($slug) >= 2) {
                    $slug = $slug[1];
                }
            ?>
                <div>
                    <a onclick="click_tile(this)" data-title ="{{ @$val['name'] }}" data-type="{{@$title}}" href="{{ getUrl('channels/'.$slug) }}">
                    <!-- <a href="{{ isset($val['path']) ? getUrl(@$val['path']) : @$val['url'] }}"> -->
                        <img src="{{ @$val['image'] }}" alt="{{ @$val['name'] }}">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>