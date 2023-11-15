<div class="carousel-main supermix-main">
    <div class="container-fluid px-0">

        @foreach($value['content'] as $key => $val)
        <?php
        $extra_text = '';

        foreach ($value['content'] as $key => $val) {
            if ($key == 0) {
                continue;
            }
            $extra_text .= ($extra_text == '') ? $val['title'] :
                ', ' . $val['title'];
        }

        $lastCommaPosition = strrpos($extra_text, ",");

        if ($lastCommaPosition !== false) {
            $extra_text = substr_replace($extra_text, " and ", $lastCommaPosition, 1);
        }
        ?>

        @endforeach

        <?php
        $card = getItemCardData($value['content'][0], $displayLanguageParam);
        ?>

        <div class="col-12">
            <div class="super-mix w-100 text-white">
                <img src="{{ $card['banner_img'] }}" alt="">
                <div class="d-flex align-items-baseline aie supermix-bottom-text">
                    <h1 class="me-3">{{ $card['title'] }} </h1><span> {{ $extra_text }} </span>
                </div>
                <button class="start-mix-btn">{{__('Start MixTape')}}</button>
            </div>
        </div>

    </div>
</div>