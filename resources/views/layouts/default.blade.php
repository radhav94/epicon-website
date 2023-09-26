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
    {{-- End header common styles --}}


    {{-- Start page specific styles --}}
    @yield('style')
    {{-- End page specific styles --}}

    <script type="text/javascript">
        var APP_URL = "{{ url('/') }}";
    </script>

</head>

<body>
    @include('layouts.header')

    @yield('content')

    @include('layouts.footer')

    <style>
        .add-icon {
            background-image: url("{{ asset('assets/img/add-icon.svg') }}") !important;
        }

        .delete-icon {
            background-image: url("{{ asset('assets/img/subs-icon.svg') }}") !important;
        }

        .search-main .add-icon {
            background: center no-repeat #272727;
            border: 0.5px solid #545454;
            border-radius: 50%;
            padding: 20px;
            margin: 12px 0 auto;
        }

        .search-main .delete-icon {
            background: center no-repeat #272727;
            border: 0.5px solid #545454;
            border-radius: 50%;
            padding: 20px;
            margin: 12px 0 auto;
        }

        .seeall-main-page .add-icon {
            background: center no-repeat #272727;
            border: 0.5px solid #545454;
            border-radius: 50%;
            padding: 20px;
            margin: 12px 0 auto;
        }

        .socialJS a {
            padding: 10px;
            font-size: 31px;
        }

        .genresexplore .card-body img {
            width: 100%;
        }

        .genere-fiesta-content img {
            height: 30px;
        }

        a.autowidth.catalog-showmore {
            font-size: 17px;
            font-weight: 500;
            color: #fff;
            width: 200px;
            height: 55px;
            line-height: 52px;
            border-radius: 32px;
            border: solid 2px transparent;
            background-image: linear-gradient(rgba(255, 255, 255, 0), rgba(255, 255, 255, 0)), linear-gradient(to top, #c15a2d, #c8265d);
            background-origin: border-box;
            background-clip: content-box, border-box;
            box-shadow: 2px 1000px 1px rgba(0, 0, 0, 0.6) inset;
            text-transform: uppercase;
            display: inline-block;
            padding: 0 25px;
            margin-top: 35px;
            transition: all linear 0.4s;
        }
    </style>

    {{-- Start footer common scripts --}}
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/swiper.js') }}"></script>
    <script src="{{ asset('assets/js/spiner.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"
        integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>



    <script src="{{ asset('assets/js/epic.js') }}"></script>
    {{-- End footer common scripts --}}



    {{-- Start page specific scripts --}}
    @yield('script')
    {{-- End page specific scripts --}}

    @notloggedin
        @include('components.login-reg-js')
    @endnotloggedin

    <script>
        $(document).ready(function() {
            $('.logout').click(function() {
                sendAjaxRequest('{{ route('logout') }}', 'POST', [],
                    onSuccess, onError);
            });
        });
    </script>
</body>

</html>
