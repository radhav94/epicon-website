@extends('layouts.default')
@section('title', 'Add Profile')

@section('style')

@stop

@section('content')


    <section class="container-fluid w-100 my-4">
        <div class="row justify-content-center">
            <div class="col-sm-4 col-md-6 col-lg-4">

                <form method="POST" action="{{ getUrlWithPrefix('profile.store') }}" id="profileAdd" autocomplete="off">

                    <div class="add-profile">
                        <div class="login-title">
                            <a href="{{ getUrlWithPrefix('profile.index') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M26.3359 15.9987C26.3359 16.551 25.8882 16.9987 25.3359 16.9987L6.66927 16.9987C6.11699 16.9987 5.66927 16.551 5.66927 15.9987C5.66927 15.4464 6.11699 14.9987 6.66927 14.9987L25.3359 14.9987C25.8882 14.9987 26.3359 15.4464 26.3359 15.9987Z"
                                        fill="white" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M16.7097 26.0391C16.3192 26.4297 15.686 26.4297 15.2955 26.0391L5.96217 16.7058C5.57164 16.3153 5.57164 15.6821 5.96217 15.2916L15.2955 5.95826C15.686 5.56773 16.3192 5.56773 16.7097 5.95826C17.1002 6.34878 17.1002 6.98195 16.7097 7.37247L8.08349 15.9987L16.7097 24.6249C17.1002 25.0154 17.1002 25.6486 16.7097 26.0391Z"
                                        fill="white" />
                                </svg>
                            </a>
                            <h5 class="w-100 text-white text-center mb-0" style="margin-left: -32px;">{{__('Add Profile')}}</h5>
                        </div>
                        <?php
                        
                        $gender = @$data['result']['user_data']['gender'] ?? 'Male';
                        $profile_img = $gender == 'Female' ? asset('assets/img/edit-profile-pik.png') : asset('assets/img/profile-boy.png');
                        ?>

                        <div class="add-propik" style="background-image: url({{ $profile_img }});" id="add-propik">
                            <a for='imgupload' href="#" onclick="$('#imgupload').trigger('click'); return false;">
                                <img src="{{ asset('assets/img/mn-edit-icon.png') }}" alt="">
                            </a>

                            <input class="form-control" type="file" name="profile_img" accept="image/*" id="imgupload"
                                style="display: none">
                        </div>

                        <div class="input-field w-100 mb-3">
                            <label for="exampleDataList" class="form-label text-white">{{__('Your Name')}}</label>
                            <input class="form-control" id="exampleDataList" name="name">
                            <button class="x emptyText">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path d="M6 18L18 6" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M18 18L6 6" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                        <div class="input-field w-100 mb-3">
                            <label for="exampleDataList" class="form-label text-white">{{__('Date of Birth')}}</label>
                            <input class="form-control" type="date" id="exampleDataList" name="dob">
                        </div>

                        @if ( @$data['result']['user_data']['kidSection'] == false)
                            <div
                                class="input-field sel-bor justify-content-between align-items-center w-100 mb-3 setpinWrapper">
                                <label for="exampleDataList" class="form-label text-white mb-0" style="font-size: 14px;">
                                    {{__('Set Child PIN')}}</label>
                                <button class="setchildpin" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                    type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.7196 0.493211C0.999494 0.187872 1.47392 0.167245 1.77926 0.447139L7.2338 5.44714C7.38878 5.5892 7.47701 5.78977 7.47701 6C7.47701 6.21023 7.38878 6.41081 7.2338 6.55287L1.77926 11.5529C1.47392 11.8328 0.999494 11.8121 0.7196 11.5068C0.439705 11.2015 0.460333 10.727 0.765672 10.4471L5.61709 6L0.765672 1.55287C0.460333 1.27298 0.439705 0.79855 0.7196 0.493211Z"
                                            fill="white" />
                                    </svg>
                                </button>
                            </div>
                        @endif

                        <button class="login-btn">
                            {{__('Create Profile')}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                                    fill="#070707" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z"
                                    fill="#070707" />
                            </svg>
                        </button>

                    </div>

                </form>
            </div>
        </div>

    </section>

    @if ( @$profile['kidSection'] == false )
        @include('components.setpin-modal')
    @endif

@stop

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <script src="{{ asset('assets/js/profile.js') }}"></script>

@stop
