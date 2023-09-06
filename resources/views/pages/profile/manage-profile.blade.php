@extends('layouts.default')
@section('title', 'Manage Profile')

@section('style')

@stop

@section('content')

    <section class="w-100 mt-5">
        <h4 class="w-100 text-white text-center">Manage Profiles</h4>
        @if ($profiles)
            <div class="manage-profile">
                <ul class="list-unstyled m-0 p-0">
                    @foreach ($profiles as $key => $value)
                        <li>
                            <a href="{{ route('profile.edit', $value['id']) }}">
                                <img src="{{ asset('assets/img/mn-girl-bg.png') }}" alt="img">
                                <span><img src="{{ asset('assets/img/mn-edit-icon.png') }}" alt="icon"></span>
                            </a>
                            <p class="mt-2">{{ ucfirst(@$value['name']) }}</p>
                        </li>
                    @endforeach

                    @if (count($profiles) < 5)
                        <li>
                            <a href="{{ route('profile.add') }}">
                                <img src="{{ asset('assets/img/mn-add.png') }}" alt="img">
                            </a>
                        </li>
                    @endif
                </ul>
                <button class="custom-btn mt-4">Done</button>
            </div>
        @else
            <h2>No data found</h2>
        @endif

    </section>



@stop

@section('script')
    <script>
        $(document).ready(function() {

        });
    </script>
@stop
