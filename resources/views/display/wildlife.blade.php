<section class="carousel-main new-release mt-0">
    <div class="carousel-title-n-arrow px-2 mb-2">
        <h1 class="text-white small">{{ $title }}</h1>
        <a href="">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </a>
    </div>
    <div class="wildlife">
        <?php
        $chunks = array_chunk($value['content'], 2);
        
        ?>
        @foreach ($chunks as $key => $val)
            <div class="wildlife-wrapper d-flex">
                <div>
                    @foreach ($val as $k => $v)
                        <?php
                        $card = getItemCardData($v, $displayLanguageParam);
                        $cover_img = isset($v['vertical_cover_image']) ? $v['vertical_cover_image']['large'] : $card['banner_img'];
                        ?>

                        <a href="#/" class="{{ $k == 0 ? 'left' : 'right' }}">
                            <img src="{{ $cover_img }}" alt="">
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach

    </div>
</section>
