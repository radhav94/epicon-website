@extends('layouts.default')
@section('title', 'Library')

@section('style')

@stop

@section('content')


    <?php //dd($data); ?>

    <section class="container w-100 my-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <h4 class="text-white">{{__('Library')}}</h4>
            </div>
            <div class="col-sm-12">
                <div class="w-100 library">
                    <ul class="nav nav-pills border-bot pb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="my-list" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">{{__('My List')}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="history" data-bs-toggle="pill" data-bs-target="#pills-profile"
                                type="button" role="tab" aria-controls="pills-profile"
                                aria-selected="false">{{__('History')}}</button>
                        </li>
                        <!-- <div class="filter-library">
                                <select name="" id="">
                                    <option value="">Sort By</option>
                                    <option value="">2</option>
                                </select>
                            </div> -->
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="my-list">
                            <?php foreach($data as $key => $listdata) {  ?>
                            <?php if(!empty($listdata)){ ?>
                            <div class="upcoming-heading">
                                <h4 class="new-popularheading text-white my-4">{{ $key }}</h4>
                            </div>
                            <?php } ?>

                            <div class="carousel-main">
                                <ul class="vertical-carousel-initilize p-0">
                                    <?php foreach($listdata as $datalist){ 
                                    $cover_img = isset($datalist['cover_image']) ? @$datalist['cover_image']['medium'] : $datalist['cover_image_special']['medium'];
                                     ?>
                                    <li>
                                        <a href="{{ url($datalist['url'] ?? '/library') }}" class="main-card">
                                            <div class="main-img">
                                                <img src="{{ $cover_img }}" alt="">

                                            </div>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>

                            <?php } ?>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="history">
                            <?php if(!empty($historydata)){ ?>
                            <div class="carousel-main">
                                <ul class="vertical-carousel-initilize p-0">
                                    <?php foreach($historydata as $historydatalist){ 
                                    $cover_image = isset($historydatalist['vertical_cover_image']) ? @$historydatalist['vertical_cover_image']['medium'] : $historydatalist['banner_image']['medium'];
                                     ?>
                                    <li>
                                        <a href="{{ url($historydatalist['url'] ?? '/library') }}" class="main-card">
                                            <div class="main-img">
                                                <img src="{{ $cover_image }}" alt="">

                                            </div>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>

                                <!-- <div class="delete-history mt-5">
                                        <p>All your history will be auto-deleted after 30 days. You can choose to turn it off or delete now.</p>
                                        <div class="d-flex">
                                            <button class="border-btn">Turn Off</button>
                                            <button class="fill-btn">Delete Now</button>
                                        </div>
                                    </div> -->

                            </div>
                            <?php }else{ ?>
                                <div class="carousel-main">
                                    <h4 style="color:white">{{__('No History Found')}}</h4>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop

@section('script')
    <script src="{{ asset('assets/js/library.js') }}"></script>
@stop
