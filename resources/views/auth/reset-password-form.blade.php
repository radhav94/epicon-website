@extends('layouts.default')
@section('title','My Rewards')

@section('style')

@stop

@section('content')

<section class="container w-100 my-4">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="signup-bg">
                <div class="container center-spacing">
                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <div class="login-popup-modal screen-set-pwd">
                                <form method="post" name="restpasswordform" id="resetpasswordformid" action="{{url('/setResetPassword')}}">
                                    <h5 class="mb-4 text-white"> Reset Password</h5>
                                    <input type="hidden" name="hash" value="{{ $hash }}">
                                    <div class="input-field w-100 mb-3">
                                        <input class="form-control" type="password" id="reset-password" name="set-password" placeholder="Enter New Password">
                                        <div class="eye-toggle" data-target="reset-password">
                                            <a class="eye eye-open-set-password" style="display:none;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16" viewBox="0 0 22 16" fill="none">
                                                    <path d="M11 5C10.2044 5 9.44129 5.31607 8.87868 5.87868C8.31607 6.44129 8 7.20435 8 8C8 8.79565 8.31607 9.55871 8.87868 10.1213C9.44129 10.6839 10.2044 11 11 11C11.7956 11 12.5587 10.6839 13.1213 10.1213C13.6839 9.55871 14 8.79565 14 8C14 7.20435 13.6839 6.44129 13.1213 5.87868C12.5587 5.31607 11.7956 5 11 5ZM11 13C9.67392 13 8.40215 12.4732 7.46447 11.5355C6.52678 10.5979 6 9.32608 6 8C6 6.67392 6.52678 5.40215 7.46447 4.46447C8.40215 3.52678 9.67392 3 11 3C12.3261 3 13.5979 3.52678 14.5355 4.46447C15.4732 5.40215 16 6.67392 16 8C16 9.32608 15.4732 10.5979 14.5355 11.5355C13.5979 12.4732 12.3261 13 11 13ZM11 0.5C6 0.5 1.73 3.61 0 8C1.73 12.39 6 15.5 11 15.5C16 15.5 20.27 12.39 22 8C20.27 3.61 16 0.5 11 0.5Z" fill="white" />
                                                </svg>
                                            </a>
                                            <a class="eye eye-close-set-password">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect x="19.4551" y="1.52148" width="2.08057" height="24.5396" transform="rotate(43.7003 19.4551 1.52148)" fill="white" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.9555 6.11126C16.2071 5.08712 14.1725 4.5 12 4.5C7 4.5 2.73 7.61 1 12C2.03885 14.6362 3.99362 16.8108 6.47236 18.1276L8.72091 15.7746C8.63295 15.6982 8.5474 15.6185 8.46447 15.5355C7.52678 14.5979 7 13.3261 7 12C7 10.6739 7.52678 9.40215 8.46447 8.46447C9.40215 7.52678 10.6739 7 12 7C13.3261 7 14.5979 7.52678 15.5355 8.46447C15.5648 8.49369 15.5936 8.52324 15.622 8.5531L17.9555 6.11126ZM14.2376 10.0017C14.2001 9.95975 14.1613 9.91871 14.1213 9.87868C13.5587 9.31607 12.7956 9 12 9C11.2044 9 10.4413 9.31607 9.87868 9.87868C9.31607 10.4413 9 11.2044 9 12C9 12.7956 9.31607 13.5587 9.87868 14.1213C9.95102 14.1937 10.0267 14.2619 10.1053 14.326L14.2376 10.0017ZM12.2365 14.9907L14.9983 12.1006C14.9729 12.8597 14.6602 13.5825 14.1213 14.1213C13.6147 14.6279 12.9456 14.9346 12.2365 14.9907ZM10.528 16.7784C11.0006 16.924 11.4964 17 12 17C13.3261 17 14.5979 16.4732 15.5355 15.5355C16.4732 14.5979 17 13.3261 17 12C17 11.4194 16.899 10.8491 16.7067 10.3128L19.6065 7.27847C21.0968 8.53554 22.2728 10.1547 23 12C21.27 16.39 17 19.5 12 19.5C10.7619 19.5 9.5685 19.3093 8.44738 18.9557L10.528 16.7784Z" fill="white" />
                                                </svg>
                                            </a>
                                        </div>
                                        <span class="text-danger text-start d-flex mt-1 error setpassword-error" style="font-size: 12px;"></span>
                                    </div>
                                    <div class="input-field w-100 mb-3">
                                        <input class="form-control" type="password" id="reset-reenter-password" name="reenter-password" placeholder="Re-enter New Password">
                                        <div class="eye-toggle" data-target="reset-reenter-password">
                                            <a class="eye eye-open-reenter-password" style="display:none;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16" viewBox="0 0 22 16" fill="none">
                                                    <path d="M11 5C10.2044 5 9.44129 5.31607 8.87868 5.87868C8.31607 6.44129 8 7.20435 8 8C8 8.79565 8.31607 9.55871 8.87868 10.1213C9.44129 10.6839 10.2044 11 11 11C11.7956 11 12.5587 10.6839 13.1213 10.1213C13.6839 9.55871 14 8.79565 14 8C14 7.20435 13.6839 6.44129 13.1213 5.87868C12.5587 5.31607 11.7956 5 11 5ZM11 13C9.67392 13 8.40215 12.4732 7.46447 11.5355C6.52678 10.5979 6 9.32608 6 8C6 6.67392 6.52678 5.40215 7.46447 4.46447C8.40215 3.52678 9.67392 3 11 3C12.3261 3 13.5979 3.52678 14.5355 4.46447C15.4732 5.40215 16 6.67392 16 8C16 9.32608 15.4732 10.5979 14.5355 11.5355C13.5979 12.4732 12.3261 13 11 13ZM11 0.5C6 0.5 1.73 3.61 0 8C1.73 12.39 6 15.5 11 15.5C16 15.5 20.27 12.39 22 8C20.27 3.61 16 0.5 11 0.5Z" fill="white" />
                                                </svg>
                                            </a>
                                            <a class="eye eye-close-reenter-password">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect x="19.4551" y="1.52148" width="2.08057" height="24.5396" transform="rotate(43.7003 19.4551 1.52148)" fill="white" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.9555 6.11126C16.2071 5.08712 14.1725 4.5 12 4.5C7 4.5 2.73 7.61 1 12C2.03885 14.6362 3.99362 16.8108 6.47236 18.1276L8.72091 15.7746C8.63295 15.6982 8.5474 15.6185 8.46447 15.5355C7.52678 14.5979 7 13.3261 7 12C7 10.6739 7.52678 9.40215 8.46447 8.46447C9.40215 7.52678 10.6739 7 12 7C13.3261 7 14.5979 7.52678 15.5355 8.46447C15.5648 8.49369 15.5936 8.52324 15.622 8.5531L17.9555 6.11126ZM14.2376 10.0017C14.2001 9.95975 14.1613 9.91871 14.1213 9.87868C13.5587 9.31607 12.7956 9 12 9C11.2044 9 10.4413 9.31607 9.87868 9.87868C9.31607 10.4413 9 11.2044 9 12C9 12.7956 9.31607 13.5587 9.87868 14.1213C9.95102 14.1937 10.0267 14.2619 10.1053 14.326L14.2376 10.0017ZM12.2365 14.9907L14.9983 12.1006C14.9729 12.8597 14.6602 13.5825 14.1213 14.1213C13.6147 14.6279 12.9456 14.9346 12.2365 14.9907ZM10.528 16.7784C11.0006 16.924 11.4964 17 12 17C13.3261 17 14.5979 16.4732 15.5355 15.5355C16.4732 14.5979 17 13.3261 17 12C17 11.4194 16.899 10.8491 16.7067 10.3128L19.6065 7.27847C21.0968 8.53554 22.2728 10.1547 23 12C21.27 16.39 17 19.5 12 19.5C10.7619 19.5 9.5685 19.3093 8.44738 18.9557L10.528 16.7784Z" fill="white" />
                                                </svg>
                                            </a>
                                        </div>
                                        <span class="text-danger text-start d-flex mt-1 error reenter-password-error" style="font-size: 12px;"></span>
                                    </div>

                                    <div class="text-danger" id="reset-result" style="color: red;">
                                        <!-- Display validation result here -->
                                    </div>
                                    <button class="login-btn set-reset-pwd w-100 mt-5" type="button">
                                        Reset Password
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"></path>
                                        </svg>
                                    </button>
                                    <div class="reset-forgot-result error" style="color:red;"></div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@stop

@section('script')
<script>
    $(document).ready(function() {
        $(".set-reset-pwd").click(function(e) {
            e.preventDefault();
            var set_password = $("#reset-password").val();
            var reenter_password = $("#reset-reenter-password").val();

            // Validate Password
            if (set_password.trim() === '') {
                $('.setpassword-error').text('Set Password is required');
            } else {
                $('.setpassword-error').text(' ');
            }

            // Validate Confirm Password
            if (reenter_password.trim() === '') {
                $('.reenter-password-error').text('Re-enter password is required');
            } else if (reenter_password !== set_password) {
                $('.reenter-password-error').text('Passwords do not match');
            } else {
                $('.reenter-password-error').text(' ');
            }

            if (set_password != '' && reenter_password != '' && set_password == reenter_password) {
                var formData = $('#resetpasswordformid').serialize();
                $.ajax({
                    url: "{{ route('setResetPassword') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.payload.success == true) {
                            showToaster('password changed successfully.', 1);
                            setTimeout(function(){
                                window.location.href = "{{ getUrlWithPrefix('homepage') }}?type=login";
                            },1000);
                        } else {
                            $('.reset-forgot-result').html(response.payload.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('error me aaya');
                    }
                });
            }
        });
    });
</script>
@stop