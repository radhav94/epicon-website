<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    @include('layouts.metadata')


    {{-- Start header common styles --}}
    <link rel="stylesheet" href="{{ asset('/css/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/toastr.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery-ui.css') }}">
    {{-- End header common styles --}}


    {{-- Start page specific styles --}}
    @yield('style')
    {{-- End page specific styles --}}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "hj6mot5z97");
    </script>
    
    <script type="text/javascript">
        var APP_URL = "{{ url('/') }}";
    </script>

    {{-- Start footer common scripts --}}
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-ui.js') }}" defer></script>
    <script src="{{ asset('assets/js/custom.js') }}?v={{ assetTime() }}" defer></script>
    <script src="{{ asset('assets/js/swiper.js') }}" defer></script>
    <script src="{{ asset('assets/js/spiner.js') }}" defer></script>
    <script src="{{ asset('assets/js/slick.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/script.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor/toastr.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/epic.js') }}" defer></script>
    <script src="{{ asset('assets/js/common.js') }}?v={{ assetTime() }}" defer></script>
    {{-- End footer common scripts --}}
</head>

<body>
    @include('layouts.header')

    @yield('content')

    @include('layouts.footer')

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
