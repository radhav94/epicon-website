
 <?php //dd($result);exit(); ?>

 @extends('layouts.default')
@section('title','About')

@section('style')

@stop

@section('content')

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
<?php //dd($result);exit; ?>

<section class="distro-main-video w-100 position-relative">
    <div class="distro-banner-video">
    <source src="{{$result['episodes_content']['url']}}" type="application/x-mpegURL" />
    <p class="vjs-no-js">
        <div class="distro-banner-item"><img src="{{$result['episodes_img_thumbh'] ?? ''}}" alt=""></div>
     
    </div>
</section>

<section class="video-main-info w-100">
    <div class="container">
        <div class="header-info mt-3 mb-3 d-flex flex-wrap justify-content-between">
            <h2 class= "text-white">{{$result['episodes_title'] ?? ''}}</h2>
            <img class="mr-3" src="{{asset('img/distro_logo-white.png')}}" alt="">
        </div>
        <div class="para-info">
           {{--<h4>Catch Distro TV Channel, and Mastiii Channel Live Online on MX Player!</h4>--}}
            <p>{{$result['episodes_description']}}</p>
        </div>

    </div>
</section>




   @stop

   @section('script')

   @stop