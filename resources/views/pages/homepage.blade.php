@extends('layouts.default')
@section('title', $meta_title)

@section('style')

@stop

@section('content')
    <input type="hidden" id="routepage" value="{{ request()->path() }}">
    <input type="hidden" id="pageval" value="1">


    <div class="loadmorecontent">

        @include('display.display-default')
    </div>

@stop

@section('script')
    <script src="{{ asset('assets/js/homepage.js') }}"></script>
    <script>
        $(document).ready(function() {



        });
    </script>


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

                    // loadMoreData();



                }
            });


            const loadMoreData = function() {
                console.log('asdasda');
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
                        console.log(response);
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
@stop
