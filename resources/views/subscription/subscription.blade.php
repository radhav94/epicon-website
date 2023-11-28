@extends('layouts.default')
@section('title','Subscription Plans - Epic On')

@section('style')

@stop
@section('content')
<!-- <section class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <a href="javascript:void(0)" class="goBackButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M26.3359 15.9987C26.3359 16.551 25.8882 16.9987 25.3359 16.9987L6.66927 16.9987C6.11699 16.9987 5.66927 16.551 5.66927 15.9987C5.66927 15.4464 6.11699 14.9987 6.66927 14.9987L25.3359 14.9987C25.8882 14.9987 26.3359 15.4464 26.3359 15.9987Z" fill="white"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7097 26.0391C16.3192 26.4297 15.686 26.4297 15.2955 26.0391L5.96217 16.7058C5.57164 16.3153 5.57164 15.6821 5.96217 15.2916L15.2955 5.95826C15.686 5.56773 16.3192 5.56773 16.7097 5.95826C17.1002 6.34878 17.1002 6.98195 16.7097 7.37247L8.08349 15.9987L16.7097 24.6249C17.1002 25.0154 17.1002 25.6486 16.7097 26.0391Z" fill="white"/>
                    </svg>
                </a>
            </div>
        </div>
    </section> -->
    <?php $meta['description'] = "Get access to a wide range of TV shows and movies of Epicon by subscribing to our platform. We have best plan for you. Check the Subscription section today!"; ?>
    <section class="container pb-5 choose-margin-mobile">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-10 position-relative">
            <h4 class="text-white text-center mb-4">
            <a href="javascript:void(0)" class="goBackButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M26.3359 15.9987C26.3359 16.551 25.8882 16.9987 25.3359 16.9987L6.66927 16.9987C6.11699 16.9987 5.66927 16.551 5.66927 15.9987C5.66927 15.4464 6.11699 14.9987 6.66927 14.9987L25.3359 14.9987C25.8882 14.9987 26.3359 15.4464 26.3359 15.9987Z" fill="white"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7097 26.0391C16.3192 26.4297 15.686 26.4297 15.2955 26.0391L5.96217 16.7058C5.57164 16.3153 5.57164 15.6821 5.96217 15.2916L15.2955 5.95826C15.686 5.56773 16.3192 5.56773 16.7097 5.95826C17.1002 6.34878 17.1002 6.98195 16.7097 7.37247L8.08349 15.9987L16.7097 24.6249C17.1002 25.0154 17.1002 25.6486 16.7097 26.0391Z" fill="white"/>
                    </svg>
            </a>
            {{__('Choose Your Plan')}}</h4>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-10 choose-plan">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    @foreach($result['plans'] as $key => $val)
                    <?php if($key === 0) {
                    $classActive = "active";
                    }else{
                        $classActive = "";
                    }
                    if($val['currency'] == 'INR' || $val['currency'] == 'inr'){
                        $currency_name = "₹ ";
                    }else{
                        $currency_name = "$ ";
                    }
                    if($val['id'] == 'epic_in_pl_4'){
                        $bestv = '<span class="best-value">Best Value</span>';
                    }else{
                        $bestv ="";
                    }    
                    ?>
                    <li class="nav-item" role="presentation">
                        
                        <button class="nav-link planid {{$classActive}}" id="pills-starter-tab" data-bs-toggle="pill" data-bs-target="#pills-starter" type="button" role="tab" aria-controls="pills-starter" aria-selected="true" data-id="{{$val['id']}}">
                        {!! $bestv !!}
                            <div>
                                <h6>
                                    <?php if($val['currency'] == 'INR' || $val['currency'] == 'inr'){ ?>
                                    <p class="small mb-0">{{$val['name']}}</p>
                                     <?php    } ?>
                                    <span class="d-none save-{{$val['id']}}"></span>
                                </h6>
                                <?php if($val['currency'] == 'INR' || $val['currency'] == 'inr'){ ?>
                                <h3 class="d-flex current-{{$val['id']}}"><div class="val-price">{{$currency_name}} {{$val['actual_price']}}.00</div><span class="ms-1 small"><b class="b-none"> /</b> {{@$val['plan'] ? @$val['plan'] : @$val['name']}}</span></h3>
                                <?php    }else { ?> 
                                    <h3 class="d-flex current-{{$val['id']}}"><div class="val-price">{{$currency_name}} {{$val['actual_price']}}</div><span class="ms-1 small"><b class="b-none"> /</b> {{@$val['name'] ? @$val['name'] : ''}}</span></h3>
                                    <?php } ?>
                                <h5 class="d-none"> </h5><h5 class="d-none oldprice-{{$val['id']}}"></h5>
                            </div>
                        </button>
                    </li>
                    @endforeach
                  </ul>
                  <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-starter" role="tabpanel" aria-labelledby="pills-starter-tab">
                        <div class="tab-main">
                            <ul class="benifits list-unstyled m-0">
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12" fill="none">
                                        <path d="M1.3313 7.27451L5.25287 11.1961L14.6646 1" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg> &nbsp; {{__('No ads')}}
                                </li>
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12" fill="none">
                                        <path d="M1.3313 7.27451L5.25287 11.1961L14.6646 1" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg> &nbsp; {{__('Upto 3 user profiles')}}
                                </li>
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12" fill="none">
                                        <path d="M1.3313 7.27451L5.25287 11.1961L14.6646 1" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg> &nbsp; {{__('Watch on all devices')}}
                                </li>
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12" fill="none">
                                        <path d="M1.3313 7.27451L5.25287 11.1961L14.6646 1" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg> &nbsp; {{__('Max video quality: Full HD 1080p')}}
                                </li>
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12" fill="none">
                                        <path d="M1.3313 7.27451L5.25287 11.1961L14.6646 1" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg> &nbsp; <?php echo __('All premium content'); ?>
                                </li>
                            </ul>
                            <div class="additional-offer d-none">
                                <div class="d-flex justify-content-between align-items-center text-white">
                                    <h6>{{__('Additional offer(s) benefits with your subscription')}}</h6>
                                    <h6>{{__('Total Coupons')}}: <span id="count">{{$offerCount}}</span></h6>
                                </div>
                                <div class="offer-data"> 
                                <ul class="additional-carousel mb-0 mt-3 p-0">
                                @foreach($result['plans'] as $key => $val)
                                    @if ($val['id'] == 'epic_in_pl_1')
                                    
                                    @foreach($val['benifits'] as $bn=>$bnval)
                                   
                                    <li>
                                        <div class="subsciption-coupon-card">
                                            <a href="javascript:void(0)">
                                                <img src="{{asset('img/coupon.svg')}}" alt="">
                                                <div class="ac-content">
                                                    <div class="left">
                                                        <div class="circle-logo">
                                                            <img src="{{ asset($bnval['vendor_image'])}}" alt="">
                                                        </div>
                                                        <span>Exc. Offer</span>
                                                    </div>
                                                    <div class="right">
                                                        <h5>25% OFF</h5>
                                                        <p id="vname">{{$bnval['vendor_name']}}</p>
                                                        <span>Valid until 03 March 2022</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="subsciption-coupon-card">
                                            <a href="javascript:void(0)">
                                                <img src="{{asset('img/coupon.svg')}}" alt="">
                                                <div class="ac-content">
                                                    <div class="left">
                                                        <div class="circle-logo">
                                                            <img src="{{ asset($bnval['vendor_image'])}}" alt="">
                                                        </div>
                                                        <span>Exc. Offer</span>
                                                    </div>
                                                    <div class="right">
                                                        <h5>25% OFF</h5>
                                                        <p id="vname">{{$bnval['vendor_name']}}</p>
                                                        <span>Valid until 03 March 2022</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                   

                                    @endforeach
                                  @endif
                                @endforeach
                                    
                                </ul>
                                </div>
                            </div>
                        </div>
                        <div class="use-code mt-4 coupan-div">
                            <p>{{__('Use code GET20 and get flat 20% off on 3/6/12-month subscriptions or get extra benefits. (T&C apply*)')}}</p>
                            <div class="position-relative">
                                <input type="text" placeholder="{{__('Enter promo code')}}" class="promocode">
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
                            <input type="hidden" name="amountid" id="amountid" value="{{$result['plans'][0]['id']}}">
                            <input type="hidden" name="currency" id="currency" value="{{$val['currency']}}">
                            <input type="hidden" name="coupanstatus" id="coupanstatus" value="No">
                            
                            {{--<p class="get-help mt-2 small">{{__('Already subscribed')}}?<a href="">{{__('Restore')}}</a></p>--}}
                            <button class="fill-btn payment" onclick="click_subscription(this)">{{__('Buy subscription')}} {{--&nbsp;<span id="plan_name"> Starter </span>--}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.75 12C4.75 11.5858 5.08579 11.25 5.5 11.25H19.5C19.9142 11.25 20.25 11.5858 20.25 12C20.25 12.4142 19.9142 12.75 19.5 12.75H5.5C5.08579 12.75 4.75 12.4142 4.75 12Z" fill="#070707"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9697 4.46967C12.2626 4.17678 12.7374 4.17678 13.0303 4.46967L20.0303 11.4697C20.3232 11.7626 20.3232 12.2374 20.0303 12.5303L13.0303 19.5303C12.7374 19.8232 12.2626 19.8232 11.9697 19.5303C11.6768 19.2374 11.6768 18.7626 11.9697 18.4697L18.4393 12L11.9697 5.53033C11.6768 5.23744 11.6768 4.76256 11.9697 4.46967Z" fill="#070707"/>
                                  </svg>
                            </button>
                            </form>
                            
                        </div>
                    </div>
                  </div>
            </div>
        </div>
    </section>
    
@stop

@section('script')
<script>
    $(document).ready(function(){
        $(".planid").click(function (e) {
            var planid =$(this).attr('data-id');  
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var ajaxurl = APP_URL+'/planBenefit';
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {planid:planid},
            dataType: 'json',
            success: function (data) {
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
        responsive: [
        {
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
            error: function (data) {
                console.log(data);
            }
        });
    });

    $(".CoupanApply").click(function (e) {
            var promo = $(".promocode").val();
            if(promo == ''){
                showToaster('Please enter coupan code.', 2);
                return false;
            }
            else{
                $('.payment').prop('disabled', true);
            }

            var btnval =$(this).text();
            if(btnval =="{{__('Remove')}}"){
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
        var ajaxurl = APP_URL+'/getCouponAjax';
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {promocode:promo},
            dataType: 'json',
            success: function (e, t, n) {
                var r = e.message;
                //console.log(r.);
                $('.payment').prop('disabled', false);
                if(e.success == false){
                    $(".coupan-msg").text(r);
                }
                if ((console.log(e.plans), "NaN" != e.plans && null != e.plans && "" != e.plans)) {
                    var o = e.plans;
                    $.each(o, function (e, t) {
                        $('.oldprice-'+t.id).removeClass('d-none');
                        if(t.currency == 'INR' || t.currency == 'inr'){
                            $('.oldprice-'+t.id).text('₹ '+t.actual_price+'.00');
                        }else{
                            $('.oldprice-'+t.id).text('$ '+t.actual_price);
                        }
                        
                        $('.save-'+t.id).removeClass('d-none');
                        $('.save-'+t.id).text('Save 20%');
                        if(t.currency == 'INR' || t.currency == 'inr'){
                        $('.current-'+t.id).html('₹ '+t.discounted_price+'<span class="ms-1 small"> / '+t.plan+'</span>');
                        }else{
                            $('.current-'+t.id).html('$ '+t.discounted_price+'<span class="ms-1 small"> / '+t.name+'</span>');
                        }
                        $("#coupanstatus").val('Yes');
                       
                    });
                    showToaster('Coupon applied', 1);
                    $(".CoupanApply").text("{{__('Remove')}}");
                    //console.log(o.pname);
                    
                }
            },
            error: function (e, t, a) {
                showToaster('Coupon code expired', 2);
                console.log("invalid3"), $(".button-loader").hide(), $(".submitpromo").show();
            },
        });
    });

    $(".payment").click(function(){
        if($("#amountid").val() == ""){
            showToaster('please select you plan', 2);
        }else{

            $(".paymentForm").submit();
            
        }
    });
    
    $(".planid").click(function(){
        let planid = $(this).attr('data-id');
        $("#amountid").val(planid);
            if(planid == 'epic_in_pl_1'){
                $(".coupan-div").hide();
            }else{
                $(".coupan-div").show();   
            }
       
    });
   
    });
    </script> 
@stop