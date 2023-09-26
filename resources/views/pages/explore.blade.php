@extends('layouts.default')
@section('title', 'Explore')

@section('style')
@stop

@section('content')


@if (@$result['data']['genres'])
<section class="container-fluid">
    <div class="genresexplore">
        <h4 class="genresheading text-white">{{__('Genres')}}</h4>
        <div class="card-details">

            @foreach ($result['data']['genres'] as $key => $value)
            <a href="{{ getUrl('explore/' . @$value['slug']) }}" class="card-body">
                {{-- <h4 class="action">{{ @$value['name'] }}</h4> --}}
                <img src="{{ @$value['images']['small'] }}" alt="">
            </a>
            @endforeach

        </div>
    </div>
</section>
@endif


@stop

@section('script')

@stop