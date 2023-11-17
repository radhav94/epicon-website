<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="csrf-token" content="{{ csrf_token()}}" />
<link rel="icon" href="{{asset('assets/img/favicon.png')}}"/>
<title id="page_title" data-page-title='{{ isset($meta_title)? $meta_title : "EPIC ON | TV Shows, Movies, Podcast, Games, Rewards"  }}'>@yield('title') | {{env('APP_NAME')}}</title>