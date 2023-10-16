<?php
$genreList = @$genrelist['success'] && array_key_exists('data', $genrelist) ? $genrelist['data'] : [];
$interests = array_key_exists("interests", $user_data) ? $user_data['interests'] : [];
$interestsCount = count($interests) ?? 0;
$kidSection = array_key_exists("kidSection", $user_data) ? $user_data['kidSection'] : false;
$activeDevices = @$activeDevice['success'] && array_key_exists('data', $activeDevice) ? $activeDevice['data'] : [];
//$segment2 =  Request::segment(2);
$request = Request();
$ispin = $request->input('status') ?? '';
//echo $ispin;exit;
//$ispin = $segment2 ?? '';
?>
 
@extends('layouts.default')
@section('title','Setting')

@section('style')
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

    .setting-right .tab-content .tab-pane {
        padding: 0;
    }

    .setting-right .tab-content .tab-pane.show.active {
        padding: 20px 15px;
    }
</style>

@stop

@section('content')
<!-- childpin model -->
<div class="modal fade" id="childpin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered px-3">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <img width="100" src="{{ asset('/img/success-tick.png') }}" alt="img">
                <h4 class="text-white mt-4">{{__('Child PIN has been created successfully!')}}</h4>
                <p class="w-75 text-white small m-auto mb-4">{{__('You can change it again any time from the settings tab.')}}</p>

                <button class="login-btn mt-0 bg-transparent text-white" class="btn-close" style="width: 280px;" data-bs-dismiss="modal" aria-label="Close">{{__('Done')}}</button>
            </div>
        </div>
    </div>
</div>

<!-- changed childpin model -->
<div class="modal fade" id="changed-childpin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered px-3">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <img width="100" src="{{ asset('/img/success-tick.png') }}" alt="img">
                <h4 class="text-white mt-4">{{__('Child PIN has been updated successfully!')}}</h4>
                <p class="w-75 text-white small m-auto mb-4">{{__('You can change it again any time from the settings tab.')}}</p>

                <button class="login-btn mt-0 bg-transparent text-white" class="btn-close" style="width: 280px;" data-bs-dismiss="modal" aria-label="Close">{{__('Done')}}</button>
            </div>
        </div>
    </div>
</div>

<!-- changed password model -->
<div class="modal fade" id="changed-pass" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered px-3">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <img width="100" src="{{ asset('/img/success-tick.png') }}" alt="img">
                <h4 class="text-white mt-4">{{__('Your password has been changed successfully!')}}</h4>
                <p class="w-75 text-white small m-auto mb-4">{{__('You can change it again any time from the settings tab.')}}</p>

                <button class="login-btn mt-0 bg-transparent text-white" class="btn-close" style="width: 280px;" data-bs-dismiss="modal" aria-label="Close">{{__('Done')}}</button>
            </div>
        </div>
    </div>
</div>

<!-- clear history model -->
<div class="modal fade" id="clear-history" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered px-3">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <img width="100" src="{{ asset('/img/success-tick.png') }}" alt="img">
                <h4 class="text-white mt-4">{{__('Your search history has been cleared successfully!')}}</h4>
                <p class="w-75 text-white small m-auto mb-4">{{__('Get ready for a fresh browsing experience.')}}</p>

                <button class="login-btn mt-0 bg-transparent text-white" class="btn-close" style="width: 280px;" data-bs-dismiss="modal" aria-label="Close">{{__('Done')}}</button>
            </div>
        </div>
    </div>
</div>

