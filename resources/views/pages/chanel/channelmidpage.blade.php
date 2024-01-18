@extends('layouts.default')
@section('title', ucwords(str_replace('-', ' ', $title)))
 

@section('content')
<div class="container mt-4">
    <div class="row">
        <h1 class="text-white fs-5">{{ucwords(str_replace('-', ' ', $title))}} Tv</h1>
        <div class="seeall-main-page">
            <ul class="p-0" id="showmore_load">
            @include('pages.chanel.channelpaginatecontent')
            </ul>
        </div>
        <!-- Load More Btn Start -->
        <input type="hidden" name="page" id="pageid" value="<?php echo $page + 1; ?>">
        @if (count($epicwebArr) > 47)
            <div class="text-center">
                <a href="javascript:;" class="autowidth channel-showmore" data-currenturl="{{ route('channelpaginatecontent') }}" slug="{{ $slug }}">{{__('Show More')}}</a>
            </div>
        @endif
        <!-- Load More Btn End -->

    </div>
</div>

@stop
@section('script')
<script>
    $(document).on("click", ".channel-showmore", function() {
        $.ajax({
            url: '/channelpaginatecontent',
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
                $("#pageid").val(page);
                $("#showmore_load").append(response.paginateHTML);
                if (response.dataCount < response.limit) {
                    $('.channel-showmore').hide();
                }
            },
            error: function(xhr, status, error) {
                console.log("in error function");
            }
        });
    });
</script>
@stop