@extends('layouts.default')
@section('title','Get to Know About Upcoming OTT New Web Series and Movies')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ env('AWS_S3_domain') }}epicon/assets/images/plyr.css?v={{ assetTime() }}">

@stop

@section('content')
<div class="scrollspy">
    <div id="nav-container" class="d-flex align-items-center justify-content-between px-3">
        <div class="carousel-title-n-arrow">
            <h5 class="text-white mb-0">{{__('Hot & New')}}</h5>
        </div>
        <div id="nav">
            @foreach ($spotlightData['data']['list'] as $key => $head_item)
                <a href="#{{ strtolower(str_replace(' ', '', $head_item['title'])) }}" class="s__spy nav-link {{ $key == 0 ? 'active' : '' }}">
                    <img src="{{ asset('assets/spotlight/' . strtolower(str_replace(' ', '', $head_item['title'])) . '-icon.svg') }}"
                        alt="">
                    {{ $head_item['title'] }}
                </a>
            @endforeach
        </div>
    </div>
    <div class="container-fluid pe-0">
        @foreach ($spotlightData['data']['list'] as $head_item)
            <section class="{{ strtolower(str_replace(' ', '', $head_item['title'])) }}">
            <div id="{{ strtolower(str_replace(' ', '', $head_item['title'])) }}"></div>
                <div class="carousel-title-n-arrow pb-3">
                    <h5 class="text-white mb-0">{{ $head_item['title'] }}</h5>
                </div>
                @php
                    $title = $head_item['title'] ?? "";
                @endphp
                <div class="top-ten-shows-movies">

                    @foreach ($head_item['content'] as $num=> $item)
                    
                        @php
                            $cover_img = getCardImage($item, 'cover_image', 'medium', ['epic_shorts_image', 'banner_image'])
                        @endphp
                        @if (!in_array(strtolower(str_replace(' ', '', $head_item['title'])), ['comingsoon', 'commingsoon']))
                        <a onclick="click_tile(this)" data-title ="{{ @$item['title'] }}" data-type="{{ @$title }}" href="{{ getContentUrl($item) }}" class="card-ms">
                            <div class="number"></div>
                            <div class="img">
                                <img src="{{ $cover_img }}" alt="">
                            </div>
                        </a>
                        @else
                        @php $date = date('Y-m-d', strtotime($item['publish_future_date'] ?? $item['created_on'])); @endphp
                        <div class="upcoming-epicon-main">
                            <div class="card-details">
                                <div class="internal-card d-flex">
                                    
                                    <div class="upcomming-scroll">
                                        <div class="card-main-body d-flex me-3">
                                                <div class="card-body">
                                                    <a onclick="click_tile(this)" class="upper-img upcomingVid"
                                                        href="javascript:void(0)" data-id="{{$item['ID'] ?? null}}" data-type="{{$item['content_type'] ?? ''}}"
                                                        data-title="{{ $item['title'] ?? '' }}"
                                                        data-promo="{{ $item['promo_url'] ?? '' }}">
                                                        <img src="{{ $item['cover_image']['original']??asset('assets/img/top-ten-movies.png') }}"
                                                            alt="">
                                                    </a>
                                                  
                                                    <div class="bottom-text d-flex mt-2">
                                                        <div class="left-text">
                                                            <h4 class="text-heading text-white upc">
                                                            {{ $item['title'] }}
                                                            </h4>
                                                            <h6 class="text-white">{{ date('d', strtotime($date)) }}
                                                            {{ date('M', strtotime($date)) }}
                                                            {{ date('Y', strtotime($date)) }}</h6>
                                                            <ul class="text-white">
                                                            @if(isset($item['age_limit']))
                                                                <li>{{ $item['age_limit'] }}</li>
                                                            @endif
                                                                @foreach ($item['genres_assign'] as $genre)
                                                                <li>{{ $genre['name'] }}</li>
                                                                @endforeach
                                                                <li>{{ date('Y', strtotime($date)) }}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>   

                        @endif
                    @endforeach
                </div>
                
            </section>
        @endforeach
    </div>
</div>

