@extends('layouts.default')
@section('title', $meta_title)

@section('style')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<style>
    #epicShots video {
        width: 340px;
        height: 500px;
    }
    #supermixModal .plyr__controls__item {
        display: none;
    }
    #supermixModal button:disabled, #supermixModal button[disabled]{
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


    @include('components.supermix-content-modal')
    @include('components.video-player-modal')

    <!-- page blocker start -->
    <?php 
                $ua = strtolower($_SERVER["HTTP_USER_AGENT"]);
                $isMob = is_numeric(strpos($ua, "mobile"));
                 if(isset($isMob) && $isMob==true){
                    if(!empty(env('PAGEBLOCKERDATE'))) {
                      $pageblockername = 'Mobile-Page-Blocks_'.env('PAGEBLOCKERDATE').'.jpg';
                  } else {
                      $pageblockername = 'Mobile-Page-Blocks.jpg';
                  }
                }else{
                     if(!empty(env('PAGEBLOCKERDATE'))) {
                        $pageblockername = 'Desktop-Page-Blocks_'.env('PAGEBLOCKERDATE').'.jpg';
                    } else {
                        $pageblockername = 'Desktop-Page-Blocks.jpg';
                    }
                }
                   
    ?>
<div class="modal modal-backdrop page-blocker" tabindex="-1">
  <div class="modal-dialog page-dialog modal-dialog-centered modal-lg">
    <div class="modal-content blocker-content">
    <button class="close-button page-close" onclick="closeModal()">&times;</button>
        <div class="modal-body blocker-body" data-url="{{ config('epicconfig.PAGEBLOCKER.PAGEBLOCKER_URL') }}">
            <a href="{{ config('epicconfig.PAGEBLOCKER.PAGEBLOCKER_URL') }}" target="_blank"><img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/'.$pageblockername;?>" alt=""> </a>
        </div> 
    </div>
  </div>
</div>
<!-- page blocker end -->

@stop

@section('script')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="{{ asset('assets/js/homepage.js') }}"></script>
    <script src="{{ asset('assets/js/epic-story.js') }}"></script>
    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    <script src="https://cdn.rawgit.com/video-dev/hls.js/18bb552/dist/hls.min.js"></script>
    <script src="{{ asset('assets/js/webvtt-subtitler.js') }}"></script>
    <script src="{{ asset('assets/js/supermix.js') }}"></script>

    
    <script>
        var processing;

        $(document).ready(function() {
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
                    success: function(response) {
                        if (response.payload.html != '') {
                            $('.loadmorecontent').css('overflow', 'auto');
                            $('.loadmorecontent').append(response.payload.html);

                            initSliders();

                            // $("img.lazyload").lazyload();
                            processing = false;
                            $("#pageval").val(paging);
                        } else {
                            $('.loadmorecontent').css('overflow', 'auto');
                            return false;
                        }
                    }
                });
            }

        });
    </script>
    <script>
    function closeModal() {
        var modal = document.querySelector('.modal-backdrop');
        modal.style.display = 'none';
    }
    </script>
@stop
