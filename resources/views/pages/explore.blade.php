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
                    <ul class="nav nav-pills pb-3 ps-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="my-list" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Genres</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="history" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Language</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">

                        @if( @$result['data']['genres'] )
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="my-list">
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
                        </div> 
                        @endif

                        @if( @$result['data']['languages'] )
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="history">
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
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>

@endif


@stop

@section('script')

@stop