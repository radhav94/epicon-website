<div class="carousel-main supermix-main">
    <div class="container-fluid px-0">

        {{-- @foreach ($value['content'] as $key => $val) --}}
        <?php
        $card = getItemCardData($value, $displayLanguageParam);
        ?>

        <div class="col-12">
            <div class="super-mix w-100 text-white pb-0">
                <img src="{{ @$value['tray_image'] }}" class="supImg" alt="">
                <div class="d-flex align-items-baseline aie supermix-bottom-text">
                    <h1 class="me-3">{{ $card['title'] }} </h1><span> {!! sanitizeData(@$value['description'] ?? '') !!} </span>
                </div>
                <button onclick="click_cta(this)" data-event_context="{!! sanitizeData(@$value['description'] ?? '') !!}" data-element_text="Start MixTape" class="start-mix-btn superMixButton">Start MixTape</button>
            </div>
        </div>
        {{-- @endforeach --}}
    </div>
</div>
