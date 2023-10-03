@extends('layouts.default')
@section('title','My Account')

@section('style')

@stop

@section('content')

<?php
if(!empty($subscriptionPurchases)){
if(isset($subscriptionPurchases[0]['subscription_start_date'])){
    $subscription_start_date = date('Y-m-d', strtotime($subscriptionPurchases[0]['subscription_start_date']));

    $substartdate=date("jS F, Y", strtotime($subscriptionPurchases[0]['subscription_start_date']));  
}
if(isset($subscriptionPurchases[0]['subscription_end_date'])){
    $subscription_end_date = date('Y-m-d', strtotime($subscriptionPurchases[0]['subscription_end_date']));

    $subenddate=date("jS F, Y", strtotime($subscriptionPurchases[0]['subscription_end_date']));  
}

if($subscriptionPurchases[0]['validity_days'] == 30){
    $plan_name = 'month';
}else if($subscriptionPurchases[0]['validity_days'] == 90){
    $plan_name = 'quarter';
}else if($subscriptionPurchases[0]['validity_days'] == 180){
    $plan_name = 'half-yearly';
}else{
    $plan_name = 'year';
}

$today = date_create(date('Y-m-d'));
$enddate = date_create(date('Y-m-d', strtotime($subscriptionPurchases[0]['subscription_end_date'])));
$dateDiff = date_diff($enddate,$today);
$numOfDays = $dateDiff->format('%a');
}
?>

