@extends('layouts.default')
@section('title', 'Edit Profile')

@section('style')

@stop

@section('content')


    <section class="container-fluid w-100 my-4">
        <div class="row justify-content-center">
            <div class="col-sm-4 col-md-6 col-lg-4">

                <form method="POST" action="{{ route('profile.update') }}" id="profileUpdate" autocomplete="off">
                    <input type="hidden" name="profile_id" value="{{ $profile['id'] }}" id="profile_id">
                    <div class="add-profile">
                        <div class="login-title">
                            <a href="{{ route('profile.index') }}">
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
                            <h5 class="w-100 text-white text-center mb-0" style="margin-left: -32px;">Edit Profile</h5>
                        </div>
                        <div class="add-propik">
                            <a href=""><img src="{{ asset('assets/img/mn-edit-icon.png') }}" alt=""></a>
                        </div>

                        <div class="input-field w-100 mb-3">
                            <label for="exampleDataList" class="form-label text-white">Profile</label>
                            <input class="form-control" type="file" name="profile_img" accept="image/*">

                            @if (@$profile['profile_img'])
                                <img src="{{ $profile['profile_img'] }}">
                                <input type="text" value="{{ $profile['profile_img'] }}" name="old_profile_img">
                            @endif
                        </div>

                        <div class="input-field w-100 mb-3">
                            <label for="exampleDataList" class="form-label text-white">Your Name</label>
                            <input class="form-control" id="exampleDataList" name="name"
                                value="{{ $profile['name'] ?? '' }}">
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
                            <label for="exampleDataList" class="form-label text-white">Date of Birth</label>
                            <input class="form-control" type="date" id="exampleDataList" name="dob"
                                value="{{ $profile['date_of_birth'] ?? '' }}">
                        </div>

                        <button class="login-btn" type="submit">
                            Update
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
                        <button class="login-btn bg-transparent mt-0 text-white" type="button" id="delete_profile">Delete
                            Profile</button>

                    </div>
                </form>
            </div>
        </div>

    </section>

    @include('components.setpin-modal')



@stop

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.emptyText').click(function() {
                $(this).parents('.input-field').find('input').val('');
            });

            $("#profileUpdate").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    dob: {
                        required: true,
                        date: true
                    },
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent(".input-field"));
                },
                submitHandler: function(form) {

                    sendAjaxRequest($(form).attr('action'), 'POST', new FormData(form),
                        onSuccess, onError);

                }
            });

            $('#delete_profile').click(function() {
                if (confirm("Are you sure you want to proceed with the action?")) {
                    sendAjaxRequest('{{ route('profile.destroy', $profile['id']) }}', 'POST', [],
                        onSuccess, onError);
                }
            });
        });
    </script>
@stop
