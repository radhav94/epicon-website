@extends('layouts.default')
@section('title','New homepage')

@section('style')

@stop

@section('content')
<?php //dd($trendingData); ?>
<main class="search-bg w-100">
    <section class="container w-100">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <div class="search">
                    <button class="back-btn p-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M26.3359 15.9987C26.3359 16.551 25.8882 16.9987 25.3359 16.9987L6.66927 16.9987C6.11699 16.9987 5.66927 16.551 5.66927 15.9987C5.66927 15.4464 6.11699 14.9987 6.66927 14.9987L25.3359 14.9987C25.8882 14.9987 26.3359 15.4464 26.3359 15.9987Z" fill="white"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7097 26.0391C16.3192 26.4297 15.686 26.4297 15.2955 26.0391L5.96217 16.7058C5.57164 16.3153 5.57164 15.6821 5.96217 15.2916L15.2955 5.95826C15.686 5.56773 16.3192 5.56773 16.7097 5.95826C17.1002 6.34878 17.1002 6.98195 16.7097 7.37247L8.08349 15.9987L16.7097 24.6249C17.1002 25.0154 17.1002 25.6486 16.7097 26.0391Z" fill="white"/>
                          </svg>
                    </button>
                    <div class="search-bar" id="searchform_id">

                        <button class="mic"><img src="{{asset('/img/mic-icon.svg')}}" alt="icon"></button>
                        <input type="text" name="search" id="searchname" placeholder="Movies, shows, podcasts and more" autocomplete="off">
                        <button class="search-icon"><img src="{{asset('/img/search-icon.svg')}}" alt="icon"></button>
                    </div>
                    <button class="remove-text p-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
                            <g clip-path="url(#clip0_132_4915)">
                              <circle cx="18" cy="18" r="18" fill="white" fill-opacity="0.3"/>
                              <path fill-rule="evenodd" clip-rule="evenodd" d="M24.7346 12.5454C24.8187 12.4615 24.8854 12.3618 24.9309 12.252C24.9765 12.1423 24.9999 12.0247 25 11.9059C25.0001 11.787 24.9767 11.6694 24.9313 11.5596C24.8859 11.4498 24.8194 11.35 24.7354 11.2659C24.6514 11.1819 24.5518 11.1152 24.442 11.0696C24.3323 11.0241 24.2146 11.0006 24.0958 11.0006C23.977 11.0005 23.8594 11.0238 23.7496 11.0692C23.6398 11.1146 23.54 11.1812 23.4559 11.2652L17.9999 16.7213L12.5454 11.2652C12.3756 11.0954 12.1454 11 11.9053 11C11.6652 11 11.4349 11.0954 11.2652 11.2652C11.0954 11.4349 11 11.6652 11 11.9053C11 12.1454 11.0954 12.3757 11.2652 12.5454L16.7212 18L11.2652 23.4546C11.1811 23.5386 11.1144 23.6384 11.0689 23.7483C11.0234 23.8581 11 23.9758 11 24.0947C11 24.2136 11.0234 24.3313 11.0689 24.4411C11.1144 24.551 11.1811 24.6508 11.2652 24.7348C11.4349 24.9046 11.6652 25 11.9053 25C12.0242 25 12.1419 24.9766 12.2517 24.9311C12.3616 24.8856 12.4613 24.8189 12.5454 24.7348L17.9999 19.2787L23.4559 24.7348C23.6257 24.9044 23.8559 24.9996 24.0958 24.9994C24.3358 24.9993 24.5658 24.9038 24.7354 24.7341C24.905 24.5643 25.0001 24.3341 25 24.0941C24.9999 23.8542 24.9044 23.6241 24.7346 23.4546L19.2786 18L24.7346 12.5454Z" fill="white"/>
                            </g>
                            <defs>
                              <clipPath id="clip0_132_4915">
                                <rect width="36" height="36" fill="white"/>
                              </clipPath>
                            </defs>
                          </svg>
                    </button>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="w-100 library mb-0 search-main">
                    <ul class="nav nav-pills d-flex justify-content-center pb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link ep active" id="episode" data-bs-toggle="pill" data-bs-target="#pills-episode" type="button" role="tab" aria-controls="pills-episode" aria-selected="true">All</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="morelike" data-bs-toggle="pill" data-bs-target="#pills-morelike" type="button" role="tab" aria-controls="pills-morelike" aria-selected="false">Movies</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="trailors" data-bs-toggle="pill" data-bs-target="#pills-trailors" type="button" role="tab" aria-controls="pills-trailors" aria-selected="false">Shows</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="history" data-bs-toggle="pill" data-bs-target="#pills-about" type="button" role="tab" aria-controls="pills-about" aria-selected="false">Podcast</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="kids" data-bs-toggle="pill" data-bs-target="#pills-kids" type="button" role="tab" aria-controls="pills-kids" aria-selected="false">Kids</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="games" data-bs-toggle="pill" data-bs-target="#pills-games" type="button" role="tab" aria-controls="pills-games" aria-selected="false">Games</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-episode" role="tabpanel" aria-labelledby="my-list">
                            <ul class="list-unstyled col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 p-0 mt-4">
                                <li class="episode-main mb-4" id="Alltopresult">
                                   <!--  @isset($Alltopresponse)
                                        {!! $Alltopresponse !!}
                                    @endisset -->
                                    <!-- <div class="pik">
                                        <img src="{{asset('/img/episode.png')}}" alt="img">
                                        <img class="crown" src="{{asset('/img/crown.svg')}}" alt="icon">
                                    </div>

                                    <div class="episode-text-details">
                                        <h6>E1 - It’s Man who exist in the dark</h6>
                                        <span>12 May 2023 | 42m</span>
                                        <p class="search-top mt-2">The first episode of Laal Banarasi is about the struggle of a Banaras based poor weaver girl Gauri with poverty and education and about the ambition perfection of a Shakuntala Saree owner Garv.</p>
                                        <div class="d-flex align-items-center">
                                            <button class="fill-btn em ms-0">Watch S1 • E1</button>
                                            <button class="rounded-grey-btn ms-3"><img src="{{asset('/img/add-icon.svg')}}" alt="icon"></button>
                                        </div>
                                    </div> -->
                                    
                                </li>
                            </ul>
