@extends('layouts.default')
@section('title','New homepage')

@section('style')

@stop

@section('content')

 <!-- login model -->
    <div class="modal fade" id="login-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered px-3">
            <div class="modal-content">
                <button class="x-btn bg-transparent text-white closebtn position-absolute" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 31 32" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M24.4212 8.60204C24.5304 8.48816 24.6171 8.35293 24.6763 8.20408C24.7355 8.05524 24.766 7.89568 24.7661 7.73453C24.7662 7.57338 24.7359 7.41378 24.6769 7.26486C24.6179 7.11593 24.5313 6.9806 24.4222 6.86657C24.313 6.75255 24.1834 6.66208 24.0408 6.60031C23.8982 6.53855 23.7453 6.50671 23.5908 6.50661C23.4364 6.50651 23.2834 6.53816 23.1407 6.59974C22.998 6.66132 22.8683 6.75162 22.759 6.86551L15.6668 14.266L8.57671 6.86551C8.35603 6.63523 8.05672 6.50586 7.74462 6.50586C7.43253 6.50586 7.13322 6.63523 6.91253 6.86551C6.69185 7.09579 6.56787 7.40811 6.56787 7.73377C6.56787 8.05944 6.69185 8.37176 6.91253 8.60204L14.0047 16.0004L6.91253 23.3988C6.80326 23.5129 6.71658 23.6482 6.65745 23.7972C6.59831 23.9462 6.56787 24.1059 6.56787 24.2671C6.56787 24.4284 6.59831 24.588 6.65745 24.737C6.71658 24.886 6.80326 25.0214 6.91253 25.1354C7.13322 25.3657 7.43253 25.495 7.74462 25.495C7.89916 25.495 8.05218 25.4633 8.19495 25.4016C8.33772 25.3398 8.46744 25.2494 8.57671 25.1354L15.6668 17.7348L22.759 25.1354C22.9797 25.3654 23.2789 25.4945 23.5908 25.4943C23.9027 25.4941 24.2018 25.3646 24.4222 25.1343C24.6426 24.904 24.7663 24.5918 24.7661 24.2664C24.7659 23.9409 24.6418 23.6288 24.4212 23.3988L17.329 16.0004L24.4212 8.60204Z" fill="#F8F8F8"/>
                    </svg>
                </button>
                <!-- <div class="modal-body">
                    <div class="childpin text-center py-4">
                        <h5 class="mb-3">Past Logins</h5>
                        <p class="small mb-4">You’ve previously logged in to Epic On</p>
                        <div class="subscriber mb-5">
                            <div>
                                <div class="d-flex align-items-center justify-content-start">
                                    <span>+91 98*****210</span>
                                    <p class="mb-0 ms-3">
                                        <img width="14" src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/crown.svg';?>" alt="">&nbsp; Subscriber
                                    </p>
                                </div>
                                <div class="small text-white mt-2">Last login : 16th May 2023  12:01 pm</div>
                            </div>
                            <button class="transparent-btn ms-5 past-login-delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.33398 9.33301C4.33398 8.78072 4.7817 8.33301 5.33398 8.33301H26.6673C27.2196 8.33301 27.6673 8.78072 27.6673 9.33301C27.6673 9.88529 27.2196 10.333 26.6673 10.333H5.33398C4.7817 10.333 4.33398 9.88529 4.33398 9.33301Z" fill="white"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8 12.333C8.55228 12.333 9 12.7807 9 13.333V23.9997C9 25.6565 10.3431 26.9997 12 26.9997H20C21.6569 26.9997 23 25.6565 23 23.9997V13.333C23 12.7807 23.4477 12.333 24 12.333C24.5523 12.333 25 12.7807 25 13.333V23.9997C25 26.7611 22.7614 28.9997 20 28.9997H12C9.23858 28.9997 7 26.7611 7 23.9997V13.333C7 12.7807 7.44772 12.333 8 12.333Z" fill="white"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11 6.66667C11 4.64162 12.6416 3 14.6667 3H17.3333C19.3584 3 21 4.64162 21 6.66667V9.33333C21 9.88562 20.5523 10.3333 20 10.3333H12C11.4477 10.3333 11 9.88562 11 9.33333V6.66667ZM14.6667 5C13.7462 5 13 5.74619 13 6.66667V8.33333H19V6.66667C19 5.74619 18.2538 5 17.3333 5H14.6667Z" fill="white"/>
                                  </svg>
                            </button>
                        </div>
                        <button class="login-btn mt-4" style="width: 280px;">
                            Continue with this account
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"/>
                            </svg>
                         </button>
                         <button class="login-btn mt-0 bg-transparent text-white" class="btn-close" style="width: 280px;">Login with another account</button>
                    </div>
                </div> -->
                <div class="modal-body">
                    <div class="login-register text-center py-4">
                                <div class="left-side">
                                    <div class="w-100">
                                        <img class="w-100" src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/login-register-bg.png';?>" alt="">
                                    </div>
                                    <div class="login-carousel px-2">
                                        <div>
                                            <h5 class="text-white text-start">Get much more than just OTT</h5>
                                            <p class="text-white text-start">Watch TV Shows, Movies, Live TV, Listen to Podcasts & Play Games</p>
                                        </div>
                                        <div>
                                            <h5 class="text-white text-start">Watch on any device</h5>
                                            <p class="text-white text-start">Stream on your phone, tablet, laptop and TV without paying more </p>
                                        </div>
                                        <div>
                                            <h5 class="text-white text-start">Fam-Tastic Watch</h5>
                                            <p class="text-white text-start">Stream on your phone, tablet, laptop and TV without paying more </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- login or register start -->
                                <div class="right-side">
                                    <div class="screen1">
                                     <form action="{{url('/sendotp')}}" method="POST" name="mobile-number-form" id="mobile-number-form-id" >
                                        @csrf
                                    <h5 class="mb-4 text-white">Login or Register</h5>
                                    <div class="input-field w-100 mb-3">
                                        <input class="form-control" id="mobile_number" name="mobile_number" placeholder="Email or Mobile Number">
                                        <input type="hidden" name="signup_method" id="signup_method" value="">
                                        <span class="text-start text-white d-flex mt-1" style="font-size: 12px;">We’ll send you an OTP to verify your account</span>
                                         <span class="text-danger text-start d-flex mt-1 get-otp-message" style="font-size: 12px;"></span>
                                       <!--  <span class="text-danger text-start d-flex mt-1 erroremail" style="font-size: 12px;">Please enter a valid mobile number</span> -->
                                    </div>
                                    <!-- <div class="input-field w-100 mb-3">
                                        <input class="form-control" id="exampleDataList" placeholder="Full Name">
                                        <span class="text-danger text-start d-flex mt-1" style="font-size: 12px;">error msg</span>
                                    </div> -->
                                    <!-- <div class="input-field w-100 mb-3">
                                        <input class="form-control" id="exampleDataList" placeholder="Create Password">
                                        <button class="eye">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16" viewBox="0 0 22 16" fill="none">
                                                <path d="M11 5C10.2044 5 9.44129 5.31607 8.87868 5.87868C8.31607 6.44129 8 7.20435 8 8C8 8.79565 8.31607 9.55871 8.87868 10.1213C9.44129 10.6839 10.2044 11 11 11C11.7956 11 12.5587 10.6839 13.1213 10.1213C13.6839 9.55871 14 8.79565 14 8C14 7.20435 13.6839 6.44129 13.1213 5.87868C12.5587 5.31607 11.7956 5 11 5ZM11 13C9.67392 13 8.40215 12.4732 7.46447 11.5355C6.52678 10.5979 6 9.32608 6 8C6 6.67392 6.52678 5.40215 7.46447 4.46447C8.40215 3.52678 9.67392 3 11 3C12.3261 3 13.5979 3.52678 14.5355 4.46447C15.4732 5.40215 16 6.67392 16 8C16 9.32608 15.4732 10.5979 14.5355 11.5355C13.5979 12.4732 12.3261 13 11 13ZM11 0.5C6 0.5 1.73 3.61 0 8C1.73 12.39 6 15.5 11 15.5C16 15.5 20.27 12.39 22 8C20.27 3.61 16 0.5 11 0.5Z" fill="white"/>
                                            </svg>
                                        </button>
                                        <span class="text-danger text-start d-flex mt-1" style="font-size: 12px;">error msg</span>
                                    </div> -->
                                    <!-- <div class="input-field w-100 mb-3">
                                        <input class="form-control" id="exampleDataList" placeholder="Confirm Password">
                                        <button class="eye">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16" viewBox="0 0 22 16" fill="none">
                                                <path d="M11 5C10.2044 5 9.44129 5.31607 8.87868 5.87868C8.31607 6.44129 8 7.20435 8 8C8 8.79565 8.31607 9.55871 8.87868 10.1213C9.44129 10.6839 10.2044 11 11 11C11.7956 11 12.5587 10.6839 13.1213 10.1213C13.6839 9.55871 14 8.79565 14 8C14 7.20435 13.6839 6.44129 13.1213 5.87868C12.5587 5.31607 11.7956 5 11 5ZM11 13C9.67392 13 8.40215 12.4732 7.46447 11.5355C6.52678 10.5979 6 9.32608 6 8C6 6.67392 6.52678 5.40215 7.46447 4.46447C8.40215 3.52678 9.67392 3 11 3C12.3261 3 13.5979 3.52678 14.5355 4.46447C15.4732 5.40215 16 6.67392 16 8C16 9.32608 15.4732 10.5979 14.5355 11.5355C13.5979 12.4732 12.3261 13 11 13ZM11 0.5C6 0.5 1.73 3.61 0 8C1.73 12.39 6 15.5 11 15.5C16 15.5 20.27 12.39 22 8C20.27 3.61 16 0.5 11 0.5Z" fill="white"/>
                                            </svg>
                                        </button>
                                        <span class="text-danger text-start d-flex mt-1" style="font-size: 12px;">error msg</span>
                                    </div>
                                    <div class="input-field w-100 mb-3">
                                        <input class="form-control" type="date" id="exampleDataList">
                                    </div>
                                    <div class="input-field w-100 mb-3">
                                        <select>
                                            <option value="">Female</option>
                                            <option value="">Male</option>
                                            <option value="">Transgender</option>
                                            <option value="">Shemale</option>
                                        </select>
                                    </div> -->
                                    <button class="login-btn w-100 mt-5">
                                        Get OTP Now
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"></path>
                                        </svg>
                                     </button>
                                     <h6 class="mb-4 text-white text-start mt-4">or Continue with</h6>
                                     <div class="lg-social">
                                        <a href=""><img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/lg-fb-icon.svg';?>" alt=""></a>
                                        <a href=""><img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/lg-twitter-icon.svg';?>" alt=""></a>
                                        <a href=""><img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/lg-google-icon.svg';?>" alt=""></a>
                                        <a href=""><img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/lg-whatsapp-icon.svg';?>" alt=""></a>
                                     </div>
                                     <p class="get-help mt-5 small">Having trouble signing in? <a href="">Get Help</a></p>
                                </form>
                                </div>
                                <div class="screen2">
                                     <h5 class="mb-2 text-white">Enter the OTP sent to</h5>
                                     <h5 class="mb-4 text-white small">+91 823****641</h5>
                                    
                                     <div class="childpin">
                                        <div class="childpin-input">
                                            <input class="mx-1" type="text" maxlength="1">
                                            <input class="mx-1" type="text" maxlength="1">
                                            <input class="mx-1" type="text" maxlength="1">
                                            <input class="mx-1" type="text" maxlength="1">
                                            <input class="mx-1" type="text" maxlength="1">
                                            <input class="mx-1" type="text" maxlength="1">
                                        </div>
                                    </div>
                                    <div class="resend-otp text-start text-white mt-4" style="font-size: 12px;">
                                        Resend OTP in:0.30
                                    </div>
                                    <button class="login-btn mt-4" style="width: 280px;">
                                        Verify Number
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"/>
                                        </svg>
                                     </button>
                                     <button class="login-btn mt-0 bg-transparent text-white" class="btn-close" style="width: 280px;">Login with password</button>
                                </div>
                                </div>
                                <!-- login or register end -->
                                <!-- successfully logged  start-->
                               <!--  <div class="successfully-loged w-100">
                                    <img width="100" src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/success-tick.png';?>" alt="">
                                    <h4 class="text-center text-white mt-3">Awesome! You have successfully logged in to Epic ON</h4>
                                    <button class="no-active-subscription mt-4 mb-4">No Active Subscription</button>
                                    <button class="login-btn mt-4" style="width: 280px;">
                                        Buy Subscription
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"/>
                                        </svg>
                                     </button>
                                     <button class="login-btn mt-0 bg-transparent text-white" class="btn-close" style="width: 280px;">Skip for now</button>
                                </div> -->
                                <!-- successfully logged  end-->
                                <!-- successfully and interest  start-->
                               <!--  <div class="successfully-loged w-100">
                                    <img width="100" src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/success-tick.png';?>" alt="">
                                    <h4 class="text-center text-white mt-3">Hey AKASH, you have successfully registered with Epic On!</h4>
                                    <p class="small text-white">Tell us what you’re interested in and we’ll do our best to give you better recommendations </p>
                                    <button class="login-btn mt-4" style="width: 280px;">
                                        Choose Interests
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"/>
                                        </svg>
                                     </button>
                                </div> -->
                                <!-- successfully and interest end-->
                                <!-- better suggetion start -->
                                    <!-- <div class="better-solution">
                                        <div class="bs-left">
                                            <h4>
                                                Choose 3 or more interests for better suggestions
                                            </h4>
                                            <div class="choose">
                                                <div class="three">
                                                    <span><img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/welcom.jpeg';?>" alt=""></span>
                                                    <span><img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/dhamal.jpeg';?>" alt=""></span>
                                                    <span><img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/welcom.jpeg';?>" alt=""></span>
                                                    <span class="span-text-3">3 of 3</span>
                                                </div>
                                                <button>Next 
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M5 12H19" stroke="#161616" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M12 5L19 12L12 19" stroke="#161616" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                      </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="bs-right">
                                            <div class="interest-suggetion">
                                                <label class="is-checkbox">
                                                    <input type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/interest-horizontal.png';?>" alt="img">
                                                <div class="is-overlay">
                                                    <h1>Thriller Movies & Shows</h1>
                                                    <p>Like NH10, Talaash, Airlift, Mirzapur, Breathe</p>
                                                </div>
                                            </div>
                                            <div class="interest-suggetion">
                                                <label class="is-checkbox">
                                                    <input type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/interest-horizontal.png';?>" alt="img">
                                                <div class="is-overlay">
                                                    <h1>Thriller Movies & Shows</h1>
                                                    <p>Like NH10, Talaash, Airlift, Mirzapur, Breathe</p>
                                                </div>
                                            </div>
                                            <div class="interest-suggetion">
                                                <label class="is-checkbox">
                                                    <input type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/interest-horizontal.png';?>" alt="img">
                                                <div class="is-overlay">
                                                    <h1>Thriller Movies & Shows</h1>
                                                    <p>Like NH10, Talaash, Airlift, Mirzapur, Breathe</p>
                                                </div>
                                            </div>
                                            <div class="interest-suggetion">
                                                <label class="is-checkbox">
                                                    <input type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/interest-horizontal.png';?>" alt="img">
                                                <div class="is-overlay">
                                                    <h1>Thriller Movies & Shows</h1>
                                                    <p>Like NH10, Talaash, Airlift, Mirzapur, Breathe</p>
                                                </div>
                                            </div>
                                            <div class="interest-suggetion">
                                                <label class="is-checkbox">
                                                    <input type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/interest-horizontal.png';?>" alt="img">
                                                <div class="is-overlay">
                                                    <h1>Thriller Movies & Shows</h1>
                                                    <p>Like NH10, Talaash, Airlift, Mirzapur, Breathe</p>
                                                </div>
                                            </div>
                                            <div class="interest-suggetion">
                                                <label class="is-checkbox">
                                                    <input type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/interest-horizontal.png';?>" alt="img">
                                                <div class="is-overlay">
                                                    <h1>Thriller Movies & Shows</h1>
                                                    <p>Like NH10, Talaash, Airlift, Mirzapur, Breathe</p>
                                                </div>
                                            </div>
                                            <div class="interest-suggetion">
                                                <label class="is-checkbox">
                                                    <input type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/interest-horizontal.png" alt="img';?>">
                                                <div class="is-overlay">
                                                    <h1>Thriller Movies & Shows</h1>
                                                    <p>Like NH10, Talaash, Airlift, Mirzapur, Breathe</p>
                                                </div>
                                            </div>
                                            <div class="interest-suggetion">
                                                <label class="is-checkbox">
                                                    <input type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/interest-horizontal.png';?>" alt="img">
                                                <div class="is-overlay">
                                                    <h1>Thriller Movies & Shows</h1>
                                                    <p>Like NH10, Talaash, Airlift, Mirzapur, Breathe</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                <!-- better suggetion end -->
                                <!-- choose 5 suggetion start -->
                                <!-- <div class="better-solution">
                                    <div class="bs-left">
                                        <h4>
                                            Choose 3 or more interests for better suggestions
                                        </h4>
                                        <div class="choose">
                                            <div class="three">
                                                <span><img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/welcom.jpeg';?>" alt=""></span>
                                                <span><img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/dhamal.jpeg';?>" alt=""></span>
                                                <span><img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/welcom.jpeg';?>" alt=""></span>
                                                <span><img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/dhamal.jpeg';?>" alt=""></span>
                                                <span><img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/welcom.jpeg';?>" alt=""></span>
                                                <span class="span-text-5">5 of 5</span>
                                            </div>
                                            <button>Next 
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M5 12H19" stroke="#161616" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M12 5L19 12L12 19" stroke="#161616" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="bs-right">
                                        <div class="interest-suggetion width-3">
                                            <label class="is-checkbox">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                            <img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/dhamal.jpeg';?>" alt="img">
                                            <div class="is-overlay">
                                                <h1>Thriller Movies & Shows</h1>
                                                <p>Like NH10, Talaash, Airlift, Mirzapur, Breathe</p>
                                            </div>
                                        </div>
                                        <div class="interest-suggetion width-3">
                                            <label class="is-checkbox">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                            <img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/dhamal.jpeg';?>" alt="img">
                                            <div class="is-overlay">
                                                <h1>Thriller Movies & Shows</h1>
                                                <p>Like NH10, Talaash, Airlift, Mirzapur, Breathe</p>
                                            </div>
                                        </div>
                                        <div class="interest-suggetion width-3">
                                            <label class="is-checkbox">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                            <img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/dhamal.jpeg';?>" alt="img">
                                            <div class="is-overlay">
                                                <h1>Thriller Movies & Shows</h1>
                                                <p>Like NH10, Talaash, Airlift, Mirzapur, Breathe</p>
                                            </div>
                                        </div>
                                        <div class="interest-suggetion width-3">
                                            <label class="is-checkbox">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                            <img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/dhamal.jpeg';?>" alt="img">
                                            <div class="is-overlay">
                                                <h1>Thriller Movies & Shows</h1>
                                                <p>Like NH10, Talaash, Airlift, Mirzapur, Breathe</p>
                                            </div>
                                        </div>
                                        <div class="interest-suggetion width-3">
                                            <label class="is-checkbox">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                            <img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/dhamal.jpeg';?>" alt="img">
                                            <div class="is-overlay">
                                                <h1>Thriller Movies & Shows</h1>
                                                <p>Like NH10, Talaash, Airlift, Mirzapur, Breathe</p>
                                            </div>
                                        </div>
                                        <div class="interest-suggetion width-3">
                                            <label class="is-checkbox">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                            <img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/dhamal.jpeg';?>" alt="img">
                                            <div class="is-overlay">
                                                <h1>Thriller Movies & Shows</h1>
                                                <p>Like NH10, Talaash, Airlift, Mirzapur, Breathe</p>
                                            </div>
                                        </div>
                                        <div class="interest-suggetion width-3">
                                            <label class="is-checkbox">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                            <img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/dhamal.jpeg';?>" alt="img">
                                            <div class="is-overlay">
                                                <h1>Thriller Movies & Shows</h1>
                                                <p>Like NH10, Talaash, Airlift, Mirzapur, Breathe</p>
                                            </div>
                                        </div>
                                        <div class="interest-suggetion width-3">
                                            <label class="is-checkbox">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                            <img src="<?php echo config('epicconfig.ASSET.ASSET_URL').'/img/dhamal.jpeg';?>" alt="img">
                                            <div class="is-overlay">
                                                <h1>Thriller Movies & Shows</h1>
                                                <p>Like NH10, Talaash, Airlift, Mirzapur, Breathe</p>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            <!-- choose 5 suggetion end -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@foreach($result['data']['list'] as $key => $value)
