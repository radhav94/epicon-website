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
    }
</style>

<div class="container videoContainer" style="display: none">
    <p id="closePlayer">Close</p>
    <div id="playVideo" data-id="{{ $content['ID'] }}" data-type="{{ $content['content_type'] }}"
        data-lg="{{ isUserLoggedIn() }}" data-title="{{ $content['title'] }}">

    </div>


    <video id="vidPlayer" class="videocont" data-id="{{ $content['ID'] }}" controls crossorigin playsinline
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
