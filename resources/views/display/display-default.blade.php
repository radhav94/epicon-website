 <?php
 $wishlist = getWishlist();
 ?>

 @if (@$result['data']['list'])
     @foreach ($result['data']['list'] as $key => $value)
         @if (isset($value['display_type']) && isset($value['content']) && !empty($value['content']))
             @php
                 $template = 'display.' . $value['display_type'];
             @endphp

             @if (View::exists($template))
                 <?php
                 $title = getDispLangContent($value, $displayLanguageParam, 'title');
                 $shortdescription = getDispLangContent($value, $displayLanguageParam, 'shortdesc');
                 
                 ?>

                 @if (request()->get('v'))
                     <h1>{{ $value['display_type'] }}</h1>
                 @endif

                @if (isset($stories) && @$value['slug'] == "short-and-sweet")
                    @include('display.epicshots', ['stories' => $stories])
                @else
                    @include($template, [
                        'value' => $value,
                        'title' => $title,
                        'shortdescription' => $shortdescription,
                    ])
                @endif
             @else
                {{--
                 <h1>
                     Template not found - {{ $value['display_type'] }}
                 </h1>--}}
             @endif
         @endif
     @endforeach
 @endif






    <div class="distrohead-row row mb-4 mt-4 me-0 pt-4 pb-2 position-relative" style="background-image: url('../img/distrotvbg-new.png')">
        <div class="view-all-div">
            <a href="{{ url('distro-landing') }}"><h6>View All</h6></a>
        </div>

        <div class=" col-4 col-md-3 pe-0 d-flex align-items-center justify-content-center">
            <div class="distro-tray w-100">
                <a class="d-flex w-100" href="{{ url('distro-landing') }}"><img src="{{asset('img/distrotv.png')}}" alt=""></a>
            </div>
        </div>
        <div class="col-8 col-md-9" style="margin: auto 0">
            <div class="distrotv-slide-inner distrotv-slide-show">
                <div class="slide">
                    <figure>
                        <div class="slide-img-wrap me-3">
                            <img class="slide-img lazyload" src="{{asset('img/sampleimg.png')}}" alt="">
                        </div>
                        <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
                    </figure>               
                </div>
                <div class="slide">
                    <figure>
                        <div class="slide-img-wrap me-3">
                            <img class="slide-img lazyload" src="{{asset('img/sampleimg.png')}}" alt="">
                        </div>
                        <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
                    </figure>               
                </div>
                <div class="slide">
                    <figure>
                        <div class="slide-img-wrap me-3">
                            <img class="slide-img lazyload" src="{{asset('img/sampleimg.png')}}" alt="">
                        </div>
                        <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
                    </figure>               
                </div>
                <div class="slide">
                    <figure>
                        <div class="slide-img-wrap me-3">
                            <img class="slide-img lazyload" src="{{asset('img/sampleimg.png')}}" alt="">
                        </div>
                        <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
                    </figure>               
                </div>
                <div class="slide">
                    <figure>
                        <div class="slide-img-wrap me-3">
                            <img class="slide-img lazyload" src="{{asset('img/sampleimg.png')}}" alt="">
                        </div>
                        <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
                    </figure>               
                </div>
                <div class="slide">
                    <figure>
                        <div class="slide-img-wrap me-3">
                            <img class="slide-img lazyload" src="{{asset('img/sampleimg.png')}}" alt="">
                        </div>
                        <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
                    </figure>               
                </div>
                <div class="slide">
                    <figure>
                        <div class="slide-img-wrap me-3">
                            <img class="slide-img lazyload" src="{{asset('img/sampleimg.png')}}" alt="">
                        </div>
                        <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
                    </figure>               
                </div>
                <div class="slide">
                    <figure>
                        <div class="slide-img-wrap me-3">
                            <img class="slide-img lazyload" src="{{asset('img/sampleimg.png')}}" alt="">
                        </div>
                        <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
                    </figure>               
                </div>
            </div>
        </div>
    </div>
