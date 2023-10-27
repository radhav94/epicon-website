<div class="carousel-main">
    <div class="carousel-title-n-arrow px-2">
        <h1 class="text-white small">{{ $title }}</h1>
        @if (@$value['show_more'])
        <a href="{{ getMidPageUrl($value) }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
        @endif
    </div>
    <ul class="vertical-carousel-initilize p-0">
        @foreach ($value['content'] as $key => $val)
        <?php
        $card = getItemCardData($val, $displayLanguageParam);

        $banner_img = getCardImage($val, 'banner_image', 'small', ['cover_image']);
        $cover_img = getCardImage($val, 'vertical_cover_image', 'small', ['cover_image', 'banner_image']);

        ?>
        <li>

            <div class="play-card">
                <a href="#/" class="top-card-img">
                    {!! freePremiumDiv($val) !!}
                    @if (@$extra['hide_top10'] != 1)
                    {!! topTenDiv($val) !!}
                    @endif
                    <img src="{{ $banner_img }}" alt="">
                </a>
                <div class="bottom-card-content">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                        @if(@$val['asset_type'] == 'PLAY')
                            {!! getplayanchorhtml($val) !!}
                        @else
                            <a class="upper-img" href="{{ getContentUrl($val) }}">
                        @endif
                                <button class="play-btn me-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z" fill="#272727" />
                                    </svg>
                                    <span class="ms-1">{{ __('Resume') }}</span>
                                </button>
                            </a>
                            {!! getWishListAction($val, $wishlist, 2) !!}
                        </div>
                    </div>
                    <h1>{{ $card['title'] }}</h1>

                    <ul>
                        {!! $card['sub_points'] !!}
                    </ul>
                    <div class="progress-main">
                        <?php $progress_duration = (@$val['user_duration'] * 100)/($val['duration'] ?? 1).'%'; ?>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $progress_duration }};" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="left-time">{{ convertSecondsToReadable(@$val['duration'] - @$val['user_duration']) }} of {{ convertSecondsToReadable(@$val['duration']) }} left</div>
                    </div>
                </div>
            </div>

            <a href="{{ getContentUrl($val) }}" class="main-card">
                {!! freePremiumDiv($val) !!}
                {!! topTenDiv($val) !!}
                <div class="main-img">
                    <img src="{{ $cover_img }}" alt="">
                </div>
            </a>
        </li>
        @endforeach
    </ul>
</div>