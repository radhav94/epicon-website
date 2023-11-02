<div class="distrohead-row row mb-4 mt-4 me-0 pt-4 pb-2 position-relative" style="background-image: url('../img/distrotvbg-new.png')">
        <div class="view-all-div">
            <a href="{{ Route('distro-tv') }}"><h6>View All</h6></a>
        </div>

        <div class=" col-4 col-md-3 pe-0 d-flex align-items-center justify-content-center">
            <div class="distro-tray w-100">
                <a class="d-flex w-100" href="{{ Route('distro-tv') }}"><img src="{{asset('img/distrotv.png')}}" alt=""></a>
            </div>
        </div>
      
        <div class="col-8 col-md-9" style="margin: auto 0">
            <div class="distrotv-slide-inner distrotv-slide-show">
            @foreach ($value['content'] as $key => $val)
                <div class="slide">
                    <figure>
                        <div class="slide-img-wrap me-3">
                            <a href="{{ url('distrotvvideo') }}/{{$val['id']}}">
                            <img class="slide-img lazyload" src="{{ $val['episodes_img_thumbh'] ?? ''; }}" alt=""></a>
                        </div>
                        <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
                    </figure>               
                </div>
        @endforeach
                
            </div>
        </div>
    </div>