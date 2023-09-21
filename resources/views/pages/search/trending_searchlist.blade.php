<div class="w-100 mb-4">
    <div class="carousel-title-n-arrow mb-3">
        <h1 class="text-white small">Trending Moments</h1>
        <button class="bg-transparent text-white border-0">Clear All</button>
    </div>
    <ul class="more-like-this px-0">
        <?php foreach ($trendingData as $val) {
            $cover_img = isset($val['cover_image']) ? @$val['cover_image']['medium'] : '';
        ?>
            <li>
                <a href="{{ getContentUrl($val) }}" class="main-card mt-0">
                    <?php if (isset($val['pay_per_use']) && $val['pay_per_use'] == true) { ?>
                        <span class="crown position-absolute"><img src="{{asset('/img/crown.svg')}}" alt=""></span>
                    <?php } ?>
                    <div class="main-img mt-0">
                        <img src="{{$cover_img}}" alt="">
                    </div>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>