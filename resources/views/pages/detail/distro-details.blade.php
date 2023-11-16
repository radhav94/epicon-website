@extends('layouts.default')
@section('title',@$content['episodes_title'])

@section('style')
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />

<style>
     .para-info p,.para-info h4{
        color: #fff;
    }
    .distro-banner-video .video-js{
        height: 500px;
        padding-top:38%;
    }
    .distro-banner-video .video-js .vjs-tech{
        height: 100%;
    }
     /*.vjs-live .vjs-progress-control{
        display: flex;
        align-items: center;
        width: 100%;
    }
    .vjs-live .vjs-time-control{
        display: block;
    }*/
    .distro-banner-video .video-js .vjs-big-play-button{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 70px;
        height: 70px;
        border-radius: 80px;
        line-height: 70px;
        pointer-events: none;
    }

    .live-tv-vidPlayer button[data-plyr="fast-forward"], 
    .live-tv-vidPlayer button[data-plyr="rewind"], 
    .live-tv-vidPlayer button[data-plyr="pip"].plyr__control, 
    .live-tv-vidPlayer .plyr__progress__container{
        display: none;
    }

    @media (max-width:768px) {
        .header-info{
            flex-direction: column-reverse;
        }
        .header-info img{
            margin: 10px 0;
        }
    }
    @media (max-width:700px) {
        .distro-banner-video .video-js{
            height: 250px;
            padding-top:38%;
        }
        .distro-banner-video .video-js .vjs-tech{
        height: 100%;
        }
    }
</style>
@stop


@section('content')
<?php 
    $cover_img = @$content['episodes_img_thumbh'];
    $is_distro = true;
?>


<section class="distro-main-video w-100 position-relative">
    <div class="distro-banner-video">
        <input type="hidden" id="dai_session_id" value="{{ isset($content['episodes_content']['dai']) ? $content['episodes_content']['dai'] : '' }}">
        <input type="hidden" id="content_provider" value="{{$content['root_content_provider']}}">
        <input type="hidden" id="show_id" value="{{$content['ID']}}">
        <input type="hidden" id="episode_id" value="{{$content['episodes_id']}}">
        <div class="distro-banner-item live-tv-vidPlayer" id="video-container">
            {{--<img src="{{ $cover_img }}" alt="" class="disto-vid-banner">--}}

            <video controls crossorigin playsinline poster="{{ $cover_img }}"></video>

        </div>
    </div>
</section>


<section class="video-main-info w-100">
    <div class="container">
        <div class="header-info mt-3 mb-3 d-flex flex-wrap justify-content-between">
            <h2 class= "text-white">{{ @$content['episodes_title'] }}</h2>
            <img class="mr-3" src="{{asset('img/distro_logo-white.png')}}" alt="">
        </div>
        <div class="para-info">
           {{--<h4>Catch Distro TV Channel, and Mastiii Channel Live Online on MX Player!</h4>--}}
            <p>{!! sanitizeData(@$content['episodes_description']) !!}</p>
        </div>

    </div>
</section>

@stop




@section('script')
<script defer src="{{ asset('assets/js/distro-tv.js') }}"></script>
<script src="{{ asset('assets/js/vendor/plyr.js') }}"></script>
<script src="{{ asset('assets/js/vendor/hls.min.js') }}"></script>


<script type="text/javascript">

    document.addEventListener('DOMContentLoaded', () => {
        // Flag to track if distroPlay has been called
        var distroPlayCalled = false;
        const source = '{{ @$content['episodes_content']['url'] }}';
        const video = document.querySelector('video');
        
        const player = new Plyr(video, {captions: {active: true, update: true, language: 'en'}});

            // Set autoplay to true
        video.autoplay = true;

        // Load and play the video
        video.load();
        
        if (!Hls.isSupported()) {
            video.src = source;
        } else {
            // For more Hls.js options, see https://github.com/dailymotion/hls.js
            const hls = new Hls();
            hls.loadSource(source);
            hls.attachMedia(video);
            window.hls = hls;
            
            // Handle changing captions
            player.on('languagechange', () => {
                // Caption support is still flaky. See: https://github.com/sampotts/plyr/issues/994
                setTimeout(() => hls.subtitleTrack = player.currentTrack, 50);
            });
        }

        player.on('play', function() {
           if (!distroPlayCalled) {
                distroPlay();
                distroPlayCalled = true;
            }
             startTimer();
        });

        player.on('pause', function() {
          // console.log('The video has paused');
          stopTimer();
        });
        
        // Expose player so it can be used from the console
        window.player = player;
    });
</script>
<script>
// Define the base URL
var baseUrl = 'https://i.jsrdn.com/i/1.gif';

// Generate a random UUIDv4 string
var uuid = generateUUIDv4();
var storedDeviceId = localStorage.getItem('deviceId');
// Initialize the 'e' value with 'vs60'
var currentE = 'vs60';
var r= Math.random(); //<random>
var e= currentE; //<event_name>
var u= storedDeviceId; //<device_or_adver/sing_id>
var i= uuid; //<dai_session_id>
var v= uuid; //<dai_session_id>
var f= $('#dai_session_id').val(); //<dai_asset_key>
var m= 'Epicon'; //<appname>
var p= $('#content_provider').val(); //<content_provider_id>
var show= $('#show_id').val(); //<show_id>
var ep= $('#episode_id').val(); //<episode_id>

// Initialize a timer interval in seconds (e.g., 60 seconds)
var timerInterval = 60;

// Variable to store the interval ID
var IntervalTimeId;

// Function to make the request with the current 'e' value
function make6ominRequest() {
    // Build the complete URL with the current 'e' value
    var url = baseUrl + '?';
    // Make the HTTP request using jQuery's AJAX
    $.ajax({
        url: url,
        data:{r:r,e:currentE,u:u,i:v,v:v,f:f,m:m,p:p,show:show,ep:ep},
        dataType: 'jsonp', // Use 'jsonp' if needed to bypass cross-origin issues
        success: function(response) {
            // Handle the response if needed
            // console.log('Request successful for e=' + currentE);
        }
    });

    // Increment the 'e' value for the next request
    currentE = 'vs' + (parseInt(currentE.slice(2)) + timerInterval);
}

function generateUUIDv4() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random() * 16 | 0,
            v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}

// Start the timer
function startTimer() {
    IntervalTimeId = setInterval(make6ominRequest, timerInterval * 1000); // Convert to milliseconds
}

// Stop the timer
function stopTimer() {
    clearInterval(IntervalTimeId);
}

</script>
@stop