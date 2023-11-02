@extends('layouts.default')
@section('title', $meta_title)

@section('style')

@stop

@section('content')
<input type="hidden" id="routepage" value="{{ request()->path() }}">
<input type="hidden" id="pageval" value="1">


<div class="loadmorecontent">

    <?php
         $wishlist = getWishlist();
         ?>

         @if (@$result['data']['list'])
             @foreach ($result['data']['list'] as $key => $value)
                 @if (isset($value['display_type']) && isset($value['content']) && !empty($value['content']))
                     @php
                         $template = 'display-distro.' . $value['display_type'];
                     @endphp

                    @if (View::exists($template))
                         <?php
                         $title = getDispLangContent($value, $displayLanguageParam, 'title');
                         $shortdescription = getDispLangContent($value, $displayLanguageParam, 'shortdesc');
                         
                         ?>

                         @if (request()->get('v'))
                             <h1>{{ $value['display_type'] }}</h1>
                         @endif

               
                            @include($template, [
                                'value' => $value,
                                'title' => $title,
                                'shortdescription' => $shortdescription,
                            ])
                     @endif
                 @endif
             @endforeach
         @endif

</div>

    <div class="content-loader d-none" style="text-align: center;"> <img style="width: 40px;" src="{{ asset('assets/img/loader.gif') }}"> </div>

@stop

@section('script')
<script src="{{ asset('assets/js/homepage.js') }}"></script>
@stop
