<div class="w-100 mb-4">
    <div class="carousel-title-n-arrow mb-3">
        <h5 class="text-white">{{__('Trending Moments')}}</h5>
    </div>
    <ul class="more-like-this px-0">
        <?php foreach ($trendingData as $val) {

            $cover_img = getCardImage($val, 'cover_image', 'medium');
        ?>
            <li>
                @if(@$val['asset_type'] == 'PLAY')
                {!! getplayanchorhtml($val) !!}
                @else
                <a onclick="click_search_results(this)" data-element_text="{{@$val['title']}}" href="{{ getContentUrl($val) }}" class="main-card mt-0">
                @endif
                    <?php if (isset($val['pay_per_use']) && $val['pay_per_use'] == true) { ?>
                        <span class="crown position-absolute"><img src="{{ env('AWS_S3_domain') }}epicon/assets/images/crown.svg" alt=""></span>
                    <?php } ?>
                    <div class="main-img mt-0">
                        <img src="{{$cover_img}}" alt="">
                    </div>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>