@extends('layouts.default')
@section('title', $meta['title'] ?? getDefaultMetaTitle() )

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plyr.css') }}?v={{ assetTime() }}">
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
<script src="{{ asset('assets/js/epic-story.js') }}?v={{ assetTime() }}"></script>
<script src="{{ asset('assets/js/vendor/plyr.js') }}"></script>
<script src="{{ asset('assets/js/vendor/hls.min.js') }}"></script>
<script src="{{ asset('assets/js/webvtt-subtitler.js') }}"></script>

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