<!-- login model -->
<div class="modal fade" id="cancelMembership" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered px-3">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 120 120" fill="none">
                        <g clip-path="url(#clip0_91_19254)">
                          <path d="M60 0C93.1371 0 120 26.8629 120 60C120 93.1371 93.1371 120 60 120C26.8629 120 0 93.1371 0 60C0 26.8629 26.8629 0 60 0ZM62.9928 116.299C62.9755 116.29 62.9553 116.292 62.9362 116.295C62.9188 116.298 62.9019 116.304 62.8861 116.312L62.5871 116.459C62.5658 116.47 62.5432 116.477 62.5199 116.482L62.507 116.485C62.4728 116.491 62.4375 116.49 62.404 116.48C62.3913 116.477 62.3791 116.472 62.3673 116.466L62.03 116.3C61.9909 116.284 61.9549 116.29 61.9291 116.308C61.9149 116.317 61.9068 116.333 61.9004 116.349C61.8935 116.366 61.8896 116.384 61.8889 116.403L61.8067 118.473C61.8056 118.501 61.8084 118.529 61.8152 118.556L61.8184 118.569C61.8261 118.599 61.8399 118.628 61.8591 118.653C61.873 118.671 61.8894 118.687 61.9079 118.7L62.3762 119.033C62.3919 119.044 62.4096 119.053 62.4282 119.058L62.4342 119.059C62.4608 119.066 62.4889 119.065 62.515 119.057C62.5283 119.052 62.5408 119.046 62.5521 119.038L63.0202 118.705C63.0433 118.688 63.0636 118.668 63.0806 118.646L63.0833 118.642C63.1042 118.614 63.1191 118.582 63.1271 118.549C63.1323 118.526 63.1345 118.503 63.1336 118.481L63.0518 116.425C63.0506 116.395 63.0495 116.364 63.0341 116.338C63.0235 116.321 63.0091 116.307 62.9928 116.299ZM64.3225 115.737C64.3024 115.726 64.2784 115.727 64.2557 115.73C64.2354 115.733 64.2156 115.74 64.1973 115.749L63.3239 116.188C63.3081 116.196 63.2936 116.206 63.2811 116.219L63.2754 116.225C63.2588 116.241 63.2467 116.262 63.2405 116.285C63.2369 116.298 63.2353 116.312 63.2359 116.326L63.3238 118.427C63.3246 118.445 63.3287 118.464 63.3358 118.481L63.3374 118.485C63.3457 118.505 63.3585 118.522 63.3747 118.537C63.3849 118.545 63.3962 118.553 63.4084 118.559L64.395 119.015C64.4398 119.03 64.4818 119.023 64.5126 119.001C64.5334 118.987 64.5435 118.963 64.5505 118.938C64.5568 118.916 64.5593 118.893 64.5581 118.87L64.393 115.89C64.391 115.853 64.3883 115.816 64.3697 115.784C64.3575 115.763 64.3416 115.747 64.3225 115.737ZM60.715 115.735C60.6923 115.725 60.6668 115.722 60.6425 115.727C60.6297 115.73 60.6176 115.735 60.6066 115.742C60.5868 115.754 60.5753 115.776 60.5661 115.797C60.5555 115.822 60.5492 115.849 60.5477 115.876L60.38 118.905C60.38 118.947 60.3968 118.979 60.4238 119.001C60.4479 119.021 60.4814 119.023 60.5125 119.019C60.5307 119.016 60.5485 119.011 60.5651 119.003L61.5275 118.558C61.5391 118.553 61.5501 118.546 61.5601 118.538L61.5656 118.534C61.5848 118.518 61.5994 118.498 61.6079 118.475C61.6126 118.462 61.6153 118.448 61.6158 118.434L61.6992 116.326C61.6997 116.312 61.6983 116.298 61.6949 116.285C61.6884 116.259 61.675 116.235 61.6562 116.216L61.6535 116.213C61.6412 116.201 61.6271 116.191 61.6116 116.183L60.715 115.735Z" fill="white"/>
                          <path d="M60 0C93.138 0 120 26.862 120 60C120 93.138 93.138 120 60 120C26.862 120 0 93.138 0 60C0 26.862 26.862 0 60 0ZM60 78C58.4087 78 56.8826 78.6321 55.7574 79.7574C54.6321 80.8826 54 82.4087 54 84C54 85.5913 54.6321 87.1174 55.7574 88.2426C56.8826 89.3679 58.4087 90 60 90C61.5913 90 63.1174 89.3679 64.2426 88.2426C65.3679 87.1174 66 85.5913 66 84C66 82.4087 65.3679 80.8826 64.2426 79.7574C63.1174 78.6321 61.5913 78 60 78ZM60 24C58.5304 24.0002 57.112 24.5397 56.0138 25.5163C54.9156 26.4928 54.2139 27.8385 54.042 29.298L54 30V66C54.0017 67.5293 54.5873 69.0002 55.6371 70.1122C56.6869 71.2242 58.1217 71.8934 59.6484 71.983C61.175 72.0727 62.6783 71.576 63.851 70.5944C65.0237 69.6129 65.7774 68.2206 65.958 66.702L66 66V30C66 28.4087 65.3679 26.8826 64.2426 25.7574C63.1174 24.6321 61.5913 24 60 24Z" fill="#FF4444"/>
                        </g>
                        <defs>
                          <clipPath id="clip0_91_19254">
                            <rect width="120" height="120" fill="white"/>
                          </clipPath>
                        </defs>
                      </svg>
                </span>
                <h4 class="text-white mt-4">{{__('Cancel Membership')}}</h4>
                <p class="w-75 text-white small m-auto">{{__('Cancellation will be effective at the end of your current billing cycle on 20 May 2024. No refunds will be made.')}}</p>
                <button class="login-btn mt-4" style="width: 280px;">
                    {{__('Finish Cancellation')}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"/>
                    </svg>
                 </button>
                 <button class="login-btn mt-0 bg-transparent text-white" class="btn-close" style="width: 280px;" data-bs-dismiss="modal" aria-label="Close">Go Back</button>
            </div>
        </div>
    </div>
</div>
    
    <section class="container w-100 my-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                    <h4 class="text-white border-bot pb-3">{{__('My Account')}}</h4>
            </div>
            @if(!empty($subscriptionPurchases))
            <?php
            if($today < $enddate){
                $plancss = '';
            }else{
                $plancss = 'plan-expired';
            }
            ?>
            <div class="col-sm-6 col-md-7">
                <div class="my-account-main {{$plancss}} position-relative mt-2">
                    
                    <div class="plan-ex">{{__('Plan Expired')}}</div>
                    
                    <img class="corner-bg" src="{{ asset('/img/corner-bg.svg') }}" alt="">
                    <p class="current-subs d-flex">{{__('Current Subscription')}}</p>
                    <h1>Premium HD</h1>
                    <div class="premium-plan">

                        <div class="past-sub w-100">{{__('PAST SUBSCRIPTION')}}</div>
                        <h2>{{ isset($subscriptionPurchases[0]['plan_name']) ? $subscriptionPurchases[0]['plan_name'] : '' }}</h2>
                        <div class="progress blue">
                            <span class="progress-left">
                                              <span class="progress-bar"></span>
                            </span>
                            <span class="progress-right">
                                              <span class="progress-bar"></span>
                            </span>
                            <div class="progress-value">
                                <span>{{ isset($numOfDays) ? $numOfDays : '' }}</span>
                                <p>{{__('Days left')}}</p>
                            </div>
                        </div>
                        <div class="pp-right">
                            <h3>₹ {{ isset($subscriptionPurchases[0]['plan_amount']) ? $subscriptionPurchases[0]['plan_amount'] : '' }} <span>/ {{ isset($plan_name) ? $plan_name : '' }}</span></h3>
                            <p>{{isset($substartdate) ? $substartdate : ''}} - {{ isset($subenddate) ? $subenddate : '' }}</p>
                        </div>
                    </div>

                    <div class="w-100 text-center">
                        <button class="renew-paln">
                            {{__('Renew plan')}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="white"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="white"/>
                            </svg>
                        </button>
                    </div>

                </div>
            </div>
            @if(!empty($viewprofile))
            <div class="col-sm-6 col-md-5 d-flex align-items-center">
                <div class="billing-details w-100 text-white">
                    <h4>{{__('Billing Details')}}</h4>
                    <p class="position-relative"> 
                        <img src="{{ asset('/img/email.svg') }}" alt="">
                        {{ isset($viewprofile['email']) ? $viewprofile['email'] : '' }} &nbsp;
                        <button class="edit-icon bg-transparent border-0">
                            <img src="{{ asset('/img/edit-icon.svg') }}" alt="">
                        </button>
                    </p>
                    <p>
                        <img src="{{ asset('/img/mobile.svg') }}" alt="">&nbsp; {{ isset($viewprofile['user_id']) ? $viewprofile['user_id'] : '' }}
                    </p>
                    <p class="border-bot pb-4">
                        <img src="{{ asset('/img/visa.svg') }}" alt=""> &nbsp; visa **** **** **** 1823
                    </p>
                    <p class="position-relative border-bot pb-4"> 
                        {{__('View Transaction History')}}
                        <a href="{{route('trans-history')}}" class="edit-icon bg-transparent border-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="20" viewBox="0 0 14 20" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.31843 0.422975C1.83708 -0.108049 2.7162 -0.143922 3.282 0.34285L13.3894 9.0385C13.6766 9.28555 13.8401 9.63438 13.8401 10C13.8401 10.3656 13.6766 10.7144 13.3894 10.9615L3.282 19.6572C2.7162 20.1439 1.83708 20.1081 1.31843 19.577C0.799777 19.046 0.838 18.2209 1.4038 17.7341L10.3936 10L1.4038 2.26586C0.838 1.77909 0.799777 0.954 1.31843 0.422975Z" fill="white"/>
                              </svg>
                        </a>
                    </p>
                    <p class="position-relative border-bot pb-4"> 
                        {{__('Cancel Membership')}}
                        <button class="edit-icon bg-transparent border-0" data-bs-toggle="modal" data-bs-target="#cancelMembership">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="20" viewBox="0 0 14 20" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.31843 0.422975C1.83708 -0.108049 2.7162 -0.143922 3.282 0.34285L13.3894 9.0385C13.6766 9.28555 13.8401 9.63438 13.8401 10C13.8401 10.3656 13.6766 10.7144 13.3894 10.9615L3.282 19.6572C2.7162 20.1439 1.83708 20.1081 1.31843 19.577C0.799777 19.046 0.838 18.2209 1.4038 17.7341L10.3936 10L1.4038 2.26586C0.838 1.77909 0.799777 0.954 1.31843 0.422975Z" fill="white"/>
                              </svg>
                        </button>
                    </p>
                </div>
            </div>
            @endif
            @else
            <div class="col-12 text-center mt-5">
                <img src="{{ asset('/img/not-subscribe.svg') }}" alt="img" style="margin-bottom: -50px;">
                <p class="small text-white">{{__('You have not subscribed to Epic On yet!')}}</p>
                <button class="login-btn mt-4" style="width: 280px;">
                    {{__('Subscribe Now')}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"></path>
                    </svg>
                 </button>
            </div>
            @endif
            <!-- <div class="col-12 text-center mt-5">
                <img src="{{ asset('/img/not-subscribe.svg') }}" alt="img" style="margin-bottom: -50px;">
                <p class="small text-white">You have not subscribed to Epic On yet!</p>
                <button class="login-btn mt-4" style="width: 280px;">
                    Subscribe Now
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"></path>
                    </svg>
                 </button>
            </div> -->

        </div>
    </section>
    

@stop

@section('script')
  
@stop