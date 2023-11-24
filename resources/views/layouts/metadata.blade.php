<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="csrf-token" content="{{ csrf_token()}}" />
<link rel="icon" href="{{asset('assets/img/favicon.png')}}"/>
<title>@yield('title') | {{ (env('APP_NAME') == '') ? 'EPIC ON' : env('APP_NAME') }}</title>

{{-- Start fb meta --}}
<meta property="og:url" content="{{URL::current()}}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ $meta['title'] ?? getDefaultMetaTitle() }}" />
<meta property="og:description" content="{{ $meta['description'] ?? 'TV Shows, Movies, Podcast, Games, Rewards' }}" />
<meta property="og:image" content="{{ $meta['image'] ?? url('/img/PB_Web_Desktop.jpg') }}" />
{{-- End fb meta --}}

{{-- start twitter meta --}}
<meta property='twitter:title' content="{{ $meta['title'] ?? getDefaultMetaTitle() }}">
<meta name="twitter:card" content="summary_large_image">
{{-- End twitter meta --}}