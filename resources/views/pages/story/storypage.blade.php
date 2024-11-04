@extends('layouts.default')
@section('title', $meta['title'] ?? getDefaultMetaTitle() )

@section('style')
<link rel="stylesheet" type="text/css" href="{{ env('AWS_S3_domain') }}epicon/assets/images/plyr.css?v={{ assetTime() }}">
<style>
    .main-header,
    .footer {
        display: none;
    }

    #epicShots video {
        width: 100%;
        height: inherit;
    }

    #epicShots .plyr__controls__item,
    #epicShots .plyr__progress__buffer {
        display: none;
    }
</style>
@stop

@section('content')

<div class="modal epic-shots-modal fade storyShareMod" id="epicShots" tabindex="-1" aria-hidden="true" data-url="{{ url('/') }}">
    <div class="modal-dialog">
        <div class="modal-content p-0">
            @include('components.epic-story-popup')
        </div>
    </div>
</div>

@stop

@section('script')
<script src="{{ env('AWS_S3_domain') }}epicon/assets/images/epic-story.js??v={{ assetTime() }}"></script>
<script src="{{ env('AWS_S3_domain') }}epicon/assets/images/plyr.js"></script>
<script src="{{ env('AWS_S3_domain') }}epicon/assets/images/hls.min.js"></script>
<script src="{{ env('AWS_S3_domain') }}epicon/assets/images/webvtt-subtitler.js"></script>

<script>
    // $(document).ready(function() {
    //     $("#epicShots").modal('show');
    //     // $('#epicShots .modal-content').html(response.payload.html);
    //     currentStep = 1;
    //     $(".progressBar progress:nth-child(" + currentStep + ")").val(100);
    //     showStoryPopup(currentStep);
    // });
    // $('.storyBtn').trigger('click');


    $(document).ready(function() {
        $("#epicShots").modal('show');
        var playHiddenVideo = $("#playHiddenVideo").val();
        if (playHiddenVideo > 0) {
        currentStep = playHiddenVideo;
        } else {
            currentStep = 1;
        }
        $(".story-share-option").removeClass("d-flex");
        if (currentStep < $(".story-modal").length) {
            showStoryPopup(currentStep);
            changePlayIcon();
            player.play();
        }
    });
</script>
@stop