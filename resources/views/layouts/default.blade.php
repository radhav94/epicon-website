<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.metadata')
    {{-- Start header common styles --}}
    <link rel="stylesheet" href="{{ asset('/css/style.min.css') }}?v={{ assetTime() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/toastr.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery-ui.min.css') }}">
    {{-- End header common styles --}}
    <script src="{{ asset('assets/js/jquery.js') }}"></script>

    {{-- Start page specific styles --}}
    @yield('style')
    {{-- End page specific styles --}}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-PS5WQPB');</script>
    <!-- End Google Tag Manager -->

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8JER642T3Z"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-8JER642T3Z');
    </script>

    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '214297036562265');
      fbq('track', 'PageView');
    </script>

    <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
            t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
            y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        })(window, document, "clarity", "script", "jqtnythpnn");
    </script>

    <script>
        var APP_URL = "{{ url('/') }}";
    </script>


    <script>
        var title = "<?php echo isset($metadata['title'])? $metadata['title'] : 'EPIC ON ' ?>";
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            'client_ga_id': '374718823',
            'content_type': title,
            'platform_type': 'web',
            'environment': 'develop',
        });
    </script> 
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','G-8JER642T3Z');
    </script>
    <!-- Schema Code Start -->
    @include('layouts.schema')
    <!-- Schema Code END -->
    
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PS5WQPB" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    @include('layouts.header')

    @yield('content')

    @include('layouts.footer')

    {{-- Start footer common scripts --}}
    <script src="{{ asset('assets/js/vendor/jquery-ui.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/ga_tag.js') }}?v={{ assetTime() }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}?v={{ assetTime() }}" defer></script>
    <script src="{{ asset('assets/js/swiper.js') }}" defer></script>
    <script src="{{ asset('assets/js/spiner.js') }}" defer></script>
    <script src="{{ asset('assets/js/slick.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/script.js') }}?v={{ assetTime() }}" defer></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor/toastr.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/epic.js') }}?v={{ assetTime() }}" defer></script>
    <script src="{{ asset('assets/js/common.js') }}?v={{ assetTime() }}" defer></script>
    
    {{-- End footer common scripts --}}

    @if(request()->get('type') == 'register')
        @include('auth.after-register-popup')
    @endif


    {{-- Start page specific scripts --}}
    @yield('script')
    {{-- End page specific scripts --}}

    @notloggedin
        @include('auth.login-reg-js')
    @endnotloggedin

    @if (session()->has('kidsMode') && session()->get('kidsMode'))
        @include('kids.child-pin-popup')
    @endif

    <script>
        $(document).ready(function() {
            $('.logout').click(function() {
                sendAjaxRequest('{{ route('logout') }}', 'POST', [],
                    onSuccess, onError);
            });
        });
        if (!localStorage.getItem('deviceId')) {
          storedDeviceId = generateDeviceId();
          localStorage.setItem('deviceId', storedDeviceId);
        }

        function generateDeviceId() {
          // Use a combination of available information
          var navigatorInfo = [
            navigator.userAgent,
            navigator.language,
            navigator.platform,
            screen.width,
            screen.height,
            new Date().getTimezoneOffset(),
          ];

          // Combine and hash the information to create a unique identifier
          var deviceId = JSON.stringify(navigatorInfo);
          deviceId = btoa(deviceId);

          return deviceId;
        }
    </script>
</body>
</html>