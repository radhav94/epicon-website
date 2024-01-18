@extends('layouts.default')
@section('title','Get to Know About Upcoming OTT New Web Series and Movies')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plyr.css') }}?v={{ assetTime() }}">

@stop

@section('content')
<?php  

$input = $upcoming;

$output = [];

foreach ($input as $item) {
    if(!isset($item['release_date'])){
        continue;
    }
    $releaseDate = substr($item['release_date'], 0, 10); // Extract the date part (e.g., "2023-09-15")

    if (!isset($output[$releaseDate])) {
        $output[$releaseDate] = []; // Initialize the array for this date if it doesn't exist
    }

    $output[$releaseDate][] = $item; // Add the item to the corresponding date in the output array
}

krsort($output);
$meta['description'] = "Exciting collection of upcoming web series and movies on OTT platforms. Watch wide range of Hindi and English TV show and movies online";
?>
<section class="container">
    <div class="upcoming-epicon-main">

        <div class="upcoming-heading border-bot">
            <h4 class="new-popularheading text-white my-4">Upcoming on Epic On</h4>
        </div>
        <!-- <span id="closePlayer" style="display:none"></span> -->
        <?php foreach ($output as $key => $releaseDate) { ?>
            <?php if ($key !== "" && !strstr($key, '1970')) { ?>
                <div class="card-details mb-4">
                    <div class="date-upperline">.</div>
                    <div class="internal-card d-flex">

                        <div class="date-card text-white">
                            <h6>{{date("d", strtotime($key))}}</h6>
                            <h6>{{date("M", strtotime($key))}}</h6>
                            <h6>{{date("y", strtotime($key))}}</h6>
                        </div>
                        <div class="upcomming-scroll">
                        <?php foreach ($releaseDate as $val) {
                            $cover_img = isset($val['cover_image']) ? @$val['cover_image']['medium'] : '';
                            $generes = array_column($val['genres_assign'] ?? [], 'name');
                            $id = isset($val['ID']) ? $val['ID'] : '';
                            $content_type = isset($val['content_type']) ? $val['content_type'] : '';
                            $title = isset($val['title']) ? $val['title'] : '';
                            
                            $sub_text = [];

                            if (isset($val['release_date'])) {
                                $date_text = date('Y', strtotime($val['release_date']));
                            }
                            if (isset($val['release_date'])) {
                                $sub_text[] = date('Y', strtotime($val['release_date']));
                            }
                            // $sub_text[] = '3 Language';

                            if ($generes) {
                                $sub_text[] = implode(" . ", $generes);
                            }
                            // if (isset($val['age_limit'])) {
                            //     $sub_text[] = $val['age_limit'];
                            // }


                            // $sub_points = (@$val['age_limit']) ? '<li class="ps-1">' . @$val['age_limit'] . '</li>' : '';
                            $sub_points = '';
                            if ($generes) {
                                foreach ($generes as $key => $genre) {
                                    $sub_points .= '<li>' . $genre . '</li>';
                                }
                            }
                        ?>
                            
                                <div class="card-main-body d-flex mt-4 pt-2 ms-3">
                                    <div class="card-body">
                                        {!! freePremiumDiv($val) !!}

                                        <a onclick="click_tile(this)" class="upper-img upcomingVid" href="javascript:void(0)" data-id="{{ $id }}" data-type="{{ $content_type }}" data-title="{{ $title }}" data-promo="{{ $val['promo_url'] ?? '' }}">

                                            <img src="{{ $cover_img }}" alt="">
                                        </a>
                                        <div class="bottom-text d-flex mt-2">
                                            <div class="left-text">
                                                <h4 class="text-heading text-white upc">{{$title}}</h4>
                                                <ul class="text-white">
                                                    <?php echo $sub_points ?>
                                             
                                                    <li>{{isset($date_text) ? $date_text : '' }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            

                        <?php } ?>
                    </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>

        
    </div>
</section>
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
                <video id="vidPlayer" class="videocont" controls crossorigin playsinline poster="">
                    <!-- <track src="subtitle.vtt" kind="subtitles" srclang="en" label="English"> -->

                </video>
            </div>

        </div>
    </div>
</div>

@stop

@section('script')
<script src="{{ asset('assets/js/vendor/plyr.js') }}"></script>
<script src="{{ asset('assets/js/vendor/hls.min.js') }}"></script>
<script src="{{ asset('assets/js/webvtt-subtitler.js') }}"></script>
<script src="{{ asset('assets/js/video-player.js') }}?v={{ assetTime() }}"></script>

<script>
    var user_duration = 0;
    var player;
   /* var TrandingSlider = new Swiper('.tranding-slider', {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        loop: true,
        slidesPerView: 'auto',
        coverflowEffect: {
            rotate: 0,
            stretch: 0,
            depth: 500,
            modifier: 50,
            slideShadows: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        }
    });*/

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

            /*let requestData = {
                cid: cid
            };

            sendAjaxRequest(APP_URL + '/player', 'POST', JSON.stringify(requestData),
                onPlayerSuccess, onPlayerError, 'application/json');

            function onPlayerSuccess(response) {
                console.log(response);

                let video_url = response.payload.video_url;
                console.log('vid', video_url);

                if (video_url) {
                    $("#upcomingModal").modal('show');
                    loadVideoPlayer(video_url, response.payload.html, customData);
                }
            }

            function onPlayerError(xhr) {
                try {
                    $res = JSON.parse(xhr.responseText);
                    if ($res.message != undefined && $res.message != 'failed') {
                        showToaster($res.message, 2);
                    }
                } catch (err) {}
            }*/

            // Add a handler for the modal close event
            

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