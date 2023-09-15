@extends('layouts.default')
@section('title','New homepage')

@section('style')

@stop

@section('content')
<?php //dd($upcoming);

$input = $upcoming;

$output = [];

foreach ($input as $item) {
    $releaseDate = substr($item['release_date'], 0, 10); // Extract the date part (e.g., "2023-09-15")
    
    if (!isset($output[$releaseDate])) {
        $output[$releaseDate] = []; // Initialize the array for this date if it doesn't exist
    }
    
    $output[$releaseDate][] = $item; // Add the item to the corresponding date in the output array
}

krsort($output);

?>
    <section class="container">
        <div class="upcoming-epicon-main">
            
            <div class="upcoming-heading border-bot">
                <h4 class="new-popularheading text-white my-4">Upcoming on Epic On</h4>
            </div>
            
            <?php foreach($output as $key => $releaseDate){ ?>
            <?php if($key !== "" && !strstr($key, '1970')){ ?>
            <div class="card-details">
                <div class="date-upperline">.</div>
                <div class="internal-card d-flex">
                   
                    <div class="date-card text-white">
                        <h6>{{date("d", strtotime($key))}}</h6>
                        <h6>{{date("M", strtotime($key))}}</h6>
                        <h5>{{date("y", strtotime($key))}}</h5>
                    </div>
                    
                    <?php foreach($releaseDate as $val){ 
                            $cover_img = isset($val['cover_image']) ? @$val['cover_image']['medium'] : '';
                            $generes = array_column($val['genres_assign'] ?? [], 'name');

    $sub_text = [];

    if (isset($val['release_date'])) {
        $date_text = date('Y', strtotime($val['release_date']));
    }
    if (isset($val['release_date'])) {
        $sub_text[] = date('Y', strtotime($val['release_date']));
    }
    // $sub_text[] = '3 Language';

    if ($generes) {
        $sub_text[] = implode(" . ", $generes);
    }
    // if (isset($val['age_limit'])) {
    //     $sub_text[] = $val['age_limit'];
    // }


    // $sub_points = (@$val['age_limit']) ? '<li class="ps-1">' . @$val['age_limit'] . '</li>' : '';
    $sub_points = '';
    if ($generes) {
        foreach ($generes as $key => $genre) {
            $sub_points .= '<li>' . $genre . '</li>';
        }
    }
                         ?>
                    <div class="card-main-body d-flex">
                        <div class="card-body">
                            {!! freePremiumDiv($val) !!}
                            
                            <a class="upper-img" href="{{ getContentUrl($val) }}">
                                <img src="{{ $cover_img }}" alt="">
                            </a>
                            <div class="bottom-text d-flex mt-2">
                                <div class="left-text">
                                    <h4 class="text-heading text-white">{{$val['title'] ?? ''}}</h4>
                                    <ul class="text-white">
                                        <?php echo $sub_points ?>
                                       <!--  <li>Drama</li>
                                        <li>Comedy</li>  -->
                                        <li>{{$date_text}}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
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