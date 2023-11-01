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
                
                $cover_img = getCardImage($value, 'vertical_cover_image', 'medium');
                ?>
                <li>
                    @if(@$value['asset_type'] == 'PLAY')
                    {!! getplayanchorhtml($value) !!}
                    @else
                    <a href="{{ getContentUrl($value) }}" class="main-card">
                    @endif
                        {!! freePremiumDiv($value) !!}
                        {!! topTenDiv($value) !!}

                        <div class="main-img">
                            <img src="{{ $cover_img }}" alt="">
                        </div>
                    </a>
                </li>
            @endforeach

        </ul>
    </div>
@endif
