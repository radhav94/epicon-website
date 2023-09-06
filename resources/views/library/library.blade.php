@extends('layouts.default')
@section('title','New homepage')

@section('style')

@stop

@section('content')

    
    <section class="container w-100 my-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <h4 class="text-white">Library</h4>
            </div>
            <div class="col-sm-12">
                <div class="w-100 library">
                    <ul class="nav nav-pills border-bot pb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="my-list" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">My List</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="history" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">History</button>
                        </li>
                        <div class="filter-library">
                            <select name="" id="">
                                <option value="">Sort By</option>
                                <option value="">2</option>
                            </select>
                        </div>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="my-list">

                            <div class="carousel-main">
                                <ul class="vertical-carousel-initilize p-0">
                                    <li> 
                                        <div class="play-card">
                                            <a href="#/" class="top-card-img">
                                                <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                                <span class="top-ten position-absolute">
                                                    <ul class="list-unstyled text-white">
                                                        <li>Top</li>
                                                        <li>10</li>
                                                    </ul>
                                                </span>
                                                <img src="public/img/dhamal.jpeg" alt="">
                                            </a>
                                            <div class="bottom-card-content">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button class="play-btn me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z" fill="#272727"/>
                                                                </svg>
                                                             <span class="ms-1">Resume</span>
                                                        </button>
                                                        <button id="add-icon" class="small-btn add-icon mx-1"></button>
                                                        <button id="like-icon" class="small-btn like-icon mx-1"></button>
                                                        <button id="share-icon" class="small-btn share-icon mx-1"></button>
                                                        <button id="add-icon" class="small-btn circle-icon mx-1"></button>
                                                    </div>
                                                </div>
                                                <h1>Laal Banarsi</h1>
                                                <!-- <p>Lorem ipsum dolor sit amet, ipsumcon dipiscing elitdconsectetur adipiscing elit dipiscing elitdconsectetur adipiscing elit</p> -->
                                                <ul>
                                                    <li>U/A 13+</li>
                                                    <li>Mystery</li>
                                                    <li>Mind Game</li>
                                                    <li>5 Seasons</li>
                                                </ul>
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="left-time">42 of 1h 20m left</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="main-card">
                                            <div class="main-img">
                                                <img src="public/img/dhamal.jpeg" alt="">
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <div class="play-card">
                                            <a href="#/" class="top-card-img">
                                                <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                                <span class="top-ten position-absolute">
                                                    <ul class="list-unstyled text-white">
                                                        <li>Top</li>
                                                        <li>10</li>
                                                    </ul>
                                                </span>
                                                <img src="public/img/dhamal.jpeg" alt="">
                                            </a>
                                            <div class="bottom-card-content">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button class="play-btn me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z" fill="#272727"/>
                                                                </svg>
                                                             <span class="ms-1">Resume</span>
                                                        </button>
                                                        <button id="add-icon" class="small-btn add-icon mx-1"></button>
                                                        <button id="like-icon" class="small-btn like-icon mx-1"></button>
                                                        <button id="share-icon" class="small-btn share-icon mx-1"></button>
                                                        <button id="add-icon" class="small-btn circle-icon mx-1"></button>
                                                    </div>
                                                </div>
                                                <h1>Laal Banarsi</h1>
                                                <!-- <p>Lorem ipsum dolor sit amet, ipsumcon dipiscing elitdconsectetur adipiscing elit dipiscing elitdconsectetur adipiscing elit</p> -->
                                                <ul>
                                                    <li>U/A 13+</li>
                                                    <li>Mystery</li>
                                                    <li>Mind Game</li>
                                                    <li>5 Seasons</li>
                                                </ul>
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="left-time">42 of 1h 20m left</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="main-card">
                                            <div class="main-img">
                                                <img src="public/img/dhamal.jpeg" alt="">
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <div class="play-card">
                                            <a href="#/" class="top-card-img">
                                                <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                                <span class="top-ten position-absolute">
                                                    <ul class="list-unstyled text-white">
                                                        <li>Top</li>
                                                        <li>10</li>
                                                    </ul>
                                                </span>
                                                <img src="public/img/dhamal.jpeg" alt="">
                                            </a>
                                            <div class="bottom-card-content">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button class="play-btn me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z" fill="#272727"/>
                                                                </svg>
                                                             <span class="ms-1">Resume</span>
                                                        </button>
                                                        <button id="add-icon" class="small-btn add-icon mx-1"></button>
                                                        <button id="like-icon" class="small-btn like-icon mx-1"></button>
                                                        <button id="share-icon" class="small-btn share-icon mx-1"></button>
                                                        <button id="add-icon" class="small-btn circle-icon mx-1"></button>
                                                    </div>
                                                </div>
                                                <h1>Laal Banarsi</h1>
                                                <!-- <p>Lorem ipsum dolor sit amet, ipsumcon dipiscing elitdconsectetur adipiscing elit dipiscing elitdconsectetur adipiscing elit</p> -->
                                                <ul>
                                                    <li>U/A 13+</li>
                                                    <li>Mystery</li>
                                                    <li>Mind Game</li>
                                                    <li>5 Seasons</li>
                                                </ul>
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="left-time">42 of 1h 20m left</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="main-card">
                                            <div class="main-img">
                                                <img src="public/img/dhamal.jpeg" alt="">
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <div class="play-card">
                                            <a href="#/" class="top-card-img">
                                                <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                                <span class="top-ten position-absolute">
                                                    <ul class="list-unstyled text-white">
                                                        <li>Top</li>
                                                        <li>10</li>
                                                    </ul>
                                                </span>
                                                <img src="public/img/dhamal.jpeg" alt="">
                                            </a>
                                            <div class="bottom-card-content">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button class="play-btn me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z" fill="#272727"/>
                                                                </svg>
                                                             <span class="ms-1">Resume</span>
                                                        </button>
                                                        <button id="add-icon" class="small-btn add-icon mx-1"></button>
                                                        <button id="like-icon" class="small-btn like-icon mx-1"></button>
                                                        <button id="share-icon" class="small-btn share-icon mx-1"></button>
                                                        <button id="add-icon" class="small-btn circle-icon mx-1"></button>
                                                    </div>
                                                </div>
                                                <h1>Laal Banarsi</h1>
                                                <!-- <p>Lorem ipsum dolor sit amet, ipsumcon dipiscing elitdconsectetur adipiscing elit dipiscing elitdconsectetur adipiscing elit</p> -->
                                                <ul>
                                                    <li>U/A 13+</li>
                                                    <li>Mystery</li>
                                                    <li>Mind Game</li>
                                                    <li>5 Seasons</li>
                                                </ul>
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="left-time">42 of 1h 20m left</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="main-card">
                                            <div class="main-img">
                                                <img src="public/img/dhamal.jpeg" alt="">
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <div class="play-card">
                                            <a href="#/" class="top-card-img">
                                                <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                                <span class="top-ten position-absolute">
                                                    <ul class="list-unstyled text-white">
                                                        <li>Top</li>
                                                        <li>10</li>
                                                    </ul>
                                                </span>
                                                <img src="public/img/dhamal.jpeg" alt="">
                                            </a>
                                            <div class="bottom-card-content">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button class="play-btn me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z" fill="#272727"/>
                                                                </svg>
                                                             <span class="ms-1">Resume</span>
                                                        </button>
                                                        <button id="add-icon" class="small-btn add-icon mx-1"></button>
                                                        <button id="like-icon" class="small-btn like-icon mx-1"></button>
                                                        <button id="share-icon" class="small-btn share-icon mx-1"></button>
                                                        <button id="add-icon" class="small-btn circle-icon mx-1"></button>
                                                    </div>
                                                </div>
                                                <h1>Laal Banarsi</h1>
                                                <!-- <p>Lorem ipsum dolor sit amet, ipsumcon dipiscing elitdconsectetur adipiscing elit dipiscing elitdconsectetur adipiscing elit</p> -->
                                                <ul>
                                                    <li>U/A 13+</li>
                                                    <li>Mystery</li>
                                                    <li>Mind Game</li>
                                                    <li>5 Seasons</li>
                                                </ul>
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="left-time">42 of 1h 20m left</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="main-card">
                                            <div class="main-img">
                                                <img src="public/img/dhamal.jpeg" alt="">
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <div class="play-card">
                                            <a href="#/" class="top-card-img">
                                                <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                                <span class="top-ten position-absolute">
                                                    <ul class="list-unstyled text-white">
                                                        <li>Top</li>
                                                        <li>10</li>
                                                    </ul>
                                                </span>
                                                <img src="public/img/dhamal.jpeg" alt="">
                                            </a>
                                            <div class="bottom-card-content">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button class="play-btn me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z" fill="#272727"/>
                                                                </svg>
                                                             <span class="ms-1">Resume</span>
                                                        </button>
                                                        <button id="add-icon" class="small-btn add-icon mx-1"></button>
                                                        <button id="like-icon" class="small-btn like-icon mx-1"></button>
                                                        <button id="share-icon" class="small-btn share-icon mx-1"></button>
                                                        <button id="add-icon" class="small-btn circle-icon mx-1"></button>
                                                    </div>
                                                </div>
                                                <h1>Laal Banarsi</h1>
                                                <!-- <p>Lorem ipsum dolor sit amet, ipsumcon dipiscing elitdconsectetur adipiscing elit dipiscing elitdconsectetur adipiscing elit</p> -->
                                                <ul>
                                                    <li>U/A 13+</li>
                                                    <li>Mystery</li>
                                                    <li>Mind Game</li>
                                                    <li>5 Seasons</li>
                                                </ul>
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="left-time">42 of 1h 20m left</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="main-card">
                                            <div class="main-img">
                                                <img src="public/img/dhamal.jpeg" alt="">
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <div class="play-card">
                                            <a href="#/" class="top-card-img">
                                                <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                                <span class="top-ten position-absolute">
                                                    <ul class="list-unstyled text-white">
                                                        <li>Top</li>
                                                        <li>10</li>
                                                    </ul>
                                                </span>
                                                <img src="public/img/dhamal.jpeg" alt="">
                                            </a>
                                            <div class="bottom-card-content">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button class="play-btn me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z" fill="#272727"/>
                                                                </svg>
                                                             <span class="ms-1">Resume</span>
                                                        </button>
                                                        <button id="add-icon" class="small-btn add-icon mx-1"></button>
                                                        <button id="like-icon" class="small-btn like-icon mx-1"></button>
                                                        <button id="share-icon" class="small-btn share-icon mx-1"></button>
                                                        <button id="add-icon" class="small-btn circle-icon mx-1"></button>
                                                    </div>
                                                </div>
                                                <h1>Laal Banarsi</h1>
                                                <!-- <p>Lorem ipsum dolor sit amet, ipsumcon dipiscing elitdconsectetur adipiscing elit dipiscing elitdconsectetur adipiscing elit</p> -->
                                                <ul>
                                                    <li>U/A 13+</li>
                                                    <li>Mystery</li>
                                                    <li>Mind Game</li>
                                                    <li>5 Seasons</li>
                                                </ul>
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="left-time">42 of 1h 20m left</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="main-card">
                                            <div class="main-img">
                                                <img src="public/img/dhamal.jpeg" alt="">
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <div class="play-card">
                                            <a href="#/" class="top-card-img">
                                                <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                                <span class="top-ten position-absolute">
                                                    <ul class="list-unstyled text-white">
                                                        <li>Top</li>
                                                        <li>10</li>
                                                    </ul>
                                                </span>
                                                <img src="public/img/dhamal.jpeg" alt="">
                                            </a>
                                            <div class="bottom-card-content">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button class="play-btn me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z" fill="#272727"/>
                                                                </svg>
                                                             <span class="ms-1">Resume</span>
                                                        </button>
                                                        <button id="add-icon" class="small-btn add-icon mx-1"></button>
                                                        <button id="like-icon" class="small-btn like-icon mx-1"></button>
                                                        <button id="share-icon" class="small-btn share-icon mx-1"></button>
                                                        <button id="add-icon" class="small-btn circle-icon mx-1"></button>
                                                    </div>
                                                </div>
                                                <h1>Laal Banarsi</h1>
                                                <!-- <p>Lorem ipsum dolor sit amet, ipsumcon dipiscing elitdconsectetur adipiscing elit dipiscing elitdconsectetur adipiscing elit</p> -->
                                                <ul>
                                                    <li>U/A 13+</li>
                                                    <li>Mystery</li>
                                                    <li>Mind Game</li>
                                                    <li>5 Seasons</li>
                                                </ul>
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="left-time">42 of 1h 20m left</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="main-card">
                                            <div class="main-img">
                                                <img src="public/img/dhamal.jpeg" alt="">
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <div class="play-card">
                                            <a href="#/" class="top-card-img">
                                                <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                                <span class="top-ten position-absolute">
                                                    <ul class="list-unstyled text-white">
                                                        <li>Top</li>
                                                        <li>10</li>
                                                    </ul>
                                                </span>
                                                <img src="public/img/dhamal.jpeg" alt="">
                                            </a>
                                            <div class="bottom-card-content">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button class="play-btn me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z" fill="#272727"/>
                                                                </svg>
                                                             <span class="ms-1">Resume</span>
                                                        </button>
                                                        <button id="add-icon" class="small-btn add-icon mx-1"></button>
                                                        <button id="like-icon" class="small-btn like-icon mx-1"></button>
                                                        <button id="share-icon" class="small-btn share-icon mx-1"></button>
                                                        <button id="add-icon" class="small-btn circle-icon mx-1"></button>
                                                    </div>
                                                </div>
                                                <h1>Laal Banarsi</h1>
                                                <!-- <p>Lorem ipsum dolor sit amet, ipsumcon dipiscing elitdconsectetur adipiscing elit dipiscing elitdconsectetur adipiscing elit</p> -->
                                                <ul>
                                                    <li>U/A 13+</li>
                                                    <li>Mystery</li>
                                                    <li>Mind Game</li>
                                                    <li>5 Seasons</li>
                                                </ul>
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="left-time">42 of 1h 20m left</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="main-card">
                                            <div class="main-img">
                                                <img src="public/img/dhamal.jpeg" alt="">
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a> 
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="history">

                            <div class="carousel-main">
                                <ul class="vertical-carousel-initilize p-0">
                                    <li> 
                                        <div class="play-card">
                                            <a href="#/" class="top-card-img">
                                                <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                                <span class="top-ten position-absolute">
                                                    <ul class="list-unstyled text-white">
                                                        <li>Top</li>
                                                        <li>10</li>
                                                    </ul>
                                                </span>
                                                <img src="public/img/dhamal.jpeg" alt="">
                                            </a>
                                            <div class="bottom-card-content">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button class="play-btn me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z" fill="#272727"/>
                                                                </svg>
                                                             <span class="ms-1">Resume</span>
                                                        </button>
                                                        <button id="add-icon" class="small-btn add-icon mx-1"></button>
                                                        <button id="like-icon" class="small-btn like-icon mx-1"></button>
                                                        <button id="share-icon" class="small-btn share-icon mx-1"></button>
                                                        <button id="add-icon" class="small-btn circle-icon mx-1"></button>
                                                    </div>
                                                </div>
                                                <h1>Laal Banarsi</h1>
                                                <!-- <p>Lorem ipsum dolor sit amet, ipsumcon dipiscing elitdconsectetur adipiscing elit dipiscing elitdconsectetur adipiscing elit</p> -->
                                                <ul>
                                                    <li>U/A 13+</li>
                                                    <li>Mystery</li>
                                                    <li>Mind Game</li>
                                                    <li>5 Seasons</li>
                                                </ul>
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="left-time">42 of 1h 20m left</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="main-card">
                                            <div class="main-img">
                                                <img src="public/img/dhamal.jpeg" alt="">
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <div class="play-card">
                                            <a href="#/" class="top-card-img">
                                                <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                                <span class="top-ten position-absolute">
                                                    <ul class="list-unstyled text-white">
                                                        <li>Top</li>
                                                        <li>10</li>
                                                    </ul>
                                                </span>
                                                <img src="public/img/dhamal.jpeg" alt="">
                                            </a>
                                            <div class="bottom-card-content">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button class="play-btn me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z" fill="#272727"/>
                                                                </svg>
                                                             <span class="ms-1">Resume</span>
                                                        </button>
                                                        <button id="add-icon" class="small-btn add-icon mx-1"></button>
                                                        <button id="like-icon" class="small-btn like-icon mx-1"></button>
                                                        <button id="share-icon" class="small-btn share-icon mx-1"></button>
                                                        <button id="add-icon" class="small-btn circle-icon mx-1"></button>
                                                    </div>
                                                </div>
                                                <h1>Laal Banarsi</h1>
                                                <!-- <p>Lorem ipsum dolor sit amet, ipsumcon dipiscing elitdconsectetur adipiscing elit dipiscing elitdconsectetur adipiscing elit</p> -->
                                                <ul>
                                                    <li>U/A 13+</li>
                                                    <li>Mystery</li>
                                                    <li>Mind Game</li>
                                                    <li>5 Seasons</li>
                                                </ul>
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="left-time">42 of 1h 20m left</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="main-card">
                                            <div class="main-img">
                                                <img src="public/img/dhamal.jpeg" alt="">
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <div class="play-card">
                                            <a href="#/" class="top-card-img">
                                                <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                                <span class="top-ten position-absolute">
                                                    <ul class="list-unstyled text-white">
                                                        <li>Top</li>
                                                        <li>10</li>
                                                    </ul>
                                                </span>
                                                <img src="public/img/dhamal.jpeg" alt="">
                                            </a>
                                            <div class="bottom-card-content">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button class="play-btn me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z" fill="#272727"/>
                                                                </svg>
                                                             <span class="ms-1">Resume</span>
                                                        </button>
                                                        <button id="add-icon" class="small-btn add-icon mx-1"></button>
                                                        <button id="like-icon" class="small-btn like-icon mx-1"></button>
                                                        <button id="share-icon" class="small-btn share-icon mx-1"></button>
                                                        <button id="add-icon" class="small-btn circle-icon mx-1"></button>
                                                    </div>
                                                </div>
                                                <h1>Laal Banarsi</h1>
                                                <!-- <p>Lorem ipsum dolor sit amet, ipsumcon dipiscing elitdconsectetur adipiscing elit dipiscing elitdconsectetur adipiscing elit</p> -->
                                                <ul>
                                                    <li>U/A 13+</li>
                                                    <li>Mystery</li>
                                                    <li>Mind Game</li>
                                                    <li>5 Seasons</li>
                                                </ul>
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="left-time">42 of 1h 20m left</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="main-card">
                                            <div class="main-img">
                                                <img src="public/img/dhamal.jpeg" alt="">
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <div class="play-card">
                                            <a href="#/" class="top-card-img">
                                                <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                                <span class="top-ten position-absolute">
                                                    <ul class="list-unstyled text-white">
                                                        <li>Top</li>
                                                        <li>10</li>
                                                    </ul>
                                                </span>
                                                <img src="public/img/dhamal.jpeg" alt="">
                                            </a>
                                            <div class="bottom-card-content">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button class="play-btn me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z" fill="#272727"/>
                                                                </svg>
                                                             <span class="ms-1">Resume</span>
                                                        </button>
                                                        <button id="add-icon" class="small-btn add-icon mx-1"></button>
                                                        <button id="like-icon" class="small-btn like-icon mx-1"></button>
                                                        <button id="share-icon" class="small-btn share-icon mx-1"></button>
                                                        <button id="add-icon" class="small-btn circle-icon mx-1"></button>
                                                    </div>
                                                </div>
                                                <h1>Laal Banarsi</h1>
                                                <!-- <p>Lorem ipsum dolor sit amet, ipsumcon dipiscing elitdconsectetur adipiscing elit dipiscing elitdconsectetur adipiscing elit</p> -->
                                                <ul>
                                                    <li>U/A 13+</li>
                                                    <li>Mystery</li>
                                                    <li>Mind Game</li>
                                                    <li>5 Seasons</li>
                                                </ul>
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="left-time">42 of 1h 20m left</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="main-card">
                                            <div class="main-img">
                                                <img src="public/img/dhamal.jpeg" alt="">
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <div class="play-card">
                                            <a href="#/" class="top-card-img">
                                                <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                                <span class="top-ten position-absolute">
                                                    <ul class="list-unstyled text-white">
                                                        <li>Top</li>
                                                        <li>10</li>
                                                    </ul>
                                                </span>
                                                <img src="public/img/dhamal.jpeg" alt="">
                                            </a>
                                            <div class="bottom-card-content">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button class="play-btn me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z" fill="#272727"/>
                                                                </svg>
                                                             <span class="ms-1">Resume</span>
                                                        </button>
                                                        <button id="add-icon" class="small-btn add-icon mx-1"></button>
                                                        <button id="like-icon" class="small-btn like-icon mx-1"></button>
                                                        <button id="share-icon" class="small-btn share-icon mx-1"></button>
                                                        <button id="add-icon" class="small-btn circle-icon mx-1"></button>
                                                    </div>
                                                </div>
                                                <h1>Laal Banarsi</h1>
                                                <!-- <p>Lorem ipsum dolor sit amet, ipsumcon dipiscing elitdconsectetur adipiscing elit dipiscing elitdconsectetur adipiscing elit</p> -->
                                                <ul>
                                                    <li>U/A 13+</li>
                                                    <li>Mystery</li>
                                                    <li>Mind Game</li>
                                                    <li>5 Seasons</li>
                                                </ul>
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="left-time">42 of 1h 20m left</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="main-card">
                                            <div class="main-img">
                                                <img src="public/img/dhamal.jpeg" alt="">
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <div class="play-card">
                                            <a href="#/" class="top-card-img">
                                                <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                                <span class="top-ten position-absolute">
                                                    <ul class="list-unstyled text-white">
                                                        <li>Top</li>
                                                        <li>10</li>
                                                    </ul>
                                                </span>
                                                <img src="public/img/dhamal.jpeg" alt="">
                                            </a>
                                            <div class="bottom-card-content">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button class="play-btn me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z" fill="#272727"/>
                                                                </svg>
                                                             <span class="ms-1">Resume</span>
                                                        </button>
                                                        <button id="add-icon" class="small-btn add-icon mx-1"></button>
                                                        <button id="like-icon" class="small-btn like-icon mx-1"></button>
                                                        <button id="share-icon" class="small-btn share-icon mx-1"></button>
                                                        <button id="add-icon" class="small-btn circle-icon mx-1"></button>
                                                    </div>
                                                </div>
                                                <h1>Laal Banarsi</h1>
                                                <!-- <p>Lorem ipsum dolor sit amet, ipsumcon dipiscing elitdconsectetur adipiscing elit dipiscing elitdconsectetur adipiscing elit</p> -->
                                                <ul>
                                                    <li>U/A 13+</li>
                                                    <li>Mystery</li>
                                                    <li>Mind Game</li>
                                                    <li>5 Seasons</li>
                                                </ul>
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="left-time">42 of 1h 20m left</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="main-card">
                                            <div class="main-img">
                                                <img src="public/img/dhamal.jpeg" alt="">
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <div class="play-card">
                                            <a href="#/" class="top-card-img">
                                                <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                                <span class="top-ten position-absolute">
                                                    <ul class="list-unstyled text-white">
                                                        <li>Top</li>
                                                        <li>10</li>
                                                    </ul>
                                                </span>
                                                <img src="public/img/dhamal.jpeg" alt="">
                                            </a>
                                            <div class="bottom-card-content">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button class="play-btn me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z" fill="#272727"/>
                                                                </svg>
                                                             <span class="ms-1">Resume</span>
                                                        </button>
                                                        <button id="add-icon" class="small-btn add-icon mx-1"></button>
                                                        <button id="like-icon" class="small-btn like-icon mx-1"></button>
                                                        <button id="share-icon" class="small-btn share-icon mx-1"></button>
                                                        <button id="add-icon" class="small-btn circle-icon mx-1"></button>
                                                    </div>
                                                </div>
                                                <h1>Laal Banarsi</h1>
                                                <!-- <p>Lorem ipsum dolor sit amet, ipsumcon dipiscing elitdconsectetur adipiscing elit dipiscing elitdconsectetur adipiscing elit</p> -->
                                                <ul>
                                                    <li>U/A 13+</li>
                                                    <li>Mystery</li>
                                                    <li>Mind Game</li>
                                                    <li>5 Seasons</li>
                                                </ul>
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="left-time">42 of 1h 20m left</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="main-card">
                                            <div class="main-img">
                                                <img src="public/img/dhamal.jpeg" alt="">
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <div class="play-card">
                                            <a href="#/" class="top-card-img">
                                                <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                                <span class="top-ten position-absolute">
                                                    <ul class="list-unstyled text-white">
                                                        <li>Top</li>
                                                        <li>10</li>
                                                    </ul>
                                                </span>
                                                <img src="public/img/dhamal.jpeg" alt="">
                                            </a>
                                            <div class="bottom-card-content">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button class="play-btn me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z" fill="#272727"/>
                                                                </svg>
                                                             <span class="ms-1">Resume</span>
                                                        </button>
                                                        <button id="add-icon" class="small-btn add-icon mx-1"></button>
                                                        <button id="like-icon" class="small-btn like-icon mx-1"></button>
                                                        <button id="share-icon" class="small-btn share-icon mx-1"></button>
                                                        <button id="add-icon" class="small-btn circle-icon mx-1"></button>
                                                    </div>
                                                </div>
                                                <h1>Laal Banarsi</h1>
                                                <!-- <p>Lorem ipsum dolor sit amet, ipsumcon dipiscing elitdconsectetur adipiscing elit dipiscing elitdconsectetur adipiscing elit</p> -->
                                                <ul>
                                                    <li>U/A 13+</li>
                                                    <li>Mystery</li>
                                                    <li>Mind Game</li>
                                                    <li>5 Seasons</li>
                                                </ul>
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="left-time">42 of 1h 20m left</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="main-card">
                                            <div class="main-img">
                                                <img src="public/img/dhamal.jpeg" alt="">
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a> 
                                    </li>
                                    <li> 
                                        <div class="play-card">
                                            <a href="#/" class="top-card-img">
                                                <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span>
                                                <span class="top-ten position-absolute">
                                                    <ul class="list-unstyled text-white">
                                                        <li>Top</li>
                                                        <li>10</li>
                                                    </ul>
                                                </span>
                                                <img src="public/img/dhamal.jpeg" alt="">
                                            </a>
                                            <div class="bottom-card-content">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button class="play-btn me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M22.5 12.0006C22.5006 12.2552 22.4353 12.5057 22.3105 12.7276C22.1856 12.9496 22.0055 13.1354 21.7875 13.2671L8.28 21.5303C8.05227 21.6697 7.79144 21.7458 7.52445 21.7508C7.25746 21.7557 6.99399 21.6893 6.76125 21.5584C6.53073 21.4295 6.3387 21.2415 6.2049 21.0138C6.07111 20.7861 6.00039 20.5269 6 20.2628V3.73839C6.00039 3.47428 6.07111 3.21504 6.2049 2.98733C6.3387 2.75962 6.53073 2.57165 6.76125 2.44276C6.99399 2.31184 7.25746 2.24542 7.52445 2.25036C7.79144 2.25531 8.05227 2.33144 8.28 2.47089L21.7875 10.734C22.0055 10.8657 22.1856 11.0516 22.3105 11.2735C22.4353 11.4954 22.5006 11.7459 22.5 12.0006Z" fill="#272727"/>
                                                                </svg>
                                                             <span class="ms-1">Resume</span>
                                                        </button>
                                                        <button id="add-icon" class="small-btn add-icon mx-1"></button>
                                                        <button id="like-icon" class="small-btn like-icon mx-1"></button>
                                                        <button id="share-icon" class="small-btn share-icon mx-1"></button>
                                                        <button id="add-icon" class="small-btn circle-icon mx-1"></button>
                                                    </div>
                                                </div>
                                                <h1>Laal Banarsi</h1>
                                                <!-- <p>Lorem ipsum dolor sit amet, ipsumcon dipiscing elitdconsectetur adipiscing elit dipiscing elitdconsectetur adipiscing elit</p> -->
                                                <ul>
                                                    <li>U/A 13+</li>
                                                    <li>Mystery</li>
                                                    <li>Mind Game</li>
                                                    <li>5 Seasons</li>
                                                </ul>
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="left-time">42 of 1h 20m left</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="main-card">
                                            <div class="main-img">
                                                <img src="public/img/dhamal.jpeg" alt="">
                                                <div class="progress-main">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a> 
                                    </li>
                                </ul>

                                <div class="delete-history mt-5">
                                    <p>All your history will be auto-deleted after 30 days. You can choose to turn it off or delete now.</p>
                                    <div class="d-flex">
                                        <button class="border-btn">Turn Off</button>
                                        <button class="fill-btn">Delete Now</button>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@stop

@section('script')



@stop