@extends('layouts.default')
@section('title','Subscription fail')

@section('content')

<section class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
         <p class="text-white text-center">Transaction unsuccessful: {{$message}}</p>
            </div>
        </div>
    </section>


@stop
@section('script')
<script>
    $(document).ready(function(){
        showToaster('Transaction unsuccessful.', 2);
            window.setTimeout(function() {

            window.location.href = APP_URL+'/subscription';
                
        }, 2000);

});
</script>    
@stop
