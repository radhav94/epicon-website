@extends('layouts.default')
@section('title','Get to Know About Upcoming OTT New Web Series and Movies')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plyr.css') }}" />

@stop

@section('content')
<?php  

$input = $upcoming;

$output = [];

foreach ($input as $item) {
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
                                        <a class="upper-img upcomingVid" href="javascript:void(0)" data-id="{{ $id }}" data-type="{{ $content_type }}" data-title="{{ $title }}" data-promo="{{ $val['promo_url'] ?? '' }}">
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
            <div id="playVideo" data-id="" data-type="promo" data-lg="{{ isUserLoggedIn() }}" data-title="">

            </div>
            <video id="vidPlayer" class="videocont" controls crossorigin playsinline poster="">
                <!-- <track src="subtitle.vtt" kind="subtitles" srclang="en" label="English"> -->

            </video>
        </div>
    </div>
</div>

@stop

@section('script')
<script src="{{ asset('assets/js/vendor/plyr.js') }}"></script>
<script src="{{ asset('assets/js/vendor/hls.min.js') }}"></script>
<script src="{{ asset('assets/js/webvtt-subtitler.js') }}"></script>
<script src="{{ asset('assets/js/video-player.js') }}"></script>

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