@extends('layouts.default')
@section('title','About')

@section('style')

@stop

@section('content')

<style>

    .play-button{
        width: 35px;
        height: 35px;
        position: absolute;
        background-color:black;
        border: 1px solid #fff;
        border-radius:50%;
        cursor: pointer;
        opacity: 0;
    }
    .play-button img{
        width: 9px !important;
        height: 14px !important;
        margin: 10px auto;
    }
    .distro-slider .sample_img{
        border-radius:15px;
        overflow:hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .sample_img:hover{
        transform: scale(1.3, 1.3);
        transform-origin: center;
        position: relative;
        z-index: 9;
    }
    .sample_img:hover .play-button{
        opacity: 1;
    }
    .distro-slider .slick-list{
        padding: 15px 0;
    }
</style>

<section class="distro-main w-100 position-relative">
    <div class="distro-overlay w-100 position-absolute">
        <div class="center-content ds-logo-text position-relative">
            <img src="{{asset('img/distrotv.png')}}" alt="">
            <span>ABP NEWS</span>
            <ul class="d-flex pl-0 list-unstyled">
                <li>LIVE</li>
                <li>English</li>
                <li>NEWS</li>
            </ul>
            <a href="">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M15 8.00031C15.0004 8.17008 14.9569 8.33706 14.8736 8.48503C14.7904 8.63299 14.6703 8.75689 14.525 8.84469L5.52 14.3534C5.36818 14.4464 5.19429 14.4972 5.0163 14.5005C4.83831 14.5037 4.66266 14.4595 4.5075 14.3722C4.35382 14.2863 4.2258 14.161 4.1366 14.0091C4.04741 13.8573 4.00026 13.6845 4 13.5084V2.49219C4.00026 2.31612 4.04741 2.14329 4.1366 1.99148C4.2258 1.83967 4.35382 1.71436 4.5075 1.62844C4.66266 1.54115 4.83831 1.49688 5.0163 1.50017C5.19429 1.50347 5.36818 1.55422 5.52 1.64719L14.525 7.15594C14.6703 7.24373 14.7904 7.36764 14.8736 7.5156C14.9569 7.66356 15.0004 7.83054 15 8.00031Z" fill="#272727"/>
                </svg> Watch
            </a>
            <!-- <p>LIVE : 8PM Prime Time NEWS</p> -->
            
        </div>
        <div class="slider-controls d-flex justify-content-between position-absolute">
                <button type="button" class="slide-m-prev"></button>
                <button type="button" class="slide-m-next"></button>
            </div>
    </div>
    <div class="distro-banner">
        <div class="distro-banner-item"><img src="{{asset('img/Desktop-Page-Blocks.png')}}" alt=""></div>
        <div class="distro-banner-item"><img src="{{asset('img/Desktop-Page-Blocks.png')}}" alt=""></div>
        <div class="distro-banner-item"><img src="{{asset('img/Desktop-Page-Blocks.png')}}" alt=""></div>
    </div>
    <div class="slider-controls-dots d-flex justify-content-center position-absolute">
        <div class="slide-dist-dots"></div>
    </div>
</section>

<section class="container-fluid top-slider addarrow pe-0 me-0 ps-4">
    <div class="row me-0 my-2">
        <div class="distro-title heading ps-0">Distro Tv</div>
    </div>
    <div class="distro-slider mb-4">
        <div class="sample_img position-relative me-3">
            <a href="{{ url('distro-video') }}">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
    </div>
</section>

<section class="container-fluid top-slider addarrow pe-0 me-0 ps-4">
    <div class="row me-0 my-2">
        <div class="distro-title heading ps-0">Distro Tv</div>
    </div>
    <div class="distro-slider">
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
    </div>
</section>

<section class="container-fluid top-slider addarrow pe-0 me-0 ps-4">
    <div class="row me-0 my-2">
        <div class="distro-title heading ps-0">Distro Tv</div>
    </div>
    <div class="distro-slider">
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
        <div class="sample_img position-relative me-3">
            <a href="">
                <img src="{{asset('img/sampleimg.png')}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
    </div>
</section>


   @stop

   @section('script')
   <script>
    $('.distro-banner').slick({
    dots: true,
    arrows: true,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    adaptiveHeight: true,
    prevArrow: $(".slide-m-prev"),
    nextArrow: $(".slide-m-next"),
    appendDots: $(".slide-dist-dots"),
  });

  $(".distro-slider").slick({
    autoplay: !1,
    slidesToShow: 6,
    centerMode: !1,
    arrow:true,
    slidesToScroll: 6,
    dots: !1,
    infinite: !1,
    cssEase: "linear",
    rtl: !1,
    responsive: [
        {
        breakpoint: 3e3,
        settings: {
            slidesToShow: 7.3,
            slidesToScroll: 1
        }
    }, {
        breakpoint: 1600,
        settings: {
            slidesToShow: 6.3,
            slidesToScroll: 1
        }
    }, {
        breakpoint: 1200,
        settings: {
            slidesToShow: 7.3,
            slidesToScroll: 1
        }
    }, {
        breakpoint: 900,
        settings: {
            slidesToShow: 5.3,
            slidesToScroll: 1
        }
    }, {
        breakpoint: 600,
        settings: {
            slidesToShow: 4.3,
            slidesToScroll: 1
        }
    }, {
        breakpoint: 480,
        settings: {
            slidesToShow: 2.2,
            slidesToScroll: 1
        }
    }]
})

   </script>

   @stop