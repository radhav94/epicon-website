@extends('layouts.default')
@section('title', $meta['title'] ?? getDefaultMetaTitle() )

@section('content')
    <?php $meta['description'] = 'Experience entertainment like never before with the Epic On OTT Platform. Enjoy an extensive collection of movies, TV shows, and live shows all in one place.'; ?>
    <section class="container w-100 my-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <h4 class="text-white mb-3">{{ __('About Us') }}</h4>
                <p class="text-white fs-5">
                    {{ __('EPIC On by IN10 Media is the go-to platform for entertaining and informative Indian TV shows, short videos, documentaries, eBooks, Podcasts, Games, LIVE TV, and Audio Books, across the genres of sports, food, history, mythology, travel, and more.') }}
                    <br><br>
                    {{ __('The streaming service offers free and premium Videos-On-Demand, exciting audio content, and popular books and games - easily accessible on smartphones and other smart devices. Explore, discover, and be inspired by all things Indian on EPIC On.') }}
                </p>
            </div>
        </div>
    </section>

@stop

@section('script')

@stop