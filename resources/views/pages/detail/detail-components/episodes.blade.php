@if ($season_episode_data && count($season_episode_data) > 0)
    <div class="tab-pane fade {{ $active_tab == 'episode' ? 'show active' : '' }}" id="pills-episode" role="tabpanel"
        aria-labelledby="my-list">
        @foreach ($season_episode_data as $skey => $ep_season_data)
        <ul class="season-episode-main list-unstyled col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 p-0 mt-4 {{ $skey == $lastSeason ? '' : 'hide' }}"  id="pills-episode-{{$skey ?? ''}}">

            @foreach ($ep_season_data as $key => $value)
                <?php
                if (!isset($value['ID']) || $value['ID'] == $content['ID']) {
                    continue;
                }
                $card = getItemCardData($value, $displayLanguageParam);
                
                $cover_img = getCardImage($value, 'cover_image', 'medium');
                ?>
                <li class="episode-main mb-4">
                    @if(@$value['asset_type'] == 'PLAY')
                    {!! getplayanchorhtml($value) !!}
                    @else
                    <a href="{{ getContentUrl($value) }}" class="pik">
                    @endif
                        <img src="{{ $cover_img }}" alt="img">

                        <?php
                        echo @$value['free_premium'] == true ? '<img class="crown" src="' . asset('assets/img/crown.svg') . '" alt="">' : '';
                        ?>
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
                        <p class="mt-2">{!! sanitizeData(@$value['short_description']) !!}</p>
                    </div>
                </li>
            @endforeach

        </ul>
        @endforeach
    </div>
@endif
