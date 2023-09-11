<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {

        $('.login').click(function() {
            $('.screen-verify,.screen-register,.screen-sucess-register,.screen-login-with-pwd,.screen-sucess-logged,.screen-forgot-pwd,.screen-forgot-otp,.screen-set-pwd')
                .hide();
            $('#login-modal').show();
            $('#login-modal').addClass("show");
        });

        $(".closebtn").click(function() {
            $('#login-modal').hide();
            $('#login-modal').removeClass("show");
        });

        $(".eye-toggle").click(function() {
            var targetId = $(this).data("target");
            var inputField = $("#" + targetId);
            var isPasswordType = inputField.attr('type') === 'password';

            if (isPasswordType) {
                inputField.attr('type', 'text');
                $(this).find('.eye-close-' + targetId).css('display', 'none');
                $(this).find('.eye-open-' + targetId).css('display', 'block');
            } else {
                inputField.attr('type', 'password');
                $(this).find('.eye-open-' + targetId).css('display', 'none');
                $(this).find('.eye-close-' + targetId).css('display', 'block');
            }
        });

        $(".login-btn-otp").click(function(e) {
            e.preventDefault();
            $('.screen-login,.left-side,.right-side').show();
            $('.screen-verify,.screen-register,.screen-sucess-register,.screen-login-with-pwd,.screen-sucess-logged,.screen-forgot-pwd,.screen-forgot-otp,.screen-set-pwd')
                .hide();
        });

        $(".login-get-otp").click(function(e) {
            e.preventDefault();
            var isInput = $("#mobile_number").val();
            var type = $.isNumeric(isInput);
            if (type == true) {
                $("#signup_method").val('MOBILE');
            } else {
                $("#signup_method").val('EMAIL');
            }

            if (isValidContact(isInput) == true) {

                var formData = $('#mobile-number-form-id').serialize();

                $.ajax({
                    // url: APP_URL+'/sendotp',
                    url: '{{ route('sendotp') }}',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // console.log(response.payload.user_id+'success me aaya');
                        var mobile = response.payload.user_id;
                        $('.mobileno').html(mobile);
                        $("#user_id").val(response.payload.user_id);
                        $("#signupmethod").val(response.payload.user_signup_method);
                        $('.screen-login,.screen-register,.screen-sucess-register,.screen-login-with-pwd,.screen-sucess-logged,.screen-forgot-pwd,.screen-forgot-otp,.screen-set-pwd')
                            .hide();
                        $('.screen-verify').show();
                        resendOTP();
                        // var response = JSON.parse(response);
                        // $('#dynamic-content').html(response.content);
                    },
                    error: function(xhr, status, error) {
                        console.log('in error');
                    }
                });
            } else {
                return isValidContact(isInput);
            }
        });

        $("#resendBtn").click(function(e) {
            e.preventDefault();
            var formData = $('#mobile-number-form-id').serialize();
            $.ajax({
                // url: APP_URL+'/sendotp',
                url: '{{ route('sendotp') }}',
                type: 'POST',
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    // console.log(response.payload.user_id+'success me aaya');
                    var mobile = response.payload.user_id;
                    $('.mobileno').html(mobile);
                    $("#user_id").val(response.payload.user_id);
                    $("#signupmethod").val(response.payload.user_signup_method);
                    $('.screen-login,.screen-register,.screen-sucess-register,.screen-login-with-pwd,.screen-sucess-logged,.screen-forgot-pwd,.screen-forgot-otp,.screen-set-pwd')
                        .hide();
                    $('.screen-verify').show();
                    // var response = JSON.parse(response);
                    // $('#dynamic-content').html(response.content);
                },
                error: function(xhr, status, error) {
                    console.log('error me aaya');
                }
            });
            resendOTP();
        });

        function resendOTP() {
            // alert("resend btn");
            // Disable the resend button
            $('#resendBtn').prop('disabled', true);

            // Set a countdown of 30 seconds
            var countdown = 30;
            var countdownDiv = $('.resend-otp');

            var interval = setInterval(function() {
                countdownDiv.text('Resend OTP in ' + countdown + ' seconds');
                countdown--;

                if (countdown < 0) {
                    clearInterval(interval);
                    countdownDiv.text('');
                    // $('.child-box').val('');
                    $('#resendBtn').prop('disabled', false);
                }
            }, 1000);
        }


        $(".forgot-otp-btn").click(function(e) {
            e.preventDefault();
            var isInput = $("#forgot-name").val();
            var type = $.isNumeric(isInput);
            // alert(type);
            if (type == true) {
                $("#signin_method").val('MOBILE');
            } else {
                $("#signin_method").val('EMAIL');
            }

            if (isValidContact(isInput) == true) {

                var formData = $('#forgot-pwd-form-id').serialize();
                // alert(formData);
                $.ajax({
                    url: '{{ route('sendforgototp') }}',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // console.log(response.payload.user_id+'success me aaya');
                        var mobile = response.payload.user_id;
                        $('.mobile_no').html(mobile);
                        $("#userid_no").val(response.payload.user_id);
                        $("#usersignupmethod").val(response.payload.user_signup_method);
                        $('.screen-login,.screen-verify,.screen-register,.screen-sucess-register,.screen-login-with-pwd,.screen-sucess-logged,.screen-forgot-pwd,.screen-set-pwd')
                            .hide();
                        $('.left-side,.right-side').show();
                        if (response.payload.success == true) {
                            $('.screen-forgot-otp').show();
                            resendForgotOTP();
                        } else {
                            $('#forgot-otp-result').html(response.payload.response
                                .meassage);
                        }
                    },
                    error: function(xhr, status, error) {}
                });
            } else {
                return isValidContact(isInput);
            }
        });

        $("#resendForgotBtn").click(function(e) {
            e.preventDefault();
            var formData = $('#forgot-pwd-form-id').serialize();
            $.ajax({
                url: '{{ route('sendforgototp') }}',
                type: 'POST',
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    // console.log(response.payload.user_id+'success me aaya');
                    var mobile = response.payload.user_id;
                    $('.mobile_no').html(mobile);
                    $("#userid_no").val(response.payload.user_id);
                    $("#usersignupmethod").val(response.payload.user_signup_method);
                    $('.screen-login,.screen-verify,.screen-register,.screen-sucess-register,.screen-login-with-pwd,.screen-sucess-logged,.screen-forgot-pwd,.screen-set-pwd')
                        .hide();
                    $('.left-side,.right-side').show();
                    if (response.payload.success == true) {
                        $('.screen-forgot-otp').show();
                    } else {
                        $('#forgot-otp-result').html(response.payload.response.meassage);
                    }
                },
                error: function(xhr, status, error) {}
            });
            resendForgotOTP();
        });

        function resendForgotOTP() {
            // alert("resend btn");
            // Disable the resend button
            $('#resendForgotBtn').prop('disabled', true);

            // Set a countdown of 30 seconds
            var countdown = 30;
            var countdownDiv = $('.resend-forgot-otp');

            var interval = setInterval(function() {
                countdownDiv.text('Resend OTP in ' + countdown + ' seconds');
                countdown--;

                if (countdown < 0) {
                    clearInterval(interval);
                    countdownDiv.text('');
                    // $('.child-box').val('');
                    $('#resendForgotBtn').prop('disabled', false);
                }
            }, 1000);
        }

        $('.child-box,.child-box1').on('input', function() {
            var inputValue = $(this).val();
            var sanitizedValue = inputValue.replace(/\D/g, ''); // Remove non-digit characters

            if (sanitizedValue.length > 1) {
                sanitizedValue = sanitizedValue.slice(0, 1); // Keep only the first digit
            }

            $(this).val(sanitizedValue);
            updateValidationResult();
        });

        function updateValidationResult() {
            var combinedValue = $('.child-box').map(function() {
                return $(this).val();
            }).get().join('');
            // console.log(combinedValue+"combinedValue");
            $("#otp_pin").val(combinedValue);
            // $('#validation-result').text('Combined value: ' + combinedValue);
            var combinedallValue = $('.child-box1').map(function() {
                return $(this).val();
            }).get().join('');

            $("#otppin").val(combinedallValue);
        }

        $('.verify-btn').click(function(e) {
            // alert("true");
            e.preventDefault();
            var mobile = $("#user_id").val();
            var signup_method = $("#signupmethod").val();
            var user_agent = $("#user_agent").val();
            var otp_pin = $("#otp_pin").val();
            var valid = true;
            $('.child-box').each(function() {
                if ($(this).val() === '') {
                    valid = false;
                    return false; // Exit the loop early if an invalid input is found
                }
            });
            if (valid) {
                $('#validation-result').text('');
            } else {
                $('#validation-result').text('Please fill in all input boxes.');
            }

            if (otp_pin != '') {

                var formData = $('#verify-number-form-id').serialize();
                // alert(formData);
                $.ajax({
                    url: '{{ route('verifyotp') }}',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // alert(response);
                        if (response.payload.success == true) {
                            $('#verifyotp-result').html('');
                            $("#userid").val(response.payload.user_id);
                            $("#sign_method").val(response.payload.user_signup_method);
                            $('.screen-login,.screen-verify,.screen-sucess-register,.screen-sucess-logged,.screen-forgot-pwd,.screen-forgot-otp,.screen-set-pwd')
                                .hide();
                            if (response.payload.response.is_verified == false) {
                                $('.screen-register').show();
                                $('.screen-login-with-pwd').hide();
                            } else {
                                $('.modal-content').hide();
                                // location.reload(true);
                            }
                            // alert("true resp");
                        } else {
                            $('#verifyotp-result').html(response.payload.response.message);
                            // $('#verifyotp-result').html('Incorrect code entered. Please try again.');
                            // return false;
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('error me aaya');
                    }
                });
            } else {
                return false;
            }
        });

        $('.register-btn').click(function(e) {
            e.preventDefault();
            // Clear previous errors
            $('.error').text('');
            // Validate Name
            var name = $('#name').val();
            if (name.trim() === '') {
                $('#name-error').text('Name is required');
            }

            // Validate Password
            var password = $('#password').val();
            if (password.trim() === '') {
                $('#password-error').text('Password is required');
            }

            // Validate Confirm Password
            var confirmPassword = $('#confirm-password').val();
            if (confirmPassword.trim() === '') {
                $('#confirm-password-error').text('Confirm password is required');
            } else if (confirmPassword !== password) {
                $('#confirm-password-error').text('Passwords do not match');
            }

            var formData = $('#register-form-id').serialize();
            // alert(formData);
            if (name != '' && password != '' && confirmPassword != '') {
                $.ajax({
                    url: '{{ route('register') }}',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // alert(response);
                        if (response.payload.success == true) {
                            // $('#register-result').html('');
                            $("#username").text(response.payload.name);
                            // $("#sign_method").val(response.payload.user_signup_method);
                            $('.screen-login,.screen-verify,.screen-register,.left-side,.right-side,.screen-login-with-pwd,.screen-sucess-logged,.screen-forgot-pwd,.screen-forgot-otp,.screen-set-pwd')
                                .hide();
                            $('.screen-sucess-register').show();
                        } else {
                            $('#register-result').html(response.payload.response.message);
                            // return false;
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('error me aaya');
                    }
                });
            } else {
                return false;
            }
        });

        $('.login-btn-pwd').click(function(e) {
            e.preventDefault();
            // alert("btn clicked");
            $('.screen-login,.screen-verify,.screen-register,.screen-sucess-register,.screen-sucess-logged,.screen-forgot-pwd,.screen-forgot-otp,.screen-set-pwd')
                .hide();
            $('.left-side,.right-side,.screen-login-with-pwd').show();
        });

        $('.forgot-pwd-btn').click(function(e) {
            e.preventDefault();
            // alert("btn clicked");
            $('.screen-login,.screen-verify,.screen-register,.screen-sucess-register,.screen-login-with-pwd,.screen-sucess-logged,.screen-forgot-otp,.screen-set-pwd')
                .hide();
            $('.left-side,.right-side,.screen-forgot-pwd').show();
        });

        $('.continue-login-btn').click(function(e) {
            e.preventDefault();
            // Clear previous errors
            $('.error').text('');
            // Validate Name
            var name = $('#mobilenumber').val();
            if (name.trim() === '') {
                $('#mobile-error').text('Name is required');
            }

            // Validate Password
            var password = $('#login_pwd').val();
            if (password.trim() === '') {
                $('#login-pwd-error').text('Password is required');
            }

            if ($('input[id="customCheck"]').is(':checked') == true) {
                $("#customCheck").val(true);
            } else {
                $("#customCheck").val(false);
            }

            var formData = $('#login-form-id').serialize();
            // alert(formData);
            if (name != '' && password != '') {
                $.ajax({
                    url: '{{ route('loginwithpwd') }}',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // alert(response);
                        if (response.payload.success == true) {
                            // $('#register-result').html('');
                            // $("#username").text(response.payload.name);
                            // $("#sign_method").val(response.payload.user_signup_method);
                            $('.screen-login,.screen-verify,.screen-register,.left-side,.right-side,.screen-sucess-register,.screen-login-with-pwd,.screen-forgot-pwd,.screen-forgot-otp,.screen-set-pwd')
                                .hide();
                            $('.screen-sucess-logged').show();
                            window.location.href = 'http://local.epicon-revampv2-site.com/';
                        } else {
                            $('#login-result').html(response.payload.response.message);
                            // return false;
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('error me aaya');
                    }
                });
            } else {
                return false;
            }
        });

        $('.verify-forgot-btn').click(function(e) {
            // alert("true");
            e.preventDefault();
            var mobile = $("#userid_no").val();
            var signup_method = $("#usersignupmethod").val();
            // var user_agent = $("#user_agent").val();
            var otp_pin = $("#otppin").val();
            var valid = true;
            $('.child-box1').each(function() {
                if ($(this).val() === '') {
                    valid = false;
                    return false; // Exit the loop early if an invalid input is found
                }
            });
            if (valid) {
                $('#validation-forgot-result').text('');
            } else {
                $('#validation-forgot-result').text('Please fill in all input boxes.');
            }

            if (otp_pin != '') {

                var formData = $('#verify-forgot-number-form-id').serialize();
                // alert(formData);
                $.ajax({
                    url: '{{ route('verifyforgototp') }}',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // alert(response);
                        if (response.payload.success == true) {
                            $("#userid_detail").val(response.payload.user_id);
                            $("#user_sign_method").val(response.payload.user_signup_method);
                            $('.screen-login,.screen-verify,.screen-register,.screen-login-with-pwd,.screen-sucess-logged,.screen-forgot-pwd,.screen-forgot-otp')
                                .hide();
                            $('.left-side,.right-side,.screen-set-pwd').show();
                        } else {
                            $('#verifyotp-forgot-result').html(
                                'Incorrect code entered. Please try again.');
                            // return false;
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('error me aaya');
                    }
                });
            } else {
                return false;
            }
        });

        $('.reset-pwd-btn').click(function(e) {
            // alert("true");
            e.preventDefault();
            var user_id = $("#userid_detail").val();
            var signup_method = $("#user_sign_method").val();
            // var user_agent = $("#user_agent").val();
            var set_password = $("#set-password").val();
            var reenter_password = $("#reenter-password").val();

            // Validate Password
            if (set_password.trim() === '') {
                $('#setpassword-error').text('Set Password is required');
            }

            // Validate Confirm Password
            if (reenter_password.trim() === '') {
                $('#reenter-password-error').text('Re-enter password is required');
            } else if (reenter_password !== set_password) {
                $('#reenter-password-error').text('Passwords do not match');
            }

            if (set_password != '' && reenter_password != '' && set_password == reenter_password) {

                var formData = $('#set-password-form-id').serialize();
                // alert("login sucess");
                $.ajax({
                    url: '{{ route('resetpwdapi') }}',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // alert(response);
                        if (response.payload.success == true) {
                            // $('#verifyotp-result').html('');
                            // $("#userid_no").val(response.payload.user_id);
                            // $("#usersignupmethod").val(response.payload.user_signup_method);
                            $('.screen-login,.screen-verify,.screen-register,.screen-sucess-register,.screen-login-with-pwd,.screen-sucess-logged,.screen-forgot-pwd,.screen-forgot-otp,.screen-set-pwd,.modal-content')
                                .hide();
                            // location.reload(true);
                        } else {
                            $('#reset-forgot-result').html(response.payload.response
                                .message);
                            // return false;
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('error me aaya');
                    }
                });
            } else {
                return false;
            }
        });

    });
</script>
