<?php 
    $title = ucfirst($slug);

    if (is_numeric($title) && strlen($title) === 4) {
        $lastTwoDigits = substr($title, 2); // Get the last two digits
        $title = $lastTwoDigits . "'s";
    }
?>

@extends('layouts.default')
@section('title', $title )


@section('style')
    <style>
        .explore-main .add-icon {
            background: center no-repeat #272727;
            border: 0.5px solid #545454;
            border-radius: 50%;
            padding: 20px;
            margin: 12px 0 auto;
        }

        .explore-main .delete-icon {
            background: center no-repeat #272727;
            border: 0.5px solid #545454;
            border-radius: 50%;
            padding: 20px;
            margin: 12px 0 auto;
        }

        a.autowidth.explore-showmore {
            font-size: 17px;
            font-weight: 500;
            color: #fff;
            width: 200px;
            height: 55px;
            line-height: 52px;
            border-radius: 32px;
            /* border: solid 1px #fff; */
            background: linear-gradient(232deg, #B14CF0 0%, #1C181E 76.18%);
            text-transform: uppercase;
            display: inline-block;
            padding: 0 25px;
            margin-top: 35px;
            transition: all linear 0.4s;
            text-decoration: none;
            margin-bottom:20px;
        }
    </style>
@stop

@section('content')
    
    <section class="container">
        <div class="new-popular-main explore-details" id="showmore_load">
            <h4 class="new-popularheading text-white mb-3">{{ $title }}</h4>

            @include('components.retro-rewind-content-list')
        </div>


        <!-- Load More Btn Start -->
        <input type="hidden" id="pageid" value="{{ $page + 1 }}">
        <div class="text-center">
            <a href="javascript:;" class="autowidth explore-showmore" data-slug="{{ $slug }}">Show More</a>
        </div>
        <!-- Load More Btn End -->
    </section>
@stop

@section('script')
    <script>
        $(document).ready(function() {

            $(document).on("click", ".explore-showmore", function() {

                $.ajax({
                    url: APP_URL + '/retro-content',
                    type: 'POST',
                    data: {
                        page: $("#pageid").val(),
                        slug: $(this).data("slug"),
                    },
                    contentType: "application/x-www-form-urlencoded",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        var page = parseInt($("#pageid").val()) + 1;

                        $("#pageid").val(page);
                        $("#showmore_load").append(response.paginateHTML);
                        if (response.dataCount < response.limit) {
                            $('.explore-showmore').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("in error function");
                    }
                });
            });
        });
    </script>
@stop
