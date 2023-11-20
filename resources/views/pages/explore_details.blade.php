@extends('layouts.default')
@section('title', ucfirst($slug))

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
            margin-top: 35px;
            transition: all linear 0.4s;
            text-decoration: none;
        }
    </style>
@stop

@section('content')

    <section class="container">
        <div class="new-popular-main explore-details" id="showmore_load">
            <h4 class="new-popularheading text-white mb-3">{{ __(ucfirst($slug)) }}</h4>

            @include('pages.explorecontent')
        </div>

        <!-- Load More Btn Start -->
        <input type="hidden" name="page" id="pageid" value="<?php echo $page + 1; ?>">
        @if (count($result) >= $limit)
            <div class="text-center">
                <a onclick="click_cta(this)" data-event_context="{{ __(ucfirst($slug)) }}" data-element_text="Show More" href="javascript:;" class="autowidth explore-showmore" data-currenturl="{{ route('explorecontent') }}"
                    slug="{{ $slug }}">{{ __('Show More') }}</a>
            </div>
        @endif
        <!-- Load More Btn End -->
    </section>
@stop

@section('script')
    <script>
        $(document).on("click", ".explore-showmore", function() {
            // var page = $("#pageid").val(parseInt($("#pageid").val()) + 1);
            $.ajax({
                url: '/explorecontent',
                type: 'POST',
                data: {
                    page: $("#pageid").val(),
                    slug: $(this).attr("slug"),
                },
                contentType: "application/x-www-form-urlencoded",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    var page = parseInt($("#pageid").val()) + 1;
                    // console.log(page+"page Number");
                    $("#pageid").val(page);
                    $("#showmore_load").append(response.paginateHTML);
                    if (response.dataCount < response.limit) {
                        // console.log("on false condition");
                        $('.explore-showmore').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("in error function");
                }
            });
        });
    </script>
@stop
