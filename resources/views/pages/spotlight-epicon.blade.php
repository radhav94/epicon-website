@extends('layouts.default')
@section('title','Get to Know About Upcoming OTT New Web Series and Movies')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plyr.css') }}?v={{ assetTime() }}">

@stop

@section('content')

<div class="scrollspy">
    <div id="nav-container" class="position-fixed d-flex align-items-center justify-content-between px-3">
        <div class="carousel-title-n-arrow">
            <h5 class="text-white mb-0">Spotlight</h5>
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
        @foreach ($spotlightData['data']['list'] as $head_item)
            <section id="{{ strtolower(str_replace(' ', '', $head_item['title'])) }}" class="mt-5">
                <div class="carousel-title-n-arrow pb-3">
                    <h5 class="text-white mb-0">{{ $head_item['title'] }} in India</h5>
                </div>
                @if (strtolower(str_replace(' ', '', $head_item['title'])) != 'commingsoon')
                    <div class="top-ten-shows-movies">
                        @foreach ($head_item['content'] as $num=> $item)
                            <?php $cover_img = getCardImage($item, 'cover_image_special', 'medium', ['epic_shorts_image', 'banner_image']); ?>
                            <a href="#/" class="card-ms">
                                <div class="number"></div>
                                <div class="img">
                                    <img src="{{ $cover_img }}" alt="">
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    @php
                        $groupedItems = [];
                    @endphp
                    @foreach ($head_item['content'] as $item)
                        @php
                            $creationDate = date('Y-m-d', strtotime($item['created_on']));
                            $groupedItems[$creationDate][] = $item;
                        @endphp
                    @endforeach
                    @foreach ($groupedItems as $date => $items)
                        <div class="upcoming-epicon-main">
                            <div class="card-details mb-4">
                                <div class="date-upperline">.</div>
                                <div class="internal-card d-flex">
                                    <div class="date-card text-white">
                                        <h6>{{ date('d', strtotime($date)) }}</h6>
                                        <h6>{{ date('M', strtotime($date)) }}</h6>
                                        <h6>{{ date('Y', strtotime($date)) }}</h6>
                                    </div>
                                    <div class="upcomming-scroll">
                                        @foreach ($items as $cont)
                                            <div class="card-main-body d-flex mt-4 pt-2 ms-3">
                                                <div class="card-body">
                                                    <a onclick="click_tile(this)" class="upper-img upcomingVid"
                                                        href="javascript:void(0)" data-id="378" data-type="SHOW"
                                                        data-title="Plot 1 By 2 - Trailer"
                                                        data-promo="">
                                                        <img src="{{ $cont['cover_image']['original']??asset('assets/img/top-ten-movies.png') }}"
                                                            alt="">
                                                    </a>
                                                    {{-- @dd($cont) --}}
                                                    <div class="bottom-text d-flex mt-2">
                                                        <div class="left-text">
                                                            <h4 class="text-heading text-white upc">
                                                                {{ $cont['title'] }}
                                                            </h4>
                                                            <ul class="text-white">
                                                                @if(isset($cont['age_limit']))
                                                                    <li>{{ $cont['age_limit'] }}</li>
                                                                @endif
                                                                @foreach ($cont['genres_assign'] as $genre)
                                                                <li>{{ $genre['name'] }}</li>
                                                                @endforeach
                                                                <li>{{ date('Y', strtotime($date)) }}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </section>
        @endforeach
    </div>
</div>
@stop