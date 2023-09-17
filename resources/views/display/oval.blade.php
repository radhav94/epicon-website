<div class="carousel-main">
    <div class="carousel-title-n-arrow px-2">
        <h1 class="text-white small">{{ $title }}</h1>
        @if (@$value['show_more'])
            <a href="{{ getMidPageUrl($value) }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </a>
        @endif
    </div>
    <ul class="vertical-carousel-initilize p-0">

        @foreach ($value['content'] as $key => $val)
            <?php
            $card = getItemCardData($val, $displayLanguageParam);
            $cover_img = isset($val['cover_image']) ? $val['cover_image']['medium'] : $card['banner_img'];
            ?>
            <li>
                @include('components.item-hover-card')
                <a href="javascript:void(0);" class="main-card">
                    {!! freePremiumDiv($val) !!}

                    <div class="main-img oval-shape avilable-audio">
                        <img src="{{ $cover_img }}" alt="">
                        <ul class="">
                            {{-- <li>Available in 4 audios</li> --}}
                            @if (@$val['is_new'])
                                <li>New Movie</li>
                            @endif
                        </ul>
                    </div>
                </a>
            </li>
        @endforeach

    </ul>
</div>
