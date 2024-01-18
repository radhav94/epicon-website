<div class="carousel-main mb-3">
    <div class="carousel-title-n-arrow px-2 mb-3">
        <h5 class="text-white">{{ $title }}</h5>
    </div>
    <div class="captive-speaker-tab">
        <div class="captive-tab">
            <ul class="nav nav-pills px-2" id="pills-tab" role="tablist">
            @foreach ($value['content'] as $key => $val)
            <?php
            //dd($val);
            $card = getItemCardData($val, $displayLanguageParam);
            $cover_img = getCardImage($val, 'cover_image', 'medium', ['epic_shorts_image', 'banner_image']);
            ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php if($key == 0){ echo 'active';} ?>" id="pills-home-tab-{{$key}}" data-bs-toggle="pill"
                        data-bs-target="#pills-home-{{$key}}" type="button" role="tab" aria-controls="pills-home"
                        aria-selected="true">
                        <div class="pik-detail">
                            <div class="pik">
                                <img src="{{$cover_img}}" alt="">
                            </div>
                            <!--<p class="name">Mithlesh</p>-->
                        </div>
                    </button>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="tab-content" id="pills-tabContent">
         @foreach ($value['content'] as $epkey => $val)
            <div class="tab-pane fade show <?php if($epkey == 0){ echo 'active';} ?>" id="pills-home-{{$epkey}}" role="tabpanel" aria-labelledby="pills-home-tab-{{$epkey}}">
                <ul class="vertical-carousel-initilize p-0 my-3">
                @foreach ($val['episodes'] as $key => $data) 
                <?php //dd($data); 
                $child_card = getItemCardData($data, $displayLanguageParam);
                $child_cover_img = getCardImage($data, 'cover_image', 'medium', ['epic_shorts_image', 'banner_image']);
                ?>   
                    <li>
                        <a href="{{ getContentUrl($data) }}" class="main-card">
                            {{-- <!-- <span class="crown position-absolute"><img src="public/img/crown.svg" alt=""></span> --> --}}
                            <?php freePremiumDiv($data); ?>
                            <div class="main-img mt-0">
                                <img src="{{$child_cover_img}}" alt="">
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
            
        </div>
    </div>
</div>
