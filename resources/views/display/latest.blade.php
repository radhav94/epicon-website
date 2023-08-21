<div class="carousel-main supermix-main">
    <div class="container-fluid">

        @foreach($value['content'] as $key => $val)
        <?php
        $card = getItemCardData($val, $displayLanguageParam);
        ?>

        <div class="col-12">
            <div class="super-mix w-100 text-white">
                <img src="{{ $card['banner_img'] }}" alt="">
                <div class="d-flex align-items-baseline aie">
                    <h1 class="me-3">{{ $card['title'] }} </h1><span> Lal Banarsi, Asur, Gullak, KGF, ZNMD and 3 Idiots </span>
                </div>
                <button class="start-mix-btn">Start MixTape</button>
            </div>
        </div>
        @break;
        @endforeach

    </div>
</div>