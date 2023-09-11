@extends('layouts.default')
@section('title', 'movies')

@section('style')

@stop

@section('content')


    <section class="content-detail-banner position-relative">
        <div class="banner-main position-relative">
            <button class="rounded-transparent-btn pos-btn">
                <img src="{{ asset('assets/img/mute-icon.svg') }}" alt="icon">
            </button>
            <img src="{{ @$content['banner_image']['large'] }}" alt="img">
        </div>

        <div class="overlay">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="banner-content">
                            <div class="all-btn">
                                <button class="fill-btn mobile-width me-3 ms-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                        viewBox="0 0 28 28" fill="none">
                                        <path
                                            d="M26.25 14.0005C26.2507 14.2976 26.1745 14.5899 26.0289 14.8488C25.8832 15.1077 25.673 15.3246 25.4188 15.4782L9.66 25.1185C9.39431 25.2812 9.09001 25.37 8.77852 25.3758C8.46703 25.3816 8.15965 25.3041 7.88813 25.1513C7.61918 25.001 7.39515 24.7817 7.23905 24.516C7.08296 24.2503 7.00045 23.9479 7 23.6398V4.36133C7.00045 4.0532 7.08296 3.75076 7.23905 3.48509C7.39515 3.21943 7.61918 3.00014 7.88813 2.84976C8.15965 2.69702 8.46703 2.61953 8.77852 2.6253C9.09001 2.63107 9.39431 2.71989 9.66 2.88258L25.4188 12.5229C25.673 12.6765 25.8832 12.8934 26.0289 13.1523C26.1745 13.4112 26.2507 13.7035 26.25 14.0005Z"
                                            fill="#272727" />
                                    </svg>&nbsp;
                                    Watch First Episode Free
                                </button>
                                <button class="subcription-btn me-3">
                                    <img src="{{ asset('assets/img/crown.svg') }}" alt="crown"> Subscribe Now
                                </button>
                                <button class="rounded-transparent-btn me-3">
                                    <img src="{{ asset('assets/img/add-icon.svg') }}" alt="icon">
                                </button>
                                <button class="rounded-transparent-btn me-3">
                                    <img src="{{ asset('assets/img/clap-icon.svg') }}" alt="icon">
                                </button>
                                <button class="rounded-transparent-btn">
                                    <img src="{{ asset('assets/img/share-icon.svg') }}" alt="icon">
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6 col-md-12 mt-3">
                        <?php
                        
                        $subtext = [];
                        if (@$content['age_limit']) {
                            $subtext[] = $content['age_limit'];
                        }
                        
                        $genres = array_column($content['genres_assign'] ?? [], 'name');
                        
                        if ($genres) {
                            foreach ($genres as $key => $genre) {
                                $subtext[] = $genre;
                            }
                        }
                        
                        if (isset($content['publish_start_date'])) {
                            $sub_text[] = date('Y', strtotime($content['publish_start_date']));
                        }
                        
                        ?>

                        <p class="ua small mb-2 b7-color">{{ implode(' • ', $subtext) }}</p>
                        <div class="seemore">
                            <p class="text-white mb-0">{{ @$content['description'] }}</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6 col-md-12 mt-3">
                        <div class="seemore">
                            <h6 class="text-white">Season 3 coming on 18 August</h6>
                            @if ($content['castncrew'])
                                <p class="text-white mb-3">Cast:
                                    @foreach ($content['castncrew'] as $key => $value)
                                        {{ $value }}
                                    @endforeach
                                </p>
                            @endif
                        </div>
                        <div class="d-flex">
                            @if (@$content['percentage_match'])
                                <button class="border-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M19.4978 7.49891L16.5078 10.4889L13.5078 7.48891L16.4978 4.49891C16.9178 4.07891 17.4578 3.87891 17.9978 3.87891C18.5378 3.87891 19.0778 4.07891 19.4978 4.49891C20.3278 5.32891 20.3278 6.66891 19.4978 7.49891Z"
                                            fill="white" />
                                        <path
                                            d="M17.3095 9.69531L6.49945 20.4953C5.66945 21.3253 4.32945 21.3253 3.49945 20.4953C2.66945 19.6653 2.66945 18.3253 3.49945 17.4953L14.3095 6.69531L17.3095 9.69531Z"
                                            fill="#B04CF1" />
                                        <path
                                            d="M9.95051 3.50051L10.3605 2.11051C10.4005 1.98051 10.3605 1.84051 10.2705 1.74051C10.1805 1.64051 10.0205 1.60051 9.89051 1.64051L8.50051 2.05051L7.11051 1.64051C6.98051 1.60051 6.84051 1.64051 6.74051 1.73051C6.64051 1.83051 6.61051 1.97051 6.65051 2.10051L7.05051 3.50051L6.64051 4.89051C6.60051 5.0205 6.64051 5.16051 6.73051 5.26051C6.83051 5.36051 6.97051 5.39051 7.10051 5.35051L8.50051 4.95051L9.89051 5.36051C9.93051 5.37051 9.96051 5.38051 10.0005 5.38051C10.1005 5.38051 10.1905 5.34051 10.2705 5.27051C10.3705 5.17051 10.4005 5.03051 10.3605 4.90051L9.95051 3.50051Z"
                                            fill="#FFAC33" />
                                        <path
                                            d="M5.9505 9.50051L6.3605 8.1105C6.4005 7.9805 6.3605 7.84051 6.2705 7.74051C6.1705 7.64051 6.0305 7.61051 5.9005 7.65051L4.5005 8.05051L3.1105 7.64051C2.9805 7.60051 2.84051 7.64051 2.74051 7.73051C2.64051 7.83051 2.61051 7.97051 2.65051 8.10051L3.0505 9.50051L2.64051 10.8905C2.60051 11.0205 2.64051 11.1605 2.73051 11.2605C2.83051 11.3605 2.9705 11.3905 3.1005 11.3505L4.4905 10.9405L5.8805 11.3505C5.9105 11.3605 5.9505 11.3605 5.9905 11.3605C6.0905 11.3605 6.18051 11.3205 6.2605 11.2505C6.36051 11.1505 6.3905 11.0105 6.3505 10.8805L5.9505 9.50051Z"
                                            fill="#FFAC33" />
                                        <path
                                            d="M20.9497 14.5L21.3597 13.11C21.3997 12.98 21.3597 12.84 21.2697 12.74C21.1697 12.64 21.0297 12.61 20.8997 12.65L19.5097 13.06L18.1197 12.65C17.9897 12.61 17.8497 12.65 17.7497 12.74C17.6497 12.84 17.6197 12.98 17.6597 13.11L18.0697 14.5L17.6597 15.89C17.6197 16.02 17.6597 16.16 17.7497 16.26C17.8497 16.36 17.9897 16.39 18.1197 16.35L19.5097 15.94L20.8997 16.35C20.9297 16.36 20.9697 16.36 21.0097 16.36C21.1097 16.36 21.1997 16.32 21.2797 16.25C21.3797 16.15 21.4097 16.01 21.3697 15.88L20.9497 14.5Z"
                                            fill="#FFAC33" />
                                    </svg> &nbsp;
                                    {{ $content['percentage_match'] }} % match
                                </button>
                            @endif

                            <button class="border-btn mx-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path
                                        d="M9.03607 6.5959C8.70795 6.00527 8.10982 4.92902 8.66295 4.20902C9.15607 3.56777 9.99982 3.77402 10.6786 4.4734L11.0761 4.90465C11.0761 4.90465 10.7404 3.6709 11.7211 3.33527C12.3792 3.11027 12.9248 3.3484 13.8079 4.40777C15.3998 6.31652 18.7767 12.1421 18.7767 12.1421C18.9342 12.4009 19.0898 12.6353 19.2042 12.5959C19.2961 12.564 19.5454 11.6472 19.5454 11.6472C19.5267 10.3834 19.6186 8.91527 20.0592 8.10715C20.5111 7.2784 21.3267 6.9784 21.8948 7.16215C22.3917 7.3234 22.6523 7.7134 22.4948 8.57965C22.3617 9.31465 22.3223 11.184 22.4817 13.0084C22.6092 14.4728 22.6692 15.4253 22.5623 16.6009C22.3579 18.834 21.4748 21.039 18.9323 22.3778C17.5279 23.1184 16.0223 23.2665 14.6217 23.0415C14.6198 23.0434 9.16357 6.82465 9.03607 6.5959Z"
                                        fill="#D69513" />
                                    <path
                                        d="M14.7221 10.1939C14.2027 9.04644 13.6102 8.16331 12.9577 7.16394C12.4927 6.45144 11.6771 5.25519 11.4239 4.65519C11.2496 4.24269 11.2533 3.91269 11.2758 3.73644C11.2814 3.69894 11.2327 3.68019 11.2102 3.71019C11.0039 4.00831 10.8952 4.49206 11.1071 5.01144C11.4314 5.79894 12.1289 6.80394 12.6014 7.52581C13.2914 8.58144 13.7733 9.35019 14.2139 10.4114L14.9339 10.9552C14.9358 10.9571 14.9152 10.6233 14.7221 10.1939Z"
                                        fill="#FFB300" />
                                    <path
                                        d="M10.0147 22.1935C9.51224 21.871 8.19411 20.8847 6.77849 19.3435C4.67849 17.056 3.66036 14.6935 3.23286 13.8066C2.82224 12.9535 2.72099 11.941 3.21224 11.5941C3.76536 11.2041 4.27911 11.596 4.27911 11.596C3.80286 10.8516 3.49349 10.1185 3.41286 9.52412C3.30224 8.69537 3.80661 8.311 3.89849 8.26037C4.33349 8.02037 4.72724 8.32787 4.72724 8.32787C4.72724 8.32787 4.20786 7.5985 4.07474 6.8185C3.99224 6.3385 4.17224 5.8435 4.57911 5.56225C5.09474 5.20787 5.58224 5.311 6.34349 5.98225L6.65286 6.2185C6.65286 6.2185 6.51036 5.81912 6.50849 5.39725C6.50661 5.01287 6.69036 4.58162 7.14036 4.40725C7.71974 4.18225 8.16224 4.33037 8.95724 5.15162C9.66974 5.8885 12.0379 8.33162 13.6691 9.65162C14.8185 10.5835 16.0935 11.5116 16.7535 11.9054C16.9635 12.031 17.1416 11.8641 17.0835 11.5679C16.7216 9.73975 16.581 8.32975 16.926 7.26287C17.271 6.19412 17.9291 5.611 18.6697 5.66912C19.0185 5.69725 19.3654 5.90537 19.5154 6.31037C19.6485 6.67412 19.6522 7.27975 19.6691 7.66412C19.7291 9.151 20.9554 13.4185 21.2066 14.5922C21.6866 16.8197 21.4991 19.2272 19.4385 21.2972C16.6766 24.0797 12.2854 23.6485 10.0147 22.1935Z"
                                        fill="#FFCA28" />
                                    <path
                                        d="M8.32527 17.1173C8.2484 17.378 8.1059 17.6705 7.90715 17.5036C7.63527 17.2748 7.67277 17.0405 7.36902 16.7273C6.49527 15.8255 4.8734 13.4986 4.50027 12.5686C4.2434 11.9273 4.27902 11.5936 4.27902 11.5936C4.27902 11.5936 6.39215 14.8373 8.3009 16.613C8.46965 16.7705 8.33465 17.0873 8.32527 17.1173ZM9.45777 14.9592C9.17465 14.8505 9.11652 14.4136 8.90652 14.2111C7.87715 13.2248 5.66652 10.5061 5.0084 9.24609C4.74027 8.73047 4.73652 8.49047 4.71777 8.31422C4.71777 8.31422 7.81527 12.1917 9.46715 13.6973C9.57215 13.793 9.90215 13.8998 9.9734 14.0573C10.1103 14.3611 9.68652 15.0455 9.45777 14.9592ZM11.6628 11.6048C9.90402 10.1348 6.61715 6.19922 6.61715 6.19922C6.61715 6.19922 6.68465 6.75234 7.07652 7.35797C7.75715 8.41359 9.73152 10.8623 11.0496 12.1073C11.3028 12.3473 11.2878 12.6417 11.5559 12.6642C11.8428 12.6886 12.1915 12.3492 12.2103 12.0905C12.2271 11.8692 11.9553 11.8486 11.6628 11.6048Z"
                                        fill="#D69513" />
                                    <path
                                        d="M0.9375 17.6009L3.33375 17.4303M5.70563 20.3197L4.92 22.5903M1.18125 21.2328L4.305 19.0409M22.6819 3.47656L20.8312 5.00844M17.2219 4.03719L16.5413 1.73281M20.37 0.664062L19.1044 4.26219"
                                        stroke="#B0BEC5" stroke-width="0.625" stroke-miterlimit="10" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M20.3305 10.7228C20.1092 9.82094 19.888 8.83469 19.8167 8.16719C19.7605 7.64031 19.7248 6.78531 19.6742 6.59781C19.4961 5.92281 19.1042 5.80469 19.1042 5.80469C19.1042 5.80469 19.3517 6.06531 19.3573 6.78719C19.363 7.55219 19.3855 9.05031 19.8242 10.7078C20.113 11.7991 20.5817 13.3703 20.7955 14.6266C21.2473 17.2722 20.8348 19.1341 19.2542 21.0953C18.3373 22.2316 16.3555 23.0697 16.3555 23.0697C16.3555 23.0697 17.9848 22.9666 19.408 21.5978C21.298 19.7791 21.9823 17.4203 21.3748 14.5928C21.1686 13.6347 20.4017 11.0153 20.3305 10.7228Z"
                                        fill="#D69513" />
                                </svg> &nbsp;
                                {{ @$content['claps'] }}
                            </button>
                            @if (@$content['is_popular'])
                                <button class="border-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M19.4997 14.5042C19.4997 19.0792 15.7122 22.758 11.1372 22.485C6.43548 22.2045 3.21723 17.6827 3.82323 12.9562C4.18998 10.0815 5.53773 7.61622 7.00473 5.70372C7.25973 5.36997 7.52148 8.05572 7.78323 7.76022C8.04573 7.45647 10.4787 3.24597 11.3247 1.76697C11.3611 1.70174 11.4111 1.6451 11.4713 1.6009C11.5315 1.5567 11.6006 1.52598 11.6737 1.51083C11.7468 1.49567 11.8224 1.49644 11.8952 1.51307C11.968 1.5297 12.0364 1.56181 12.0957 1.60722C13.7952 2.88972 19.4997 7.70697 19.4997 14.5042Z"
                                            fill="#FF6723" />
                                        <path
                                            d="M17.2503 16.3883C17.2503 19.4198 14.611 21.8565 11.401 21.7463C7.93602 21.6293 5.56001 18.4583 6.06851 15.192C6.80276 10.509 11.6103 7.5 11.6103 7.5C11.6103 7.5 17.2503 11.0302 17.2503 16.3883Z"
                                            fill="#FFB02E" />
                                    </svg> &nbsp;
                                    Most Popular
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container w-100 mt-2 mb-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="w-100 library">
                    <ul class="nav nav-pills border-bot pb-3 ps-2" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link ep active" id="episode" data-bs-toggle="pill"
                                data-bs-target="#pills-episode" type="button" role="tab"
                                aria-controls="pills-episode" aria-selected="true">Episodes</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="morelike" data-bs-toggle="pill"
                                data-bs-target="#pills-morelike" type="button" role="tab"
                                aria-controls="pills-morelike" aria-selected="false">More like this</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="trailors" data-bs-toggle="pill"
                                data-bs-target="#pills-trailors" type="button" role="tab"
                                aria-controls="pills-trailors" aria-selected="false">Trailers & More</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="history" data-bs-toggle="pill" data-bs-target="#pills-about"
                                type="button" role="tab" aria-controls="pills-about"
                                aria-selected="false">About</button>
                        </li>
                        <!-- filter -->
                        <div class="episode-season">
                            <div class="all-episode">
                                <select>
                                    <option value="0">All Episodes</option>
                                    <option value="1">1 to 50</option>
                                    <option value="2">51 - 100</option>
                                    <option value="3">101 - 150</option>
                                    <option value="4">151 - 200</option>
                                </select>
                            </div>
                            <div class="season">
                                <select>
                                    <option value="0">Season 1</option>
                                    <option value="1">Season 2</option>
                                    <option value="2">Season 3</option>
                                    <option value="3">Season 4</option>
                                    <option value="4">Season 5</option>
                                </select>
                            </div>
                        </div>
                        <!-- filter end-->
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-episode" role="tabpanel"
                            aria-labelledby="my-list">
                            <ul class="list-unstyled col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 p-0 mt-4">
                                <li class="episode-main mb-4">
                                    <div class="pik">
                                        <img src="public/img/episode.png" alt="img">
                                        <img class="crown" src="public/img/crown.svg" alt="icon">
                                    </div>
                                    <div class="episode-text-details">
                                        <h6>E1 - It’s Man who exist in the dark</h6>
                                        <span>12 May 2023 | 42m</span>
                                        <p class="mt-2">The first episode of Laal Banarasi is about the struggle of a
                                            Banaras based poor weaver girl Gauri with poverty and education and about
                                            the ambition perfection of a Shakuntala Saree owner Garv.</p>
                                    </div>
                                </li>
                                <li class="episode-main mb-4">
                                    <div class="pik">
                                        <img src="public/img/episode.png" alt="img">
                                        <img class="crown" src="public/img/crown.svg" alt="icon">
                                    </div>
                                    <div class="episode-text-details">
                                        <h6>E1 - It’s Man who exist in the dark</h6>
                                        <span>12 May 2023 | 42m</span>
                                        <p class="mt-2">The first episode of Laal Banarasi is about the struggle of a
                                            Banaras based poor weaver girl Gauri with poverty and education and about
                                            the ambition perfection of a Shakuntala Saree owner Garv.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="pills-morelike" role="tabpanel" aria-labelledby="my-list">
                            <ul class="more-like-this px-0 py-4">
                                <li>
                                    <a href="javascript:void(0);" class="main-card">
                                        <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                alt=""></span>
                                        <span class="top-ten position-absolute">
                                            <ul class="list-unstyled text-white">
                                                <li>Top</li>
                                                <li>10</li>
                                            </ul>
                                        </span>
                                        <div class="main-img">
                                            <img src="public/img/dhamal.jpeg" alt="">
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="main-card">
                                        <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                alt=""></span>
                                        <span class="top-ten position-absolute">
                                            <ul class="list-unstyled text-white">
                                                <li>Top</li>
                                                <li>10</li>
                                            </ul>
                                        </span>
                                        <div class="main-img">
                                            <img src="public/img/dhamal.jpeg" alt="">
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="main-card">
                                        <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                alt=""></span>
                                        <span class="top-ten position-absolute">
                                            <ul class="list-unstyled text-white">
                                                <li>Top</li>
                                                <li>10</li>
                                            </ul>
                                        </span>
                                        <div class="main-img">
                                            <img src="public/img/dhamal.jpeg" alt="">
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="main-card">
                                        <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                alt=""></span>
                                        <span class="top-ten position-absolute">
                                            <ul class="list-unstyled text-white">
                                                <li>Top</li>
                                                <li>10</li>
                                            </ul>
                                        </span>
                                        <div class="main-img">
                                            <img src="public/img/dhamal.jpeg" alt="">
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="main-card">
                                        <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                alt=""></span>
                                        <span class="top-ten position-absolute">
                                            <ul class="list-unstyled text-white">
                                                <li>Top</li>
                                                <li>10</li>
                                            </ul>
                                        </span>
                                        <div class="main-img">
                                            <img src="public/img/dhamal.jpeg" alt="">
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="main-card">
                                        <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                alt=""></span>
                                        <span class="top-ten position-absolute">
                                            <ul class="list-unstyled text-white">
                                                <li>Top</li>
                                                <li>10</li>
                                            </ul>
                                        </span>
                                        <div class="main-img">
                                            <img src="public/img/dhamal.jpeg" alt="">
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="main-card">
                                        <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                alt=""></span>
                                        <span class="top-ten position-absolute">
                                            <ul class="list-unstyled text-white">
                                                <li>Top</li>
                                                <li>10</li>
                                            </ul>
                                        </span>
                                        <div class="main-img">
                                            <img src="public/img/dhamal.jpeg" alt="">
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="main-card">
                                        <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                alt=""></span>
                                        <span class="top-ten position-absolute">
                                            <ul class="list-unstyled text-white">
                                                <li>Top</li>
                                                <li>10</li>
                                            </ul>
                                        </span>
                                        <div class="main-img">
                                            <img src="public/img/dhamal.jpeg" alt="">
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="main-card">
                                        <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                alt=""></span>
                                        <span class="top-ten position-absolute">
                                            <ul class="list-unstyled text-white">
                                                <li>Top</li>
                                                <li>10</li>
                                            </ul>
                                        </span>
                                        <div class="main-img">
                                            <img src="public/img/dhamal.jpeg" alt="">
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="pills-trailors" role="tabpanel" aria-labelledby="my-list">
                            <div class="carousel-main mb-4">
                                <div class="carousel-title-n-arrow px-2 mb-2">
                                    <h1 class="text-white small">Trending Moments</h1>
                                </div>
                                <ul class="carousel-initilize px-0">
                                    <li>
                                        <a href="javascript:void(0);" class="main-card">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                    alt=""></span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                            <div class="upcoming-title-play-btn">
                                                <div class="title">Asur 2</div>
                                                <button class="play-btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M18.75 10.0004C18.7505 10.2126 18.6961 10.4213 18.5921 10.6063C18.488 10.7912 18.3379 10.9461 18.1563 11.0559L6.9 17.9418C6.71022 18.058 6.49287 18.1214 6.27037 18.1256C6.04788 18.1297 5.82832 18.0743 5.63438 17.9652C5.44227 17.8578 5.28225 17.7012 5.17075 17.5114C5.05926 17.3217 5.00032 17.1056 5 16.8855V3.11523C5.00032 2.89514 5.05926 2.67911 5.17075 2.48935C5.28225 2.29959 5.44227 2.14295 5.63438 2.03555C5.82832 1.92644 6.04788 1.87109 6.27037 1.87521C6.49287 1.87933 6.71022 1.94278 6.9 2.05898L18.1563 8.94492C18.3379 9.05467 18.488 9.20955 18.5921 9.3945C18.6961 9.57945 18.7505 9.78818 18.75 10.0004Z"
                                                            fill="#272727" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="main-card">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                    alt=""></span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                            <div class="upcoming-title-play-btn">
                                                <div class="title">Asur 2</div>
                                                <button class="play-btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M18.75 10.0004C18.7505 10.2126 18.6961 10.4213 18.5921 10.6063C18.488 10.7912 18.3379 10.9461 18.1563 11.0559L6.9 17.9418C6.71022 18.058 6.49287 18.1214 6.27037 18.1256C6.04788 18.1297 5.82832 18.0743 5.63438 17.9652C5.44227 17.8578 5.28225 17.7012 5.17075 17.5114C5.05926 17.3217 5.00032 17.1056 5 16.8855V3.11523C5.00032 2.89514 5.05926 2.67911 5.17075 2.48935C5.28225 2.29959 5.44227 2.14295 5.63438 2.03555C5.82832 1.92644 6.04788 1.87109 6.27037 1.87521C6.49287 1.87933 6.71022 1.94278 6.9 2.05898L18.1563 8.94492C18.3379 9.05467 18.488 9.20955 18.5921 9.3945C18.6961 9.57945 18.7505 9.78818 18.75 10.0004Z"
                                                            fill="#272727" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="main-card">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                    alt=""></span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                            <div class="upcoming-title-play-btn">
                                                <div class="title">Asur 2</div>
                                                <button class="play-btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M18.75 10.0004C18.7505 10.2126 18.6961 10.4213 18.5921 10.6063C18.488 10.7912 18.3379 10.9461 18.1563 11.0559L6.9 17.9418C6.71022 18.058 6.49287 18.1214 6.27037 18.1256C6.04788 18.1297 5.82832 18.0743 5.63438 17.9652C5.44227 17.8578 5.28225 17.7012 5.17075 17.5114C5.05926 17.3217 5.00032 17.1056 5 16.8855V3.11523C5.00032 2.89514 5.05926 2.67911 5.17075 2.48935C5.28225 2.29959 5.44227 2.14295 5.63438 2.03555C5.82832 1.92644 6.04788 1.87109 6.27037 1.87521C6.49287 1.87933 6.71022 1.94278 6.9 2.05898L18.1563 8.94492C18.3379 9.05467 18.488 9.20955 18.5921 9.3945C18.6961 9.57945 18.7505 9.78818 18.75 10.0004Z"
                                                            fill="#272727" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="main-card">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                    alt=""></span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                            <div class="upcoming-title-play-btn">
                                                <div class="title">Asur 2</div>
                                                <button class="play-btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M18.75 10.0004C18.7505 10.2126 18.6961 10.4213 18.5921 10.6063C18.488 10.7912 18.3379 10.9461 18.1563 11.0559L6.9 17.9418C6.71022 18.058 6.49287 18.1214 6.27037 18.1256C6.04788 18.1297 5.82832 18.0743 5.63438 17.9652C5.44227 17.8578 5.28225 17.7012 5.17075 17.5114C5.05926 17.3217 5.00032 17.1056 5 16.8855V3.11523C5.00032 2.89514 5.05926 2.67911 5.17075 2.48935C5.28225 2.29959 5.44227 2.14295 5.63438 2.03555C5.82832 1.92644 6.04788 1.87109 6.27037 1.87521C6.49287 1.87933 6.71022 1.94278 6.9 2.05898L18.1563 8.94492C18.3379 9.05467 18.488 9.20955 18.5921 9.3945C18.6961 9.57945 18.7505 9.78818 18.75 10.0004Z"
                                                            fill="#272727" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="main-card">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                    alt=""></span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                            <div class="upcoming-title-play-btn">
                                                <div class="title">Asur 2</div>
                                                <button class="play-btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M18.75 10.0004C18.7505 10.2126 18.6961 10.4213 18.5921 10.6063C18.488 10.7912 18.3379 10.9461 18.1563 11.0559L6.9 17.9418C6.71022 18.058 6.49287 18.1214 6.27037 18.1256C6.04788 18.1297 5.82832 18.0743 5.63438 17.9652C5.44227 17.8578 5.28225 17.7012 5.17075 17.5114C5.05926 17.3217 5.00032 17.1056 5 16.8855V3.11523C5.00032 2.89514 5.05926 2.67911 5.17075 2.48935C5.28225 2.29959 5.44227 2.14295 5.63438 2.03555C5.82832 1.92644 6.04788 1.87109 6.27037 1.87521C6.49287 1.87933 6.71022 1.94278 6.9 2.05898L18.1563 8.94492C18.3379 9.05467 18.488 9.20955 18.5921 9.3945C18.6961 9.57945 18.7505 9.78818 18.75 10.0004Z"
                                                            fill="#272727" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="main-card">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                    alt=""></span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                            <div class="upcoming-title-play-btn">
                                                <div class="title">Asur 2</div>
                                                <button class="play-btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M18.75 10.0004C18.7505 10.2126 18.6961 10.4213 18.5921 10.6063C18.488 10.7912 18.3379 10.9461 18.1563 11.0559L6.9 17.9418C6.71022 18.058 6.49287 18.1214 6.27037 18.1256C6.04788 18.1297 5.82832 18.0743 5.63438 17.9652C5.44227 17.8578 5.28225 17.7012 5.17075 17.5114C5.05926 17.3217 5.00032 17.1056 5 16.8855V3.11523C5.00032 2.89514 5.05926 2.67911 5.17075 2.48935C5.28225 2.29959 5.44227 2.14295 5.63438 2.03555C5.82832 1.92644 6.04788 1.87109 6.27037 1.87521C6.49287 1.87933 6.71022 1.94278 6.9 2.05898L18.1563 8.94492C18.3379 9.05467 18.488 9.20955 18.5921 9.3945C18.6961 9.57945 18.7505 9.78818 18.75 10.0004Z"
                                                            fill="#272727" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="carousel-main">
                                <div class="carousel-title-n-arrow px-2 mb-2">
                                    <h1 class="text-white small">Unforgettable Trailer Highlights</h1>
                                </div>
                                <ul class="carousel-initilize px-0">
                                    <li>
                                        <a href="javascript:void(0);" class="main-card">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                    alt=""></span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                            <div class="upcoming-title-play-btn">
                                                <div class="title">Asur 2</div>
                                                <button class="play-btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M18.75 10.0004C18.7505 10.2126 18.6961 10.4213 18.5921 10.6063C18.488 10.7912 18.3379 10.9461 18.1563 11.0559L6.9 17.9418C6.71022 18.058 6.49287 18.1214 6.27037 18.1256C6.04788 18.1297 5.82832 18.0743 5.63438 17.9652C5.44227 17.8578 5.28225 17.7012 5.17075 17.5114C5.05926 17.3217 5.00032 17.1056 5 16.8855V3.11523C5.00032 2.89514 5.05926 2.67911 5.17075 2.48935C5.28225 2.29959 5.44227 2.14295 5.63438 2.03555C5.82832 1.92644 6.04788 1.87109 6.27037 1.87521C6.49287 1.87933 6.71022 1.94278 6.9 2.05898L18.1563 8.94492C18.3379 9.05467 18.488 9.20955 18.5921 9.3945C18.6961 9.57945 18.7505 9.78818 18.75 10.0004Z"
                                                            fill="#272727" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="main-card">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                    alt=""></span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                            <div class="upcoming-title-play-btn">
                                                <div class="title">Asur 2</div>
                                                <button class="play-btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M18.75 10.0004C18.7505 10.2126 18.6961 10.4213 18.5921 10.6063C18.488 10.7912 18.3379 10.9461 18.1563 11.0559L6.9 17.9418C6.71022 18.058 6.49287 18.1214 6.27037 18.1256C6.04788 18.1297 5.82832 18.0743 5.63438 17.9652C5.44227 17.8578 5.28225 17.7012 5.17075 17.5114C5.05926 17.3217 5.00032 17.1056 5 16.8855V3.11523C5.00032 2.89514 5.05926 2.67911 5.17075 2.48935C5.28225 2.29959 5.44227 2.14295 5.63438 2.03555C5.82832 1.92644 6.04788 1.87109 6.27037 1.87521C6.49287 1.87933 6.71022 1.94278 6.9 2.05898L18.1563 8.94492C18.3379 9.05467 18.488 9.20955 18.5921 9.3945C18.6961 9.57945 18.7505 9.78818 18.75 10.0004Z"
                                                            fill="#272727" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="main-card">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                    alt=""></span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                            <div class="upcoming-title-play-btn">
                                                <div class="title">Asur 2</div>
                                                <button class="play-btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M18.75 10.0004C18.7505 10.2126 18.6961 10.4213 18.5921 10.6063C18.488 10.7912 18.3379 10.9461 18.1563 11.0559L6.9 17.9418C6.71022 18.058 6.49287 18.1214 6.27037 18.1256C6.04788 18.1297 5.82832 18.0743 5.63438 17.9652C5.44227 17.8578 5.28225 17.7012 5.17075 17.5114C5.05926 17.3217 5.00032 17.1056 5 16.8855V3.11523C5.00032 2.89514 5.05926 2.67911 5.17075 2.48935C5.28225 2.29959 5.44227 2.14295 5.63438 2.03555C5.82832 1.92644 6.04788 1.87109 6.27037 1.87521C6.49287 1.87933 6.71022 1.94278 6.9 2.05898L18.1563 8.94492C18.3379 9.05467 18.488 9.20955 18.5921 9.3945C18.6961 9.57945 18.7505 9.78818 18.75 10.0004Z"
                                                            fill="#272727" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="main-card">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                    alt=""></span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                            <div class="upcoming-title-play-btn">
                                                <div class="title">Asur 2</div>
                                                <button class="play-btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M18.75 10.0004C18.7505 10.2126 18.6961 10.4213 18.5921 10.6063C18.488 10.7912 18.3379 10.9461 18.1563 11.0559L6.9 17.9418C6.71022 18.058 6.49287 18.1214 6.27037 18.1256C6.04788 18.1297 5.82832 18.0743 5.63438 17.9652C5.44227 17.8578 5.28225 17.7012 5.17075 17.5114C5.05926 17.3217 5.00032 17.1056 5 16.8855V3.11523C5.00032 2.89514 5.05926 2.67911 5.17075 2.48935C5.28225 2.29959 5.44227 2.14295 5.63438 2.03555C5.82832 1.92644 6.04788 1.87109 6.27037 1.87521C6.49287 1.87933 6.71022 1.94278 6.9 2.05898L18.1563 8.94492C18.3379 9.05467 18.488 9.20955 18.5921 9.3945C18.6961 9.57945 18.7505 9.78818 18.75 10.0004Z"
                                                            fill="#272727" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="main-card">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                    alt=""></span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                            <div class="upcoming-title-play-btn">
                                                <div class="title">Asur 2</div>
                                                <button class="play-btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M18.75 10.0004C18.7505 10.2126 18.6961 10.4213 18.5921 10.6063C18.488 10.7912 18.3379 10.9461 18.1563 11.0559L6.9 17.9418C6.71022 18.058 6.49287 18.1214 6.27037 18.1256C6.04788 18.1297 5.82832 18.0743 5.63438 17.9652C5.44227 17.8578 5.28225 17.7012 5.17075 17.5114C5.05926 17.3217 5.00032 17.1056 5 16.8855V3.11523C5.00032 2.89514 5.05926 2.67911 5.17075 2.48935C5.28225 2.29959 5.44227 2.14295 5.63438 2.03555C5.82832 1.92644 6.04788 1.87109 6.27037 1.87521C6.49287 1.87933 6.71022 1.94278 6.9 2.05898L18.1563 8.94492C18.3379 9.05467 18.488 9.20955 18.5921 9.3945C18.6961 9.57945 18.7505 9.78818 18.75 10.0004Z"
                                                            fill="#272727" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="main-card">
                                            <span class="crown position-absolute"><img src="public/img/crown.svg"
                                                    alt=""></span>
                                            <div class="main-img">
                                                <img src="public/img/lara.jpeg" alt="">
                                            </div>
                                            <div class="upcoming-title-play-btn">
                                                <div class="title">Asur 2</div>
                                                <button class="play-btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M18.75 10.0004C18.7505 10.2126 18.6961 10.4213 18.5921 10.6063C18.488 10.7912 18.3379 10.9461 18.1563 11.0559L6.9 17.9418C6.71022 18.058 6.49287 18.1214 6.27037 18.1256C6.04788 18.1297 5.82832 18.0743 5.63438 17.9652C5.44227 17.8578 5.28225 17.7012 5.17075 17.5114C5.05926 17.3217 5.00032 17.1056 5 16.8855V3.11523C5.00032 2.89514 5.05926 2.67911 5.17075 2.48935C5.28225 2.29959 5.44227 2.14295 5.63438 2.03555C5.82832 1.92644 6.04788 1.87109 6.27037 1.87521C6.49287 1.87933 6.71022 1.94278 6.9 2.05898L18.1563 8.94492C18.3379 9.05467 18.488 9.20955 18.5921 9.3945C18.6961 9.57945 18.7505 9.78818 18.75 10.0004Z"
                                                            fill="#272727" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-about" role="tabpanel" aria-labelledby="my-list">
                            <div class="row pt-4">
                                <div class="col-sm-6">
                                    <div class="content-detail-about">
                                        <h6>Language</h6>
                                        <p>English, Hindi, Korean</p>
                                    </div>
                                    <div class="content-detail-about">
                                        <h6>Production</h6>
                                        <p>Dharma, Fireworks, Dreamworks </p>
                                    </div>
                                    <div class="content-detail-about">
                                        <h6>Release Date</h6>
                                        <p>12 May 2023</p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="content-detail-about">
                                        <h6>Genre</h6>
                                        <p>Romance, Fantasy, Comedy</p>
                                    </div>
                                    <div class="content-detail-about">
                                        <h6>Seasons</h6>
                                        <p>4 Seasons</p>
                                    </div>
                                    <div class="content-detail-about">
                                        <h6>Region of Origin</h6>
                                        <p>India</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-4">
                                    <div class="cast">
                                        <h6 class="text-white mb-4">Cast</h6>
                                        <ul class="list-unstyled p-0">
                                            <li class="pik">
                                                <div class="celebrity-pik mb-3"><img src="public/img/cast-pik.png"
                                                        alt="pik"></div>
                                                <span>Sharukh Khan</span>
                                            </li>
                                            <li class="pik">
                                                <div class="celebrity-pik mb-3"><img src="public/img/cast-pik.png"
                                                        alt="pik"></div>
                                                <span>Sharukh Khan</span>
                                            </li>
                                            <li class="pik">
                                                <div class="celebrity-pik mb-3"><img src="public/img/cast-pik.png"
                                                        alt="pik"></div>
                                                <span>Sharukh Khan</span>
                                            </li>
                                            <li class="pik">
                                                <div class="celebrity-pik mb-3"><img src="public/img/cast-pik.png"
                                                        alt="pik"></div>
                                                <span>Sharukh Khan</span>
                                            </li>
                                            <li class="pik">
                                                <div class="celebrity-pik mb-3"><img src="public/img/cast-pik.png"
                                                        alt="pik"></div>
                                                <span>Sharukh Khan</span>
                                            </li>
                                            <li class="pik">
                                                <div class="celebrity-pik mb-3"><img src="public/img/cast-pik.png"
                                                        alt="pik"></div>
                                                <span>Sharukh Khan</span>
                                            </li>
                                            <li class="pik">
                                                <div class="celebrity-pik mb-3"><img src="public/img/cast-pik.png"
                                                        alt="pik"></div>
                                                <span>Sharukh Khan</span>
                                            </li>
                                            <li class="pik">
                                                <div class="celebrity-pik mb-3"><img src="public/img/cast-pik.png"
                                                        alt="pik"></div>
                                                <span>Sharukh Khan</span>
                                            </li>
                                            <li class="pik">
                                                <div class="celebrity-pik mb-3"><img src="public/img/cast-pik.png"
                                                        alt="pik"></div>
                                                <span>Sharukh Khan</span>
                                            </li>
                                        </ul>
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
    <script src="{{ asset('assets/js/homepage.js') }}"></script>
    <script>
        $(document).ready(function() {



        });
    </script>


    <script>
        var processing;

        $(document).ready(function() {
            if (typeof activateSpinner === 'function') {
                activateSpinner();
            }
            initSliders();

            $(document).scroll(function(e) {

                if (processing) {
                    return false;
                }
                if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.4) {
                    processing = true;

                    // loadMoreData();



                }
            });


            const loadMoreData = function() {
                console.log('asdasda');
                var paging = $("#pageval").val();
                var paging = parseInt(paging) + 1;
                var routepage = $("#routepage").val();
                $('.loadmorecontent').css('overflow', 'hidden');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    url: '{{ route('page.loadmore') }}',
                    data: {
                        page: paging,
                        route: routepage
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.payload.html != '') {
                            $('.loadmorecontent').css('overflow', 'auto');
                            $('.loadmorecontent').append(response.payload.html);

                            initSliders();

                            // $("img.lazyload").lazyload();
                            processing = false;
                            $("#pageval").val(paging);
                        } else {
                            $('.loadmorecontent').css('overflow', 'auto');
                            return false;
                        }
                    }
                });
            }

        });
    </script>
@stop
