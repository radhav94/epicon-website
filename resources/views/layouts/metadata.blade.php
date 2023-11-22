<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="csrf-token" content="{{ csrf_token()}}" />
<link rel="icon" href="{{asset('assets/img/favicon.png')}}"/>
<title>@yield('title') | {{env('APP_NAME')}}</title>
<meta name="description" content="{{htmlspecialchars_decode(@$meta_description)}}" />
