@extends('layouts.default')
@section('title', $meta['title'] ?? getDefaultMetaTitle() )

@section('style')
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
        pointer-events: none;
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
        transform: scale(1.2, 1.2);
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
    .distro-search-img img{
        width: 100%;
        height:100%;
        object-fit:cover;
    }
    .npq.active
    {
        background: #ffffff1a;
        color: #fff;
    }
    /* .dis-img-toggle{display: none;} */
</style>
@stop

@section('content')
<input type="hidden" id="routepage" value="{{ request()->path() }}">
<input type="hidden" id="pageval" value="1">


<div class="loadmorecontent">

    <?php
         $wishlist = getWishlist();
         //dd($result['pageData']);
         ?>

         @if (@$result['pageData']['list'])
             @foreach ($result['pageData']['list'] as $key => $value)
                 @if (isset($value['display_type']) && isset($value['content']) && !empty($value['content']))
                     @php
                         $template = 'display-distro.' . $value['display_type'];
                     @endphp

                    @if (View::exists($template))
                         <?php
                         $title = getDispLangContent($value, $displayLanguageParam, 'title');
                         $shortdescription = getDispLangContent($value, $displayLanguageParam, 'shortdesc');
                         
                         ?>

                         @if (request()->get('v'))
                             <h1>{{ $value['display_type'] }}</h1>
                         @endif

               
                            @include($template, [
                                'value' => $value,
                                'title' => $title,
                                'shortdescription' => sanitizeData($shortdescription),
                            ])
                     @endif
                 @endif
             @endforeach
         @endif

</div>

    <div class="content-loader d-none" style="text-align: center;"> <img style="width: 40px;" src="{{ asset('assets/img/loader.gif') }}" alt=""> </div>

@stop

@section('script')
<script src="{{ asset('assets/js/homepage.js') }}?v={{ assetTime() }}"></script>
<script defer src="{{ asset('assets/js/distro-tv.js') }}?v={{ assetTime() }}"></script>
<script>
    window.onload = function() {
        eventAfterDistroLoad();
    }
    var processing;
    var spinnerAdded = false;

    $(document).ready(function() {
        $('#pageval').val('1');
        
        if (typeof activateSpinner === 'function') {
            activateSpinner();
        }
        initSliders();

        });

    </script>
    

@stop
