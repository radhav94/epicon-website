<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
    .stdisdcode {
        display: none;  
    }
    .input-field select{
        width: auto!important;
        padding-right: 40px;
        position: absolute;
        bottom: 0;
        top: 0;
        color:#000;
        background-image: url("../img/drop-down-arrow-select-white.svg");
        background-repeat: no-repeat;
        background-position: center right 15px;
    }

</style>
<!-- login model -->
<div class="modal fade" id="login-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered px-3">
        <div class="modal-content">
            <button class="x-btn bg-transparent text-white closebtn position-absolute" class="btn-close"
                data-bs-dismiss="modal" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 31 32"
                    fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M24.4212 8.60204C24.5304 8.48816 24.6171 8.35293 24.6763 8.20408C24.7355 8.05524 24.766 7.89568 24.7661 7.73453C24.7662 7.57338 24.7359 7.41378 24.6769 7.26486C24.6179 7.11593 24.5313 6.9806 24.4222 6.86657C24.313 6.75255 24.1834 6.66208 24.0408 6.60031C23.8982 6.53855 23.7453 6.50671 23.5908 6.50661C23.4364 6.50651 23.2834 6.53816 23.1407 6.59974C22.998 6.66132 22.8683 6.75162 22.759 6.86551L15.6668 14.266L8.57671 6.86551C8.35603 6.63523 8.05672 6.50586 7.74462 6.50586C7.43253 6.50586 7.13322 6.63523 6.91253 6.86551C6.69185 7.09579 6.56787 7.40811 6.56787 7.73377C6.56787 8.05944 6.69185 8.37176 6.91253 8.60204L14.0047 16.0004L6.91253 23.3988C6.80326 23.5129 6.71658 23.6482 6.65745 23.7972C6.59831 23.9462 6.56787 24.1059 6.56787 24.2671C6.56787 24.4284 6.59831 24.588 6.65745 24.737C6.71658 24.886 6.80326 25.0214 6.91253 25.1354C7.13322 25.3657 7.43253 25.495 7.74462 25.495C7.89916 25.495 8.05218 25.4633 8.19495 25.4016C8.33772 25.3398 8.46744 25.2494 8.57671 25.1354L15.6668 17.7348L22.759 25.1354C22.9797 25.3654 23.2789 25.4945 23.5908 25.4943C23.9027 25.4941 24.2018 25.3646 24.4222 25.1343C24.6426 24.904 24.7663 24.5918 24.7661 24.2664C24.7659 23.9409 24.6418 23.6288 24.4212 23.3988L17.329 16.0004L24.4212 8.60204Z"
                        fill="#F8F8F8" />
                </svg>
            </button>

            <div class="modal-body">
                <div class="login-register text-center">
                    <div class="left-side">
                        <div class="w-100">
                            <img class="w-100" src="{{ asset('/img/login-register-bg.png') }}" alt="">
                        </div>
                        <div class="login-carousel px-2">
                            <div>
                                <h5 class="text-white text-start">Get much more than just OTT</h5>
                                <p class="text-white text-start">Watch TV Shows, Movies, Live TV, Listen to Podcasts &
                                    Play Games</p>
                            </div>
                            <div>
                                <h5 class="text-white text-start">Watch on any device</h5>
                                <p class="text-white text-start">Stream on your phone, tablet, laptop and TV without
                                    paying more </p>
                            </div>
                            <div>
                                <h5 class="text-white text-start">Fam-Tastic Watch</h5>
                                <p class="text-white text-start">Stream on your phone, tablet, laptop and TV without
                                    paying more </p>
                            </div>
                        </div>
                    </div>
                    <!-- login or register start -->
                    <div class="right-side">
                        <div class="login-popup-modal screen-login">
                            <form method="POST" name="mobile-number-form" id="mobile-number-form-id">
                                @csrf
                                <h5 class="mb-4 text-white">Login or Register</h5>
                                <div class="input-field w-100 mb-3 position-relative">
                                    <select class="uk-select select-control input__field stdisdcode" name="stdisdcode">
                                        {!! getCountryStateDataInHtml() !!}
                                    </select>
                                    <input class="form-control emailText" id="mobile_number" name="mobile_number"
                                        placeholder="Email or Mobile Number">
                                    <input type="hidden" name="signup_method" class="signup_method" value="">
                                    <span class="text-start text-white d-flex mt-1" style="font-size: 12px;">We’ll send
                                        you an OTP to verify your account</span>
                                    <span class="text-danger text-start d-flex mt-1 get-otp-message"
                                        style="font-size: 12px;"></span>
                                    <!--  <span class="text-danger text-start d-flex mt-1 erroremail" style="font-size: 12px;">Please enter a valid mobile number</span> -->
                                </div>
                                <button class="login-btn login-get-otp w-100 mt-5">
                                    Get OTP Now
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                                            fill="#070707"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z"
                                            fill="#070707"></path>
                                    </svg>
                                </button>
                                <h6 class="mb-4 text-white text-start mt-4">or Continue with</h6>
                                <div class="lg-social">
                                    <a href="{{ url('/login/facebook') }}"><img src="{{ asset('/img/lg-fb-icon.svg') }}"
                                            alt=""></a>
                                    <a href="{{route('login.twitter')}}"><img src="{{ asset('/img/lg-twitter-icon.svg') }}"
                                            alt=""></a>
                                    <a href="{{route('login.google')}}"><img src="{{ asset('/img/lg-google-icon.svg') }}"
                                            alt=""></a>
                                    <!-- <a href=""><img src="{{ asset('/img/lg-whatsapp-icon.svg') }}"
                                            alt=""></a> -->
                                </div>
                                <p class="get-help mt-5 small">Having trouble signing in? <a href="{{route('feedback')}}">Get Help</a>
                                </p>
                            </form>
                        </div>
                        <div class="login-popup-modal screen-verify">
                            <form method="POST" name="verify-number-form" id="verify-number-form-id">
                                @csrf
                                <h5 class="mb-2 text-white">Enter the OTP sent to</h5>
                                <h5 class="mb-4 text-white mobileno">+91 823****641</h5>
                                <input type="hidden" name="user_id" id="user_id" value="">
                                <input type="hidden" name="signupmethod" id="signupmethod" value="">
                                <input type="hidden" name="user_agent" id="user_agent" value="WEB">
                                <input type="hidden" name="otp_pin" id="otp_pin" value="">
                                <div class="childpin">
                                    <div class="childpin-input no-number-arrows">
                                        <input class="mx-1 child-box" type="number" min="0" max="9"
                                            maxlength="1" id="childpin1" name="childpin1">
                                        <input class="mx-1 child-box" type="number" min="1" max="9"
                                            maxlength="1" id="childpin2" name="childpin2">
                                        <input class="mx-1 child-box" type="number" min="1" max="9"
                                            maxlength="1" id="childpin3" name="childpin3">
                                        <input class="mx-1 child-box" type="number" min="1" max="9"
                                            maxlength="1" id="childpin4" name="childpin4">
                                        <input class="mx-1 child-box" type="number" min="1" max="9"
                                            maxlength="1" id="childpin5" name="childpin5">
                                        <input class="mx-1 child-box" type="number" min="1" max="9"
                                            maxlength="1" id="childpin6" name="childpin6">
                                    </div>
                                </div>
                                <div id="validation-result" style="color: red;">
                                    <!-- Display validation result here -->
                                </div>
                                <div class="resend-otp text-start text-white mt-4" style="font-size: 12px;">
                                    <!-- Resend OTP in:0.30 -->
                                </div>
                                <div id="verifyotp-result" style="color: red;">
                                    <!-- Display validation result here -->
                                </div>
                                <button class="btn btn-primary bg-transparent" id="resendBtn" onclick="resendOTP()">Resend OTP</button>
                                <button class="login-btn verify-btn mt-4" style="width: 280px;">
                                    Verify Number
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                                            fill="#070707" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z"
                                            fill="#070707" />
                                    </svg>
                                </button>
                                <button class="login-btn login-btn-pwd mt-0 bg-transparent text-white"
                                    class="btn-close" style="width: 280px;">Login with password</button>
                            </form>
                        </div>
                        <div class="login-popup-modal screen-register">
                            <form method="POST" name="register-form" id="register-form-id">
                                <h5 class="mb-4 text-white"> Register</h5>
                                <input type="hidden" id="userid" name="userid" value="">
                                <input type="hidden" id="sign_method" name="sign_method" value="">
                                <div class="input-field w-100 mb-3">
                                    <input class="form-control" id="name" name="name"
                                        placeholder="Full Name">
                                    <span class="text-danger text-start d-flex mt-1 error" id="name-error"
                                        style="font-size: 12px;"></span>
                                </div>
                                <div class="input-field w-100 mb-3">
                                    <input class="form-control" type="password" id="password" name="password"
                                        placeholder="Create Password">
                                    <div class="eye-toggle" data-target="password">
                                        <a class="eye eye-open-password" style="display:none;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16"
                                                viewBox="0 0 22 16" fill="none">
                                                <path
                                                    d="M11 5C10.2044 5 9.44129 5.31607 8.87868 5.87868C8.31607 6.44129 8 7.20435 8 8C8 8.79565 8.31607 9.55871 8.87868 10.1213C9.44129 10.6839 10.2044 11 11 11C11.7956 11 12.5587 10.6839 13.1213 10.1213C13.6839 9.55871 14 8.79565 14 8C14 7.20435 13.6839 6.44129 13.1213 5.87868C12.5587 5.31607 11.7956 5 11 5ZM11 13C9.67392 13 8.40215 12.4732 7.46447 11.5355C6.52678 10.5979 6 9.32608 6 8C6 6.67392 6.52678 5.40215 7.46447 4.46447C8.40215 3.52678 9.67392 3 11 3C12.3261 3 13.5979 3.52678 14.5355 4.46447C15.4732 5.40215 16 6.67392 16 8C16 9.32608 15.4732 10.5979 14.5355 11.5355C13.5979 12.4732 12.3261 13 11 13ZM11 0.5C6 0.5 1.73 3.61 0 8C1.73 12.39 6 15.5 11 15.5C16 15.5 20.27 12.39 22 8C20.27 3.61 16 0.5 11 0.5Z"
                                                    fill="white" />
                                            </svg>
                                        </a>
                                        <a class="eye eye-close-password">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect x="19.4551" y="1.52148" width="2.08057" height="24.5396"
                                                    transform="rotate(43.7003 19.4551 1.52148)" fill="white" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M17.9555 6.11126C16.2071 5.08712 14.1725 4.5 12 4.5C7 4.5 2.73 7.61 1 12C2.03885 14.6362 3.99362 16.8108 6.47236 18.1276L8.72091 15.7746C8.63295 15.6982 8.5474 15.6185 8.46447 15.5355C7.52678 14.5979 7 13.3261 7 12C7 10.6739 7.52678 9.40215 8.46447 8.46447C9.40215 7.52678 10.6739 7 12 7C13.3261 7 14.5979 7.52678 15.5355 8.46447C15.5648 8.49369 15.5936 8.52324 15.622 8.5531L17.9555 6.11126ZM14.2376 10.0017C14.2001 9.95975 14.1613 9.91871 14.1213 9.87868C13.5587 9.31607 12.7956 9 12 9C11.2044 9 10.4413 9.31607 9.87868 9.87868C9.31607 10.4413 9 11.2044 9 12C9 12.7956 9.31607 13.5587 9.87868 14.1213C9.95102 14.1937 10.0267 14.2619 10.1053 14.326L14.2376 10.0017ZM12.2365 14.9907L14.9983 12.1006C14.9729 12.8597 14.6602 13.5825 14.1213 14.1213C13.6147 14.6279 12.9456 14.9346 12.2365 14.9907ZM10.528 16.7784C11.0006 16.924 11.4964 17 12 17C13.3261 17 14.5979 16.4732 15.5355 15.5355C16.4732 14.5979 17 13.3261 17 12C17 11.4194 16.899 10.8491 16.7067 10.3128L19.6065 7.27847C21.0968 8.53554 22.2728 10.1547 23 12C21.27 16.39 17 19.5 12 19.5C10.7619 19.5 9.5685 19.3093 8.44738 18.9557L10.528 16.7784Z"
                                                    fill="white" />
                                            </svg>
                                        </a>
                                    </div>
                                    <span class="text-danger text-start d-flex mt-1 error" id="password-error"
                                        style="font-size: 12px;"></span>
                                </div>
                                <div class="input-field w-100 mb-3">
                                    <input class="form-control" type="password" id="confirm-password"
                                        name="confirm-password" placeholder="Confirm Password">
                                    <div class="eye-toggle" data-target="confirm-password">
                                        <a class="eye eye-open-confirm-password" style="display:none;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16"
                                                viewBox="0 0 22 16" fill="none">
                                                <path
                                                    d="M11 5C10.2044 5 9.44129 5.31607 8.87868 5.87868C8.31607 6.44129 8 7.20435 8 8C8 8.79565 8.31607 9.55871 8.87868 10.1213C9.44129 10.6839 10.2044 11 11 11C11.7956 11 12.5587 10.6839 13.1213 10.1213C13.6839 9.55871 14 8.79565 14 8C14 7.20435 13.6839 6.44129 13.1213 5.87868C12.5587 5.31607 11.7956 5 11 5ZM11 13C9.67392 13 8.40215 12.4732 7.46447 11.5355C6.52678 10.5979 6 9.32608 6 8C6 6.67392 6.52678 5.40215 7.46447 4.46447C8.40215 3.52678 9.67392 3 11 3C12.3261 3 13.5979 3.52678 14.5355 4.46447C15.4732 5.40215 16 6.67392 16 8C16 9.32608 15.4732 10.5979 14.5355 11.5355C13.5979 12.4732 12.3261 13 11 13ZM11 0.5C6 0.5 1.73 3.61 0 8C1.73 12.39 6 15.5 11 15.5C16 15.5 20.27 12.39 22 8C20.27 3.61 16 0.5 11 0.5Z"
                                                    fill="white" />
                                            </svg>
                                        </a>
                                        <a class="eye eye-close-confirm-password">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect x="19.4551" y="1.52148" width="2.08057" height="24.5396"
                                                    transform="rotate(43.7003 19.4551 1.52148)" fill="white" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M17.9555 6.11126C16.2071 5.08712 14.1725 4.5 12 4.5C7 4.5 2.73 7.61 1 12C2.03885 14.6362 3.99362 16.8108 6.47236 18.1276L8.72091 15.7746C8.63295 15.6982 8.5474 15.6185 8.46447 15.5355C7.52678 14.5979 7 13.3261 7 12C7 10.6739 7.52678 9.40215 8.46447 8.46447C9.40215 7.52678 10.6739 7 12 7C13.3261 7 14.5979 7.52678 15.5355 8.46447C15.5648 8.49369 15.5936 8.52324 15.622 8.5531L17.9555 6.11126ZM14.2376 10.0017C14.2001 9.95975 14.1613 9.91871 14.1213 9.87868C13.5587 9.31607 12.7956 9 12 9C11.2044 9 10.4413 9.31607 9.87868 9.87868C9.31607 10.4413 9 11.2044 9 12C9 12.7956 9.31607 13.5587 9.87868 14.1213C9.95102 14.1937 10.0267 14.2619 10.1053 14.326L14.2376 10.0017ZM12.2365 14.9907L14.9983 12.1006C14.9729 12.8597 14.6602 13.5825 14.1213 14.1213C13.6147 14.6279 12.9456 14.9346 12.2365 14.9907ZM10.528 16.7784C11.0006 16.924 11.4964 17 12 17C13.3261 17 14.5979 16.4732 15.5355 15.5355C16.4732 14.5979 17 13.3261 17 12C17 11.4194 16.899 10.8491 16.7067 10.3128L19.6065 7.27847C21.0968 8.53554 22.2728 10.1547 23 12C21.27 16.39 17 19.5 12 19.5C10.7619 19.5 9.5685 19.3093 8.44738 18.9557L10.528 16.7784Z"
                                                    fill="white" />
                                            </svg>
                                        </a>
                                    </div>
                                    <span class="text-danger text-start d-flex mt-1 error" id="confirm-password-error"
                                        style="font-size: 12px;"></span>
                                </div>
                                <div class="input-field w-100 mb-3">
                                    <input class="form-control date_picker" type="text" id="dob" name="dob" placeholder="Date Of Birth" required readonly>
                                </div>
                                <div class="input-field text-white w-100 mb-3">
                                    <select id="gender" name="gender">
                                        <option value="">Gender</option>
                                        <option value="Female">Female</option>
                                        <option value="Male">Male</option>
                                        <option value="Transgender">Transgender</option>
                                        <option value="Shemale">Shemale</option>
                                    </select>
                                    <span class="text-danger text-start d-flex mt-1 error" id="gender-error"
                                        style="font-size: 12px;"></span>
                                </div>
                                <div id="register-result" style="color: red;">
                                    <!-- Display validation result here -->
                                </div>
                                <button class="login-btn register-btn w-100 mt-5">
                                    Let's Get Started
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                                            fill="#070707"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z"
                                            fill="#070707"></path>
                                    </svg>
                                </button>
                                <p class="get-help mt-5 small">By clicking on Register, you agree to our <a href="{{ route('terms-of-use') }}">Terms & Conditions</a> and <a href="{{ route('privacy') }}">Privacy Policy</a></p>
                            </form>
                        </div>

                        <div class="login-popup-modal screen-login-with-pwd">
                            <form method="POST" name="login-form" id="login-form-id">
                                <h5 class="mb-4 text-white">Login with Password</h5>
                                <div class="input-field w-100 mb-3">
                                    <select class="uk-select select-control input__field stdisdcode" name="stdisdcode">
                                        {!! getCountryStateDataInHtml() !!}
                                    </select>
                                    <input class="form-control emailText" id="mobilenumber" name="mobilenumber"
                                        placeholder="Email or Mobile Number" value="<?php if(isset($_COOKIE["user_id"])) { echo $_COOKIE["user_id"]; } ?>">
                                    <input type="hidden" name="signup_method" class="signup_method" value="">
                                    <span class="text-danger text-start d-flex mt-1 error" id="mobile-error"
                                        style="font-size: 12px;"></span>
                                </div>
                                <div class="input-field w-100 mb-3">
                                    <input class="form-control" id="login_pwd" name="login_pwd" type="password"
                                        placeholder="Enter Password" value="<?php if(isset($_COOKIE["user_password"])) { echo $_COOKIE["user_password"]; } ?>">
                                    <div class="eye-toggle" data-target="login_pwd">
                                        <a class="eye eye-open-login_pwd" style="display: none;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16"
                                                viewBox="0 0 22 16" fill="none">
                                                <path
                                                    d="M11 5C10.2044 5 9.44129 5.31607 8.87868 5.87868C8.31607 6.44129 8 7.20435 8 8C8 8.79565 8.31607 9.55871 8.87868 10.1213C9.44129 10.6839 10.2044 11 11 11C11.7956 11 12.5587 10.6839 13.1213 10.1213C13.6839 9.55871 14 8.79565 14 8C14 7.20435 13.6839 6.44129 13.1213 5.87868C12.5587 5.31607 11.7956 5 11 5ZM11 13C9.67392 13 8.40215 12.4732 7.46447 11.5355C6.52678 10.5979 6 9.32608 6 8C6 6.67392 6.52678 5.40215 7.46447 4.46447C8.40215 3.52678 9.67392 3 11 3C12.3261 3 13.5979 3.52678 14.5355 4.46447C15.4732 5.40215 16 6.67392 16 8C16 9.32608 15.4732 10.5979 14.5355 11.5355C13.5979 12.4732 12.3261 13 11 13ZM11 0.5C6 0.5 1.73 3.61 0 8C1.73 12.39 6 15.5 11 15.5C16 15.5 20.27 12.39 22 8C20.27 3.61 16 0.5 11 0.5Z"
                                                    fill="white" />
                                            </svg>
                                        </a>
                                        <a class="eye eye-close-login_pwd">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect x="19.4551" y="1.52148" width="2.08057" height="24.5396"
                                                    transform="rotate(43.7003 19.4551 1.52148)" fill="white" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M17.9555 6.11126C16.2071 5.08712 14.1725 4.5 12 4.5C7 4.5 2.73 7.61 1 12C2.03885 14.6362 3.99362 16.8108 6.47236 18.1276L8.72091 15.7746C8.63295 15.6982 8.5474 15.6185 8.46447 15.5355C7.52678 14.5979 7 13.3261 7 12C7 10.6739 7.52678 9.40215 8.46447 8.46447C9.40215 7.52678 10.6739 7 12 7C13.3261 7 14.5979 7.52678 15.5355 8.46447C15.5648 8.49369 15.5936 8.52324 15.622 8.5531L17.9555 6.11126ZM14.2376 10.0017C14.2001 9.95975 14.1613 9.91871 14.1213 9.87868C13.5587 9.31607 12.7956 9 12 9C11.2044 9 10.4413 9.31607 9.87868 9.87868C9.31607 10.4413 9 11.2044 9 12C9 12.7956 9.31607 13.5587 9.87868 14.1213C9.95102 14.1937 10.0267 14.2619 10.1053 14.326L14.2376 10.0017ZM12.2365 14.9907L14.9983 12.1006C14.9729 12.8597 14.6602 13.5825 14.1213 14.1213C13.6147 14.6279 12.9456 14.9346 12.2365 14.9907ZM10.528 16.7784C11.0006 16.924 11.4964 17 12 17C13.3261 17 14.5979 16.4732 15.5355 15.5355C16.4732 14.5979 17 13.3261 17 12C17 11.4194 16.899 10.8491 16.7067 10.3128L19.6065 7.27847C21.0968 8.53554 22.2728 10.1547 23 12C21.27 16.39 17 19.5 12 19.5C10.7619 19.5 9.5685 19.3093 8.44738 18.9557L10.528 16.7784Z"
                                                    fill="white" />
                                            </svg>
                                        </a>
                                    </div>
                                    <span class="text-danger text-start d-flex mt-1 error" id="login-pwd-error"
                                        style="font-size: 12px;"></span>
                                </div>
                                <div id="login-result" style="color: red;">
                                    <!-- Display validation result here -->
                                </div>
                                <div class="w-100 d-flex justify-content-between">
                                    <div class="form-check">
                                        <input type="checkbox" class="custom-control-input" id="customCheck"
                                            name="rememberme" value="false">
                                        <label class="form-check-label small text-white" for="flexCheckDefault1">
                                            Remember me
                                        </label>
                                    </div>
                                    <button
                                        class="bg-transparent text-white p-0 small w-auto border-0 forgot-pwd-btn">Forgot
                                        Password?</button>
                                </div>
                                <button class="login-btn continue-login-btn mt-4" style="width: 280px;">
                                    Continue to Login
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                                            fill="#070707"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z"
                                            fill="#070707"></path>
                                    </svg>
                                </button>
                                <button class="login-btn login-btn-otp mt-0 bg-transparent text-white"
                                    style="width: 280px;">Login using OTP</button>
                                <p class="get-help mt-5 small">Having trouble signing in? <a href="">Get
                                        Help</a></p>
                            </form>
                        </div>
                        <!-- forgot password start -->
                        <div class="login-popup-modal screen-forgot-pwd">
                            <form method="POST" name="forgot-pwd-form-id" id="forgot-pwd-form-id">
                                <h5 class="mb-4 text-white">Forgot Password</h5>
                                <div class="input-field w-100 mb-3">
                                    <select class="uk-select select-control input__field stdisdcode" name="stdisdcode">
                                        {!! getCountryStateDataInHtml() !!}
                                    </select>
                                    <input class="form-control emailText" id="forgot-name" name="forgot-name"
                                        placeholder="Email or Mobile Number">
                                    <input type="hidden" name="signin_method" id="signin_method" value="">
                                    <span class="text-start text-white d-flex mt-1" style="font-size: 12px;">We’ll
                                        send you an OTP to verify your account. You’ll then be able to create a new
                                        password.</span>
                                    <span class="text-danger text-start d-flex mt-1 get-otp-message"
                                        style="font-size: 12px;"></span>
                                </div>
                                <button class="login-btn forgot-otp-btn mt-4" style="width: 280px;">
                                    Get OTP Now
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                                            fill="#070707"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z"
                                            fill="#070707"></path>
                                    </svg>
                                </button>
                                <div id="forgot-otp-result" style="color: red;">
                                    <!-- Display validation result here -->
                                </div>
                            </form>
                        </div>
                        <!-- forgot password end -->

                        <div class="login-popup-modal screen-forgot-otp">
                            <form method="POST" name="verify-forgot-number-form" id="verify-forgot-number-form-id">
                                @csrf
                                <h5 class="mb-2 text-white">Forgot Password</h5>
                                <h5 class="mb-2 text-white">Enter the OTP sent to</h5>
                                <h5 class="mb-4 text-white small mobile_no">+91 823****641</h5>
                                <input type="hidden" name="userid_no" id="userid_no" value="">
                                <input type="hidden" name="usersignupmethod" id="usersignupmethod" value="">
                                <!-- <input type="hidden" name="user_agent" id="user_agent" value="WEB"> -->
                                <input type="hidden" name="otppin" id="otppin" value="">
                                <div class="childpin">
                                    <div class="childpin-input">
                                        <input class="mx-1 child-box1" type="number" min="0" max="9"
                                            maxlength="1" id="childpin11" name="childpin11">
                                        <input class="mx-1 child-box1" type="number" min="1" max="9"
                                            maxlength="1" id="childpin22" name="childpin22">
                                        <input class="mx-1 child-box1" type="number" min="1" max="9"
                                            maxlength="1" id="childpin33" name="childpin33">
                                        <input class="mx-1 child-box1" type="number" min="1" max="9"
                                            maxlength="1" id="childpin44" name="childpin44">
                                        <input class="mx-1 child-box1" type="number" min="1" max="9"
                                            maxlength="1" id="childpin55" name="childpin55">
                                        <input class="mx-1 child-box1" type="number" min="1" max="9"
                                            maxlength="1" id="childpin66" name="childpin66">
                                    </div>
                                </div>
                                <div id="validation-forgot-result" style="color: red;">
                                    <!-- Child Pin Input Validation -->
                                </div>
                                <div class="resend-forgot-otp text-start text-white mt-4" style="font-size: 12px;">
                                    <!-- Resend OTP in:0.30 -->
                                </div>
                                <div id="verifyotp-forgot-result" style="color: red;">
                                    <!-- Display validation result here -->
                                </div>
                                <button class="bg-transparent rounded text-white" id="resendForgotBtn" onclick="resendForgotOTP()">Resend OTP</button>
                                <button class="login-btn verify-forgot-btn mt-4" style="width: 280px;">
                                    Verify Email/Number
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                                            fill="#070707" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z"
                                            fill="#070707" />
                                    </svg>
                                </button>
                                <!-- <button class="login-btn login-btn-pwd mt-0 bg-transparent text-white" class="btn-close" style="width: 280px;">Login with password</button> -->
                            </form>
                        </div>

                        <!-- Screen 55 Start -->
                        <div class="login-popup-modal screen-set-pwd">
                            <form method="POST" name="set-password-form" id="set-password-form-id">
                                <h5 class="mb-4 text-white"> Set New Password</h5>
                                <input type="hidden" id="userid_detail" name="userid_detail" value="">
                                <input type="hidden" id="user_sign_method" name="user_sign_method" value="">

                                <div class="input-field w-100 mb-3">
                                    <input class="form-control" type="password" id="set-password"
                                        name="set-password" placeholder="Enter New Password">
                                    <div class="eye-toggle" data-target="set-password">
                                        <a class="eye eye-open-set-password" style="display:none;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16"
                                                viewBox="0 0 22 16" fill="none">
                                                <path
                                                    d="M11 5C10.2044 5 9.44129 5.31607 8.87868 5.87868C8.31607 6.44129 8 7.20435 8 8C8 8.79565 8.31607 9.55871 8.87868 10.1213C9.44129 10.6839 10.2044 11 11 11C11.7956 11 12.5587 10.6839 13.1213 10.1213C13.6839 9.55871 14 8.79565 14 8C14 7.20435 13.6839 6.44129 13.1213 5.87868C12.5587 5.31607 11.7956 5 11 5ZM11 13C9.67392 13 8.40215 12.4732 7.46447 11.5355C6.52678 10.5979 6 9.32608 6 8C6 6.67392 6.52678 5.40215 7.46447 4.46447C8.40215 3.52678 9.67392 3 11 3C12.3261 3 13.5979 3.52678 14.5355 4.46447C15.4732 5.40215 16 6.67392 16 8C16 9.32608 15.4732 10.5979 14.5355 11.5355C13.5979 12.4732 12.3261 13 11 13ZM11 0.5C6 0.5 1.73 3.61 0 8C1.73 12.39 6 15.5 11 15.5C16 15.5 20.27 12.39 22 8C20.27 3.61 16 0.5 11 0.5Z"
                                                    fill="white" />
                                            </svg>
                                        </a>
                                        <a class="eye eye-close-set-password">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect x="19.4551" y="1.52148" width="2.08057" height="24.5396"
                                                    transform="rotate(43.7003 19.4551 1.52148)" fill="white" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M17.9555 6.11126C16.2071 5.08712 14.1725 4.5 12 4.5C7 4.5 2.73 7.61 1 12C2.03885 14.6362 3.99362 16.8108 6.47236 18.1276L8.72091 15.7746C8.63295 15.6982 8.5474 15.6185 8.46447 15.5355C7.52678 14.5979 7 13.3261 7 12C7 10.6739 7.52678 9.40215 8.46447 8.46447C9.40215 7.52678 10.6739 7 12 7C13.3261 7 14.5979 7.52678 15.5355 8.46447C15.5648 8.49369 15.5936 8.52324 15.622 8.5531L17.9555 6.11126ZM14.2376 10.0017C14.2001 9.95975 14.1613 9.91871 14.1213 9.87868C13.5587 9.31607 12.7956 9 12 9C11.2044 9 10.4413 9.31607 9.87868 9.87868C9.31607 10.4413 9 11.2044 9 12C9 12.7956 9.31607 13.5587 9.87868 14.1213C9.95102 14.1937 10.0267 14.2619 10.1053 14.326L14.2376 10.0017ZM12.2365 14.9907L14.9983 12.1006C14.9729 12.8597 14.6602 13.5825 14.1213 14.1213C13.6147 14.6279 12.9456 14.9346 12.2365 14.9907ZM10.528 16.7784C11.0006 16.924 11.4964 17 12 17C13.3261 17 14.5979 16.4732 15.5355 15.5355C16.4732 14.5979 17 13.3261 17 12C17 11.4194 16.899 10.8491 16.7067 10.3128L19.6065 7.27847C21.0968 8.53554 22.2728 10.1547 23 12C21.27 16.39 17 19.5 12 19.5C10.7619 19.5 9.5685 19.3093 8.44738 18.9557L10.528 16.7784Z"
                                                    fill="white" />
                                            </svg>
                                        </a>
                                    </div>
                                    <span class="text-danger text-start d-flex mt-1 error" id="setpassword-error"
                                        style="font-size: 12px;"></span>
                                </div>
                                <div class="input-field w-100 mb-3">
                                    <input class="form-control" type="password" id="reenter-password"
                                        name="reenter-password" placeholder="Re-enter New Password">
                                    <div class="eye-toggle" data-target="reenter-password">
                                        <a class="eye eye-open-reenter-password" style="display:none;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16"
                                                viewBox="0 0 22 16" fill="none">
                                                <path
                                                    d="M11 5C10.2044 5 9.44129 5.31607 8.87868 5.87868C8.31607 6.44129 8 7.20435 8 8C8 8.79565 8.31607 9.55871 8.87868 10.1213C9.44129 10.6839 10.2044 11 11 11C11.7956 11 12.5587 10.6839 13.1213 10.1213C13.6839 9.55871 14 8.79565 14 8C14 7.20435 13.6839 6.44129 13.1213 5.87868C12.5587 5.31607 11.7956 5 11 5ZM11 13C9.67392 13 8.40215 12.4732 7.46447 11.5355C6.52678 10.5979 6 9.32608 6 8C6 6.67392 6.52678 5.40215 7.46447 4.46447C8.40215 3.52678 9.67392 3 11 3C12.3261 3 13.5979 3.52678 14.5355 4.46447C15.4732 5.40215 16 6.67392 16 8C16 9.32608 15.4732 10.5979 14.5355 11.5355C13.5979 12.4732 12.3261 13 11 13ZM11 0.5C6 0.5 1.73 3.61 0 8C1.73 12.39 6 15.5 11 15.5C16 15.5 20.27 12.39 22 8C20.27 3.61 16 0.5 11 0.5Z"
                                                    fill="white" />
                                            </svg>
                                        </a>
                                        <a class="eye eye-close-reenter-password">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect x="19.4551" y="1.52148" width="2.08057" height="24.5396"
                                                    transform="rotate(43.7003 19.4551 1.52148)" fill="white" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M17.9555 6.11126C16.2071 5.08712 14.1725 4.5 12 4.5C7 4.5 2.73 7.61 1 12C2.03885 14.6362 3.99362 16.8108 6.47236 18.1276L8.72091 15.7746C8.63295 15.6982 8.5474 15.6185 8.46447 15.5355C7.52678 14.5979 7 13.3261 7 12C7 10.6739 7.52678 9.40215 8.46447 8.46447C9.40215 7.52678 10.6739 7 12 7C13.3261 7 14.5979 7.52678 15.5355 8.46447C15.5648 8.49369 15.5936 8.52324 15.622 8.5531L17.9555 6.11126ZM14.2376 10.0017C14.2001 9.95975 14.1613 9.91871 14.1213 9.87868C13.5587 9.31607 12.7956 9 12 9C11.2044 9 10.4413 9.31607 9.87868 9.87868C9.31607 10.4413 9 11.2044 9 12C9 12.7956 9.31607 13.5587 9.87868 14.1213C9.95102 14.1937 10.0267 14.2619 10.1053 14.326L14.2376 10.0017ZM12.2365 14.9907L14.9983 12.1006C14.9729 12.8597 14.6602 13.5825 14.1213 14.1213C13.6147 14.6279 12.9456 14.9346 12.2365 14.9907ZM10.528 16.7784C11.0006 16.924 11.4964 17 12 17C13.3261 17 14.5979 16.4732 15.5355 15.5355C16.4732 14.5979 17 13.3261 17 12C17 11.4194 16.899 10.8491 16.7067 10.3128L19.6065 7.27847C21.0968 8.53554 22.2728 10.1547 23 12C21.27 16.39 17 19.5 12 19.5C10.7619 19.5 9.5685 19.3093 8.44738 18.9557L10.528 16.7784Z"
                                                    fill="white" />
                                            </svg>
                                        </a>
                                    </div>
                                    <span class="text-danger text-start d-flex mt-1 error" id="reenter-password-error"
                                        style="font-size: 12px;"></span>
                                </div>

                                <div id="reset-result" style="color: red;">
                                    <!-- Display validation result here -->
                                </div>
                                <button class="login-btn reset-pwd-btn w-100 mt-5">
                                    Reset Password
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                                            fill="#070707"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z"
                                            fill="#070707"></path>
                                    </svg>
                                </button>
                                <div class="reset-forgot-result" style="color:red;"></div>
                            </form>
                        </div>
                        <!-- Screen55 end -->
                    </div>

                    <!-- successfully and interest  start-->
                    <div class="login-popup-modal successfully-loged screen-sucess-register py-5">
                        <img width="100" src="{{ asset('/img/success-tick.png') }}" alt="">
                        <h4 class="text-center text-white mt-3">Hey <span id="username"></span>, you have
                            successfully registered with Epic On!</h4>
                        <p class="small text-white">Tell us what you’re interested in and we’ll do our best to give you
                            better recommendations </p>
                        {{--<button class="login-btn interest-btn mt-4" style="width: 280px;">
                            Choose Interests
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                                    fill="#070707" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z"
                                    fill="#070707" />
                            </svg>
                        </button> --}}
                    </div>

                    <!-- successfully logged  start-->
                    <div class="login-popup-modal successfully-loged w-100 screen-sucess-logged 12345">

                        <img width="100" class="{{@$subplan['status']}}" src="{{ asset('/img/success-tick.png') }}" alt="">
                        <h4 class="text-center text-white mt-3">Awesome! You have successfully logged in to Epic ON {{@$subplan_status}}
                        </h4>
                        <div class="no-subscription-user">
                        <input type="hidden" id="redi-val" value="">  
                        <button class="no-active-subscription mt-4 mb-4">No Active Subscription</button>
                        <button class="login-btn subscription-btn mt-4 redi-subs" style="width: 280px;">
                            Buy Subscription
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                                    fill="#070707" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z"
                                    fill="#070707" />
                            </svg>
                        </button>
                        <button class="login-btn skip-btn mt-0 bg-transparent text-white" class="btn-close"
                            style="width: 280px;">Skip for now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
