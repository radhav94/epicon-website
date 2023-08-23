<!DOCTYPE html>
<html lang="en">

<head>

    @include('layouts.metadata')


    {{-- Start header common styles --}}
    <link rel="stylesheet" href="{{asset('assets/css/style.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/slick.min.css')}}"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    {{-- End header common styles --}}


    {{-- Start page specific styles --}}
    @yield('style')
    {{-- End page specific styles --}}

    <script type="text/javascript">
        var APP_URL = "{{ url('/')}}";
    </script>

</head>

<body >
    @include('layouts.header')

    @yield('content')

    @include('layouts.footer')
    

    {{-- Start footer common scripts --}}
    <script src="{{asset('assets/js/jquery.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <script src="{{asset('assets/js/swiper.js')}}"></script>
    <script src="{{asset('assets/js/slick.min.js')}}"></script>
    <script src="{{asset('assets/js/spiner.js')}}"></script>
    <script src="{{asset('assets/js/script.js')}}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    {{-- End footer common scripts --}}



    {{-- Start page specific scripts --}}
    @yield('script')
    {{-- End page specific scripts --}}

</body>

</html>