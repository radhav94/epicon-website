<script src="{{ asset('assets/js/vendor/jquery.validate.min.js') }}"></script>
<script>
    var user_mob_email = '';
    var interval = "";
    $(document).ready(function() {
        $( ".date_picker" ).datepicker({
            dateFormat: 'MM dd, yy',
            maxDate: '-1d',
            changeMonth: true,
            changeYear: true,
            maxDate: "-1Y",
            minDate: "-100Y",
            yearRange: "-100:-1"
        });

        $(".emailText").on("keyup", function (e) {
            var t = $(this).val();
            $(".emailText").val(t);
            t.length >= 7 && Number.isInteger(+t)
                ? (
                    $(".stdisdcode").css({ display: "block" }),
                    $(".emailText").css({ "text-indent": "115px" }),
                    $(".signup_method").val('MOBILE')
                  )
                : (
                    $(".stdisdcode").css({ display: "none" }),
                    $(".emailText").css({ "text-indent": "0px" }),
                    $(".signup_method").val('EMAIL')
                );
        }),

        $('.login').click(function(event) {
            if (!event.isTrigger) {
                window.history.replaceState({}, document.title, "/" );
            }
            $('.login-popup-modal').hide();

            $('.left-side,.right-side,.screen-login-with-pwd').show();
            $('#login-modal').show();
            $('#login-modal').addClass("show");
            $(".child-box").val('');
            $(".text-danger").html('');

            $('.login-carousel').not('.slick-initialized').slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                dots: true,
                autoplay: true,
            });
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
            $('.login-popup-modal').hide();
            $('.screen-login,.left-side,.right-side').show();
        });

        $(".login-get-otp").click(function(e) {
            e.preventDefault();
            var isInput = $("#mobile_number").val();
            user_mob_email = isInput;

            if (isValidContact(isInput) == true) {

                var formData = $('#mobile-number-form-id').serialize();

                $.ajax({
                    // url: APP_URL+'/sendotp',
                    url: "{{ route('sendotp') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response.payload.success == true){
                        var mobile = hideMiddleCharacters(response.payload.user_id);
                        $('.mobileno').html(mobile);
                        $("#user_id").val(response.payload.user_id);
                        $("#signupmethod").val(response.payload.user_signup_method);
                        $('.login-popup-modal').hide();
                        $('.screen-verify').show();
                        resendOTP();
                        // var response = JSON.parse(response);
                        // $('#dynamic-content').html(response.content);
                        }else{
                            showToaster(response.payload.response.meassage, 2);
                        }
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
                url: "{{ route('sendotp') }}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.payload.success == true) {
                        // console.log(response.payload.user_id+'success me aaya');
                        var mobile = hideMiddleCharacters(response.payload.user_id);
                        $('.mobileno').html(mobile);
                        $("#user_id").val(response.payload.user_id);
                        $("#signupmethod").val(response.payload.user_signup_method);
                        $('.login-popup-modal').hide();
                        $('.screen-verify').show();
                        // var response = JSON.parse(response);
                        // $('#dynamic-content').html(response.content);
                    } else {
                        $("#verifyotp-result").html(response.payload.response.meassage);
                        clearInterval(interval);
                        $('#resendBtn').prop('disabled', true);
                    }
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
            $('.childpin-input .child-box').val('');
            // Set a countdown of 30 seconds
            var countdown = 30;
            var countdownDiv = $('.resend-otp');

            interval = setInterval(function() {
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
                    url: "{{ route('sendforgototp') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // console.log(response.payload.user_id+'success me aaya');
                        var mobile = hideMiddleCharacters(response.payload.user_id);
                        $('.mobile_no').html(mobile);
                        $("#userid_no").val(response.payload.user_id);
                        $("#usersignupmethod").val(response.payload.user_signup_method);
                        $('.login-popup-modal').hide();
                        $('.left-side,.right-side').show();
                        if (response.payload.success == true) {
                            $('.screen-forgot-otp').show();
                            resendForgotOTP();
                        } else {
                            $('.screen-forgot-pwd').show();
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
                url: "{{ route('sendforgototp') }}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // console.log(response.payload.user_id+'success me aaya');
                    var mobile = hideMiddleCharacters(response.payload.user_id);

                    $('.mobile_no').html(mobile);
                    $("#userid_no").val(response.payload.user_id);
                    $("#usersignupmethod").val(response.payload.user_signup_method);
                    $('.login-popup-modal').hide();
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

            interval = setInterval(function() {
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
            $('#verifyotp-result').html('');
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
                    url: "{{ route('verifyotp') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                            if (response.payload.success == true) {
                            login_success();
                            queryParams = new URLSearchParams(window.location.search);
                            $("#userid").val(response.payload.user_id);
                            $("#sign_method").val(response.payload.user_signup_method);
                            
                            if (response.payload.response.is_verified == false) {
                                $('.login-popup-modal').hide();
                                $('.screen-register').show();
                                $('.screen-login-with-pwd').hide();
                            } else {
                                if (queryParams.get('profile') == "kids") {
                                    window.location.href = $("input[name='kidsUrl']").val();
                                }else if(queryParams.get('ref') == "subscription"){

                                    if(response.payload.subplan_status == 'active'){
                                        var chekUrl = localStorage.getItem("redirectURL");
                                        if(chekUrl != "" && chekUrl !=null &&  chekUrl!=undefined){
                                               localStorage.removeItem("redirectURL");
                                               window.location.href = chekUrl;
                                               return false;
                                            }else{
                                                window.location.href = response.payload.redirect;
                                                return false;
                                            }
                                    }else{
                                        window.location.href = APP_URL+'/subscription';
                                        return false;
                                    }

                                }else if(queryParams.get('ref') == "rewards"){

                                    window.location.href = APP_URL+'/my-rewards'; 
                                }else {
                                    location.reload();
                                }
                                return false;
                            }
                            // alert("true resp");
                        } else {
                            login_failed();
                            $('#verifyotp-result').html(response.payload.response.message);
                            // $('#verifyotp-result').html('Incorrect code entered. Please try again.');
                            // return false;
                        }
                    },
                    error: function(xhr, status, error) {
                        login_failed();
                        console.log('error me aaya');
                    }
                });
            } else {
                login_failed();
                return false;
            }
        });

        $('.register-btn').click(function(e) {
            e.preventDefault();
            // getGenreList();
            // Clear previous errors
            $('.error').text('');
            // Validate Name
            var name = $('#name').val();
            if (name.trim() === '') {
                $('#name-error').text('Email or Mobile is required');
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

            var gender = $.trim($('#gender').val());
            if (gender == '') {
                $('#gender-error').text('Gender is required');
            }

            var formData = $('#register-form-id').serialize();
            // alert(formData);
            if (name != '' && password != '' && confirmPassword != '') {
                $.ajax({
                    url: "{{ route('register') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // alert(response);
                        if (response.payload.success == true) {
                            registration_success();
                            // $('#register-result').html('');
                            $("#username").text(response.payload.name);
                            // $("#sign_method").val(response.payload.user_signup_method);
                            // $('.login-popup-modal').hide();
                            // $('.screen-sucess-register').show();
                            // $("#interestsSuggestions input[name='user_token']").val(response.payload.user_token);
                            // $('.left-side, .login-popup-modal').hide();
                            $('.left-side, .right-side').hide();
                            $('.screen-sucess-register').show();
                            setTimeout(function(){
                                window.location.href = "?type=register";
                            },1000);
                        } else {
                            registration_failed();
                            $('#register-result').html(response.payload.response.message);
                            return false;
                        }
                    },
                    error: function(xhr, status, error) {
                        registration_failed();
                        console.log('error me aaya');
                    }
                });
            } else {
                registration_failed();
                return false;
            }
        });

        $('.interest-btn').click(function(e) {
            e.preventDefault();
            $('.login-popup-modal').hide();
            $('.choose-interests').show();
            $('.better-solution').show();
        });

        $('.login-btn-pwd').click(function(e) {
            e.preventDefault();
            $("#login-form-id #mobilenumber").val(user_mob_email);
            // alert("btn clicked");
            $('.login-popup-modal').hide();
            $('.left-side,.right-side,.screen-login-with-pwd').show();
        });

        $('.forgot-pwd-btn').click(function(e) {
            e.preventDefault();
            // alert("btn clicked");
            $('.login-popup-modal').hide();
            $('.left-side,.right-side,.screen-forgot-pwd').show();
        });

        $('.continue-login-btn').click(function(e) {
            e.preventDefault();
            // Clear previous errors
            $('.error').text('');
            // Validate Name
            var name = $('#mobilenumber').val();
            if (name.trim() === '') {
                $('#mobile-error').text('Email or Mobile is required');
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

            // $('.screen-login-with-pwd').show();

            var formData = $('#login-form-id').serialize();
            // alert(formData);
            if (name != '' && password != '') {
                $.ajax({
                    url: "{{ route('loginwithpwd') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        queryParams = new URLSearchParams(window.location.search);
                        // alert(response);
                        if (response.payload.success == true) {
                            login_success();
                            // $('#register-result').html('');
                            // $("#username").text(response.payload.name);
                            // $("#sign_method").val(response.payload.user_signup_method);
                            $('.left-side, .right-side, .login-popup-modal').hide();
                            $('.screen-sucess-logged').show();
                            
                            if(response.payload.subplan_status == 'active'){
                                $('.no-subscription-user').hide();
                            }else{
                                $('.no-subscription-user').show();
                            }
                            setTimeout(function() {
                                if (queryParams.get('profile') == "kids" ) {
                                    window.location.href = $("input[name='kidsUrl']").val();
                                    return false;
                                }else if(queryParams.get('ref') == "subscription"){
                                    if(response.payload.subplan_status == 'active'){
                                        var chekUrl = localStorage.getItem("redirectURL");
                                        if(chekUrl != "" && chekUrl !=null &&  chekUrl!=undefined){
                                               localStorage.removeItem("redirectURL");
                                               window.location.href = chekUrl;
                                               return false;
                                            }else{
                                                window.location.href = response.payload.redirect;
                                                return false;
                                            }
                                    }else{
                                        window.location.href = APP_URL+'/subscription';
                                        return false;
                                    }

                                }else if(queryParams.get('ref') == "rewards"){

                                        window.location.href = APP_URL+'/my-rewards'; 
                                }else {
                                    if($("#redi-val").val() == "subscription"){
                                        window.location.href = APP_URL+'/subscription';
                                        return false;
                                    }else{
                                        window.location.href = response.payload.redirect;
                                        return false;
                                    }
                                }
                            }, 2000);
                            return false;

                        } else {
                            login_failed();
                            $('#login-result').html(response.payload.response.message);
                            // return false;
                        }
                    },
                    error: function(xhr, status, error) {
                        login_failed();
                        console.log('error me aaya');
                    }
                });
            } else {
                login_failed();
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
                    url: "{{ route('verifyforgototp') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // alert(response);
                        if (response.payload.success == true) {
                            $("#userid_detail").val(response.payload.user_id);
                            $("#user_sign_method").val(response.payload.user_signup_method);
                            $('.login-popup-modal').hide();
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
                    url: "{{ route('resetpwdapi') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // alert(response);
                        if (response.payload.success == true) {
                            // $('#verifyotp-result').html('');
                            // $("#userid_no").val(response.payload.user_id);
                            // $("#usersignupmethod").val(response.payload.user_signup_method);
                            $('.login-popup-modal').hide();
                            $('#login-modal').hide();
                            $('.loginBtn.login').trigger('click');
                            showToaster('password changed successfully.', 1);
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

        //focus otp input
        $(".childpin-input .mx-1").on("input", function() {
            const maxLength = parseInt($(this).attr("maxlength"));
            const currentLength = $(this).val().length;

            // If the current input field is filled, move to the next field
            if (currentLength === maxLength) {
                $(this).next(".mx-1").val('');
                $(this).next(".mx-1").focus();
            }
        });

        $("input.child-box").keydown(function(event) {
            if (event.keyCode == 8 && $(this).val().length == 0) {
            if ($(this).prev('input.child-box')) {
                $(this).prev('input.child-box').focus();
                }
            }
        });
        
        $(".redi-subs").click(function() {
          $("#redi-val").val("subscription");
         });

    });
    
</script>
