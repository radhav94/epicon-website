<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    @include('layouts.metadata')


    {{-- Start header common styles --}}
    <link rel="stylesheet" href="{{ asset('/css/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css"
        integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    {{-- End header common styles --}}


    {{-- Start page specific styles --}}
    @yield('style')
    {{-- End page specific styles --}}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
   <!-- old ga tag manager -->
    <!-- <script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "hj6mot5z97");
    </script> -->
    
    <script type="text/javascript">
        var APP_URL = "{{ url('/') }}";
    </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8JER642T3Z"></script> 
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
</head>

<body>
    @include('layouts.header')

    @yield('content')

    @include('layouts.footer')

    {{-- Start footer common scripts --}}
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}?v={{ assetTime() }}"></script>
    <script src="{{ asset('assets/js/swiper.js') }}"></script>
    <script src="{{ asset('assets/js/spiner.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/toastr.min.js') }}"></script>

    <script src="{{ asset('assets/js/epic.js') }}"></script>
    <script src="{{ asset('assets/js/common.js') }}?v={{ assetTime() }}"></script>
    <script src="{{ asset('assets/js/ga_tag.js') }}?v={{ assetTime() }}"></script>
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
