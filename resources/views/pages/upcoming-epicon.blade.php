@extends('layouts.default')
@section('title','Upcoming on Epicon')

@section('style')
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />

@stop

@section('content')
<?php //dd($upcoming);

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

?>
<section class="container">
    <div class="upcoming-epicon-main">

        <div class="upcoming-heading border-bot">
            <h4 class="new-popularheading text-white my-4">Upcoming on Epic On</h4>
        </div>

        <?php foreach ($output as $key => $releaseDate) { ?>
            <?php if ($key !== "" && !strstr($key, '1970')) { ?>
                <div class="card-details mb-4">
                    <div class="date-upperline">.</div>
                    <div class="internal-card d-flex">

                        <div class="date-card text-white">
                            <h6>{{date("d", strtotime($key))}}</h6>
                            <h6>{{date("M", strtotime($key))}}</h6>
                            <h5>{{date("y", strtotime($key))}}</h5>
                        </div>

                        <?php foreach ($releaseDate as $val) {
                            $cover_img = isset($val['cover_image']) ? @$val['cover_image']['medium'] : '';
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

                                    <a class="upper-img upcomingVid" href="javascript:void(0)" data-id="{{ @$val['ID'] }}" data-type="{{ @val['content_type'] }}" data-title="{{ @$val['title'] }}">
                                        <img src="{{ $cover_img }}" alt="">
                                    </a>
                                    <div class="bottom-text d-flex mt-2">
                                        <div class="left-text">
                                            <h4 class="text-heading text-white">{{$val['title'] ?? ''}}</h4>
                                            <ul class="text-white">
                                                <?php echo $sub_points ?>
                                                <!--  <li>Drama</li>
                                        <li>Comedy</li>  -->
                                                <li>{{isset($date_text) ? $date_text : '' }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>

        <!--  <div class="card-details">
                <div class="date-upperline">.</div>
                <div class="internal-card d-flex">
                    <div class="date-card text-white">
                        <h6>Jun</h6>
                        <h5>23</h5>
                    </div>

                    <div class="card-main-body d-flex">
                        <div class="card-body">
                             <span class="crown position-absolute"><img src="{{ asset('/img/crown.svg') }}" alt=""></span>
                            <div class="upper-img">
                                <img src="{{ asset('/img/new-popular-img-1.png') }}" alt="">
                            </div>
                            <div class="bottom-text d-flex mt-2">
                                <div class="left-text">
                                    <h4 class="text-heading text-white">Inside Edge 3</h4>
                                    <ul class="text-white">
                                        <li>U/A 13+</li>
                                        <li>Drama</li>
                                        <li>Comedy</li>
                                        <li>2023</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                             <span class="crown position-absolute"><img src="{{ asset('/img/crown.svg') }}" alt=""></span>
                            <div class="upper-img">
                                <img src="{{ asset('/img/new-popular-img-1.png') }}" alt="">
                            </div>
                            <div class="bottom-text d-flex mt-2">
                                <div class="left-text">
                                    <h4 class="text-heading text-white">Inside Edge 3</h4>
                                    <ul class="text-white">
                                        <li>U/A 13+</li>
                                        <li>Drama</li>
                                        <li>Comedy</li>
                                        <li>2023</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                             <span class="crown position-absolute"><img src="{{ asset('/img/crown.svg') }}" alt=""></span>
                            <div class="upper-img">
                                <img src="{{ asset('/img/new-popular-img-1.png') }}" alt="">
                            </div>
                            <div class="bottom-text d-flex mt-2">
                                <div class="left-text">
                                    <h4 class="text-heading text-white">Inside Edge 3</h4>
                                    <ul class="text-white">
                                        <li>U/A 13+</li>
                                        <li>Drama</li>
                                        <li>Comedy</li>
                                        <li>2023</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                       
                    </div>
                </div>
            </div> -->
    </div>
</section>
<div class="modal" id="upcomingModal">
    <div class="modal-dialog modal-lg">
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
<script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
<script src="https://cdn.rawgit.com/video-dev/hls.js/18bb552/dist/hls.min.js"></script>
<script src="{{ asset('assets/js/webvtt-subtitler.js') }}"></script>
<script src="{{ asset('assets/js/video-player.js') }}"></script>

<script>
    var TrandingSlider = new Swiper('.tranding-slider', {
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
    });

    $(document).ready(function() {

        $(".upcomingVid").click(function() {
            let cid = $(this).data('id');
            let title = $(this).data('title');
            let lg = $(this).data('lg');
            let tp = $(this).data('type');

            let requestData = {
                cid: cid
            };
            let customData = {
                cid: cid,
                tp: tp,
                title: title,
                lg: lg
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
            }

            // Add a handler for the modal close event
            $('#upcomingModal').on('hidden.bs.modal', function() {
                if (typeof player !== "undefined") {
                    console.log(player)
                    player.stop();
                }
                $('video').attr('src', '');
            });

            // Add a click event listener to the window
            $(window).click(function(event) {
                // Check if the clicked element is not inside the modal
                if (!$(event.target).closest('#upcomingModal').length) {
                    $('#upcomingModal').modal('hide');
                }
            });
        });
    });
</script>

@stop