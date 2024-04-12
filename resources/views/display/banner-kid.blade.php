<div class="carousel-main home-kids-bg">
    <div class="punjab">
    <div class="punjab-da-swaad align-items-center">
        <div class="punjab-title arvr-text">
            <img src="{{asset('assets/img/kids-home-img.svg')}}" alt="">
        </div>
    </div>
    <ul class="home-kids p-0 mb-0">
        @foreach ($value['content'] as $key => $val)
            <?php
            $card = getItemCardData($val, $displayLanguageParam);
            
            $cover_img = getCardImage($val, 'vertical_cover_image', 'medium');
            
            $getTitle = getNewTitle($val);
            ?>
            <li>
               @include('components.item-hover-card')
               @if(@$val['asset_type'] == 'PLAY')
                   {!! getplayanchorhtml($val) !!}
               @else
                   <a class="main-card" onclick="click_tile(this)" data-title ="{{ @$val['title'] }}" data-type="{{@$title}}" href="{{ getContentUrl($val) }}">
               @endif
                    {!! freePremiumDiv($val) !!}
                    {!! topTenDiv($val) !!}
                    <div class="main-img {{$getTitle['cls']}}">
                        <img src="{{ $cover_img }}" alt="">
                        {!! $getTitle['html'] !!}
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
    </div>
</div>
