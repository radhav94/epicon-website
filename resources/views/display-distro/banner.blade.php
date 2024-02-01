<section class="distro-main w-100 position-relative">

    <div class="distro-banner">
    @foreach ($value['content'] as $key => $val)
  
        <div class="distro-banner-item">
            <div class="distro-overlay w-100 position-absolute">
            <div class="center-content ds-logo-text position-relative">
            @if(!isMobliDevice())
                <img src="{{@$val['root_img_logo']}}" alt="">
            @endif

            <span>{{@$val['root_title']}}</span>
            <ul class="d-flex pl-0 list-unstyled">
                <li>{{@$val['root_type']}}</li>
                <li>{{@$val['root_genre']}}</li>
              
            </ul>
            <a onclick="click_carousel(this)" data-title ="{{ @$val['root_title'] }}" href="{{ getUrl('distro-tv') }}/{{@$val['ID']}}">
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
          @if(isMobliDevice())
                <img src="{{@$val['banner_image_app']}}" alt="">
            @else
                <img src="{{@$val['banner_image_web']}}" alt="">
            @endif
        </div>
        @endforeach

        {{-- <!-- <div class="distro-banner-item"><img src="{{asset('img/Desktop-Page-Blocks.png')}}" alt=""></div>
        <div class="distro-banner-item"><img src="{{asset('img/Desktop-Page-Blocks.png')}}" alt=""></div> --> --}}
    </div>
    <div class="slider-controls-dots d-flex justify-content-center position-absolute">
        <div class="slide-dist-dots"></div>
    </div>
</section>

<div class="distro-search-main position-relative">
    <div class="distro-search-filter">
        <input class="distro-search-input" type="text" placeholder="Search">
        <button class="distro-search-clear">
            <img src="{{asset('assets/img/distro-search-text-clear.svg')}}" alt="icon">
        </button>
        <button class="distro-filter">
            <img class="dis-img-toggle" src="{{asset('assets/img/distro-filter-arrow.svg')}}" alt="icon">
        </button>
    </div>
    <div class="distro-search-show d-none">
        <ul>
            <li class="d-flex">
                <div class="distro-search-img"><img src="{{asset('assets/img/distro-search-img.png')}}" alt="icon"></div>
                <div class="distro-search-title-text">
                    <h1 class="distro-search-title">Mastiii - India’s No.1 Music and Youth Channel Live TV</h1>
                    <p class="distro-search-text">Catch Distro TV Channel, and Mastiii Channel Live Online on MX Player!</p>
                </div>
            </li>
            <li class="d-flex">
                <div class="distro-search-img"><img src="{{asset('assets/img/distro-search-img.png')}}" alt="icon"></div>
                <div class="distro-search-title-text">
                    <h1 class="distro-search-title">Mastiii - India’s No.1 Music and Youth Channel Live TV</h1>
                    <p class="distro-search-text">Catch Distro TV Channel, and Mastiii Channel Live Online on MX Player!</p>
                </div>
            </li>
            <li class="d-flex">
                <div class="distro-search-img"><img src="{{asset('assets/img/distro-search-img.png')}}" alt="icon"></div>
                <div class="distro-search-title-text">
                    <h1 class="distro-search-title">Mastiii - India’s No.1 Music and Youth Channel Live TV</h1>
                    <p class="distro-search-text">Catch Distro TV Channel, and Mastiii Channel Live Online on MX Player!</p>
                </div>
            </li>
        </ul>
    </div>
    <div class="distro-search-select d-none">
        <h1>Genre</h1>
        <h1>Title</h1>
        <h1>Category</h1>
    </div>
</div>