@if( isset($value['display_type']) && isset($value['content']) && !empty($value['content']))
@php
$template = 'display.'.$value['display_type'];
@endphp

@if(View::exists($template))
<?php
$title = getDispLangContent($value, $displayLanguageParam, 'title');
$shortdescription = getDispLangContent($value, $displayLanguageParam, 'shortdesc');
?>


@include($template,['value' => $value,'title' => $title,'shortdescription' => $shortdescription])

@else
<h1>
    Template not found - {{ $value['display_type'] }}
</h1>

@endif

@endif
@endforeach


@stop

@section('script')
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        var TrandingSlider = new Swiper('.tranding-slider', {
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            loop: true,
            slidesPerView: 'auto',
            coverflowEffect: {
                rotate: 0,
                stretch: 0,
                depth: 500,
                modifier: 50,
                slideShadows: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            }
        });

        $('.screen2').hide();
        $('#login-modal').show();
        $('#login-modal').addClass("show");
        

        $(".closebtn").click(function(){
          $('#login-modal').hide();
          $('#login-modal').removeClass("show");
        });

        $(".login-btn").click(function(){
            var isInput = $("#mobile_number").val();
            var type = $.isNumeric(isInput);
                if(type == true){
                 $("#signup_method").val('MOBILE');
                }else{
                    $("#signup_method").val('EMAIL');
                }
            // return isValidContact(isInput);
            if(isValidContact(isInput) == true){
                // ajax call
                alert("true");
                var formData = $('#mobile-number-form-id').serialize();
                console.log(formData+"Form Data Response");
                $.ajax({
                    url: '/sendotp',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        var response = JSON.parse(response);
                        // console.log(response.success);
                        // console.log(JSON.parse(response)+"Response");
                        // $('#dynamic-content').html(response.content);
                    },
                    error: function(xhr, status, error) {
                        console.error('Request failed with status:', status);
                    }
                });
            }else{
                alert("false");
                return isValidContact(isInput);
            }

            // $('.screen1').hide();
        });
    });
</script>
@stop