<?php
$genreList      = @$genrelist['success'] && array_key_exists('data', $genrelist) ? $genrelist['data'] : [];
$interests      = array_key_exists("interests", $user_data) ? $user_data['interests'] : [];
$interestsCount = count($interests) ?? 0;
$kidSection     = array_key_exists("kidSection", $user_data) ? $user_data['kidSection'] : false;
$activeDevices  = @$activeDevice['success'] && array_key_exists('data', $activeDevice) ? $activeDevice['data'] : [];
$request        = Request();
$ispin          = $request->input('status') ?? '';
$device_detail  = session()->get("device-detail");

/* search history start */
$profileSearchHistory = [];
if (session()->has('active_profile') && session()->has('searchHistory')) {
    $activeProfile  = session()->get('active_profile');
    $searchHistory  = session()->get('searchHistory') ?? [];
    $profileSearchHistory = $searchHistory[$activeProfile] ?? [];
}
$hasSearchHistory = count($profileSearchHistory) > 0 ? true : false;
/* search history end */
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
                        @include('settings.account')
                        @include('settings.language')
                        @include('settings.syncDevice')
                        @include('settings.activeDevice')
                        @include('settings.setChildPin')
                        @include('settings.changePassword')
                        @include('settings.clearSearchHistory')
                        @include('settings.deleteAccount')
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
        if(checkpin == "ispin"){
            $("#v-pills-childpin-tab").trigger('click');
        }
        var searchHistory = "{{ $hasSearchHistory }}";
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
            $.ajax({
                url: "{{ route('deleteSearchHistory') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#clear-history").modal('show');
                    $("#clearHistoryDiv").hide();
                    $("#browseHistoryDiv").show();
                },
                error: function(xhr, status, error) {
                    onError(xhr);
                }
            });
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
            $(this).addClass(targetId);
            if (isPasswordType) {
                $('.'+targetId).html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">'+
  '<path d="M20.9593 2.95892L19.4551 1.52148L2.50101 19.2627L4.00518 20.7002L20.9593 2.95892Z" fill="white"/>'+
  '<path fill-rule="evenodd" clip-rule="evenodd" d="M17.9555 6.11126C16.2071 5.08712 14.1725 4.5 12 4.5C7 4.5 2.73 7.61 1 12C2.03885 14.6362 3.99362 16.8108 6.47236 18.1276L8.72091 15.7746C8.63295 15.6982 8.5474 15.6185 8.46447 15.5355C7.52678 14.5979 7 13.3261 7 12C7 10.6739 7.52678 9.40215 8.46447 8.46447C9.40215 7.52678 10.6739 7 12 7C13.3261 7 14.5979 7.52678 15.5355 8.46447C15.5648 8.49369 15.5936 8.52324 15.622 8.5531L17.9555 6.11126ZM14.2376 10.0017C14.2001 9.95975 14.1613 9.91871 14.1213 9.87868C13.5587 9.31607 12.7956 9 12 9C11.2044 9 10.4413 9.31607 9.87868 9.87868C9.31607 10.4413 9 11.2044 9 12C9 12.7956 9.31607 13.5587 9.87868 14.1213C9.95102 14.1937 10.0267 14.2619 10.1053 14.326L14.2376 10.0017ZM12.2365 14.9907L14.9983 12.1006C14.9729 12.8597 14.6602 13.5825 14.1213 14.1213C13.6147 14.6279 12.9456 14.9346 12.2365 14.9907ZM10.528 16.7784C11.0006 16.924 11.4964 17 12 17C13.3261 17 14.5979 16.4732 15.5355 15.5355C16.4732 14.5979 17 13.3261 17 12C17 11.4194 16.899 10.8491 16.7067 10.3128L19.6065 7.27847C21.0968 8.53554 22.2728 10.1547 23 12C21.27 16.39 17 19.5 12 19.5C10.7619 19.5 9.5685 19.3093 8.44738 18.9557L10.528 16.7784Z" fill="white"/></svg>');
                inputField.attr('type', 'text');
            } else {    
                    $('.'+targetId).html('<svg xmlns="http://www.w3.org/2000/svg" width="22" height="16" viewBox="0 0 22 16" fill="none"><path d="M11 5C10.2044 5 9.44129 5.31607 8.87868 5.87868C8.31607 6.44129 8 7.20435 8 8C8 8.79565 8.31607 9.55871 8.87868 10.1213C9.44129 10.6839 10.2044 11 11 11C11.7956 11 12.5587 10.6839 13.1213 10.1213C13.6839 9.55871 14 8.79565 14 8C14 7.20435 13.6839 6.44129 13.1213 5.87868C12.5587 5.31607 11.7956 5 11 5ZM11 13C9.67392 13 8.40215 12.4732 7.46447 11.5355C6.52678 10.5979 6 9.32608 6 8C6 6.67392 6.52678 5.40215 7.46447 4.46447C8.40215 3.52678 9.67392 3 11 3C12.3261 3 13.5979 3.52678 14.5355 4.46447C15.4732 5.40215 16 6.67392 16 8C16 9.32608 15.4732 10.5979 14.5355 11.5355C13.5979 12.4732 12.3261 13 11 13ZM11 0.5C6 0.5 1.73 3.61 0 8C1.73 12.39 6 15.5 11 15.5C16 15.5 20.27 12.39 22 8C20.27 3.61 16 0.5 11 0.5Z" fill="white" /></svg>');              
                inputField.attr('type', 'text');
                inputField.attr('type', 'password');
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
                            if (checkpin == "ispin") {
                                window.location.href = "{{ getUrlWithPrefix('kidsIndex') }}";
                            }
                            $("#childpin").modal('show');
                        } else {
                            $("#changed-childpin").modal('show');
                        }
                    } else {
                        $("#childPinForm #error-msg").html(response.payload.message);
                    }
                },
                error: function(xhr, status, error) {
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
                }
            });
        })

        /* Delete Account Section start */
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
        /* Delete Account Section end */

        /* Language Section start */
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
        /* Language Section end */
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
                    showToaster('Device logout successfully.', 1);
                } else {
                    $("#updateInterestForm #error-meg-for-genre-select").html(response.payload.message);
                }
            },
            error: function(xhr, status, error) {
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