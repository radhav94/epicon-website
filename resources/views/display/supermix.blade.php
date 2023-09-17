<div class="carousel-main supermix-main">
    <div class="container-fluid">

        {{-- @foreach ($value['content'] as $key => $val) --}}
        <?php
        $card = getItemCardData($value, $displayLanguageParam);
        ?>

        <div class="col-12">
            <div class="super-mix w-100 text-white">
                <img src="{{ @$value['tray_image'] }}" class="supImg" alt="">
                <div class="d-flex align-items-baseline aie">
                    <h1 class="me-3">{{ $card['title'] }} </h1><span> {{ @$value['description'] ?? '' }} </span>
                </div>
                <button class="start-mix-btn superMixButton">Start MixTape</button>
            </div>
        </div>
        {{-- @endforeach --}}
    </div>
</div>
