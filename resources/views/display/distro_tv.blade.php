<div class="distrohead-row row me-0 position-relative">
        {{--<div class="view-all-div">
            <a href="{{ url('distro-landing') }}"><h6>View All</h6></a>
        </div> --}}
        
        @if (@$value['show_more'])
             {{-- <!-- <a class="text-end" href="{{ Route('distro-tv') }}">
                 <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                     <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round" />
                 </svg>
             </a> --> --}}
             <div class="view-all-div">
            <a href="{{ Route('distro-tv') }}">View All</a>
        </div>
         @endif

        <div class=" col-4 col-md-3 pe-0 d-flex align-items-center justify-content-center">
            <div class="distro-tray w-100">
                <a class="d-flex w-100" href="{{ Route('distro-tv') }}"><img src="{{env('AWS_S3_domain').'epicon/assets/images/distrotv.png'}}" alt=""></a>
            </div>
        </div>
      
        <div class="col-8 col-md-9" style="margin: auto 0">
            <div class="distrotv-slide-inner distrotv-slide-show">
            @foreach ($value['content'] as $key => $val)
                <div class="slide">
                    <figure>
                        <div class="slide-img-wrap">
                            <a href="{{ getUrl('distro-tv') }}/{{@$val['id']}}">
                            <img class="slide-img lazyload" src="{{ @$val['episodes_img_thumbh'] }}" alt=""></a>
                        </div>
                        <div class="play-button"><img src="{{env('AWS_S3_domain')}}epicon/assets/images/play-white.png" alt=""></div>
                    </figure>               
                </div>
        @endforeach
                
            </div>
        </div>
    </div>