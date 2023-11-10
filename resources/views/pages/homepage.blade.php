@extends('layouts.default')
@section('title', $meta_title)

@section('style')
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
<style>
    #epicShots video {
        width: 340px;
        height: 500px;
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
</style>
@stop

@section('content')
<input type="hidden" id="routepage" value="{{ request()->path() }}">
<input type="hidden" id="pageval" value="1">


<div class="loadmorecontent">

    @include('display.display-default')
</div>

    <div class="content-loader d-none" style="text-align: center;"> <img style="width: 40px;" src="{{ asset('assets/img/loader.gif') }}"> </div>

    @include('components.supermix-content-modal')
    @include('components.video-player-modal')
    <?php if(request()->path() == '' || request()->path() == '/' || request()->path() == 'hi' || request()->path() == '/hi'){ ?>
    @include('components.page-blocker')
    <?php } ?>
@stop

@section('script')
<script src="{{ asset('assets/js/homepage.js') }}"></script>
<script src="{{ asset('assets/js/epic-story.js') }}"></script>
<script src="{{ asset('assets/js/vendor/plyr.js') }}"></script>
<script src="{{ asset('assets/js/vendor/hls.min.js') }}"></script>
<script src="{{ asset('assets/js/webvtt-subtitler.js') }}"></script>
<script src="{{ asset('assets/js/supermix.js') }}"></script>

<script>
    var processing;
    var spinnerAdded = false;

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
                    route: routepage
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

        });

    function closeModal() {
        var modal = document.querySelector('.modal-backdrop');
        modal.style.display = 'none';
    }
    </script>
@stop
