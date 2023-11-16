@extends('layouts.default')
@section('title','Thank you')
@section('content') 

<?php 
    $planName =""; 
    $enddate ="";
    if(!empty($orderData)){
         
        if($orderData['plan_id'] == 'epic_in_pl_1'){
            $planName = "1 Month";
        }else if($orderData['plan_id'] == 'epic_in_pl_2'){
            $planName = "3 Months";
        }else if($orderData['plan_id'] == 'epic_in_pl_3'){
            $planName = "6 Months";
        }else if($orderData['plan_id'] == 'epic_in_pl_4'){
            $planName = "1 Year";
        }else{
            $planName = "";
        }

    $enddate = date('jS F, Y h:i A', strtotime($orderData['subscription_end_date']));
 
    }

?>

<section class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <a href="{{route('my-account')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M26.3359 15.9987C26.3359 16.551 25.8882 16.9987 25.3359 16.9987L6.66927 16.9987C6.11699 16.9987 5.66927 16.551 5.66927 15.9987C5.66927 15.4464 6.11699 14.9987 6.66927 14.9987L25.3359 14.9987C25.8882 14.9987 26.3359 15.4464 26.3359 15.9987Z" fill="white"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7097 26.0391C16.3192 26.4297 15.686 26.4297 15.2955 26.0391L5.96217 16.7058C5.57164 16.3153 5.57164 15.6821 5.96217 15.2916L15.2955 5.95826C15.686 5.56773 16.3192 5.56773 16.7097 5.95826C17.1002 6.34878 17.1002 6.98195 16.7097 7.37247L8.08349 15.9987L16.7097 24.6249C17.1002 25.0154 17.1002 25.6486 16.7097 26.0391Z" fill="white"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>
    <section class="container pb-5">
        <div class="row justify-content-center">
            <h4 class="text-white text-center mb-4">{{__('Your Current Plan')}}</h4>

            <div class="col-sm-8">
                <div class="current-plan-card position-relative">
                    <img src="{{ asset('assets/img/current-plan-card.png') }}" alt="img">
                    <div class="detail text-white">
                        <div class="active mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M15.5574 8.52628C15.8137 8.21935 15.8137 7.77301 15.5574 7.46607L14.4444 6.13322C14.3042 5.96529 14.2362 5.74864 14.2554 5.5307L14.4102 3.76891C14.4461 3.3604 14.1773 2.98727 13.7784 2.89204L12.1978 2.51465C11.9743 2.46128 11.783 2.31732 11.6699 2.11727L10.8445 0.657489C10.6339 0.285121 10.1742 0.134751 9.78429 0.310736L8.34026 0.962523C8.12393 1.06017 7.87608 1.06017 7.65975 0.962523L6.21571 0.310736C5.82581 0.134751 5.36606 0.28512 5.15551 0.657489L4.33076 2.11609C4.21726 2.31682 4.02511 2.46106 3.80067 2.51399L2.22399 2.88585C1.82401 2.98018 1.55397 3.35388 1.58995 3.76325L1.74471 5.5239C1.76382 5.74134 1.6962 5.95751 1.5566 6.1253L0.440912 7.46625C0.185513 7.77321 0.185907 8.21882 0.441848 8.52533L1.55566 9.85923C1.69585 10.0271 1.76382 10.2437 1.74472 10.4616L1.58959 12.2312C1.55379 12.6397 1.82263 13.0127 2.22143 13.1079L3.80222 13.4854C4.02574 13.5387 4.21699 13.6827 4.3301 13.8827L5.15455 15.3408C5.3655 15.7139 5.8265 15.864 6.21668 15.6867L7.65898 15.0312C7.87573 14.9327 8.12442 14.9324 8.34142 15.0304L9.78429 15.6816C10.1742 15.8576 10.6339 15.7072 10.8445 15.3349L11.6699 13.8751C11.783 13.675 11.9743 13.5311 12.1978 13.4777L13.7784 13.1003C14.1773 13.0051 14.4461 12.632 14.4102 12.2234L14.2554 10.4617C14.2362 10.2437 14.3042 10.0271 14.4444 9.85914L15.5574 8.52628ZM7.14467 11.1886C6.81868 11.5313 6.27224 11.5313 5.94624 11.1886L4.12404 9.27324C3.85086 8.98609 3.85086 8.53517 4.12404 8.24802C4.41679 7.94031 4.90735 7.93983 5.20069 8.24698L6.11077 9.1999C6.3474 9.44766 6.74311 9.44728 6.97926 9.19906L10.7961 5.1871C11.0907 4.87745 11.5848 4.87832 11.8783 5.18901C12.1504 5.47711 12.1496 5.92778 11.8765 6.21491L7.14467 11.1886Z" fill="white"/>
                              </svg>
                            Active
                        </div>
                        <h1>{{$planName}}</h1>
                        <p>Subscription</p>
                        <span>Expires on {{$enddate}}</span>
                    </div>
                </div>
            </div>

            {{--<div class="col-sm-12 col-md-12 col-lg-12 col-xl-10 choose-plan">
                        <div class="tab-main">
                            <ul class="benifits list-unstyled m-0">
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12" fill="none">
                                        <path d="M1.3313 7.27451L5.25287 11.1961L14.6646 1" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg> &nbsp; No ads
                                </li>
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12" fill="none">
                                        <path d="M1.3313 7.27451L5.25287 11.1961L14.6646 1" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg> &nbsp; Upto 3 user profiles
                                </li>
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12" fill="none">
                                        <path d="M1.3313 7.27451L5.25287 11.1961L14.6646 1" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg> &nbsp; Watch on all devices
                                </li>
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12" fill="none">
                                        <path d="M1.3313 7.27451L5.25287 11.1961L14.6646 1" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg> &nbsp; Max video quality: Full HD 1080p
                                </li>
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12" fill="none">
                                        <path d="M1.3313 7.27451L5.25287 11.1961L14.6646 1" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg> &nbsp; All premium content
                                </li>
                            </ul>
                            <div class="additional-offer">
                                <div class="d-flex justify-content-between align-items-center text-white">
                                    <h6>Additional offer(s) benefits with your subscription</h6>
                                    <h6>Total Coupons: 5</h6>
                                </div>
                                <ul class="additional-carousel mb-0 mt-3 p-0">
                                    <li>
                                        <a href="#">
                                            <img src="public/img/coupon.svg" alt="">
                                            <div class="ac-content">
                                                <div class="left">
                                                    <div class="circle-logo">
                                                        <img src="public/img/kfc-logo.png" alt="">
                                                    </div>
                                                    <span>Exc. Offer</span>
                                                </div>
                                                <div class="right">
                                                    <h5>25% OFF</h5>
                                                    <p>KFC</p>
                                                    <span>Valid until 03 March 2022</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="public/img/coupon.svg" alt="">
                                            <div class="ac-content">
                                                <div class="left">
                                                    <div class="circle-logo">
                                                        <img src="public/img/kfc-logo.png" alt="">
                                                    </div>
                                                    <span>Exc. Offer</span>
                                                </div>
                                                <div class="right">
                                                    <h5>25% OFF</h5>
                                                    <p>KFC</p>
                                                    <span>Valid until 03 March 2022</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="public/img/coupon.svg" alt="">
                                            <div class="ac-content">
                                                <div class="left">
                                                    <div class="circle-logo">
                                                        <img src="public/img/kfc-logo.png" alt="">
                                                    </div>
                                                    <span>Exc. Offer</span>
                                                </div>
                                                <div class="right">
                                                    <h5>25% OFF</h5>
                                                    <p>KFC</p>
                                                    <span>Valid until 03 March 2022</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="public/img/coupon.svg" alt="">
                                            <div class="ac-content">
                                                <div class="left">
                                                    <div class="circle-logo">
                                                        <img src="public/img/kfc-logo.png" alt="">
                                                    </div>
                                                    <span>Exc. Offer</span>
                                                </div>
                                                <div class="right">
                                                    <h5>25% OFF</h5>
                                                    <p>KFC</p>
                                                    <span>Valid until 03 March 2022</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="public/img/coupon.svg" alt="">
                                            <div class="ac-content">
                                                <div class="left">
                                                    <div class="circle-logo">
                                                        <img src="public/img/kfc-logo.png" alt="">
                                                    </div>
                                                    <span>Exc. Offer</span>
                                                </div>
                                                <div class="right">
                                                    <h5>25% OFF</h5>
                                                    <p>KFC</p>
                                                    <span>Valid until 03 March 2022</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                  </div>
            </div>--}}
        </div>
    </section>

<script>
var start = new Date;
    showToaster('You have successfully purchased a subscription plan.', 1);
        window.setTimeout(function() {
            var chekUrl = localStorage.getItem("redirectURL");
            if(chekUrl != "" && chekUrl !=null &&  chekUrl!=undefined){
                localStorage.removeItem("redirectURL");
                window.location.href = chekUrl;
            }else{
             window.location.href = APP_URL+'/my-account';
            }
    }, 2000);
</script>    
@stop