<?php 
// dd(session()->all());
$userData = session()->get('user');
$subscription = $userData['subscriptions'] ?? [];
$plan_id = $subscription['plan_id'] ?? "";
    $planName =""; 
    $enddate ="";
    if(!empty($plan_id)){
         
        if($plan_id == 'epic_in_pl_1'){
            $planName = "1 Month";
        }else if($plan_id == 'epic_in_pl_2'){
            $planName = "3 Months";
        }else if($plan_id == 'epic_in_pl_3'){
            $planName = "6 Months";
        }else if($plan_id == 'epic_in_pl_4'){
            $planName = "1 Year";
        }else{
            $planName = "";
        }
    $enddate = date('jS F, Y h:i A', strtotime($subscription['subscription_end_date'] ?? ""));
 
    }
?>
@extends('layouts.default')
@section('title', $meta['title'] ?? 'Subscription Plans' )
@section('style')
<style>
    #coupon-text:disabled {
        color: #b7b7b7;
        cursor: not-allowed;
    }
</style>
@stop
@section('content')
<?php $meta['description'] = "Get access to a wide range of TV shows and movies of Epicon by subscribing to our platform. We have best plan for you. Check the Subscription section today!"; ?>
    <section class="container pb-3">
        <div class="row justify-content-center">
            <h4 class="text-white text-center mb-4">{{__('Your Current Plan')}}</h4>
            <div class="col-sm-8 d-flex justify-content-center">
                <div class="current-plan-card ycp position-relative">
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
    <section class="container pb-5 choose-margin-mobile">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-10 position-relative">
            <h4 class="text-white text-center mb-4">
                <a href="javascript:void(0)" class="goBackButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M26.3359 15.9987C26.3359 16.551 25.8882 16.9987 25.3359 16.9987L6.66927 16.9987C6.11699 16.9987 5.66927 16.551 5.66927 15.9987C5.66927 15.4464 6.11699 14.9987 6.66927 14.9987L25.3359 14.9987C25.8882 14.9987 26.3359 15.4464 26.3359 15.9987Z" fill="white" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7097 26.0391C16.3192 26.4297 15.686 26.4297 15.2955 26.0391L5.96217 16.7058C5.57164 16.3153 5.57164 15.6821 5.96217 15.2916L15.2955 5.95826C15.686 5.56773 16.3192 5.56773 16.7097 5.95826C17.1002 6.34878 17.1002 6.98195 16.7097 7.37247L8.08349 15.9987L16.7097 24.6249C17.1002 25.0154 17.1002 25.6486 16.7097 26.0391Z" fill="white" />
                    </svg>
                </a>
                {{__('Upgrade Your Plan')}}
            </h4>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-10 choose-plan">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                @foreach($result['plans'] as $key => $val)
                <?php if ($key === 0) {
                    $classActive = "active";
                } else {
                    $classActive = "";
                }
                if (@$val['id'] == 'epic_in_pl_4') {
                    $bestv = '<span class="best-value">Best Value</span>';
                } else {
                    $bestv = "";
                }
                ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link planid {{$classActive}}" id="pills-starter-tab" data-bs-toggle="pill" data-bs-target="#pills-starter" type="button" role="tab" aria-controls="pills-starter" aria-selected="true" data-id="{{@$val['id']}}">
                        {!! $bestv !!}
                        <div>
                            <h6>
                                <?php if ($val['currency'] == 'INR' || $val['currency'] == 'inr') { ?>
                                    <p class="small mb-0">{{@$val['name']}}</p>
                                <?php    } ?>
                                <span class="d-none save-{{@$val['id']}} coupon-percent"></span>
                            </h6>
                            <?php if ($val['currency'] == 'INR' || $val['currency'] == 'inr') { ?>
                                <h3 class="d-flex current-{{@$val['id']}}">
                                    <div class="val-price">{!! getCurrency(@$val['currency']) !!} {{@$val['actual_price']}}.00</div><span class="ms-1 small"><b class="b-none"> /</b> {{@$val['plan'] ? @$val['plan'] : @$val['name']}}</span>
                                </h3>
                            <?php    } else { ?>
                                <h3 class="d-flex current-{{@$val['id']}}">
                                    <div class="val-price">{!! getCurrency(@$val['currency']) !!} {{@$val['actual_price']}}</div><span class="ms-1 small"><b class="b-none"> /</b> {{@$val['name'] ? @$val['name'] : ''}}</span>
                                </h3>
                            <?php } ?>
                            <h5 class="d-none"> </h5>
                            <h5 class="d-none oldprice-{{@$val['id']}} old-price"></h5>
                        </div>
                    </button>
                </li>
                @endforeach
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-starter" role="tabpanel" aria-labelledby="pills-starter-tab">
                    <div class="use-code mt-4 coupan-div">
                        <p>{{@$result['promotion_text']}}</p>
                        <div class="position-relative">
                            <input type="text" id="coupon-text" placeholder="{{__('Enter promo code')}}" class="promocode">
                            <div>
                                <button class="apl-btn bg-transparent CoupanApply" id="">{{__('Apply')}}</button>
                            </div>
                            <div> </div>
                        </div>
                        <div style="color:red" class="coupan-msg"></div>
                    </div>
                    <div class="subscribe-bottom mt-4">
                        <div class="tc mt-3">
                            <a href="{{route('terms-of-use')}}">{{__('Terms of Use')}}</a>
                            <b>•</b>
                            <a href="{{route('privacy')}}">{{__('Privacy Policy')}}</a>
                        </div>
                        <form method="post" action="{{getUrl('paymentMethod')}}" class="paymentForm">
                            @csrf
                            <input type="hidden" name="amountid" id="amountid" value="{{@$result['plans'][0]['id']}}">
                            <input type="hidden" name="currency" id="currency" value="{{@$val['currency']}}">
                            <input type="hidden" name="coupanstatus" id="coupanstatus" value="No">
                            {{--<p class="get-help mt-2 small">{{__('Already subscribed')}}?<a href="">{{__('Restore')}}</a></p>--}}
                            <?php if (isUserLoggedIn()) { ?>
                                <button class="fill-btn payment" onclick="click_subscription(this)">{{__('Upgrade')}} {{--&nbsp;<span id="plan_name"> Starter </span>--}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.75 12C4.75 11.5858 5.08579 11.25 5.5 11.25H19.5C19.9142 11.25 20.25 11.5858 20.25 12C20.25 12.4142 19.9142 12.75 19.5 12.75H5.5C5.08579 12.75 4.75 12.4142 4.75 12Z" fill="#070707" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9697 4.46967C12.2626 4.17678 12.7374 4.17678 13.0303 4.46967L20.0303 11.4697C20.3232 11.7626 20.3232 12.2374 20.0303 12.5303L13.0303 19.5303C12.7374 19.8232 12.2626 19.8232 11.9697 19.5303C11.6768 19.2374 11.6768 18.7626 11.9697 18.4697L18.4393 12L11.9697 5.53033C11.6768 5.23744 11.6768 4.76256 11.9697 4.46967Z" fill="#070707" />
                                    </svg>
                                </button>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="success-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered px-3">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <img width="100" height="100" src="{{ env('AWS_S3_domain') }}epicon/assets/images/success-tick.png" alt="img">
                <h4 class="text-white mt-4">{{__('Subscription successfully!')}}</h4>
                <p class="w-75 text-white small m-auto mb-4"></p>
                <button class="login-btn mt-0 bg-transparent text-white btn-close" style="width: 280px;" data-bs-dismiss="modal" aria-label="Close">{{__('Done')}}</button>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
<script>
    $(document).ready(function() {
        $(".planid-hold").click(function(e) {
            var planid = $(this).attr('data-id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            var ajaxurl = APP_URL + '/planBenefit';
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    planid: planid
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data.pname);
                    $(".offer-data").html(data.html);
                    $('#count').text(data.count);
                    $("#plan_name").text(data.pname);
                    $('.additional-carousel').not('.slick-initialized').slick({
                        dots: false,
                        infinite: false,
                        speed: 300,
                        slidesToShow: 3.2,
                        slidesToScroll: 1,
                        accessibility: true,
                        responsive: [{
                                breakpoint: 1367,
                                settings: {
                                    slidesToShow: 3.2,
                                    slidesToScroll: 1,
                                }
                            },
                            {
                                breakpoint: 1025,
                                settings: {
                                    slidesToShow: 2.2,
                                    slidesToScroll: 1,
                                }
                            },
                            {
                                breakpoint: 769,
                                settings: {
                                    slidesToShow: 1.6,
                                    slidesToScroll: 1,
                                }
                            },
                            {
                                breakpoint: 600,
                                settings: {
                                    slidesToShow: 1.1,
                                    slidesToScroll: 1
                                }
                            },
                            {
                                breakpoint: 480,
                                settings: {
                                    slidesToShow: 1.1,
                                    slidesToScroll: 1
                                }
                            }
                        ]
                    });
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
        $(".CoupanApply").click(function(e) {
            var promo = $(".promocode").val();
            if (promo == '') {
                showToaster('Please enter coupan code.', 2);
                return false;
            } else {
                $('.payment').prop('disabled', true);
            }
            var btnval = $(this).text();
            if (btnval == "{{__('Remove')}}") {
                $("#coupanstatus").val('No');
                setTimeout(function() {
                    location.reload();
                }, 2500);
                showToaster('Coupon Removed.', 1);
                return false;
            }
            $(".coupan-msg").html("");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content'),
                }
            });
            e.preventDefault();
            var ajaxurl = APP_URL + '/getCouponAjax';
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    promocode: promo
                },
                dataType: 'json',
                success: function(e, t, n) {
                    if (e.is_createdPlan) {
                        $("#success-modal p").text(e.message);
                        $("#success-modal").modal("show");
                        setTimeout(function() {
                            window.location.href = "{{ route('my-account') }}";
                        }, 3000);
                        return;
                    } else {
                        var r = e.message;
                        // console.log("message="+e.message);
                        // console.log("message="+e);
                        showToaster(e.message, e.type);
                        $('.payment').prop('disabled', false);
                        if (e.success == false) {
                            $(".coupan-msg").text(r);
                        }
                        if ((console.log(e.plans), "NaN" != e.plans && null != e.plans && "" != e.plans)) {
                            var o = e.plans;
                            $.each(o, function(e, t) {
                                $('.oldprice-' + t.id).removeClass('d-none');
                                if (t.currency == 'INR' || t.currency == 'inr') {
                                    $('.oldprice-' + t.id).text('₹ ' + t.actual_price + '.00');
                                } else {
                                    $('.oldprice-' + t.id).text('$ ' + t.actual_price);
                                }
                                $('.save-' + t.id).removeClass('d-none');
                                $('.save-' + t.id).text('Save ' + t.discount_percentage_value + '%');
                                if (t.currency == 'INR' || t.currency == 'inr') {
                                    $('.current-' + t.id).html('<div class="val-price">₹ ' + t.discounted_price + '</div><span class="ms-1 small"> / ' + t.plan + '</span>');
                                } else {
                                    $('.current-' + t.id).html('<div class="val-price">$ ' + t.discounted_price + '</div><span class="ms-1 small"> / ' + t.name + '</span>');
                                }
                                $("#coupanstatus").val('Yes');
                            });
                            showToaster('Coupon applied', 1);
                            $(".CoupanApply").text("{{__('Remove')}}");
                            $("#coupon-text").prop("disabled", true);
                            //console.log(o.pname);
                        }
                    }
                },
                error: function(e, t, a) {
                    if (e.responseJSON.message != "") {
                        showToaster(e.responseJSON.message, 2);
                    } else {
                        showToaster('Coupon code expired', 2);
                    }
                    $(".button-loader").hide(), $(".submitpromo").show();
                },
            });
        });
        $(".payment").click(function() {
            if ($("#amountid").val() == "") {
                showToaster('please select you plan', 2);
            } else {
                $(".paymentForm").submit();
            }
        });
        $(".planid").click(function() {
            let planid = $(this).attr('data-id');
            $("#amountid").val(planid);
            if (planid == 'epic_in_pl_1') {
                $(".coupan-div").hide();
            } else {
                $(".coupan-div").show();
            }
        });
    });
</script>
@stop