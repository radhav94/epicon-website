@php
$disallowUrls = config('epicconfig.DISALLOW_URL');
$lastSegment = request()->segment(count(request()->segments()));
@endphp
<meta charset="utf-8">
{{-- <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"> --> --}}
<meta content='width=device-width, initial-scale=1, user-scalable=1, minimum-scale=1, maximum-scale=5' name='viewport' >

<meta name="csrf-token" content="{{ csrf_token() }}">
@if(env('DISABLE_CSP') != 1)
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
@endif
<link rel="icon" href="{{ env('AWS_S3_domain') }}epicon/assets/images/favicon.png">
<title id="page_title" data-page-title="@yield('title')">@yield('title')</title>
<link rel="canonical" href="{{ URL::current() }}">

<meta name="theme-color" content="#9442c7">
<meta name="description" content="{{ htmlspecialchars_decode(@$meta['description'] ?? 'Watch TV Shows, Web Series, Movies, Podcasts & Live TV Channels online at EPIC ON, India\'s premier OTT platform in India. With a wide selection of new and classic shows and Movies.') }}">
@if(in_array($lastSegment, $disallowUrls))
<meta name="Robots" content="NOINDEX, NOFOLLOW" />
@else
<meta name="Robots" content="INDEX, FOLLOW" >
@endif
<meta name="Author" content="Epicon, epicon.in/">
<meta name="YahooSeeker" content="INDEX, FOLLOW" >
<meta name="msnbot" content="INDEX, FOLLOW" >
<meta name="googlebot" content="Default, follow" >
<meta name="owner" content="epicon.in/">
<meta name="language" content="English">
<meta name="revisit-after" content="2 days" >


<!-- HTML Meta Tags -->
<meta property="og:title" content="{{ $meta['title'] ?? getDefaultMetaTitle() }}">
<meta property="og:site_name" content="EPIC ON">
<meta property="og:url" content="{{ URL::current() }}">
<meta property="og:description"
    content="{{ htmlspecialchars_decode(@$meta['description'] ?? 'Watch Indian and Hollywood movies & TV shows online at EPIC ON, India\'s premier OTT platform in India. With a wide selection of new and classic shows and Movies.') }}">
<meta property="og:type" content="website">
<meta property="og:image" content="{{ $meta['image'] ?? env('AWS_S3_domain') }}epicon/assets/images/epiconlogo.png' }}">

<!-- Facebook Meta Tags -->
<meta property="og:title" content="{{ $meta['title'] ?? getDefaultMetaTitle() }}">
<meta property="og:description"
    content="{{ $meta['description'] ?? 'Watch TV Shows, Web Series, Movies, Podcasts & Live TV Channels online at EPIC ON, India\'s premier OTT platform in India. With a wide selection of new and classic shows and Movies.' }}">
<meta property="og:url" content="{{ URL::current() }}">
<meta property="og:image" content="{{ $meta['image'] ?? env('AWS_S3_domain') }}epicon/assets/images/epiconlogo.png' }}">

<meta property="og:image:alt" content="Epicon" >
<meta property="og:type" content="website">
<meta property="og:site_name" content="Epicon">
<meta property="fb:page_id" content="100064228862142">

<!-- Twitter Meta Tags -->
<meta name="twitter:title" content="{{ $meta['title'] ?? getDefaultMetaTitle() }}">
<meta name="twitter:description" content="{{ $meta['description'] ?? 'Watch TV Shows, Web Series, Movies, Podcasts & Live TV Channels online at EPIC ON, India\'s premier OTT platform in India. With a wide selection of new and classic shows and Movies.' }}">
<meta name="twitter:image" content="{{ $meta['image'] ?? env('AWS_S3_domain') }}epicon/assets/images/epiconlogo.png' }}">
<meta name="twitter:image:src" content="{{ $meta['image'] ?? env('AWS_S3_domain') }}epicon/assets/images/epiconlogo.png' }}">
<meta name="twitter:card" content="summary">
<meta name="twitter:site_name" content="@Epicon">
<meta name="twitter:creator" content="@Epicon">
<meta name="twitter:domain" content="{{ url('/') }}">
<meta property="twitter:url" content="{{ URL::current() }}">
<meta property="twitter:account_id" content="1230520950346543116">
