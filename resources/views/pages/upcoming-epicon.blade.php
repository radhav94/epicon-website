@extends('layouts.default')
@section('title','New homepage')

@section('style')

@stop

@section('content')
<?php //dd($upcoming);
$uniqueReleaseDates = [];

foreach ($upcoming as $item) {
    $releaseDate = $item['release_date'];
    
    // Check if the release date is not already in the uniqueReleaseDates array
    if (!in_array($releaseDate, $uniqueReleaseDates)) {
        $uniqueReleaseDates[] = $releaseDate;
    }
}

// Now $uniqueReleaseDates contains unique release dates
// dd($uniqueReleaseDates);
// Remove null and "1970" year entries
$filteredDates = array_filter($uniqueReleaseDates, function ($date) {
    return $date !== null && !strstr($date, '1970');
});

// Sort the array by date
usort($filteredDates, function ($a, $b) {
    return strtotime($a) <=> strtotime($b);
});

// Print the sorted array
// dd($filteredDates);


?>
    <section class="container">
        <div class="upcoming-epicon-main">
            
            <div class="upcoming-heading border-bot">
                <h4 class="new-popularheading text-white my-4">Upcoming on Epic On</h4>
            </div>
            
            <?php foreach($filteredDates as $key => $val){ ?>
            <div class="card-details">
                <div class="date-upperline">.</div>
                <div class="internal-card d-flex">
                   
                    <div class="date-card text-white">
                        <h6>{{date("M", strtotime($val))}}</h6>
                        <h5>{{date("y", strtotime($val))}}</h5>
                    </div>
                    <?php //foreach($upcoming as $content){ ?>
                    <?php //if(in_array( $val, $content['release_date'])){ ?>
                    <div class="card-main-body d-flex">
                        <div class="card-body">
                            <span class="crown position-absolute"><img src="{{ asset('/img/crown.svg') }}" alt=""></span>
                            <div class="upper-img">
                                <img src="{{ asset('/img/new-popular-img-1.png') }}" alt="">
                            </div>
                            <div class="bottom-text d-flex mt-2">
                                <div class="left-text">
                                    <h4 class="text-heading text-white">Inside Edge 3</h4>
                                    <ul class="text-white">
                                        <li>U/A 13+</li>
                                        <li>Drama</li>
                                        <li>Comedy</li>
                                        <li>2023</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php //} ?>
                    <?php //} ?>
                </div>
            </div>
            <?php } ?>

           <!--  <div class="card-details">
                <div class="date-upperline">.</div>
                <div class="internal-card d-flex">
                    <div class="date-card text-white">
                        <h6>Jun</h6>
                        <h5>23</h5>
                    </div>

                    <div class="card-main-body d-flex">
                        <div class="card-body">
                             <span class="crown position-absolute"><img src="{{ asset('/img/crown.svg') }}" alt=""></span>
                            <div class="upper-img">
                                <img src="{{ asset('/img/new-popular-img-1.png') }}" alt="">
                            </div>
                            <div class="bottom-text d-flex mt-2">
                                <div class="left-text">
                                    <h4 class="text-heading text-white">Inside Edge 3</h4>
                                    <ul class="text-white">
                                        <li>U/A 13+</li>
                                        <li>Drama</li>
                                        <li>Comedy</li>
                                        <li>2023</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                             <span class="crown position-absolute"><img src="{{ asset('/img/crown.svg') }}" alt=""></span>
                            <div class="upper-img">
                                <img src="{{ asset('/img/new-popular-img-1.png') }}" alt="">
                            </div>
                            <div class="bottom-text d-flex mt-2">
                                <div class="left-text">
                                    <h4 class="text-heading text-white">Inside Edge 3</h4>
                                    <ul class="text-white">
                                        <li>U/A 13+</li>
                                        <li>Drama</li>
                                        <li>Comedy</li>
                                        <li>2023</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                             <span class="crown position-absolute"><img src="{{ asset('/img/crown.svg') }}" alt=""></span>
                            <div class="upper-img">
                                <img src="{{ asset('/img/new-popular-img-1.png') }}" alt="">
                            </div>
                            <div class="bottom-text d-flex mt-2">
                                <div class="left-text">
                                    <h4 class="text-heading text-white">Inside Edge 3</h4>
                                    <ul class="text-white">
                                        <li>U/A 13+</li>
                                        <li>Drama</li>
                                        <li>Comedy</li>
                                        <li>2023</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                       
                    </div>
                </div>
            </div> -->
        </div>
    </section>

@stop

@section('script')
    <script>
        var TrandingSlider = new Swiper('.tranding-slider', {
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            loop: true,
            slidesPerView: 'auto',
            coverflowEffect: {
                rotate: 0,
                stretch: 0,
                depth: 500,
                modifier: 50,
                slideShadows: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            }
        });
    </script>
  
@stop