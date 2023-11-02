<section class="container-fluid top-slider addarrow pe-0 me-0 ps-4">
    <div class="row me-0 my-2">
        <div class="distro-title heading ps-0">{{ $title }}</div>
    </div>
    <div class="distro-slider mb-4">
    @foreach ($value['content'] as $key => $val)
        <div class="sample_img position-relative me-3">
            <a href="{{ url('distro-video') }}">
                <img src="{{@$val['episodes_img_thumbh']}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
    @endforeach
       {{-- <div class="sample_img position-relative me-3">
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
        </div>--}}
    </div>
</section>

{{--<section class="container-fluid top-slider addarrow pe-0 me-0 ps-4">
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
</section>--}}

   @section('script')
  