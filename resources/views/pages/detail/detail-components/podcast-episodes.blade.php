@if ($season_episode_data && count($season_episode_data) > 0)
    <div class="tab-pane fade {{ $active_tab == 'episode' ? 'show active' : '' }}" id="pills-episode" role="tabpanel" aria-labelledby="my-list">
        @foreach ($season_episode_data as $skey => $ep_season_data)
            <ul class="season-episode-main list-unstyled col-12 p-0  {{ $skey == $lastSeason ? '' : 'hide' }}" id="pills-episode-{{$skey ?? ''}}">
                @foreach ($ep_season_data as $key => $value)
                <?php
                if (!isset($value['ID']) || $value['ID'] == $content['ID']) {
                    continue;
                }
                $card = getItemCardData($value, $displayLanguageParam);
                //$cover_img = isset($value['cover_image']) ? @$value['cover_image']['medium'] : $card['banner_img'];

                $cover_img = getCardImage($value, 'cover_image', 'medium');

                ?>

                <li class="pod-main position-relative py-3" data-id="{{ $value['ID'] }}">
                    <div class="col-12 col-sm-11 ps-3 d-flex">
                        <div class="pik position-relative">
                            @if(@$value['asset_type'] == 'PLAY')
                            {!! getplayanchorhtml($value) !!}
                            @else
                            <a href="{{ getContentUrl($value) }}" class="pik-img">
                                @endif
                                <img src="{{ $cover_img }}" alt="img">
                            </a>
                            {{-- <h6 class="pod-title">EPIC ON ORIGINAL</h6> --}}
                            {{-- <h5 class="pod-series">CASO.63</h5> --}}
                            <img class="podcast-top-icon" src="{{ asset('assets/img/podcast-top-icon.svg') }}" alt="podcast icon">
                        </div>
                        <div class="middle">
                            <h6>{{ $card['title'] }}</h6>
                            <div class="d-flex align-items-center flex-wrap">
                                <span class="me-3">
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
                                <div class="progress-main">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <p class="col-sm-8 col-md-10 mt-2">{!! sanitizeData(@$value['short_description']) !!}</p>

                            <div class="pod-grey-btn-list">

                                <?php
                                $ep_wishAction = in_array($value['ID'], $wishlist_ids) ? 'delete' : 'add';

                                $share_title = @$value['title'];
                                if ($content['content_type'] == 'SEASON') {
                                    $share_title = @$content['parent_name'] . ' - ' . @$value['title'];
                                }
                                ?>

                                <button class="rounded-grey-btn me-2 addToList" data-id="{{ @$value['ID'] }}" data-action="{{ $ep_wishAction }}" data-type="3">
                                    <img class="wl_add" src="{{ asset('assets/img/add-icon.svg') }}" alt="icon" @if ($ep_wishAction=='delete' ) style="display: none" @endif>
                                    <img class="wl_remove" src="{{ asset('assets/img/subs-icon.svg') }}" alt="icon" @if ($ep_wishAction=='add' ) style="display: none" @endif>
                                </button>

                                <button class="rounded-grey-btn me-2 clapButton" data-cardtype="list" data-id="{{ @$value['ID'] }}">
                                    <img src="{{ asset('assets/img/clap-icon.svg') }}" alt="icon">
                                </button>
                                <button class="rounded-grey-btn shareThis" data-url="{{ getContentUrl($value) }}" data-title="{{ $share_title }}">
                                    <img src="{{ asset('assets/img/share-icon.svg') }}" alt="icon">
                                </button>
                            </div>
                        </div>
                        <button class="pod-play playBtn" data-id="{{ @$value['ID'] }}" data-url="{{ getContentUrl($value) }}"> <img src="{{ asset('assets/img/play-icon.svg') }}" alt="">
                            </a>

                    </div>
                </li>
                @endforeach

            </ul>
        @endforeach
    </div>
@endif