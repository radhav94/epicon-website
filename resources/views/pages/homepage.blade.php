@extends('layouts.default')
@section('title','New homepage')

@section('style')

@stop

@section('content')

@foreach($result['data']['list'] as $key => $value)
@if( isset($value['display_type']) && isset($value['content']) && !empty($value['content']))
@php
$template = 'display.'.$value['display_type'];
@endphp

@if(View::exists($template))
<?php
$title = getDispLangContent($value, $displayLanguageParam, 'title');
$shortdescription = getDispLangContent($value, $displayLanguageParam, 'shortdesc');
?>
@include($template,['value' => $value,'title' => $title,'shortdescription' => $shortdescription])
@endif

@endif
@endforeach



@stop

@section('script')
<script>
    $(document).ready(function() {
        var TrandingSlider = new Swiper('.tranding-slider', {
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            loop: true,
            slidesPerView: 'auto',
            coverflowEffect: {
                rotate: 0,
                stretch: 0,
                depth: 500,
                modifier: 50,
                slideShadows: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            }
        });
    });
</script>
@stop