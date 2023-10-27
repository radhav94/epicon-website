@foreach ($epicwebArr as $key => $val)

<?php
$cover_img = isset($val['cover_image']) ? $val['cover_image']['medium'] : @$val['banner_image']['medium'];
$getTitle = getNewTitle($val);
$wishlist = getWishlist();
$card = getItemCardData($val, 'ENGLISH');
?>
<li>
    @include('components.item-hover-card')
    @if(@$val['asset_type'] == 'PLAY')
        {!! getplayanchorhtml($val) !!}
    @else
        <a href="{{ getContentUrl($val) }}" class="main-card">
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