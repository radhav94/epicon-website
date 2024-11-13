@foreach ($epicwebArr as $key => $val)
    <?php
    $cover_img = isset($val['vertical_cover_image']) ? getCardImage($val, 'vertical_cover_image') : getCardImage($val, 'cover_image');
    $generes = array_column($val['genres_assign'] ?? [], 'name');
    $sub_text = [];
    
    if (isset($val['release_date'])) {
        $date_text = date('Y', strtotime($val['release_date']));
    }
    if (isset($val['release_date'])) {
        $sub_text[] = date('Y', strtotime($val['release_date']));
    }
    // $sub_text[] = '3 Language';
    
    if ($generes) {
        $sub_text[] = implode(' . ', $generes);
    }
    $getTitle = getNewTitle($val);
    // if (isset($val['age_limit'])) {
    //     $sub_text[] = $val['age_limit'];
    // }
    
    if ($val['content_type'] == 'GAMEZOP') {
        $cardcls = 'game-hover';
    } else {
        $cardcls = '';
    }
    // $sub_points = (@$val['age_limit']) ? '<li class="ps-1">' . @$val['age_limit'] . '</li>' : '';
    $sub_points = '';
    if ($generes) {
        foreach ($generes as $key => $genre) {
            $sub_points .= '<li>' . $genre . '</li>';
        }
    }
    ?>
    <li>
        <div class="play-card {{ $cardcls }}">
            <div class="top-card-img">
                {!! freePremiumDiv($val) !!}
                @if (@$extra['hide_top10'] != 1)
                    {!! topTenDiv($val) !!}
                @endif
                <a aria-label="item-hover" href="{{ getContentUrl($val) }}">
                    <img src="{{ $cover_img }}" alt="">
                </a>
            </div>
            <div class="bottom-card-content">
                <a aria-label="item-main" href="{{ getContentUrl($val) }}">
                    <h1>{{ $val['title'] ?? '' }}</h1>
                </a>
                <div class="marquee">
                    <ul><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                            fill="none">
                            <path
                                d="M13.0011 4.99927L11.0078 6.9926L9.00781 4.9926L11.0011 2.99927C11.2811 2.71927 11.6411 2.58594 12.0011 2.58594C12.3611 2.58594 12.7211 2.71927 13.0011 2.99927C13.5545 3.5526 13.5545 4.44594 13.0011 4.99927Z"
                                fill="white" />
                            <path
                                d="M11.5435 6.46875L4.33687 13.6687C3.78354 14.2221 2.89021 14.2221 2.33688 13.6687C1.78354 13.1154 1.78354 12.2221 2.33688 11.6687L9.54354 4.46875L11.5435 6.46875Z"
                                fill="#B04CF1" />
                            <path
                                d="M6.63107 2.32846L6.9044 1.4018C6.93107 1.31513 6.9044 1.2218 6.8444 1.15513C6.7844 1.08846 6.67773 1.0618 6.59107 1.08846L5.6644 1.3618L4.73773 1.08846C4.65107 1.0618 4.55773 1.08846 4.49107 1.14846C4.4244 1.21513 4.4044 1.30846 4.43107 1.39513L4.69773 2.32846L4.4244 3.25513C4.39773 3.3418 4.4244 3.43513 4.4844 3.5018C4.55107 3.56846 4.6444 3.58846 4.73107 3.5618L5.6644 3.29513L6.59107 3.56846C6.61773 3.57513 6.63773 3.5818 6.6644 3.5818C6.73107 3.5818 6.79107 3.55513 6.8444 3.50846C6.91107 3.4418 6.93107 3.34846 6.9044 3.2618L6.63107 2.32846Z"
                                fill="#FFAC33" />
                            <path
                                d="M3.967 6.32846L4.24034 5.40179C4.267 5.31513 4.24034 5.2218 4.18034 5.15513C4.11367 5.08846 4.02034 5.06846 3.93367 5.09513L3.00034 5.3618L2.07367 5.08846C1.987 5.0618 1.89367 5.08846 1.827 5.14846C1.76034 5.21513 1.74034 5.30846 1.767 5.39513L2.03367 6.32846L1.76034 7.25513C1.73367 7.3418 1.76034 7.43513 1.82034 7.5018C1.887 7.56846 1.98034 7.58846 2.067 7.5618L2.99367 7.28846L3.92034 7.5618C3.94034 7.56846 3.967 7.56846 3.99367 7.56846C4.06034 7.56846 4.12034 7.5418 4.17367 7.49513C4.24034 7.42846 4.26034 7.33513 4.23367 7.24846L3.967 6.32846Z"
                                fill="#FFAC33" />
                            <path
                                d="M13.9704 9.66664L14.2437 8.73997C14.2704 8.6533 14.2437 8.55997 14.1837 8.4933C14.1171 8.42664 14.0237 8.40664 13.9371 8.4333L13.0104 8.70664L12.0837 8.4333C11.9971 8.40664 11.9037 8.4333 11.8371 8.4933C11.7704 8.55997 11.7504 8.6533 11.7771 8.73997L12.0504 9.66664L11.7771 10.5933C11.7504 10.68 11.7771 10.7733 11.8371 10.84C11.9037 10.9066 11.9971 10.9266 12.0837 10.9L13.0104 10.6266L13.9371 10.9C13.9571 10.9066 13.9837 10.9066 14.0104 10.9066C14.0771 10.9066 14.1371 10.88 14.1904 10.8333C14.2571 10.7666 14.2771 10.6733 14.2504 10.5866L13.9704 9.66664Z"
                                fill="#FFAC33" />
                        </svg>
                        {{-- <!-- <li class="ps-1">U/A 13+</li> --> --}}
                        <?php echo $sub_points; ?>
                        {{-- <!-- <li>Mystery</li>
                                <li>Mind Game</li>
                                <li>5 Seasons</li> --> --}}
                    </ul>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="w-100 d-flex justify-content-between align-items-center position-relative">
                        <div class="d-flex justify-content-start">
                            @if (@$val['asset_type'] == 'PLAY')
                                {!! getplayanchorhtml($val) !!}
                            @else
                                <a class="upper-img play-btn" href="{{ getContentUrl($val) }}">
                            @endif
                            {{-- <button class="play-btn w-100 text-center"> --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z"
                                    fill="#272727" />
                            </svg>
                            <?php
                            $wishlist = getWishlist();
                            $watch_text = getPlayText($val);
                            
                            $se_epi_text = getSeasonEpisodeNum($val);
                            if (@$se_epi_text['season']) {
                                $watch_text .= 'S' . $se_epi_text['season'];
                            }
                            
                            if (@$se_epi_text['episode']) {
                                $watch_text .= 'E' . $se_epi_text['episode'];
                            }
                            ?>
                            @if ($val['asset_type'] == 'PLAY')
                                <span class="ms-1">{!! getPlayText($val) !!}</span>
                            @else
                                <span class="ms-1">{{ $watch_text }}</span>
                            @endif
                            {{-- </button> --}}
                            </a>
                            <!-- share start -->
                            <div class="share-hover">
                                <a href="javascript:void(0)" class="copyUrl upper-img ms-1 position-relative"
                                    data-url="{{ getContentUrl($val) }}" data-toggle="tooltip" title="Copy"
                                    class="my-tool-tip">
                                    <button class="play-btn">
                                        {{-- <!-- <svg xmlns="http://www.w3.org/2000/svg" width="17" height="18" viewBox="0 0 17 18" fill="none">
                                        <path d="M13.6944 12.4523C13.0259 12.4523 12.4278 12.7033 11.9704 13.0966L5.69861 9.62435C5.74259 9.43191 5.77778 9.23948 5.77778 9.03868C5.77778 8.83787 5.74259 8.64544 5.69861 8.453L11.9 5.01424C12.375 5.43258 12.9995 5.69196 13.6944 5.69196C15.1546 5.69196 16.3333 4.5708 16.3333 3.18192C16.3333 1.79303 15.1546 0.671875 13.6944 0.671875C12.2343 0.671875 11.0556 1.79303 11.0556 3.18192C11.0556 3.38272 11.0907 3.57515 11.1347 3.76759L4.93333 7.20635C4.45833 6.78801 3.8338 6.52864 3.13889 6.52864C1.6787 6.52864 0.5 7.64979 0.5 9.03868C0.5 10.4276 1.6787 11.5487 3.13889 11.5487C3.8338 11.5487 4.45833 11.2893 4.93333 10.871L11.1963 14.3516C11.1523 14.5273 11.1259 14.7114 11.1259 14.8954C11.1259 16.2425 12.2782 17.3385 13.6944 17.3385C15.1106 17.3385 16.263 16.2425 16.263 14.8954C16.263 13.5484 15.1106 12.4523 13.6944 12.4523Z" fill="#272727"/>
                                    </svg> --> --}}
                                        <img class="popup-share-icon" src="{{ env('AWS_S3_domain') }}epicon/assets/images/share-copy-icon.svg"
                                            alt="share">
                                    </button>
                                </a>
                                {{-- <!-- <div class="share-open">
                                    <a href="">
                                        <img src="{{env('AWS_S3_domain').'epicon/assets/images/share-facebook-icon.svg'}}" alt="share">
                                    </a>
                                    <a href="">
                                        <img src="{{env('AWS_S3_domain').'epicon/assets/images/share-tweeter-icon.svg'}}" alt="share">
                                    </a>
                                    <a href="">
                                        <img src="{{env('AWS_S3_domain').'epicon/assets/images/share-copy-icon.svg'}}" alt="share">
                                    </a>
                            </div> --> --}}
                            </div>
                            <!-- share end -->
                        </div>
                        {!! getWishListAction($val, $wishlist, 2) !!}
                    </div>
                </div>

                <p class="text-white mb-0">{!! sanitizeData($val['description']) !!}</p>
            </div>
        </div>
        @if (@$val['asset_type'] == 'PLAY')
            {!! getplayanchorhtml($val) !!}
        @else
            <a aria-label="item-main" href="{{ getContentUrl($val) }}" class="main-card">
        @endif
        {!! freePremiumDiv($val) !!}
        {!! topTenDiv($val) !!}
        <div class="main-img {{ $getTitle['cls'] }}">
            <img src="{{ $cover_img }}" alt="">
            {!! $getTitle['html'] !!}
        </div>
        </a>
    </li>
@endforeach
