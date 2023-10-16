@if ($content)
<div class="carousel-main">
    <div class="carousel-title-n-arrow border-bot pb-4 px-2">
        <h1 class="text-white small">{{ count($content) }} SuperMixed Content
        </h1>
    </div>
    <ul class="list-unstyled col-12 p-0 mt-4 " id="sortable">
        @foreach ($content as $key => $value)
        <?php
        $card = getItemCardData($value, $displayLanguageParam);

        $cover_img = isset($value['cover_image_v2']) ? $value['cover_image_v2']['small'] : $card['banner_img'];
        ?>

        <li class="episode-main mb-4 ">
            <div class="pik supermixPlay" data-id="{{ @$value['ID'] }}" data-video="{{ @$value['supermix_url']['play_url'] }}">
                <img src="{{ $cover_img }}" alt="img" class="popupVideo">

                {!! freePremiumDiv($value) !!}
                {{-- <img class="crown" src="public/img/crown.svg" alt="icon"> --}}
            </div>
            <div class="episode-text-details">
                <h6>{{ @$value['title'] }}</h6>
                <span class="ua-drama">
                    @include('pages.detail.detail-components.sub-bullets', [
                    'v_content' => $value,
                    ])
                </span>
                <p class="col-sm-8 col-md-10 mt-2">
                    {{ @$value['short_description'] }}
                </p>
            </div>
            <button class="reorder-icon handle">
                <img src="{{ asset('assets/img/reorder-icon.svg') }}" alt="icon">
            </button>
        </li>
        @endforeach

    </ul>
</div>
@endif
