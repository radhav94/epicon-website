
@if ($season_episode_data && count($season_episode_data) > 0)
    <div class="tab-pane fade {{ $active_tab == 'episode' ? 'show active' : '' }}" id="pills-episode" role="tabpanel"
        aria-labelledby="my-list">
        @foreach ($season_episode_data as $skey => $ep_season_data)
        <ul class="season-episode-main list-unstyled col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 p-0 mt-4 {{ $skey == $lastSeason ? '' : 'hide' }}"  id="pills-episode-{{$skey ?? ''}}">
            <?php  $subplan = checkSubscription(); ?>
            @foreach ($ep_season_data as $key => $value)
                <?php
      
                $addClass = isKidsPage() ? "allAccessBtn-sub" : "subscription";

                $hreflink = getContentUrl($value);

                $watchClass = '';

                /*if (!isUserLoggedIn()) {
                    $watchClass = @$value['free_premium'] == true ? "login-with-subscription" : "";
                    $href = "javascript:void(0);"; 
                } else {
                    $watchClass = @$value['free_premium'] == true && @$subplan['status'] != 'active' ? $addClass : "";
                    $href = @$value['free_premium'] == true && @$subplan['status'] != 'active' ? 'javascript:void(0);' : $hreflink;
                } */  
                if (!isset($value['ID']) || $value['ID'] == $content['ID']) {
                    continue;
                }
                $card = getItemCardData($value, $displayLanguageParam);
                
                $cover_img = getCardImage($value, 'cover_image', 'medium');
                ?>
                <li class="episode-main mb-4 showmore-main">
                    @if(@$value['asset_type'] == 'PLAY')
                    {!! getplayanchorhtml($value) !!}
                    @else
                    <a href="{{ $hreflink }}" class="pik {{$watchClass}}">
                    @endif
                        <img src="{{ $cover_img }}" alt="img">

                        <?php
                        echo @$value['free_premium'] == true ? '<img class="crown" src="' . asset('assets/img/crown.svg') . '" alt="">' : '';
                        ?>
                        <button class="play-btn" tabindex="0">
                             <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                 <path d="M18.75 10.0004C18.7505 10.2126 18.6961 10.4213 18.5921 10.6063C18.488 10.7912 18.3379 10.9461 18.1563 11.0559L6.9 17.9418C6.71022 18.058 6.49287 18.1214 6.27037 18.1256C6.04788 18.1297 5.82832 18.0743 5.63438 17.9652C5.44227 17.8578 5.28225 17.7012 5.17075 17.5114C5.05926 17.3217 5.00032 17.1056 5 16.8855V3.11523C5.00032 2.89514 5.05926 2.67911 5.17075 2.48935C5.28225 2.29959 5.44227 2.14295 5.63438 2.03555C5.82832 1.92644 6.04788 1.87109 6.27037 1.87521C6.49287 1.87933 6.71022 1.94278 6.9 2.05898L18.1563 8.94492C18.3379 9.05467 18.488 9.20955 18.5921 9.3945C18.6961 9.57945 18.7505 9.78818 18.75 10.0004Z" fill="#272727"></path>
                             </svg>
                         </button>
                    </a>
                    <div class="episode-text-details">
                        <h6>{{ $card['title'] }}</h6>
                        <span>
                            @if (@$value['release_date'])
                                {{ formatDate($value['release_date']) }}
                            @endif

                            @if (@$value['duration'])
                                @if (@$value['release_date'])
                                    |
                                @endif
                                {{ convertSecondsToReadable($value['duration']) }}
                            @endif
                        </span>
                        <p class="mt-2 shot-desc-{{$key}}">{!! sanitizeData(@$value['short_description']) !!}</p>
                        <span class="read-button-{{$key}}"> </span>
                    </div>
                </li>
            @endforeach

        </ul>
        @endforeach
    </div>
@endif


