@extends('layouts.default')
@section('title','New homepage')

@section('style')

@stop

@section('content')
<?php //dd($popular[0]); ?>
    <section class="container">
        <div class="new-popular-main">
            <h4 class="new-popularheading text-white mb-3">New & Popular</h4>
            <div class="card-details">
                <?php foreach($popular as $val){
                $cover_img = isset($val['cover_image']) ? @$val['cover_image']['medium'] : '';
                $generes = array_column($val['genres_assign'] ?? [], 'name');

    $sub_text = [];

    if (isset($val['publish_start_date'])) {
        $date_text = date('Y', strtotime($val['publish_start_date']));
    }
    if (isset($val['publish_start_date'])) {
        $sub_text[] = date('Y', strtotime($val['publish_start_date']));
    }
    // $sub_text[] = '3 Language';

    if ($generes) {
        $sub_text[] = implode(" . ", $generes);
    }
    if (isset($val['age_limit'])) {
        $sub_text[] = $val['age_limit'];
    }


    $sub_points = (@$val['age_limit']) ? '<li class="ps-1">' . @$val['age_limit'] . '</li>' : '';

    if ($generes) {
        foreach ($generes as $key => $genre) {
            $sub_points .= '<li>' . $genre . '</li>';
        }
    }
     $wishlist = getWishlist();
     // dd($wishlist);
    //dd($sub_points); ?>
                <div class="card-body">
                    {!! freePremiumDiv($val) !!}
                    <?php if($val['is_popular'] == true){ ?>
                    <h6 class="popular-head text-white">
                        <span><img src="{{ asset('/img/fire-emoji.png') }}" alt=""></span>Most Popular
                    </h6>
                    <?php } ?>
                    <a class="upper-img" href="{{ url($val['url'] ?? '/new-popular') }}">
                        <img src="{{ $cover_img }}" alt="">
                    </a>
                    <div class="bottom-text d-flex mt-2">
                        <div class="left-text">
                            <h4 class="text-heading text-white">{{$val['title'] ?? ''}}</h4>
                            <ul class="text-white">
                                <?php echo $sub_points ?>
                                <!-- <li>{{$val['age_limit']}}</li>
                                <li>Drama</li>
                                <li>Comedy</li> -->
                                <li>{{$date_text}}</li>
                            </ul>
                        </div>
                        <!-- <button class="addbutton"> -->
                            <!-- <img src="{{ asset('/img/round-add.png') }}" alt=""> -->
                            {!! getWishListAction($val, $wishlist, 2) !!}
                        <!-- </button> -->
                    </div>
                </div>
            <?php } ?>
            </div>
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