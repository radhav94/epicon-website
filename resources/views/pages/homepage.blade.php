@extends('layouts.default')
@section('title', $meta['title'] ?? getDefaultMetaTitle() )


@section('style')
<link rel="stylesheet" type="text/css" href="{{ env('AWS_S3_domain') }}epicon/assets/images/plyr.css?v={{ assetTime() }}">
<style>
    #epicShots video {
        width: 100%;
        height: 100%;
    }

    #supermixModal button:disabled,
    #supermixModal button[disabled] {
        border: 1px solid #999999;
        background-color: #cccccc;
        color: #666666;
        cursor: not-allowed;
    }

    #supermixModal li.episode-main.mb-4.active {
        border: 1px solid #999999;
        background-color: #16161600;
    }
    .banner-img{
        aspect-ratio: auto 442 / 213;
    }
</style>
@stop

@section('content')
<input type="hidden" id="routepage" value="{{ request()->path() }}">
<input type="hidden" id="pageval" value="0">


<div class="loadmorecontent">

    @include('display.display-default')
</div>

    <div class="content-loader d-none" style="text-align: center;"> <img style="width: 40px;" src="{{ env('AWS_S3_domain') }}epicon/assets/images/loader.gif" alt="loading"> </div>

    {{--@include('components.supermix-content-modal')
    @include('components.video-player-modal')--}}
    <?php if(request()->path() == '' || request()->path() == '/' || request()->path() == 'hi' || request()->path() == '/hi'){ ?>
    @include('components.page-blocker')
    <?php } ?>
@stop

@section('script')
<script src="{{ env('AWS_S3_domain') }}epicon/assets/images/homepage.js?v={{ assetTime() }}" defer></script>
<script src="{{ env('AWS_S3_domain') }}epicon/assets/images/epic-story.js?v={{ assetTime() }}" defer></script>
{{-- <script src="{{ env('AWS_S3_domain').'epicon/assets/images/vendor/plyr.js' }}" defer></script> --}}
{{-- <script src="{{ env('AWS_S3_domain').'epicon/assets/images/vendor/hls.min.js' }}" defer></script> --}}
<script src="{{ env('AWS_S3_domain') }}epicon/assets/images/webvtt-subtitler.js" defer></script>
<script src="{{ env('AWS_S3_domain') }}epicon/assets/images/supermix.js?v={{ assetTime() }}" defer></script>

<script>
    var processing;
    var spinnerAdded = false;
    var continuewatching = "{{ $continuewatching ?? '' }}";
    var isMobileView = "{{ isMobliDevice() }}";

    $(document).ready(function() {
        $('#pageval').val('1');
        if (typeof activateSpinner === 'function') {
            activateSpinner();
        }
        initSliders();

        $(document).scroll(function(e) {
            if (processing) {
                return false;
            }
            if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.4) {
                processing = true;

                loadMoreData();
            }
        });


        const loadMoreData = function() {
            var paging = $("#pageval").val();
            var paging = parseInt(paging) + 1;
            var routepage = $("#routepage").val();
            $('.loadmorecontent').css('overflow', 'hidden');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                url: '{{ route('page.loadmore') }}',
                data: {
                    page: paging,
                    route: routepage,
                    continuewatching: continuewatching,
                    isMobileView: isMobileView
                },
                dataType: 'json',
                beforeSend: function() {
                    $('.content-loader').removeClass('d-none');
                },
                complete: function() {
                    $('.content-loader').addClass('d-none');
                },
                success: function(response) {
                    if (response.payload.html != '') {
                        $('.loadmorecontent').css('overflow', 'auto');
                        $('.loadmorecontent').append(response.payload.html);

                        initSliders();

                        if(spinnerAdded == false){
                            if (typeof activateSpinner === 'function') {
                                activateSpinner();
                            }
                        }
                        

                        // $("img.lazyload").lazyload();
                        processing = false;
                        $("#pageval").val(paging);
                        $(".loginwish").click(function(e){
                            e.preventDefault();
                            $(".loginBtn.login").trigger('click');
                            return false;
                        });
                    } else {
                        $('.loadmorecontent').css('overflow', 'auto');
                        return false;
                    }
                }
            });
        }
        
        if ("{{session()->has('error')}}") {
            $('.loginBtn.login').trigger('click');
            showToaster("{{session()->get('error')}}", 2);
        }
    });

    function closeModal() {
        var modal = document.querySelector('.modal-backdrop');
        modal.style.display = 'none';
    }
    </script>
@stop
