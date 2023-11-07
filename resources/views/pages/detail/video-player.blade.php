<style>
    .videoContainer {
        position: relative;
    }

    .videoContainer video {
        width: 100%;
    }

    #playVideo {
        position: absolute;
        width: 100%;
        height: 100%;
    }
    .plyr:fullscreen video {
        height: 100%!important;
    }
    #vidPlayer.hide {
        display: none !important;
    }

    .custom-play-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 60px;
        height: 60px;
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .custom-play-button i {
        color: white;
        font-size: 36px;
    }

    #closePlayer {
        text-align: right;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
        margin: 0 0 0 auto;
        padding: 10px 0px 10px 10px;
    }
    .live-tv-vidPlayer button[data-plyr="fast-forward"], 
    .live-tv-vidPlayer button[data-plyr="rewind"], 
    .live-tv-vidPlayer button[data-plyr="pip"].plyr__control, 
    .live-tv-vidPlayer .plyr__progress__container{
        display: none;
    }
</style>

<div class="container videoContainer {{ getFirstSegment() == 'live-tv' ? 'live-tv-vidPlayer' : '' }}" style="display: none">
    <p id="closePlayer">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <g clip-path="url(#clip0_887_29375)">
                <path d="M17.0508 19.0726L12 14.0218L6.94924 19.0726C6.39365 19.6282 5.48452 19.6282 4.92893 19.0726C4.37335 18.517 4.37335 17.6079 4.92893 17.0523L9.9797 12.0015L4.92893 6.95075C4.37335 6.39516 4.37335 5.48603 4.92893 4.93044C5.48452 4.37486 6.39365 4.37486 6.94924 4.93044L12 9.9812L17.0508 4.93044C17.6063 4.37486 18.5155 4.37486 19.0711 4.93044C19.6267 5.48603 19.6267 6.39516 19.0711 6.95075L14.0203 12.0015L19.0711 17.0523C19.6267 17.6079 19.6267 18.517 19.0711 19.0726C18.5155 19.6282 17.6063 19.6282 17.0508 19.0726Z" fill="white"/>
            </g>
            <defs>
                <clipPath id="clip0_887_29375">
                <rect width="24" height="24" fill="white"/>
                </clipPath>
            </defs>
        </svg>
    </p>
    <div id="playVideo" data-id="{{ $content['ID'] }}" data-type="{{ $content['content_type'] }}"
        data-lg="{{ isUserLoggedIn() }}" data-title="{{ $content['title'] }}">

    </div>


    <video id="vidPlayer" class="videocont " data-id="{{ $content['ID'] }}" controls crossorigin playsinline
        poster="{{ $cover_img }}">
        <!-- <track src="subtitle.vtt" kind="subtitles" srclang="en" label="English"> -->

    </video>

    {{-- <div class="custom-play-button" id="customPlayButton">
        <i class="fas fa-play"></i>

        PLAY
    </div> --}}

</div>

<div style="display:none;">
    <p class="rewind-btn"> Rewind</p>
    <p class="forward-btn"> Fast -forward </p>
</div>
