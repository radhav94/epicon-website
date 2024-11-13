@extends('layouts.default')
@section('title','About')

@section('style')
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

@stop

@section('content')



<section class="distro-main-video w-100 position-relative">
    <div class="distro-banner-video">
        <div class="distro-banner-item"><img src="{{env('AWS_S3_domain').'epicon/assets/images/live-player-container.png'}}" alt=""></div>
    </div>
</section>

<section class="video-main-info w-100">
    <div class="container">
        <div class="header-info mt-3 mb-3 d-flex flex-wrap justify-content-between">
            <h2 class= "text-white">Mastiii - India’s No.1 Music and Youth Channel Live TV</h2>
            <img class="mr-3" src="{{env('AWS_S3_domain').'epicon/assets/images/distro_logo-white.png'}}" alt="">
        </div>
        <div class="para-info">
            <h4>Catch Distro TV Channel, and Mastiii Channel Live Online on MX Player!</h4>
            <p>Can't live without your daily dose of awesome Hindi music? Mastiii is here with all your favorites in one place. Mastiii is India's No.1 free 24x7 Music & Youth channel! With its universal appeal, Mastiii offers a diverse range of music genres, catering to a wide audience from preppy to
            romantic and from retro hits to the latest blockbusters. Whether you're a music aficionado or a young viewer looking for vibrant entertainment, Mastiii has got you covered. Mastiii is a channel that understands the power of music to uplift spirits and bring people together. It provides a
            constant stream of chart-topping hits, foot-tapping melodies, and popular tracks that will keep you grooving all day long. Don't miss out on Mastiii channel live, Distro TV Channels Live only on MX Player.</p>
        </div>
        <div class="para-info">
            <h4>Catch Distro TV Channel, and Mastiii Channel Live Online on MX Player!</h4>
            <p>Can't live without your daily dose of awesome Hindi music? Mastiii is here with all your favorites in one place. Mastiii is India's No.1 free 24x7 Music & Youth channel! With its universal appeal, Mastiii offers a diverse range of music genres, catering to a wide audience from preppy to
            romantic and from retro hits to the latest blockbusters. Whether you're a music aficionado or a young viewer looking for vibrant entertainment, Mastiii has got you covered. Mastiii is a channel that understands the power of music to uplift spirits and bring people together. It provides a
            constant stream of chart-topping hits, foot-tapping melodies, and popular tracks that will keep you grooving all day long. Don't miss out on Mastiii channel live, Distro TV Channels Live only on MX Player.</p>
        </div>
    </div>
</section>




   @stop

   @section('script')

   @stop