<!-- delete yr account model -->
<div class="modal fade" id="delete-account" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered px-3">
        <div class="modal-content">
            <div class="modal-body text-center py-5" id="sendOTP">
                <h4 class="text-white mt-2 mb-4">{{__('Deleting Your Account')}}</h4>
                <div class="col-sm-8 m-auto">
                    <div class="text-start mb-5">
                        <label class="text-white mb-1" for="">{{__('Please enter your current password')}}</label>
                        <div class="input-field w-100 mb-3">
                            <input class="form-control" type="password" id="passwordForDelete" placeholder="{{__('Current Password')}}">
                            <button class="eye" data-target="passwordForDelete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16" viewBox="0 0 22 16" fill="none">
                                    <path d="M11 5C10.2044 5 9.44129 5.31607 8.87868 5.87868C8.31607 6.44129 8 7.20435 8 8C8 8.79565 8.31607 9.55871 8.87868 10.1213C9.44129 10.6839 10.2044 11 11 11C11.7956 11 12.5587 10.6839 13.1213 10.1213C13.6839 9.55871 14 8.79565 14 8C14 7.20435 13.6839 6.44129 13.1213 5.87868C12.5587 5.31607 11.7956 5 11 5ZM11 13C9.67392 13 8.40215 12.4732 7.46447 11.5355C6.52678 10.5979 6 9.32608 6 8C6 6.67392 6.52678 5.40215 7.46447 4.46447C8.40215 3.52678 9.67392 3 11 3C12.3261 3 13.5979 3.52678 14.5355 4.46447C15.4732 5.40215 16 6.67392 16 8C16 9.32608 15.4732 10.5979 14.5355 11.5355C13.5979 12.4732 12.3261 13 11 13ZM11 0.5C6 0.5 1.73 3.61 0 8C1.73 12.39 6 15.5 11 15.5C16 15.5 20.27 12.39 22 8C20.27 3.61 16 0.5 11 0.5Z" fill="white" />
                                </svg>
                            </button>
                            <span class="text-danger text-start d-flex mt-1" style="font-size: 12px;"></span>
                            <p class="mb-0 small text-white">{{__('We’ll send you an OTP to verify your account')}}</p>
                        </div>
                    </div>
                </div>
                <button class="login-btn mt-4" id="getDeleteAccountOTP" style="width: 280px;">
                    {{__('Get OTP Now')}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"></path>
                    </svg>
                </button>
                <span class="text-danger text-start d-flex mt-1 error" id="password-error" style="font-size: 12px;"></span>
                <button class="login-btn mt-0 bg-transparent text-white" class="btn-close" style="width: 280px;" data-bs-dismiss="modal" aria-label="Close">{{__('Go Back')}}</button>
            </div>


            <div class="modal-body text-center py-5" id="verifyOTP">
                <h4 class="text-white mt-2 mb-4">{{__('Deleting Your Account')}}</h4>
                <form id="verifyOTPDeleteAccountForm">
                    <div class="col-sm-12 col-md-12 col-lg-7 m-auto">
                        <div class="mb-5">
                            <label class="text-white text-start w-100 mb-1" for="">{{__('Enter the 4-digit code sent to +9186******41')}}</label>
                            <div class="childpin">
                                <div class="childpin-input d-flex justify-content-between pt-3">
                                    <input class="mx-1 child-box onlydigit" name="verifyOTP[]" type="text" min="0" max="9" maxlength="1">
                                    <input class="mx-1 child-box onlydigit" name="verifyOTP[]" type="text" min="0" max="9" maxlength="1">
                                    <input class="mx-1 child-box onlydigit" name="verifyOTP[]" type="text" min="0" max="9" maxlength="1">
                                    <input class="mx-1 child-box onlydigit" name="verifyOTP[]" type="text" min="0" max="9" maxlength="1">
                                    <input class="mx-1 child-box onlydigit" name="verifyOTP[]" type="text" min="0" max="9" maxlength="1">
                                    <input class="mx-1 child-box onlydigit" name="verifyOTP[]" type="text" min="0" max="9" maxlength="1">
                                </div>
                            </div>
                            <p class="text-start w-100 text-white small mt-2 resend-otp">{{__('Resend OTP in 0:30')}}</p>
                            <button class="btn btn-primary" id="resendOTPBtn" onclick="resendVerifyOTP()" style="display:none">{{__('Resend OTP')}}</button>
                        </div>
                    </div>
                    <a id="verifyDeleteAccountOTPBtn" class="login-btn mt-4" style="width: 280px;">
                        {{__('Verify OTP')}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"></path>
                        </svg>
                    </a>
                    <span class="text-danger text-start d-flex mt-1 error" id="verify-otp-error" style="font-size: 12px;"></span>
                    <button type="button" class="login-btn mt-0 bg-transparent text-white" class="btn-close" style="width: 280px;" data-bs-dismiss="modal" aria-label="Close">{{__('Cancel')}}</button>
                </form>
            </div>

            <div class="modal-body text-center py-5" id="reasonFordelete">
                <h4 class="text-white mt-2 mb-4">{{__('Deleting Your Account')}}</h4>
                <div class="col-sm-12 col-md-12 col-lg-7 m-auto">
                    <div class="mb-5">
                        <div class="input-field w-100 mb-3">
                            <p class="text-start w-100 text-white mt-2">{{__('Tell us why you’re leaving us so soon?')}}</p>
                            <select name="deleteAcctReason" id="deleteAcctReason">
                                <option value="">{{__('Reason(Optional)')}}</option>
                                <option value="I didn’t like the platform">{{__('I didn’t like the platform')}}</option>
                                <option value="I have privacy concerns">{{__('I have privacy concerns')}}</option>
                                <option value="It is very costly">{{__('It is very costly')}}</option>
                                <option value="I am wasting too much time">{{__('I am wasting too much time')}}</option>
                                <option value="Just need a break">{{__('Just need a break')}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <a id="deleteAcctReasonBtn" class="login-btn mt-4" style="width: 280px;">
                    {{__('Delete Account')}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"></path>
                    </svg>
                </a>
                <span class="text-danger text-start d-flex mt-1 error" id="reason-error" style="font-size: 12px;"></span>
                <button class="login-btn mt-0 bg-transparent text-white" class="btn-close" style="width: 280px;" data-bs-dismiss="modal" aria-label="Close">{{__('Cancel')}}</button>
            </div>

        </div>
    </div>
</div>


<section class="w-100 mt-4">
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-3 pb-4">
                <div class="sidenav-setting">
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <input type="hidden" name="ispin" value="{{$ispin}}" id="ispin">
                        <button class="nav-link bg-transparent">
                            <h4>{{__('Settings')}}</h4>
                        </button>
                        <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">{{__('Account')}}</button>
                        <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">{{__('Language')}}</button>

                        <button class="nav-link bg-transparent d-flex justify-content-between">
                            <span>{{__('Privacy & Policy')}}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M12.0677 13.3139L17.0177 8.36388C17.11 8.26837 17.2203 8.19219 17.3423 8.13978C17.4643 8.08737 17.5955 8.05979 17.7283 8.05863C17.8611 8.05748 17.9928 8.08278 18.1157 8.13306C18.2386 8.18334 18.3502 8.25759 18.4441 8.35149C18.538 8.44538 18.6123 8.55703 18.6625 8.67993C18.7128 8.80282 18.7381 8.9345 18.737 9.06728C18.7358 9.20006 18.7082 9.33128 18.6558 9.45329C18.6034 9.57529 18.5272 9.68564 18.4317 9.77788L12.7747 15.4349C12.5872 15.6224 12.3329 15.7277 12.0677 15.7277C11.8026 15.7277 11.5483 15.6224 11.3607 15.4349L5.70373 9.77788C5.60822 9.68564 5.53203 9.57529 5.47962 9.45329C5.42722 9.33128 5.39963 9.20006 5.39848 9.06728C5.39732 8.9345 5.42262 8.80282 5.4729 8.67993C5.52318 8.55703 5.59744 8.44538 5.69133 8.35149C5.78522 8.25759 5.89688 8.18334 6.01977 8.13306C6.14267 8.08278 6.27435 8.05748 6.40713 8.05863C6.53991 8.05979 6.67113 8.08737 6.79313 8.13978C6.91513 8.19219 7.02548 8.26837 7.11773 8.36388L12.0677 13.3139Z" fill="white" />
                            </svg>
                        </button>

                        <button class="nav-link" id="v-pills-sync-tab" data-bs-toggle="pill" data-bs-target="#v-pills-sync" type="button" role="tab" aria-controls="v-pills-sync" aria-selected="true">{{__('Sync Device')}}</button>
                        <button class="nav-link" id="v-pills-active-device-tab" data-bs-toggle="pill" data-bs-target="#v-pills-active-device" type="button" role="tab" aria-controls="v-pills-active-device" aria-selected="true">{{__('Active Devices')}}</button>
                        <button class="nav-link" id="v-pills-childpin-tab" data-bs-toggle="pill" data-bs-target="#v-pills-childpin" type="button" role="tab" aria-controls="v-pills-childpin" aria-selected="true">{{__('Set/Change Child PIN')}}</button>
                        <button class="nav-link" id="v-pills-changed-password-tab" data-bs-toggle="pill" data-bs-target="#v-pills-changed-password" type="button" role="tab" aria-controls="v-pills-changed-password" aria-selected="true">{{__('Change Password')}}</button>
                        <button class="nav-link" id="v-pills-clear-search-history-tab" data-bs-toggle="pill" data-bs-target="#v-pills-clear-search-history" type="button" role="tab" aria-controls="v-pills-clear-search-history" aria-selected="true">{{__('Clear Search History')}}</button>
                        <button class="nav-link" id="v-pills-delete-account-tab" data-bs-toggle="pill" data-bs-target="#v-pills-delete-account" type="button" role="tab" aria-controls="v-pills-delete-account" aria-selected="true">{{__('Delete Account')}}</button>

                    </div>
                </div>
            </div>
            <div class="col-sm-9 pb-4">
                <div class="setting-right">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane text-white fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <!-- choose 5 suggetion start -->
                            <div class="better-solution">
                                <form id="updateInterestForm" class="better-solution">
                                    <div class="bs-left">
                                        <h4 class="mb-2">
                                            {{__('Manage your preferences')}}
                                        </h4>
                                        <p class="small text-start w-100">{{__('Update your interests')}} ({{__('choose 5')}})</p>
                                        <div class="choose">
                                            <div class="three">
                                                <span><img src="{{ asset('/img/welcom.jpeg') }}" alt=""></span>
                                                <span><img src="{{ asset('/img/dhamal.jpeg') }}" alt=""></span>
                                                <span><img src="{{ asset('/img/welcom.jpeg') }}" alt=""></span>
                                                <span><img src="{{ asset('/img/dhamal.jpeg') }}" alt=""></span>
                                                <span><img src="{{ asset('/img/welcom.jpeg') }}" alt=""></span>
                                                <span class="span-text-5 genre-select-count">{{ $interestsCount }} of 5</span>
                                            </div>
                                            <button type="button" id="updatePreference">{{('Next')}}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M5 12H19" stroke="#161616" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M12 5L19 12L12 19" stroke="#161616" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div id="error-meg-for-genre-select" style="color: red;"></div>
                                        <div id="success-meg-for-genre-select" style="color: green;"></div>
                                    </div>
                                    <div class="bs-right">
                                        <?php foreach ($genreList as $genre) { ?>
                                            <div class="interest-suggetion width-3">
                                                <label class="is-checkbox">
                                                    <input type="checkbox" name="genreInterest[]" <?php if (in_array($genre['genre'], $interests)) {
                                                                                                        echo "checked";
                                                                                                    } ?> value="{{ $genre['genre'] }}">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <img src="{{ $genre['cover_image']['medium'] }}" alt="{{ $genre['genre'] }}">
                                                <div class="is-overlay">
                                                    <h1>{{ $genre['genre'] }}</h1>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </form>
                            </div>
                            <!-- choose 5 suggetion end -->
                        </div>
                        <div class="tab-pane text-white fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                            <div class="language-setting">
                                <h4 class="pb-4 border-bot">{{ __('Manage your language preferences') }} </h4>

                                <div class="display-language border-bot">
                                    <p>{{ __('Display Language') }}</p>
                                    <div>
                                        <div class="form-check mb-4">
                                            <input class="form-check-input me-2" type="radio" name="displayLang" id="exampleRadios2" value="en" <?php if ($displayLanguage == 'en') {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                            <label class="form-check-label" for="exampleRadios2">
                                                {{ __('English') }}
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input me-2" type="radio" name="displayLang" id="exampleRadios3" value="hi" <?php if ($displayLanguage == 'hi') {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                            <label class="form-check-label" for="exampleRadios3">
                                                {{ __('Hindi')}}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="display-language pb-0">
                                    <p>{{ __('Content Language') }}</p>
                                    <div>
                                        <div class="form-check mb-4">
                                            <input class="form-check-input me-2" type="radio" name="contentLang" id="exampleRadios7" value="all" <?php if ($listLanguage == 'all') {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                            <label class="form-check-label" for="exampleRadios7">
                                                {{__('All')}}
                                            </label>
                                        </div>
                                        <div class="form-check mb-4">
                                            <input class="form-check-input me-2" type="radio" name="contentLang" id="exampleRadios8" value="en" <?php if ($listLanguage == 'en') {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                            <label class="form-check-label" for="exampleRadios8">
                                                {{ __('English') }}
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input me-2" type="radio" name="contentLang" id="exampleRadios9" value="hi" <?php if ($listLanguage == 'hi') {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                            <label class="form-check-label" for="exampleRadios9">
                                                {{__('Hindi')}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane text-white fade" id="v-pills-sync" role="tabpanel" aria-labelledby="v-pills-sync-tab">
                            <div class="language-setting">
                                <h4 class="pb-4 border-bot">{{__('Sync your device')}}</h4>

                                <div class="sync-device-main pb-4 w-100">
                                    <div class="pt-3">
                                        <p>{{__('Use the generated pin to Sign-in on your smart tv')}}</p>
                                        <div class="sync-device">
                                            <h1 id="syncDevicePin">{{ $syncPin }}</h1> <a href="javascript:regenerateSyncPin()" class="">{{__('Regenerate PIN')}}</a>
                                        </div>
                                        <div class="d-flex mt-5">
                                            <button class="border-btn copyBtn" onclick="copyText('syncDevicePin')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1.33594 12.6654C1.33594 13.1958 1.54665 13.7045 1.92172 14.0796C2.2968 14.4547 2.8055 14.6654 3.33594 14.6654H5.33594V13.332H3.33594C3.15913 13.332 2.98956 13.2618 2.86453 13.1368C2.73951 13.0117 2.66927 12.8422 2.66927 12.6654V3.33203C2.66927 3.15522 2.73951 2.98565 2.86453 2.86063C2.98956 2.7356 3.15913 2.66536 3.33594 2.66536H12.6693C12.8461 2.66536 13.0157 2.7356 13.1407 2.86063C13.2657 2.98565 13.3359 3.15522 13.3359 3.33203V5.33203H7.33594C6.8055 5.33203 6.2968 5.54274 5.92172 5.91782C5.54665 6.29289 5.33594 6.8016 5.33594 7.33203V16.6654C5.33594 17.1958 5.54665 17.7045 5.92172 18.0796C6.2968 18.4547 6.8055 18.6654 7.33594 18.6654H16.6693C17.1997 18.6654 17.7084 18.4547 18.0835 18.0796C18.4586 17.7045 18.6693 17.1958 18.6693 16.6654V7.33203C18.6693 6.8016 18.4586 6.29289 18.0835 5.91782C17.7084 5.54274 17.1997 5.33203 16.6693 5.33203H14.6693V3.33203C14.6693 2.8016 14.4586 2.29289 14.0835 1.91782C13.7084 1.54274 13.1997 1.33203 12.6693 1.33203H3.33594C2.8055 1.33203 2.2968 1.54274 1.92172 1.91782C1.54665 2.29289 1.33594 2.8016 1.33594 3.33203V12.6654ZM6.66927 7.33203C6.66927 7.15522 6.73951 6.98565 6.86453 6.86063C6.98956 6.7356 7.15913 6.66536 7.33594 6.66536H16.6693C16.8461 6.66536 17.0157 6.7356 17.1407 6.86063C17.2657 6.98565 17.3359 7.15522 17.3359 7.33203V16.6654C17.3359 16.8422 17.2657 17.0117 17.1407 17.1368C17.0157 17.2618 16.8461 17.332 16.6693 17.332H7.33594C7.15913 17.332 6.98956 17.2618 6.86453 17.1368C6.73951 17.0117 6.66927 16.8422 6.66927 16.6654V7.33203Z" fill="white" />
                                                </svg>&nbsp;
                                                {{__('Copy PIN')}}
                                            </button>
                                            <button class="border-btn copiedBtn" style="display:none">{{__('Copied')}}</button>
                                            <button class="fill-btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <g clip-path="url(#clip0_91_19405)">
                                                        <path d="M15.2907 13.3338C14.9165 13.3352 14.5465 13.4122 14.2028 13.5602C13.8591 13.7082 13.5489 13.9241 13.2907 14.1949L6.51848 10.806C6.68507 10.3009 6.68507 9.7556 6.51848 9.25046L13.3018 5.80046C13.7877 6.31248 14.4466 6.62555 15.1504 6.67883C15.8543 6.7321 16.5528 6.52178 17.1102 6.08873C17.6676 5.65569 18.0441 5.03086 18.1665 4.3357C18.2889 3.64053 18.1484 2.92469 17.7724 2.32731C17.3964 1.72993 16.8117 1.2937 16.132 1.10339C15.4523 0.913075 14.7261 0.982291 14.0946 1.29758C13.463 1.61287 12.9713 2.1517 12.7149 2.80935C12.4586 3.467 12.4559 4.19649 12.7074 4.85602L5.9907 8.27268C5.62795 7.82904 5.13686 7.50845 4.58476 7.35486C4.03266 7.20127 3.44657 7.2222 2.90683 7.41478C2.36709 7.60735 1.90012 7.96215 1.56993 8.43053C1.23974 8.89891 1.0625 9.45795 1.0625 10.031C1.0625 10.6041 1.23974 11.1631 1.56993 11.6315C1.90012 12.0999 2.36709 12.4547 2.90683 12.6473C3.44657 12.8398 4.03266 12.8608 4.58476 12.7072C5.13686 12.5536 5.62795 12.233 5.9907 11.7894L12.6907 15.1616C12.5775 15.4655 12.5192 15.7872 12.5185 16.1116C12.5185 16.661 12.6814 17.198 12.9866 17.6548C13.2918 18.1116 13.7257 18.4677 14.2332 18.6779C14.7408 18.8881 15.2993 18.9432 15.8382 18.836C16.377 18.7288 16.872 18.4642 17.2604 18.0758C17.6489 17.6873 17.9135 17.1923 18.0207 16.6535C18.1278 16.1147 18.0728 15.5561 17.8626 15.0486C17.6523 14.541 17.2963 14.1072 16.8395 13.8019C16.3827 13.4967 15.8456 13.3338 15.2963 13.3338H15.2907ZM15.2907 2.22268C15.6203 2.22268 15.9426 2.32043 16.2166 2.50357C16.4907 2.6867 16.7044 2.947 16.8305 3.25154C16.9566 3.55609 16.9896 3.8912 16.9253 4.2145C16.861 4.5378 16.7023 4.83477 16.4692 5.06786C16.2361 5.30095 15.9392 5.45968 15.6158 5.52399C15.2925 5.5883 14.9574 5.5553 14.6529 5.42915C14.3483 5.303 14.0881 5.08938 13.9049 4.8153C13.7218 4.54122 13.624 4.21899 13.624 3.88935C13.624 3.44732 13.7996 3.0234 14.1122 2.71084C14.4247 2.39828 14.8487 2.22268 15.2907 2.22268ZM3.88514 11.6671C3.55551 11.6671 3.23328 11.5694 2.95919 11.3862C2.68511 11.2031 2.47149 10.9428 2.34534 10.6383C2.2192 10.3337 2.18619 9.99861 2.2505 9.67531C2.31481 9.35201 2.47355 9.05504 2.70663 8.82195C2.93972 8.58886 3.23669 8.43013 3.55999 8.36582C3.8833 8.30151 4.21841 8.33452 4.52295 8.46066C4.82749 8.58681 5.08779 8.80043 5.27093 9.07451C5.45406 9.34859 5.55181 9.67083 5.55181 10.0005C5.55181 10.4425 5.37622 10.8664 5.06366 11.179C4.75109 11.4915 4.32717 11.6671 3.88514 11.6671ZM15.2907 17.7782C14.9611 17.7782 14.6388 17.6805 14.3647 17.4974C14.0907 17.3142 13.877 17.0539 13.7509 16.7494C13.6248 16.4448 13.5917 16.1097 13.6561 15.7864C13.7204 15.4631 13.8791 15.1661 14.1122 14.9331C14.3453 14.7 14.6422 14.5412 14.9655 14.4769C15.2888 14.4126 15.624 14.4456 15.9285 14.5718C16.233 14.6979 16.4933 14.9115 16.6765 15.1856C16.8596 15.4597 16.9574 15.7819 16.9574 16.1116C16.9574 16.5536 16.7818 16.9775 16.4692 17.2901C16.1566 17.6026 15.7327 17.7782 15.2907 17.7782Z" fill="black" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_91_19405">
                                                            <rect width="20" height="20" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>&nbsp;
                                                {{__('Share PIN')}}
                                            </button>
                                        </div>
                                    </div>
                                    <img class="mt-3 mb-2" width="150" src="{{ asset('/img/sync-yr-device.svg') }}" alt="">
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane text-white fade" id="v-pills-active-device" role="tabpanel" aria-labelledby="v-pills-active-device-tab">
                            <div class="language-setting">
                                <h4 class="pb-4 border-bot">{{__('Manage the active devices')}}</h4>

                                <div class="container-fluid">
                                    <?php if (count($activeDevices) > 0) {
                                        foreach ($activeDevices as $device) {
                                            $deviceId = $device['id'];
                                    ?>
                                            <div class="row border-bot pt-4" data-id="{{ $deviceId }}">
                                                <div class="col-sm-4 col-md-3">
                                                    <p>{{__('Device')}}</p>
                                                </div>
                                                <div class="col-sm-4 col-md-5">
                                                    <div class="form-check d-flex align-items-center ps-0 mb-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M3.9375 2.25C3.29103 2.25 2.67105 2.50681 2.21393 2.96393C1.75681 3.42105 1.5 4.04103 1.5 4.6875V16.3125C1.5 16.959 1.75681 17.579 2.21393 18.0361C2.67105 18.4932 3.29103 18.75 3.9375 18.75H9.0075V20.2507H6.759C6.65856 20.2476 6.55851 20.2646 6.46479 20.3009C6.37106 20.3371 6.28558 20.3918 6.21341 20.4617C6.14124 20.5316 6.08385 20.6154 6.04467 20.7079C6.00548 20.8004 5.98529 20.8999 5.98529 21.0004C5.98529 21.1009 6.00548 21.2003 6.04467 21.2929C6.08385 21.3854 6.14124 21.4691 6.21341 21.539C6.28558 21.6089 6.37106 21.6637 6.46479 21.6999C6.55851 21.7361 6.65856 21.7532 6.759 21.75H17.253C17.3534 21.7532 17.4535 21.7361 17.5472 21.6999C17.6409 21.6637 17.7264 21.6089 17.7986 21.539C17.8708 21.4691 17.9281 21.3854 17.9673 21.2929C18.0065 21.2003 18.0267 21.1009 18.0267 21.0004C18.0267 20.8999 18.0065 20.8004 17.9673 20.7079C17.9281 20.6154 17.8708 20.5316 17.7986 20.4617C17.7264 20.3918 17.6409 20.3371 17.5472 20.3009C17.4535 20.2646 17.3534 20.2476 17.253 20.2507H15.0045V18.75H20.0625C20.709 18.75 21.329 18.4932 21.7861 18.0361C22.2432 17.579 22.5 16.959 22.5 16.3125V4.6875C22.5 4.04103 22.2432 3.42105 21.7861 2.96393C21.329 2.50681 20.709 2.25 20.0625 2.25H3.9375ZM13.5045 18.75V20.2507H10.5075V18.75H13.5045ZM3 4.6875C3 4.17 3.42 3.75 3.9375 3.75H20.0625C20.58 3.75 21 4.17 21 4.6875V16.3125C21 16.83 20.58 17.25 20.0625 17.25H3.9375C3.42 17.25 3 16.83 3 16.3125V4.6875Z" fill="white" />
                                                        </svg>
                                                        <div class="ms-3">
                                                            <p class="mb-0 w-auto">{{ $device['device'] }}</p>
                                                            <span class="small text-opacity">{{__('Last Active')}}: <?php echo date('Y-m-d h:i:s A', strtotime($device['date'])); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-md-4">
                                                    <button class="border-btn mb-4" onclick="logoutDevice('{{ $deviceId }}')">{{__('Log Out')}}</button>
                                                </div>
                                            </div>
                                        <?php }
                                    } else { ?>
                                        <div class="row pt-4">
                                            <div class="col-sm-4 col-md-3">
                                                <p>{{__('No device found')}}</p>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane text-white fade" id="v-pills-childpin" role="tabpanel" aria-labelledby="v-pills-childpin-tab">
                            <div class="language-setting">
                                <h4 class="pb-4 border-bot">{{__('Control kids’ access')}}</h4>

                                <div class="childpin text-start py-4">
                                    <form id="childPinForm">
                                        <?php if (!$kidSection) { ?>
                                            <div>
                                                <input type="hidden" name="command" value="createKidsPin">
                                                <h6 class="mb-3">{{__('Create a 4-digit Child PIN')}}</h6>
                                                <p class="small mb-4">{{__('This PIN will be used to switch from kids profile to all adult profiles')}}</p>
                                                <div class="childpin-input pt-3">
                                                    <input class="mx-1 child-box onlydigit" type="text" min="0" max="9" name="kidsPin[]" maxlength="1">
                                                    <input class="mx-1 child-box onlydigit" type="text" min="0" max="9" name="kidsPin[]" maxlength="1">
                                                    <input class="mx-1 child-box onlydigit" type="text" min="0" max="9" name="kidsPin[]" maxlength="1">
                                                    <input class="mx-1 child-box onlydigit" type="text" min="0" max="9" name="kidsPin[]" maxlength="1">
                                                </div>
                                                <button type="button" class="login-btn mt-5 ms-0" id="setChildPin" style="width: 280px;">
                                                    Done
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"></path>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        <?php } else { ?>
                                            <div>
                                                <input type="hidden" name="command" value="changeKidsPin">
                                                <h6 class="mb-3">{{__('Change Child PIN')}}</h6>
                                                <div class="d-flex align-items-center mb-4">
                                                    <p class="small" style="width: 150px;">{{__('Current PIN')}}</p>
                                                    <div class="childpin-input">
                                                        <input class="mx-1 child-box onlydigit" type="text" min="0" max="9" name="oldKidsPin[]" maxlength="1">
                                                        <input class="mx-1 child-box onlydigit" type="text" min="0" max="9" name="oldKidsPin[]" maxlength="1">
                                                        <input class="mx-1 child-box onlydigit" type="text" min="0" max="9" name="oldKidsPin[]" maxlength="1">
                                                        <input class="mx-1 child-box onlydigit" type="text" min="0" max="9" name="oldKidsPin[]" maxlength="1">
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <p class="small" style="width: 150px;">{{__('New PIN')}}</p>
                                                    <div class="childpin-input">
                                                        <input class="mx-1 child-box onlydigit" type="text" min="0" max="9" name="newKidsPin[]" maxlength="1">
                                                        <input class="mx-1 child-box onlydigit" type="text" min="0" max="9" name="newKidsPin[]" maxlength="1">
                                                        <input class="mx-1 child-box onlydigit" type="text" min="0" max="9" name="newKidsPin[]" maxlength="1">
                                                        <input class="mx-1 child-box onlydigit" type="text" min="0" max="9" name="newKidsPin[]" maxlength="1">
                                                    </div>
                                                </div>
                                                <button type="button" class="login-btn mt-5 ms-0" id="setChildPin" style="width: 280px;">
                                                    {{__('Done')}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"></path>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        <?php } ?>
                                        <div id="error-msg" style="color: red;"></div>
                                        <div id="success-msg" style="color: green;"></div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane text-white fade" id="v-pills-changed-password" role="tabpanel" aria-labelledby="v-pills-changed-password-tab">
                            <div class="language-setting">
                                <h4 class="pb-4 border-bot">{{__('Manage your passwords')}}</h4>

                                <div class="childpin text-start py-4">
                                    <form id="change_password">
                                        <h6 class="mb-3">{{__('Change Password')}}</h6>

                                        <div class="container-fluid ps-0">
                                            <div class="row">
                                                <div class="col-sm-3 col-md-4 col-lg-3 col-xl-3 d-flex align-items-center">
                                                    <p>{{__('Current Password')}}</p>
                                                </div>
                                                <div class="col-sm-4 col-md-7 col-lg-6 col-xl-5">
                                                    <div class="input-field w-100 mb-3">
                                                        <input type="password" name="old_password" class="form-control" id="old_password" placeholder="{{__('Current Password')}}">
                                                        <button class="eye" type="button" data-target="old_password">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16" viewBox="0 0 22 16" fill="none">
                                                                <path d="M11 5C10.2044 5 9.44129 5.31607 8.87868 5.87868C8.31607 6.44129 8 7.20435 8 8C8 8.79565 8.31607 9.55871 8.87868 10.1213C9.44129 10.6839 10.2044 11 11 11C11.7956 11 12.5587 10.6839 13.1213 10.1213C13.6839 9.55871 14 8.79565 14 8C14 7.20435 13.6839 6.44129 13.1213 5.87868C12.5587 5.31607 11.7956 5 11 5ZM11 13C9.67392 13 8.40215 12.4732 7.46447 11.5355C6.52678 10.5979 6 9.32608 6 8C6 6.67392 6.52678 5.40215 7.46447 4.46447C8.40215 3.52678 9.67392 3 11 3C12.3261 3 13.5979 3.52678 14.5355 4.46447C15.4732 5.40215 16 6.67392 16 8C16 9.32608 15.4732 10.5979 14.5355 11.5355C13.5979 12.4732 12.3261 13 11 13ZM11 0.5C6 0.5 1.73 3.61 0 8C1.73 12.39 6 15.5 11 15.5C16 15.5 20.27 12.39 22 8C20.27 3.61 16 0.5 11 0.5Z" fill="white" />
                                                            </svg>
                                                        </button>
                                                        <span class="text-danger text-start d-flex mt-1 cngPwd" id="oldPwd" style="font-size: 12px;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3 col-md-4 col-lg-3 col-xl-3 d-flex align-items-center">
                                                    <p>{{__('New Password')}}</p>
                                                </div>
                                                <div class="col-sm-4 col-md-7 col-lg-6 col-xl-5">
                                                    <div class="input-field w-100 mb-3">
                                                        <input type="password" name="new_password" class="form-control" id="new_password" placeholder="{{__('New Password')}}">
                                                        <button type="button" class="eye" data-target="new_password">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16" viewBox="0 0 22 16" fill="none">
                                                                <path d="M11 5C10.2044 5 9.44129 5.31607 8.87868 5.87868C8.31607 6.44129 8 7.20435 8 8C8 8.79565 8.31607 9.55871 8.87868 10.1213C9.44129 10.6839 10.2044 11 11 11C11.7956 11 12.5587 10.6839 13.1213 10.1213C13.6839 9.55871 14 8.79565 14 8C14 7.20435 13.6839 6.44129 13.1213 5.87868C12.5587 5.31607 11.7956 5 11 5ZM11 13C9.67392 13 8.40215 12.4732 7.46447 11.5355C6.52678 10.5979 6 9.32608 6 8C6 6.67392 6.52678 5.40215 7.46447 4.46447C8.40215 3.52678 9.67392 3 11 3C12.3261 3 13.5979 3.52678 14.5355 4.46447C15.4732 5.40215 16 6.67392 16 8C16 9.32608 15.4732 10.5979 14.5355 11.5355C13.5979 12.4732 12.3261 13 11 13ZM11 0.5C6 0.5 1.73 3.61 0 8C1.73 12.39 6 15.5 11 15.5C16 15.5 20.27 12.39 22 8C20.27 3.61 16 0.5 11 0.5Z" fill="white" />
                                                            </svg>
                                                        </button>
                                                        <span class="text-danger text-start d-flex mt-1 cngPwd" id="newPwd" style="font-size: 12px;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3 col-md-4 col-lg-3 col-xl-3 d-flex align-items-center">
                                                    <p>{{__('Confirm Password')}}</p>
                                                </div>
                                                <div class="col-sm-4 col-md-7 col-lg-6 col-xl-5">
                                                    <div class="input-field w-100 mb-3">
                                                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="{{__('Confirm Password')}}">
                                                        <button class="eye" type="button" data-target="confirm_password">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16" viewBox="0 0 22 16" fill="none">
                                                                <path d="M11 5C10.2044 5 9.44129 5.31607 8.87868 5.87868C8.31607 6.44129 8 7.20435 8 8C8 8.79565 8.31607 9.55871 8.87868 10.1213C9.44129 10.6839 10.2044 11 11 11C11.7956 11 12.5587 10.6839 13.1213 10.1213C13.6839 9.55871 14 8.79565 14 8C14 7.20435 13.6839 6.44129 13.1213 5.87868C12.5587 5.31607 11.7956 5 11 5ZM11 13C9.67392 13 8.40215 12.4732 7.46447 11.5355C6.52678 10.5979 6 9.32608 6 8C6 6.67392 6.52678 5.40215 7.46447 4.46447C8.40215 3.52678 9.67392 3 11 3C12.3261 3 13.5979 3.52678 14.5355 4.46447C15.4732 5.40215 16 6.67392 16 8C16 9.32608 15.4732 10.5979 14.5355 11.5355C13.5979 12.4732 12.3261 13 11 13ZM11 0.5C6 0.5 1.73 3.61 0 8C1.73 12.39 6 15.5 11 15.5C16 15.5 20.27 12.39 22 8C20.27 3.61 16 0.5 11 0.5Z" fill="white" />
                                                            </svg>
                                                        </button>
                                                        <span class="text-danger text-start d-flex mt-1 cngPwd" id="confPwd" style="font-size: 12px;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="login-btn mt-4 ms-0" type="button" id="changePassword" style="width: 280px;">
                                            {{__('Continue')}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane text-white fade" id="v-pills-clear-search-history" role="tabpanel" aria-labelledby="v-pills-clear-search-history-tab">
                            <div class="language-setting">
                                <h4 class="pb-4 border-bot">{{__('Clear your search history')}}</h4>

                                <div class="childpin text-start py-4">

                                    <div id="clearHistoryDiv" class="sync-device-main pb-4 w-100">
                                        <div>
                                            <p class="my-3">{{__('Are you sure you want to clear all your search history?')}}</p>
                                            <button class="login-btn mt-4 ms-0" style="width: 100px;" id="clearSearchBtn">
                                                {{__('Yes')}}
                                            </button>
                                        </div>
                                        <img class="mb-4" width="150" src="{{ asset('/img/clear-icon.svg') }}" alt="icon">
                                    </div>
                                    <div id="browseHistoryDiv" class="w-100 text-center mt-4">
                                        <img width="300" src="{{ asset('/img/clear-history-bg.svg') }}" alt="img">
                                        <p>{{__('You do not have any recent search history.')}}</p>
                                        <button class="login-btn mt-4" style="width: 250px;" id="searchBrowseBtn">
                                            {{__('Browse Now')}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"></path>
                                            </svg>
                                        </button>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="tab-pane text-white fade" id="v-pills-delete-account" role="tabpanel" aria-labelledby="v-pills-delete-account-tab">
                            <div class="language-setting">
                                <h4 class="pb-4 border-bot">{{__('Permanently delete your account')}}</h4>

                                <div class="childpin text-start py-4">

                                    <div class="sync-device-main pb-4 w-100">
                                        <div>
                                            <p class="delete-text my-3">{{__('Deleting your account will delete all your saved content. You will also lose any subscription linked to your account. You can chose to log out instead. This will allow you to come back any time you wish.')}}</p>
                                            <div class="d-flex mt-4">
                                                <button class="border-btn" id="delete_user_account">{{__('Delete Acc')}}</button>
                                                <button class="fill-btn logout">{{__('Log Out')}}</button>
                                            </div>
                                        </div>
                                        <img class="mb-4" width="150" src="{{ asset('/img/delete-account-icon.svg') }}" alt="icon">
                                    </div>

                                </div>

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
        var checkpin = $("#ispin").val();
        if(checkpin !="ispin"){
            $("#v-pills-childpin-tab").trigger('click');
        }
        var searchHistory = "{{ session()->has('searchHistory') }}";
        var resendOtp = false;

        console.log(searchHistory);
        if (searchHistory == "1") {
            $("#clearHistoryDiv").show();
            $("#browseHistoryDiv").hide();
        } else {
            $("#clearHistoryDiv").hide();
            $("#browseHistoryDiv").show();
        }

        $("#searchBrowseBtn").click(function() {
            window.location.href = "{{ getUrl('search') }}";
        })

        $("#clearSearchBtn").click(function() {
            "{{ session()->forget('searchHistory') }}"
            $("#clear-history").modal('show');
            $("#clearHistoryDiv").hide();
            $("#browseHistoryDiv").show();
        })

        //focus otp input
        $(".mx-1").on("input", function() {
            const maxLength = parseInt($(this).attr("maxlength"));
            const currentLength = $(this).val().length;

            // If the current input field is filled, move to the next field
            if (currentLength === maxLength) {
                $(this).next(".mx-1").val('');
                $(this).next(".mx-1").focus();
            }
        });

        $(".eye").click(function() {
            var targetId = $(this).data("target");
            var inputField = $("#" + targetId);
            var isPasswordType = inputField.attr('type') === 'password';

            if (isPasswordType) {
                inputField.attr('type', 'text');
            } else {
                inputField.attr('type', 'password');
            }
        });

        $("input[name='genreInterest[]']").change(function() {
            var genreCount = 0;

            $("input[name='genreInterest[]']").each(function() {
                if (this.checked) {
                    genreCount++;
                }
            });
            if (genreCount > 5) {
                console.log(this);
                if (this.checked) {
                    this.checked = false;
                }
            } else {
                $(".genre-select-count").text(genreCount + " of 5");
            }
        });

        $("#updatePreference").click(function() {
            $("#updateInterestForm #success-meg-for-genre-select, #updateInterestForm #error-meg-for-genre-select").html("");
            var genreCount = 0;
            $("input[name='genreInterest[]']").each(function() {
                if (this.checked) {
                    genreCount++;
                }
            });
            if (genreCount > 0 && genreCount != 5) {
                $("#error-meg-for-genre-select").html("Selected genre list should be 5");
            }

            var formData = $('#updateInterestForm').serialize();
            if (formData != '') {
                $.ajax({
                    url: "{{ route('update-genre') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.payload.success == true) {
                            $("#updateInterestForm #success-meg-for-genre-select").html("Your preferences updated.");
                        } else {
                            $("#updateInterestForm #error-meg-for-genre-select").html(response.payload.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('error me aaya');
                        onError(xhr);
                    }
                });
            } else {
                $("#updateInterestForm #error-meg-for-genre-select").html("Please select your preferences");
            }
        })

        $("#childPinForm #setChildPin").click(function() {
            $("#childPinForm #error-msg").html("");
            var formData = $('#childPinForm').serialize();
            var command = $('#childPinForm input[name="command"]').val();
            $.ajax({
                url: "{{ route('set-kidsPin') }}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    if (response.payload.success == true) {
                        $("#childPinForm input").val("");
                        if (command == "createKidsPin") {
                            $("#childpin").modal('show');
                        } else {
                            $("#changed-childpin").modal('show');
                        }
                    } else {
                        $("#childPinForm #error-msg").html(response.payload.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('error me aaya');
                    onError(xhr);
                }
            });
        })

        $("#changePassword").click(function() {
            $(".cngPwd").html("");
            var old_password = $("#change_password input[name='old_password']").val();
            var new_password = $("#change_password input[name='new_password']").val();
            var confirm_password = $("#change_password input[name='confirm_password']").val();

            if (old_password.trim() === "") {
                $('#oldPwd').text('Password is required');
                return;
            }
            if (new_password.trim() === "") {
                $('#newPwd').text('Password is required');
                return;
            }
            if (confirm_password.trim() === "") {
                $('#confPwd').text('Password is required');
                return;
            }
            if (new_password !== confirm_password) {
                $('#confPwd').text('Passwords do not match');
                return;
            }

            var formData = $('#change_password').serialize();
            $.ajax({
                url: "{{ route('change-password') }}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    if (response.payload.success == true) {
                        $("#change_password input").val("");
                        $("#changed-pass").modal('show');
                    } else {
                        if (response.payload.errorcode == 1054) {
                            $("#oldPwd").html(response.payload.message);
                        } else {
                            $("#newPwd").html(response.payload.message);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    onError(xhr);
                    console.log('error me aaya');
                }
            });
        })

        $("#delete_user_account").click(function() {
            resendOtp = false;
            $("#delete-account input").val("");
            $("#delete-account .modal-body, #resendOTPBtn").hide();
            $("#sendOTP").show();
            $("#delete-account").modal('show');
        })

        $("#resendOTPBtn").click(function() {
            resendOtp = true;
            $('#getDeleteAccountOTP').trigger('click');
        })

        $("#getDeleteAccountOTP").click(function() {
            $(".error").html("");
            var password = $("#passwordForDelete").val();
            if (password.trim() == "") {
                $("#password-error").text("Current Password is required");
                return;
            }
            var formData = {
                password: password
            }

            $.ajax({
                url: "{{ route('sendOTP-delete-account') }}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    if (response.payload.success == true) {
                        if (!resendOtp) {
                            $("#delete-account .modal-body").hide();
                            $("#verifyOTP").show();
                        }
                        resendVerifyOTP();
                    } else {
                        if (resendOtp) {
                            $("#verify-otp-error").html(response.payload.message);
                        }
                        $("#password-error").html(response.payload.message);
                    }
                },
                error: function(xhr, status, error) {
                    onError(xhr);
                }
            });
        })

        $("#verifyDeleteAccountOTPBtn").click(function() {
            $(".error").html("");


            var verifyOTP = $('input[name="verifyOTP[]"]').val();
            console.log(verifyOTP);
            if (verifyOTP.trim() == "") {
                $("#password-error").text("OTP is required");
                return;
            }

            var formData = $('#verifyOTPDeleteAccountForm').serialize();

            $.ajax({
                url: "{{ route('verifyOTP-delete-account') }}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    if (response.payload.success == true) {
                        $("#delete-account .modal-body").hide();
                        $("#reasonFordelete").show();
                    } else {
                        $("#verify-otp-error").html(response.payload.message);
                    }
                },
                error: function(xhr, status, error) {
                    onError(xhr);
                }
            });
        })

        $("#deleteAcctReasonBtn").click(function() {
            $(".error").html("");

            var reason = $('#deleteAcctReason').val();

            var formData = {
                reason: reason
            };

            $.ajax({
                url: "{{ route('delete-account') }}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    if (response.payload.success == true) {
                        $(".logout").trigger('click');
                    } else {
                        $("#reason-error").html(response.payload.message);
                    }
                },
                error: function(xhr, status, error) {
                    onError(xhr);
                }
            });
        })

        $('input[name="displayLang"]').change(function() {
            var selectedLang = $('input[name="displayLang"]:checked').val();
            var formData = "language=" + selectedLang + "&type=display";
            $.ajax({
                url: "{{ route('set-language') }}?" + formData,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    if (selectedLang != "en") {
                        window.location.href = "{{url('/')}}/" + selectedLang;
                    } else {
                        window.location.href = "{{url('/')}}";
                    }
                },
                error: function(xhr, status, error) {
                    onError(xhr);
                }
            });
        })
        
        $('input[name="contentLang"]').change(function() {
            var selectedLang = $('input[name="contentLang"]:checked').val();
            var formData = "language=" + selectedLang + "&type=content";
            $.ajax({
                url: "{{ route('set-language') }}?" + formData,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                },
                error: function(xhr, status, error) {
                    onError(xhr);
                }
            });
        })
    })

    function logoutDevice(params) {
        if (params == "") return;
        var formData = {
            deviceId: params
        }
        $.ajax({
            url: "{{ route('remove-device') }}",
            type: 'POST',
            data: formData,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response);
                if (response.payload.success == true) {
                    $("div[data-id='" + params + "']").remove();
                } else {
                    $("#updateInterestForm #error-meg-for-genre-select").html(response.payload.message);
                }
            },
            error: function(xhr, status, error) {
                console.log('error me aaya');
                onError(xhr);
            }
        });
    }

    function resendVerifyOTP() {
        // Disable the resend button
        $('#resendOTPBtn').show();
        $('#resendOTPBtn').prop('disabled', true);

        // Set a countdown of 30 seconds
        var countdown = 30;
        var countdownDiv = $('.resend-otp');

        var interval = setInterval(function() {
            countdownDiv.text('Resend OTP in ' + countdown + ' seconds');
            countdown--;

            if (countdown < 0) {
                clearInterval(interval);
                countdownDiv.text('');
                $('#resendOTPBtn').prop('disabled', false);
            }
        }, 1000);
    }

    function regenerateSyncPin() {
        $.ajax({
            url: "{{ route('syncDevice-pin') }}",
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response);
                if (response.payload.success == true) {
                    var pin = response.payload.syncPin;
                    $("#syncDevicePin").html(pin)
                } else {
                    var message = response.payload.message;
                    showToaster(message, 2);
                }
            },
            error: function(xhr, status, error) {
                onError(xhr);
            }
        });
    }

    function copyText(tagId) {
        console.time('time1');
        var temp = $("<input>");
        $("body").append(temp);
        temp.val($('#' + tagId).text()).select();
        document.execCommand("copy");
        temp.remove();
        console.timeEnd('time1');
        $(".copiedBtn").show();
        $(".copyBtn").hide();
        setTimeout(function() {
            $(".copiedBtn").hide();
            $(".copyBtn").show();
        }, 2000);
    }
</script>
@stop