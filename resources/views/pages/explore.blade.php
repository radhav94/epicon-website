@extends('layouts.default')
@section('title', $meta['title'] ?? getDefaultMetaTitle() )
 

@section('content')


@if (@$result['data']['genres'])
{{-- <!-- <section class="container-fluid">
    <div class="genresexplore">
        <h4 class="genresheading text-white">{{__('Genres')}}</h4>
        <div class="card-details">

            @foreach ($result['data']['genres'] as $key => $value)
            <a href="{{ getUrl('explore/' . @$value['slug']) }}" class="card-body">
                <h4 class="action">{{ @$value['name'] }}</h4>
                <img src="{{ @$value['images']['small'] }}" alt="">
            </a>
            @endforeach

        </div>
    </div>
</section> --> --}}

<section class="container w-100 my-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="w-100 library lb mt-0">
                    <div class="">
                        <h5 class="text-white">Genres</h5>
                    </div>
                  

                        @if( @$result['data']['genres'] )
                            <div class="genresexplore">
                                {{-- <!-- <h4 class="genresheading text-white">{{__('Genres')}}</h4> --> --}}
                                <div class="card-details">

                                    @foreach ($result['data']['genres'] as $key => $value)
                                    <a onclick="click_explore(this)" data-title ="{{ @$value['name'] }}" href="{{ getUrl('explore/' . @$value['slug']) }}" class="card-body">
                                        {{-- <h4 class="action">{{ @$value['name'] }}</h4> --}}
                                        <img src="{{ @$value['images']['small'] }}" alt="">
                                    </a>
                                    @endforeach

                                </div>
                            </div>
                        @endif
                        <div class="carousel-title-n-arrow px-2 mb-2">
                            <h5 class="text-white">Language</h5>
                        </div>
                        @if( @$result['data']['languages'] )
                            <div class="gener-lang">

                                @foreach ($result['data']['languages'] as $key => $value)

                                <?php
                                $cover_img = '';
                                if(isset($value['images']) ){
                                    $cover_img = isset($value['images']['small']) ? $value['images']['small'] : '';
                                }
                                
                                ?>

                                <a onclick="click_tile(this)" data-title="{{@$value['name']}}" data-type="Languages" href="{{ getUrl('explore/' . @$value['slug']) }}" tabindex="0">
                                    <img src="{{ $cover_img }}">
                                </a>
                                @endforeach

                            </div>
                        @endif

                </div>
            </div>
        </div>
    </section>

@endif


@stop

@section('script')

@stop