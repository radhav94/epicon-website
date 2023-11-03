@extends('layouts.default')
@section('title','Distro TV')

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
        <div class="distro-banner-item live-tv-vidPlayer">

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
            <p>{{ @$content['episodes_description'] }}</p>
        </div>

    </div>
</section>

@stop




@section('script')

<script src="{{ asset('assets/js/vendor/plyr.js') }}"></script>
<script src="{{ asset('assets/js/vendor/hls.min.js') }}"></script>


<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () => {
        const source = '{{ @$content['episodes_content']['url'] }}';
        const video = document.querySelector('video');
        
        const player = new Plyr(video, {captions: {active: true, update: true, language: 'en'}});
        
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
        
        // Expose player so it can be used from the console
        window.player = player;
    });
</script>
@stop