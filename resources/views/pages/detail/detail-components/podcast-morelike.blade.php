@if ($morelike)
    <div class="tab-pane fade {{ $active_tab == 'morelike' ? 'show active' : '' }}" id="pills-morelike" role="tabpanel"
        aria-labelledby="my-list">

        <ul class="more-like-this px-0 py-4">
            @foreach ($morelike as $key => $value)
                <?php
                if ($value['ID'] == $content['ID']) {
                    continue;
                }
                
                $card = getItemCardData($value, $displayLanguageParam);
                
                $cover_img = getCardImage($value, 'cover_image', 'medium');
                ?>

                <li>
                    @if(@$value['asset_type'] == 'PLAY')
                    {!! getplayanchorhtml($value) !!}
                    @else
                    <a href="{{ getContentUrl($value) }}" class="main-card">
                    @endif
                        <div class="main-img eod-darlings">
                            <img src="{{ $cover_img }}" alt="">
                            <div class="new-show-title"><img src="{{ asset('img/sound-equalizer.svg') }}"
                                    alt="">
                            </div>
                            @if (@$value['duration'])
                                <div class="sound-time">{{ convertSecondsToReadable($value['duration']) }}</div>
                            @endif
                        </div>
                    </a>
                </li>

                {{-- <li>
                    <a href="{{ getContentUrl($value) }}" class="main-card">
                        {!! freePremiumDiv($value) !!}
                        {!! topTenDiv($value) !!}

                        <div class="main-img">
                            <img src="{{ $cover_img }}" alt="">
                        </div>
                    </a>
                </li> --}}
            @endforeach

        </ul>
    </div>
@endif
