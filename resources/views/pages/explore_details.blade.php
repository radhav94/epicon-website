@extends('layouts.default')
@section('title', 'Explore - ' . ucfirst(str_replace('-', ' ', $slug)))

@section('content')
    <?php
    
    $bannerImage = isset($result['image']) && $result['image'] != '' ? $result['image'] : ''; ?>

    @if (isset($bannerImage) && $bannerImage != '')
        <div class="w-100 px-2">
            <h4 class="text-white mb-4 ps-4">{{ __(strtoupper(str_replace('-', ' ', $slug))) }}</h4>
        </div>
        <section class="container-fluid">
            <img class="w-100" src="{{ $bannerImage }}" alt="">

        </section>
    @endif

    @if (isset($result['list']) && count($result['list']) > 0)
        @foreach ($result['list'] as $listKey => $listVal)
            @if (isset($listVal['content']) && count($listVal['content']) > 0)
                <div class="carousel-main">
                    <div class="carousel-title-n-arrow px-2">
                        <h5 class="text-white">
                            {{ isset($listVal['name']) && $listVal['name'] != '' ? $listVal['name'] : ucfirst($slug) }}</h5>
                            <?php if(isset($listVal['show_more']) && $listVal['show_more'] == true){ ?>
                        <a href="{{ url('explore' . '/' . $slug . '/' . $listVal['catalog_slug']) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
                                fill="none">
                                <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                        <?php } ?>
                    </div>
                    <ul class="vertical-carousel-initilize p-0">
                        @foreach ($listVal['content'] as $key => $contentVal)
                            <?php
                            $cover_image = getCardImage($contentVal, 'vertical_cover_image');
                            
                            $getTitle = getNewTitle($contentVal);
                            $generes = array_column($contentVal['genres_assign'] ?? [], 'name');

                            if ($generes) {
                                $sub_text[] = implode(' . ', $generes);
                            }
                            $sub_points = '';
                            if ($generes) {
                                foreach ($generes as $key => $genre) {
                                    $sub_points .= '<li>' . $genre . '</li>';
                                }
                            }
                            ?>
                            <li>
                                <div class="play-card">

                                    <div class="top-card-img">
                                        <span class="crown position-absolute"><img src="{{ env('AWS_S3_domain') }}epicon/assets/images/crown.svg"
                                                alt=""></span>
                                        <a href="{{ getContentUrl($contentVal) }}">
                                            <img src="{{ $cover_image }}" alt="">
                                        </a>
                                    </div>

                                    <div class="bottom-card-content">
                                        <a href="{{ getContentUrl($contentVal) }}" tabindex="{{ $key }}">
                                            <h1>{{ $contentVal['title'] }}</h1>
                                        </a>
                                        <div class="marquee">
                                        <ul>
                                            <li>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 16 16" fill="none">
                                                    <path
                                                        d="M13.0011 4.99927L11.0078 6.9926L9.00781 4.9926L11.0011 2.99927C11.2811 2.71927 11.6411 2.58594 12.0011 2.58594C12.3611 2.58594 12.7211 2.71927 13.0011 2.99927C13.5545 3.5526 13.5545 4.44594 13.0011 4.99927Z"
                                                        fill="white"></path>
                                                    <path
                                                        d="M11.5435 6.46875L4.33687 13.6687C3.78354 14.2221 2.89021 14.2221 2.33688 13.6687C1.78354 13.1154 1.78354 12.2221 2.33688 11.6687L9.54354 4.46875L11.5435 6.46875Z"
                                                        fill="#B04CF1"></path>
                                                    <path
                                                        d="M6.63107 2.32846L6.9044 1.4018C6.93107 1.31513 6.9044 1.2218 6.8444 1.15513C6.7844 1.08846 6.67773 1.0618 6.59107 1.08846L5.6644 1.3618L4.73773 1.08846C4.65107 1.0618 4.55773 1.08846 4.49107 1.14846C4.4244 1.21513 4.4044 1.30846 4.43107 1.39513L4.69773 2.32846L4.4244 3.25513C4.39773 3.3418 4.4244 3.43513 4.4844 3.5018C4.55107 3.56846 4.6444 3.58846 4.73107 3.5618L5.6644 3.29513L6.59107 3.56846C6.61773 3.57513 6.63773 3.5818 6.6644 3.5818C6.73107 3.5818 6.79107 3.55513 6.8444 3.50846C6.91107 3.4418 6.93107 3.34846 6.9044 3.2618L6.63107 2.32846Z"
                                                        fill="#FFAC33"></path>
                                                    <path
                                                        d="M3.967 6.32846L4.24034 5.40179C4.267 5.31513 4.24034 5.2218 4.18034 5.15513C4.11367 5.08846 4.02034 5.06846 3.93367 5.09513L3.00034 5.3618L2.07367 5.08846C1.987 5.0618 1.89367 5.08846 1.827 5.14846C1.76034 5.21513 1.74034 5.30846 1.767 5.39513L2.03367 6.32846L1.76034 7.25513C1.73367 7.3418 1.76034 7.43513 1.82034 7.5018C1.887 7.56846 1.98034 7.58846 2.067 7.5618L2.99367 7.28846L3.92034 7.5618C3.94034 7.56846 3.967 7.56846 3.99367 7.56846C4.06034 7.56846 4.12034 7.5418 4.17367 7.49513C4.24034 7.42846 4.26034 7.33513 4.23367 7.24846L3.967 6.32846Z"
                                                        fill="#FFAC33"></path>
                                                    <path
                                                        d="M13.9704 9.66664L14.2437 8.73997C14.2704 8.6533 14.2437 8.55997 14.1837 8.4933C14.1171 8.42664 14.0237 8.40664 13.9371 8.4333L13.0104 8.70664L12.0837 8.4333C11.9971 8.40664 11.9037 8.4333 11.8371 8.4933C11.7704 8.55997 11.7504 8.6533 11.7771 8.73997L12.0504 9.66664L11.7771 10.5933C11.7504 10.68 11.7771 10.7733 11.8371 10.84C11.9037 10.9066 11.9971 10.9266 12.0837 10.9L13.0104 10.6266L13.9371 10.9C13.9571 10.9066 13.9837 10.9066 14.0104 10.9066C14.0771 10.9066 14.1371 10.88 14.1904 10.8333C14.2571 10.7666 14.2771 10.6733 14.2504 10.5866L13.9704 9.66664Z"
                                                        fill="#FFAC33"></path>
                                                </svg>
                                            </li>
                                            <?php echo $sub_points; ?>
                                        </ul>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div
                                                class="w-100 d-flex justify-content-between align-items-center position-relative">
                                                <div class="d-flex justify-content-start">
                                                    <a onclick="click_tile(this)" data-title ="{{ $contentVal['title'] }}"
                                                        data-type="{{ __(ucfirst($slug)) }}" class="upper-img"
                                                        href="{{ getContentUrl($contentVal) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none">
                                                            <path
                                                                d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z"
                                                                fill="#272727"></path>
                                                        </svg>
                                                        <span class="ms-1">PLAY</span>
                                                    </a>
                                                    <!-- share start -->
                                                    <div class="share-hover">
                                                        <a href="javascript:void(0)"
                                                            class="copyUrl upper-img ms-1 position-relative my-tool-tip play-btn"
                                                            data-url="{{ url($contentVal['url']) }}" data-toggle="tooltip"
                                                            title="Copy" tabindex="{{ $key }}">

                                                            <img class="popup-share-icon"
                                                                src="{{ asset('img/share-copy-icon.svg') }}"
                                                                alt="share">

                                                        </a>
                                                    </div>
                                                    <!-- share end -->
                                                </div>

                                                <button class="small-btn add-icon mx-2 mt-0 loginwish" aria-label="wishlist"
                                                    data-id="{{ $contentVal['ID'] }}" data-action="add" data-type="2"
                                                    tabindex="{{ $key }}"></button>
                                            </div>
                                        </div>

                                        <p class="text-white mb-0">{{ $contentVal['short_description'] }}</p>
                                    </div>
                                </div>
                                <a class="main-card" href="{{ url($contentVal['url']) }}">
                                    <span class="crown position-absolute"><img src="{{ env('AWS_S3_domain') }}epicon/assets/images/crown.svg"
                                            alt="">
                                    </span>

                                    <div class="main-img {{ $getTitle['cls'] }}">
                                        <img src="{{ $cover_image }}" alt="">
                                        {!! $getTitle['html'] !!}
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                </div>
            @endif
        @endforeach
    @endif

@stop
@section('script')

    <script src="{{ asset('assets/js/library.js') }}?v={{ assetTime() }}"></script>
@stop