<!-- 'pages.detail.detail-components.tabs' -->
                            @include('pages.search.trending_searchlist')
                            <div class="w-100">
                                <div class="carousel-title-n-arrow mb-1">
                                    <h1 class="text-white small">Trending Movie Buzz</h1>
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                            <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
                                </div>
                                <ul class="more-like-this trend px-0">
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="pills-morelike" role="tabpanel" aria-labelledby="my-list">
                            <ul class="list-unstyled col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 p-0 mt-4">
                                <li class="episode-main mb-4" id="Moviestopresult">
                                    <!-- <div class="pik">
                                        <img src="public/img/episode.png" alt="img">
                                        <img class="crown" src="public/img/crown.svg" alt="icon">
                                    </div>
                                    <div class="episode-text-details">
                                        <h6>E1 - It’s Man who exist in the dark</h6>
                                        <span>12 May 2023 | 42m</span>
                                        <p class="search-top mt-2">The first episode of Laal Banarasi is about the struggle of a Banaras based poor weaver girl Gauri with poverty and education and about the ambition perfection of a Shakuntala Saree owner Garv.</p>
                                        <div class="d-flex align-items-center">
                                            <button class="fill-btn em ms-0">Watch S1 • E1</button>
                                            <button class="rounded-grey-btn ms-3"><img src="public/img/add-icon.svg" alt="icon"></button>
                                        </div>
                                    </div> -->
                                    
                                </li>
                            </ul>

                            @include('pages.search.trending_searchlist')

                            <div class="w-100">
                                <div class="carousel-title-n-arrow mb-1">
                                    <h1 class="text-white small">Trending Movie Buzz</h1>
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                            <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
                                </div>
                                <ul class="more-like-this trend px-0">
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-trailors" role="tabpanel" aria-labelledby="my-list">
                            <ul class="list-unstyled col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 p-0 mt-4">
                                <li class="episode-main mb-4" id="Showtopresult">
                                    <!-- <div class="pik">
                                        <img src="public/img/episode.png" alt="img">
                                        <img class="crown" src="public/img/crown.svg" alt="icon">
                                    </div>
                                    <div class="episode-text-details">
                                        <h6>E1 - It’s Man who exist in the dark</h6>
                                        <span>12 May 2023 | 42m</span>
                                        <p class="search-top mt-2">The first episode of Laal Banarasi is about the struggle of a Banaras based poor weaver girl Gauri with poverty and education and about the ambition perfection of a Shakuntala Saree owner Garv.</p>
                                        <div class="d-flex align-items-center">
                                            <button class="fill-btn em ms-0">Watch S1 • E1</button>
                                            <button class="rounded-grey-btn ms-3"><img src="public/img/add-icon.svg" alt="icon"></button>
                                        </div>
                                    </div> -->
                                    
                                </li>
                            </ul>

                            @include('pages.search.trending_searchlist')

                            <div class="w-100">
                                <div class="carousel-title-n-arrow mb-1">
                                    <h1 class="text-white small">Trending Movie Buzz</h1>
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                            <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
                                </div>
                                <ul class="more-like-this trend px-0">
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-about" role="tabpanel" aria-labelledby="my-list">
                            <ul class="list-unstyled col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 p-0 mt-4">
                                <li class="episode-main mb-4" id="Podcasttopresult">
                                    <!-- <div class="pik">
                                        <img src="public/img/episode.png" alt="img">
                                        <img class="crown" src="public/img/crown.svg" alt="icon">
                                    </div>
                                    <div class="episode-text-details">
                                        <h6>E1 - It’s Man who exist in the dark</h6>
                                        <span>12 May 2023 | 42m</span>
                                        <p class="search-top mt-2">The first episode of Laal Banarasi is about the struggle of a Banaras based poor weaver girl Gauri with poverty and education and about the ambition perfection of a Shakuntala Saree owner Garv.</p>
                                        <div class="d-flex align-items-center">
                                            <button class="fill-btn em ms-0">Watch S1 • E1</button>
                                            <button class="rounded-grey-btn ms-3"><img src="public/img/add-icon.svg" alt="icon"></button>
                                        </div>
                                    </div> -->
                                    
                                </li>
                            </ul>

                            @include('pages.search.trending_searchlist')

                            <div class="w-100">
                                <div class="carousel-title-n-arrow mb-1">
                                    <h1 class="text-white small">Trending Movie Buzz</h1>
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                            <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
                                </div>
                                <ul class="more-like-this trend px-0">
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-kids" role="tabpanel" aria-labelledby="my-list">
                            <ul class="list-unstyled col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 p-0 mt-4">
                                <li class="episode-main mb-4" id="Kidstopresult">

                                    <!-- <div class="pik">
                                        <img src="public/img/episode.png" alt="img">
                                        <img class="crown" src="public/img/crown.svg" alt="icon">
                                    </div>
                                    <div class="episode-text-details">
                                        <h6>E1 - It’s Man who exist in the dark</h6>
                                        <span>12 May 2023 | 42m</span>
                                        <p class="search-top mt-2">The first episode of Laal Banarasi is about the struggle of a Banaras based poor weaver girl Gauri with poverty and education and about the ambition perfection of a Shakuntala Saree owner Garv.</p>
                                        <div class="d-flex align-items-center">
                                            <button class="fill-btn em ms-0">Watch S1 • E1</button>
                                            <button class="rounded-grey-btn ms-3"><img src="public/img/add-icon.svg" alt="icon"></button>
                                        </div>
                                    </div> -->
                                    
                                </li>
                            </ul>

                            @include('pages.search.trending_searchlist')

                            <div class="w-100">
                                <div class="carousel-title-n-arrow mb-1">
                                    <h1 class="text-white small">Trending Movie Buzz</h1>
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                            <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
                                </div>
                                <ul class="more-like-this trend px-0">
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-games" role="tabpanel" aria-labelledby="my-list">
                            <ul class="list-unstyled col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 p-0 mt-4">
                                <li class="episode-main mb-4" id="Gamestopresult">
                                    <!-- <div class="pik">
                                        <img src="public/img/episode.png" alt="img">
                                        <img class="crown" src="public/img/crown.svg" alt="icon">
                                    </div>
                                    <div class="episode-text-details">
                                        <h6>E1 - It’s Man who exist in the dark</h6>
                                        <span>12 May 2023 | 42m</span>
                                        <p class="search-top mt-2">The first episode of Laal Banarasi is about the struggle of a Banaras based poor weaver girl Gauri with poverty and education and about the ambition perfection of a Shakuntala Saree owner Garv.</p>
                                        <div class="d-flex align-items-center">
                                            <button class="fill-btn em ms-0">Watch S1 • E1</button>
                                            <button class="rounded-grey-btn ms-3"><img src="public/img/add-icon.svg" alt="icon"></button>
                                        </div>
                                    </div> -->
                                    
                                </li>
                            </ul>

                            @include('pages.search.trending_searchlist')

                            <div class="w-100">
                                <div class="carousel-title-n-arrow mb-1">
                                    <h1 class="text-white small">Trending Movie Buzz</h1>
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                            <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
                                </div>
                                <ul class="more-like-this trend px-0">
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="javascript:void(0);" class="main-card mt-0">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                            <span class="top-ten position-absolute">
                                                <ul class="list-unstyled text-white">
                                                    <li>Top</li>
                                                    <li>10</li>
                                                </ul>
                                            </span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                        </a> 
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@stop

@section('script')
    <script src="{{ asset('assets/js/search.js') }}"></script>
@stop