<div class="modal" id="upcomingModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <button class="x-btn bg-transparent text-white closebtn position-absolute btn-close" data-bs-dismiss="modal" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 31 32" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M24.4212 8.60204C24.5304 8.48816 24.6171 8.35293 24.6763 8.20408C24.7355 8.05524 24.766 7.89568 24.7661 7.73453C24.7662 7.57338 24.7359 7.41378 24.6769 7.26486C24.6179 7.11593 24.5313 6.9806 24.4222 6.86657C24.313 6.75255 24.1834 6.66208 24.0408 6.60031C23.8982 6.53855 23.7453 6.50671 23.5908 6.50661C23.4364 6.50651 23.2834 6.53816 23.1407 6.59974C22.998 6.66132 22.8683 6.75162 22.759 6.86551L15.6668 14.266L8.57671 6.86551C8.35603 6.63523 8.05672 6.50586 7.74462 6.50586C7.43253 6.50586 7.13322 6.63523 6.91253 6.86551C6.69185 7.09579 6.56787 7.40811 6.56787 7.73377C6.56787 8.05944 6.69185 8.37176 6.91253 8.60204L14.0047 16.0004L6.91253 23.3988C6.80326 23.5129 6.71658 23.6482 6.65745 23.7972C6.59831 23.9462 6.56787 24.1059 6.56787 24.2671C6.56787 24.4284 6.59831 24.588 6.65745 24.737C6.71658 24.886 6.80326 25.0214 6.91253 25.1354C7.13322 25.3657 7.43253 25.495 7.74462 25.495C7.89916 25.495 8.05218 25.4633 8.19495 25.4016C8.33772 25.3398 8.46744 25.2494 8.57671 25.1354L15.6668 17.7348L22.759 25.1354C22.9797 25.3654 23.2789 25.4945 23.5908 25.4943C23.9027 25.4941 24.2018 25.3646 24.4222 25.1343C24.6426 24.904 24.7663 24.5918 24.7661 24.2664C24.7659 23.9409 24.6418 23.6288 24.4212 23.3988L17.329 16.0004L24.4212 8.60204Z" fill="#F8F8F8" />
                </svg>
            </button>

            <div class="modal-body">
                <div id="playVideo" data-id="" data-type="promo" data-lg="{{ isUserLoggedIn() }}" data-title=""> </div> 
                <video id="vidPlayer" class="videocont" controls crossorigin playsinline >
                    {{-- <!-- <track src="subtitle.vtt" kind="subtitles" srclang="en" label="English"> --> --}}

                </video>
            </div>

        </div>
    </div>
</div>
@stop

@section('script')
<script src="{{ env('AWS_S3_domain') }}epicon/assets/images/plyr.js"></script>
<script src="{{ env('AWS_S3_domain') }}epicon/assets/images/hls.min.js"></script>
<script src="{{ env('AWS_S3_domain') }}epicon/assets/images/webvtt-subtitler.js"></script>
<script src="{{ asset('assets/js/video-player.js') }}?v={{ assetTime() }}"></script>

<script>
    var user_duration = 0;
    var player;

    $(document).ready(function() {

        $(".upcomingVid").click(function() {
            let cid = $(this).data('id');
            let title = $(this).data('title');
            let lg = $(this).data('lg');
            let tp = $(this).data('type');
            let promo = $(this).data('promo');

            let customData = {
                cid: cid,
                tp: tp,
                title: title,
                lg: lg
            };

            if(promo == ''){
                showToaster('Content video not found', 2);
                return;
            }else{
                $("#upcomingModal").modal('show');
                loadVideoPlayer(promo, '', customData);
            }

            // Add a click event listener to the window
            $(window).click(function(event) {
                // Check if the clicked element is not inside the modal
                if (!$(event.target).closest('#upcomingModal').length) {
                    $('#upcomingModal').modal('hide');
                }
            });
        });

        $('#upcomingModal').on('hidden.bs.modal', function() {
            if (typeof player !== "undefined") {
                console.log(player)
                player.stop();
            }
            $('video').attr('src', '');
        });
    });
</script>

@stop
