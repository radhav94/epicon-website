<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="icon" href="{{ asset('assets/img/favicon.png') }}" />

<title id="page_title" data-page-title="@yield('title') | {{ env('APP_NAME') }}">@yield('title') | {{ env('APP_NAME') == '' ? 'EPIC ON' : env('APP_NAME') }}</title>

<link rel="canonical" href="{{ URL::current() }}"/>

<!-- HTML Meta Tags -->
<meta property="og:title" content="{{ $meta['title'] ?? getDefaultMetaTitle() }}">
<meta property="og:site_name" content="Epic On">
<meta property="og:url" content="{{ URL::current() }}">
<meta property="og:description"
    content="{{ htmlspecialchars_decode(@$meta['description'] ?? 'Watch Indian and Hollywood movies & TV shows online at Epic On, India\'s premier OTT platform in India. With a wide selection of new and classic shows and Movies.') }}">
<meta property="og:type" content="website">
<meta property="og:image" content="{{ $meta['image'] ?? url('/img/epiconlogo.png') }}">
<!------------------------>

<!-- Facebook Meta Tags -->
<meta property="og:url" content="{{ URL::current() }}">
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $meta['title'] ?? getDefaultMetaTitle() }}">
<meta property="og:description"
    content="{{ $meta['description'] ?? 'Watch Indian and Hollywood movies & TV shows online at Epic On, India\'s premier OTT platform in India. With a wide selection of new and classic shows and Movies.' }}">
<meta property="og:image" content="{{ $meta['image'] ?? url('/img/epiconlogo.png') }}">
<!------------------------>


<!-- Twitter Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta property="twitter:domain" content="{{ URL::current() }}">
<meta property="twitter:url" content="{{ URL::current() }}">
<meta name="twitter:title" content="{{ $meta['title'] ?? getDefaultMetaTitle() }}">
<meta name="twitter:description"
    content="{{ $meta['description'] ?? 'Watch Indian and Hollywood movies & TV shows online at Epic On, India\'s premier OTT platform in India. With a wide selection of new and classic shows and Movies.' }}">
<meta name="twitter:image" content="{{ $meta['image'] ?? url('/img/epiconlogo.png') }}">
<!------------------------>