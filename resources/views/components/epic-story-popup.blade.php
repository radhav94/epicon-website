<?php
$content_list = $story_list['content_list'] ?? [];
?>
@if($content_list)
<div class="progressBar">
    @for ($i = 0; $i < count($content_list); $i++) <progress max="100" value="0"></progress>
        @endfor
</div>
@foreach ($content_list as $key => $value)
<div class="story-modal" id="story-modal-{{ ($key + 1) }}">

    <a href="javascript:;" class="epic-short-close close" aria-label="Close">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <g clip-path="url(#clip0_374_100985)">
                <path d="M17.0508 19.0726L12 14.0218L6.94924 19.0726C6.39365 19.6282 5.48452 19.6282 4.92893 19.0726C4.37335 18.517 4.37335 17.6079 4.92893 17.0523L9.9797 12.0015L4.92893 6.95075C4.37335 6.39516 4.37335 5.48603 4.92893 4.93044C5.48452 4.37486 6.39365 4.37486 6.94924 4.93044L12 9.9812L17.0508 4.93044C17.6063 4.37486 18.5155 4.37486 19.0711 4.93044C19.6267 5.48603 19.6267 6.39516 19.0711 6.95075L14.0203 12.0015L19.0711 17.0523C19.6267 17.6079 19.6267 18.517 19.0711 19.0726C18.5155 19.6282 17.6063 19.6282 17.0508 19.0726Z" fill="white" />
            </g>
            <defs>
                <clipPath id="clip0_374_100985">
                    <rect width="24" height="24" fill="white" />
                </clipPath>
            </defs>
        </svg>
    </a>

    <!-- Previous story Button -->
    <div class="previousStoryBtn" is-prev="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 56 56" fill="none">
            <circle cx="28" cy="28" r="23.25" transform="rotate(-180 28 28)" stroke="#B0B0B0" stroke-width="2.5" />
            <path d="M31.4057 36.2383L23.1924 28.0016L31.4057 19.7649" stroke="#B0B0B0" stroke-width="2.625" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </div>
    <!-- Previous story Button -->
    <div class="story-iframe">
        <!-- <h5 class="epic-shots-title text-white w-100 text-center mb-3">Epic Shots</h5> -->
        <!--start player -->
        <!-- top views -->
        <!-- <span class="total-views">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M7.9974 6C7.46696 6 6.95826 6.21071 6.58318 6.58579C6.20811 6.96086 5.9974 7.46957 5.9974 8C5.9974 8.53043 6.20811 9.03914 6.58318 9.41421C6.95826 9.78929 7.46696 10 7.9974 10C8.52783 10 9.03654 9.78929 9.41161 9.41421C9.78668 9.03914 9.9974 8.53043 9.9974 8C9.9974 7.46957 9.78668 6.96086 9.41161 6.58579C9.03654 6.21071 8.52783 6 7.9974 6ZM7.9974 11.3333C7.11334 11.3333 6.2655 10.9821 5.64037 10.357C5.01525 9.7319 4.66406 8.88406 4.66406 8C4.66406 7.11595 5.01525 6.2681 5.64037 5.64298C6.2655 5.01786 7.11334 4.66667 7.9974 4.66667C8.88145 4.66667 9.7293 5.01786 10.3544 5.64298C10.9795 6.2681 11.3307 7.11595 11.3307 8C11.3307 8.88406 10.9795 9.7319 10.3544 10.357C9.7293 10.9821 8.88145 11.3333 7.9974 11.3333ZM7.9974 3C4.66406 3 1.8174 5.07333 0.664062 8C1.8174 10.9267 4.66406 13 7.9974 13C11.3307 13 14.1774 10.9267 15.3307 8C14.1774 5.07333 11.3307 3 7.9974 3Z" fill="white" />
            </svg>&nbsp; 124
        </span> -->
        <!-- top end -->
        <!-- mute button start-->
        <button class="mute-btn-storie mute-btn">
            <img src="{{ asset('assets/img/mute-shots.svg') }}" width="40" height="40" alt="">
        </button>
        <button class="mute-btn-storie unmute-btn" style="display:none;">
            <img src="{{ asset('assets/img/unmute.svg') }}" width="40" height="40" alt="">
        </button>
        <!-- mute button end-->
        <!-- <div> -->
        <div class="play-add-share">
            <button class="story-play-btn" id="story-play-btn{{ ($key + 1) }}" data-id="{{ @$value['ID'] }}" data-url="{{ @$value['limelight_videourl'] }}" style="display:none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                    <path d="M30.25 19.9977L30.25 20.0023C30.2504 20.1664 30.2104 20.3252 30.1374 20.4625C30.0645 20.5996 29.9629 20.7076 29.8479 20.7811L29.8479 20.7811L29.8431 20.7841L13.4704 31.3774L13.47 31.3776C13.3477 31.4569 13.2125 31.4972 13.0782 31.4999C12.944 31.5025 12.8081 31.4675 12.684 31.3936L12.6817 31.3923C12.5597 31.3201 12.4511 31.2106 12.3725 31.0693C12.2939 30.9278 12.2503 30.7626 12.25 30.5912V9.40877C12.2503 9.2374 12.2939 9.07222 12.3725 8.93074C12.4511 8.7894 12.5597 8.6799 12.6817 8.60774L12.6817 8.60775L12.684 8.60638C12.8081 8.53254 12.944 8.49751 13.0782 8.50014C13.2125 8.50277 13.3477 8.54314 13.47 8.62239L13.4704 8.62263L29.8431 19.2159L29.8431 19.2159L29.8479 19.2189C29.9629 19.2924 30.0645 19.4004 30.1374 19.5375C30.2104 19.6748 30.2504 19.8336 30.25 19.9977Z" stroke="white" stroke-width="2" />
                </svg>
            </button>
            <button class="story-pause-btn" id="story-pause-btn{{ ($key + 1) }}" data-id="{{ @$value['ID'] }}" data-url="{{ @$value['limelight_videourl'] }}">
                <img src="{{ asset('assets/img/pause.svg') }}" width="40" height="40" alt="">
            </button>
        </div>

        <!--play button-->
        <!-- <div>
            <button class="story-play-btn" id="story-play-btn{{ ($key + 1) }}" data-id="{{ @$value['ID'] }}" data-type="{{ @$value['content_type'] }}" data-title="{{ @$value['title'] }}" data-lg="{{ isUserLoggedIn() }} style=" margin: 50%;">play</button>
        </div> -->

        <?php
        $poster_img_url = getCardImage($value, 'banner_image', 'small', []);
        ?>
        <video class="videocont" controls crossorigin playsinline poster="{{ $poster_img_url }}">
        </video>

        <div class="stories-title">
            <div class="st-pik mb-2">
                <?php
                $img_url = getCardImage($value, 'banner_image', 'small', []);
                ?>
                <div class="st-pik-wrapper">
                    <img src="{{ $img_url }}" alt="shot-img">
                </div>
                <div>
                    <h6 class="mt-3">{{ @$value['title'] }}</h6>
                    <span class="my-1" style="font-size: 10px;">{{ timestampToDate(@$value['publish_start_date'], 'Y') }}.
                        @if (is_array(@$story_list['genre']))
                        {{ ucwords(implode(" . ", @$story_list['genre'])) }}
                        @else
                        {{ @$story_list['genre'] }}
                        @endif
                    </span>
                </div>
            </div>
            <span class="small">{!! sanitizeData(@$value['short_description']) !!}</span>
        </div>
        <!-- <video-js id="myPlayersStories" data-account="3588749423001" data-video-id="{{ @$value['ID'] }}" data-player="default" data-embed="default" controls="true" autoplay data-tracker-type="{{ @$value['content_type'] }}" data-tracker-action="VIEW" data-application-id="" class="vjs-fluid"></video-js> -->
        <!-- </div> -->
        <!-- <script src="//players.brightcove.net/3588749423001/default_default/index.min.js"></script> -->
        <!-- <div class="vjs-playlist"></div> -->
        <!--end player -->
    </div>
    <!-- Next story button -->
    <div class="nextStoryBtn" is-next="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 56 56" fill="none">
            <circle cx="24.5" cy="24.5" r="23.25" transform="matrix(1 -2.38498e-08 -2.38498e-08 -1 3.5 52.5)" stroke="#B0B0B0" stroke-width="2.5" />
            <path d="M24.5943 36.2383L32.8076 28.0016L24.5943 19.7649" stroke="#B0B0B0" stroke-width="2.625" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </div>
    <!-- Next Story Button -->
</div>
@endforeach
@endif