@extends('layouts.default')
@section('title','New homepage')

@section('style')

@stop

@section('content') 

<section class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
          <span style="color:red">{{$result['message']}} </span>
            </div>
        </div>
    </section>

@section('script')


@stop