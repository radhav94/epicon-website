@extends('layouts.default')
@section('title','New homepage')

@section('content') 

<section class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
         {{-- <span style="color:red"> </span>--}}
         <p class="text-white text-center">{{$final_result['message']}}</p>
         <p class="Timer" style="color:green"> </p>
            </div>
        </div>
    </section>

<script>
var start = new Date;
    setInterval(function() {
        var total_seconds = (new Date - start) / 1000;
        var seconds = Math.floor(total_seconds);
        var currentTimeString = seconds;
        $('.Timer').text("We will redirect on account page in "+currentTimeString+ " Seconds"); 
    }, 1000);
        window.setTimeout(function() {
        window.location.href = APP_URL+'/my-account';
    }, 5000);
</script>    
@stop