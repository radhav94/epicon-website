@extends('layouts.default')
@section('title', 'Library')

@section('content')

    <section class="container w-100 my-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <h4 class="text-white library-title-center">{{__('Library')}}</h4>
            </div>
            <div class="col-sm-12">
                <div class="w-100 library">
                    <ul class="nav nav-pills border-bot pb-3 nav-center" id="pills-tab" role="tablist">
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
                        {{-- <!-- <div class="filter-library">
                                <select name="" id="">
                                    <option value="">Sort By</option>
                                    <option value="">2</option>
                                </select>
                            </div> --> --}}
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="my-list">
                        <?php if(!empty($data)){ 
                             foreach($data as $key => $listdata) {  ?>
                            <?php if(!empty($listdata)){ ?>
                            <div class="upcoming-heading">
                                <h4 class="new-popularheading text-white my-4">{{ $key }}</h4>
                            </div>
                            <?php } ?>

                            <div class="carousel-main">
                                <ul class="vertical-carousel-initilize p-0">
                                    <?php foreach($listdata as $datalist){ 
                                        $cover_img = getCardImage($datalist, 'cover_image');
                                     ?>
                                    <li>
                                        <a aria-label="item-main" href="{{ url($datalist['url'] ?? '/library') }}" class="main-card">
                                            <div class="main-img">
                                                <img src="{{ $cover_img }}" alt="">

                                            </div>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>

                            <?php } 
                            }else{ ?>
                                <div class="carousel-main text-center">
                                <!-- <h4 style="color:white">{{__('No data found')}}</h4> -->
                                <img class="not-subscribe" src="{{asset('assets/img/no-data-found-library.svg')}}" alt="no data img">
                                <p class="small text-white">You have not added anything to My List yet!</p>
                                <a href="{{ getUrlWithPrefix('homepage') }}" class="login-btn mt-4" style="width: 280px;">
                                    Explores Now
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"></path>
                                    </svg>
                                </a>
                            </div>
                            <?php } ?>
                        </div>
                        
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="history">
                            <?php if(!empty($historydata)){ ?>
                            <div class="carousel-main">
                                <ul class="more-like-this px-0">
                                    <?php foreach($historydata as $historydatalist){ 
                                        $cover_image = getCardImage($historydatalist, 'vertical_cover_image');
                                     ?>
                                    <li>
                                        <a aria-label="item-main" href="{{ url($historydatalist['url'] ?? '/library') }}" class="main-card">
                                            <div class="main-img">
                                                <img src="{{ $cover_image }}" alt="">

                                            </div>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>

                                {{-- <!-- <div class="delete-history mt-5">
                                        <p>All your history will be auto-deleted after 30 days. You can choose to turn it off or delete now.</p>
                                        <div class="d-flex">
                                            <button class="border-btn">Turn Off</button>
                                            <button class="fill-btn">Delete Now</button>
                                        </div>
                                    </div> --> --}}

                            </div>
                            <?php }else{ ?>
                                <div class="carousel-main text-center">
                                    <!-- <h4 style="color:white">{{__('No History Found')}}</h4> -->
                                    <img class="not-subscribe" src="{{asset('assets/img/no-data-found-history-library.svg')}}" alt="no data img">
                                    <p class="small text-white">You do not have any recent content history.</p>
                                    <a href="{{ getUrlWithPrefix('homepage') }}" class="login-btn mt-4" style="width: 280px;">
                                        Explores Now
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"></path>
                                        </svg>
                                    </a>
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

    <script src="{{ asset('assets/js/library.js') }}?v={{ assetTime() }}"></script>
    <script>
        $("#history,#my-list").on('click', function() {
            $('.vertical-carousel-initilize').slick('slickGoTo', 0);
        });
    </script>
@stop

