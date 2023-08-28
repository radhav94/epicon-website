<div class="carousel-main">
    <div class="carousel-title-n-arrow px-2">
        <h1 class="text-white small">{{ $title }}</h1>
        <a href="">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
    </div>
    <ul class="carousel-initilize p-0">

        @foreach ($value['content'] as $key => $val)
            <?php
            
            $card = getItemCardData($val, $displayLanguageParam);
            $cover_img = isset($val['cover_image']) ? $val['cover_image']['medium'] : $card['banner_img'];
            ?>
            <li>
                @include('components.item-hover-card')
                <a href="javascript:void(0);" class="main-card">
                    {{ freePremiumDiv($val) }}
                    {!! topTenDiv($val) !!}
                    <div class="main-img">
                        <img src="{{ $cover_img }}" alt="">
                    </div>
                </a>
            </li>
        @endforeach

    </ul>
</div>
