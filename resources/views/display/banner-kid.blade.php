<div class="carousel-main home-kids-bg">
    <div class="gaming-galore-main">
        <a href="{{ url('kids') }}" class="">
            <div class="galore-title">
                <img class="kids-tray-img" src="{{ asset('assets/img/kids-home-img.svg') }}" alt="">
            </div>
        </a>
        <div class="gaming-galore p-0 mb-0">
            @foreach ($value['content'] as $key => $val)
                <?php
                $card = getItemCardData($val, $displayLanguageParam);
                
                $cover_img = getCardImage($val, 'vertical_cover_image', 'medium');
                
                $getTitle = getNewTitle($val);
                ?>
                <div>
                    @include('components.item-hover-card')
                    @if (@$val['asset_type'] == 'PLAY')
                        {!! getplayanchorhtml($val) !!}
                    @else
                        <a class="main-card p-0" onclick="click_tile(this)" data-title ="{{ @$val['title'] }}"
                            data-type="{{ @$title }}" href="{{ getContentUrl($val) }}">
                    @endif
                    {!! freePremiumDiv($val) !!}
                    {!! topTenDiv($val) !!}
                    <div class="main-img p-0 {{ $getTitle['cls'] }}">
                        <img src="{{ $cover_img }}" alt="">
                        {!! $getTitle['html'] !!}
                    </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
