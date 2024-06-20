@extends('layouts.default')
@section('title','Get to Know About Upcoming OTT New Web Series and Movies')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plyr.css') }}?v={{ assetTime() }}">

@stop

@section('content')
<div class="scrollspy pb-5">
    <div id="nav-container" class="position-fixed d-flex align-items-center justify-content-between px-3">
        <div class="carousel-title-n-arrow">
            <h5 class="text-white mb-0">{{__('Hot & New')}}</h5>
        </div>
        <div id="nav">
            @foreach ($spotlightData['data']['list'] as $key => $head_item)
                <a href="#{{ strtolower(str_replace(' ', '', $head_item['title'])) }}" class="nav-link {{ $key == 0 ? 'active' : '' }}">
                    <img src="{{ asset('assets/spotlight/' . strtolower(str_replace(' ', '', $head_item['title'])) . '-icon.svg') }}"
                        alt="">
                    {{ $head_item['title'] }}
                </a>
            @endforeach
        </div>
    </div>
    <div class="container-fluid pt-5 pe-0">
        {{--dd($spotlightData['data']['list'][0]['content'][0]['cover_image'])--}}
        @foreach ($spotlightData['data']['list'] as $head_item)
            <section id="{{ strtolower(str_replace(' ', '', $head_item['title'])) }}" class="mt-5">
                <div class="carousel-title-n-arrow pb-3">
                    <h5 class="text-white mb-0">{{ $head_item['title'] }}</h5>
                </div>
                @php
                    $title = $head_item['title'] ?? "";
                @endphp
                    <div class="top-ten-shows-movies">

                        @foreach ($head_item['content'] as $num=> $item)
                       
                            @php
                                $cover_img = getCardImage($item, 'cover_image', 'medium', ['epic_shorts_image', 'banner_image'])
                            @endphp
                            @if (!in_array(strtolower(str_replace(' ', '', $head_item['title'])), ['comingsoon', 'commingsoon']))
                            <a onclick="click_tile(this)" data-title ="{{ @$item['title'] }}" data-type="{{ @$title }}" href="{{ getContentUrl($item) }}" class="card-ms">
                                <div class="number"></div>
                                <div class="img">
                                    <img src="{{ $cover_img }}" alt="">
                                </div>
                            </a>
                            @else
                            @php $date = date('Y-m-d', strtotime($item['publish_future_date'] ?? $item['created_on'])); @endphp
                            <div class="upcoming-epicon-main">
                            <div class="card-details">
                                <div class="internal-card d-flex">
                                    
                                    <div class="upcomming-scroll">
                                        <div class="card-main-body d-flex ms-3">
                                                <div class="card-body">
                                                    <div class="upper-img upcomingVid">
                                                        <img src="{{ $item['cover_image']['original']??asset('assets/img/top-ten-movies.png') }}" alt="">
                                                    </div>
                                                    
                                                    <div class="bottom-text d-flex mt-2">
                                                        <div class="left-text">
                                                            <h4 class="text-heading text-white upc">
                                                            {{ $item['title'] }}
                                                            </h4>
                                                            <h6 class="text-white">{{ date('d', strtotime($date)) }}
                                                            {{ date('M', strtotime($date)) }}
                                                            {{ date('Y', strtotime($date)) }}</h6>
                                                            <ul class="text-white">
                                                            @if(isset($item['age_limit']))
                                                                <li>{{ $item['age_limit'] }}</li>
                                                            @endif
                                                                @foreach ($item['genres_assign'] as $genre)
                                                                <li>{{ $genre['name'] }}</li>
                                                                @endforeach
                                                                <li>{{ date('Y', strtotime($date)) }}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>   

                    @endif
                @endforeach
                    </div>
                
            </section>
        @endforeach
    </div>
</div>
@stop
