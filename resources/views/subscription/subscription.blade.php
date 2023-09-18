@extends('layouts.default')
@section('title','New homepage')

@section('style')

@stop

@section('content')    
<section class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <a href="index.html">
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
            <h4 class="text-white text-center mb-4">Choose Your Plan</h4>
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
                    ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{$classActive}} planid" id="pills-starter-tab" data-bs-toggle="pill" data-bs-target="#pills-starter" type="button" role="tab" aria-controls="pills-starter" aria-selected="true" data-id="{{$val['id']}}">
                            <div>
                                <h6>
                                    <p class="small mb-0">{{$val['name']}}</p>
                                    <span class="d-none save-{{$val['id']}}"></span>
                                </h6>
                                <h3 class="d-flex current-{{$val['id']}}">{{$currency_name}} {{$val['actual_price']}}.00 <span class="ms-1 small"> / {{$val['plan']}}</span></h3>
                                <h5 class="d-none"> </h5><h5 class="d-none oldprice-{{$val['id']}}"></h5>
                            </div>
                        </button>
                    </li>
                    @endforeach
                   <!-- <li class="nav-item" role="presentation">
                      <button class="nav-link" id="pills-basic-tab" data-bs-toggle="pill" data-bs-target="#pills-basic" type="button" role="tab" aria-controls="pills-basic" aria-selected="false">
                        <div>
                            <h6>
                                <p class="small mb-0">BASIC</p>
                            </h6>
                            <h3 class="d-flex">₹ 159.00 <span class="ms-1 small"> / 3 month</span></h3>
                        </div>
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="pills-elite-tab" data-bs-toggle="pill" data-bs-target="#pills-elite" type="button" role="tab" aria-controls="pills-elite" aria-selected="false">
                        <div>
                            <h6>
                                <p class="small mb-0">ELITE</p>
                                <span>Save 20%</span>
                            </h6>
                            <h3 class="d-flex">₹ 299.00 <span class="ms-1 small"> / 6 month</span></h3>
                            <h5>₹ 399.00</h5>
                        </div>
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-primium-tab" data-bs-toggle="pill" data-bs-target="#pills-primium" type="button" role="tab" aria-controls="pills-primium" aria-selected="false">
                            <div>
                                <h6>
                                    <p class="small mb-0">PREMIUM</p>
                                    <span>Save 40%</span>
                                </h6>
                                <h3 class="d-flex">₹ 399.00 <span class="ms-1 small"> / year</span></h3>
                                <h5>₹ 999.00</h5>
                            </div>
                        </button>
                      </li>-->
                  </ul>
                  <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-starter" role="tabpanel" aria-labelledby="pills-starter-tab">
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
                                    <h6>Total Coupons: <span id="count">{{$offerCount}}</span></h6>
                                </div>
                                <div class="offer-data"> 
                                <ul class="additional-carousel mb-0 mt-3 p-0">
                                @foreach($result['plans'] as $key => $val)
                                    @if ($val['id'] == 'epic_in_pl_1')
                                    
                                    @foreach($val['benifits'] as $bn=>$bnval)
                                   
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset($bnval['vendor_image'])}}" alt="">
                                            <div class="ac-content">
                                                <div class="left">
                                                    <div class="circle-logo">
                                                        <img src="{{ asset('/img/kfc-logo.png')}}" alt="">
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
                                    </li>
                                   

                                    @endforeach
                                  @endif
                                @endforeach
                                    
                                </ul>
                                </div>
                            </div>
                        </div>
                        <div class="use-code mt-4">
                            <p>Use code GET20 and get flat 20% off on 3/6/12-month subscriptions or get extra benefits. (T&C apply*)</p>
                            <div class="position-relative">
                                <input type="text" placeholder="Enter promo code" class="promocode">
                                <button class="apl-btn bg-transparent CoupanApply">Apply</button>
                            </div>
                            <div style="color:red" class="coupan-msg"></div>
                        </div>
                        
                        <div class="subscribe-bottom mt-4">
                        <form method="post" action="{{route('paymentMethod')}}" class="paymentForm">
                            @csrf
                            <input type="hidden" name="amountid" id="amountid" value="{{$result['plans'][0]['id']}}">
                            <p class="get-help mt-2 small">Already subscribed?<a href="">Restore</a></p>
                            <button class="fill-btn payment">Continue with Premium
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.75 12C4.75 11.5858 5.08579 11.25 5.5 11.25H19.5C19.9142 11.25 20.25 11.5858 20.25 12C20.25 12.4142 19.9142 12.75 19.5 12.75H5.5C5.08579 12.75 4.75 12.4142 4.75 12Z" fill="#070707"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9697 4.46967C12.2626 4.17678 12.7374 4.17678 13.0303 4.46967L20.0303 11.4697C20.3232 11.7626 20.3232 12.2374 20.0303 12.5303L13.0303 19.5303C12.7374 19.8232 12.2626 19.8232 11.9697 19.5303C11.6768 19.2374 11.6768 18.7626 11.9697 18.4697L18.4393 12L11.9697 5.53033C11.6768 5.23744 11.6768 4.76256 11.9697 4.46967Z" fill="#070707"/>
                                  </svg>
                            </button>
                            </form>
                            <div class="tc mt-3">
                                <a href="">Terms of Use</a>
                                <b>•</b>
                                <a href="">Privacy Policy</a>
                            </div>
                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-basic" role="tabpanel" aria-labelledby="pills-basic-tab">
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
                        <div class="use-code mt-4">
                            <p>Use code GET20 and get flat 20% off on 3/6/12-month subscriptions or get extra benefits. (T&C apply*)</p>
                            <div class="position-relative">
                                <input type="text" placeholder="Enter promo code" class="promocode">
                                <button class="apl-btn bg-transparent">Apply</button>
                            </div>
                        </div>
                        
                        <div class="subscribe-bottom mt-4">
                        <form method="post" action="{{route('paymentMethod')}}" class="paymentForm">
                            <p class="get-help mt-2 small">Already subscribed?<a href="">Restore</a></p>
                            <button class="fill-btn payment">Continue with Premium
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.75 12C4.75 11.5858 5.08579 11.25 5.5 11.25H19.5C19.9142 11.25 20.25 11.5858 20.25 12C20.25 12.4142 19.9142 12.75 19.5 12.75H5.5C5.08579 12.75 4.75 12.4142 4.75 12Z" fill="#070707"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9697 4.46967C12.2626 4.17678 12.7374 4.17678 13.0303 4.46967L20.0303 11.4697C20.3232 11.7626 20.3232 12.2374 20.0303 12.5303L13.0303 19.5303C12.7374 19.8232 12.2626 19.8232 11.9697 19.5303C11.6768 19.2374 11.6768 18.7626 11.9697 18.4697L18.4393 12L11.9697 5.53033C11.6768 5.23744 11.6768 4.76256 11.9697 4.46967Z" fill="#070707"/>
                                  </svg>
                            </button>
                            </form>
                            <div class="tc mt-3">
                                <a href="">Terms of Use</a>
                                <b>•</b>
                                <a href="">Privacy Policy</a>
                            </div>
                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-elite" role="tabpanel" aria-labelledby="pills-elite-tab">
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
                        <div class="use-code mt-4">
                            <p>Use code GET20 and get flat 20% off on 3/6/12-month subscriptions or get extra benefits. (T&C apply*)</p>
                            <div class="position-relative">
                                <input type="text" placeholder="Enter promo code" class="promocode">
                                <button class="apl-btn bg-transparent CoupanApply">Apply</button>
                            </div>
                        </div>
                        
                        <div class="subscribe-bottom mt-4">
                        <form method="post" action="{{route('paymentMethod')}}" class="paymentForm">
                            <p class="get-help mt-2 small">Already subscribed?<a href="">Restore</a></p>
                            <button class="fill-btn payment">Continue with Premium
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.75 12C4.75 11.5858 5.08579 11.25 5.5 11.25H19.5C19.9142 11.25 20.25 11.5858 20.25 12C20.25 12.4142 19.9142 12.75 19.5 12.75H5.5C5.08579 12.75 4.75 12.4142 4.75 12Z" fill="#070707"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9697 4.46967C12.2626 4.17678 12.7374 4.17678 13.0303 4.46967L20.0303 11.4697C20.3232 11.7626 20.3232 12.2374 20.0303 12.5303L13.0303 19.5303C12.7374 19.8232 12.2626 19.8232 11.9697 19.5303C11.6768 19.2374 11.6768 18.7626 11.9697 18.4697L18.4393 12L11.9697 5.53033C11.6768 5.23744 11.6768 4.76256 11.9697 4.46967Z" fill="#070707"/>
                                  </svg>
                            </button>
                        </form>
                            <div class="tc mt-3">
                                <a href="">Terms of Use</a>
                                <b>•</b>
                                <a href="">Privacy Policy</a>
                            </div>
                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-primium" role="tabpanel" aria-labelledby="pills-primium-tab">
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
                                            <img src="{{ asset('/img/coupon.svg')}}" alt="">
                                            <div class="ac-content">
                                                <div class="left">
                                                    <div class="circle-logo">
                                                        <img src="{{ asset('/img/kfc-logo.png')}}" alt="">
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
                                            <img src="{{ asset('/img/coupon.svg')}}" alt="">
                                            <div class="ac-content">
                                                <div class="left">
                                                    <div class="circle-logo">
                                                        <img src="{{ asset('/img/kfc-logo.png')}}" alt="">
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
                        <div class="use-code mt-4">
                            <p>Use code GET20 and get flat 20% off on 3/6/12-month subscriptions or get extra benefits. (T&C apply*)</p>
                            <div class="position-relative">
                                <input type="text" placeholder="Enter promo code" class="promocode"> 
                                <button class="apl-btn bg-transparent CoupanApply">Apply</button>
                            </div>
                        </div>
                        
                        <div class="subscribe-bottom mt-4">
                        <form method="post" action="{{route('paymentMethod')}}" id="paymentForm">
                            <p class="get-help mt-2 small">Already subscribed?<a href="">Restore</a></p>
                            <button class="fill-btn payment" type="submit" id="payment">Continue with Premium
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.75 12C4.75 11.5858 5.08579 11.25 5.5 11.25H19.5C19.9142 11.25 20.25 11.5858 20.25 12C20.25 12.4142 19.9142 12.75 19.5 12.75H5.5C5.08579 12.75 4.75 12.4142 4.75 12Z" fill="#070707"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9697 4.46967C12.2626 4.17678 12.7374 4.17678 13.0303 4.46967L20.0303 11.4697C20.3232 11.7626 20.3232 12.2374 20.0303 12.5303L13.0303 19.5303C12.7374 19.8232 12.2626 19.8232 11.9697 19.5303C11.6768 19.2374 11.6768 18.7626 11.9697 18.4697L18.4393 12L11.9697 5.53033C11.6768 5.23744 11.6768 4.76256 11.9697 4.46967Z" fill="#070707"/>
                                  </svg>
                            </button>
                        </form>
                            <div class="tc mt-3">
                                <a href="">Terms of Use</a>
                                <b>•</b>
                                <a href="">Privacy Policy</a>
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
                console.log(data);
                //console.log(plan[0].vendor_image);
                // $.each(plan, function (e, t) {
                //     //console.log(t.vendor_image);
                //     $('.off-image').append('<img src="'+t.vendor_image+'"  alt=""></span>');
                //     $('#vname').text(t.vendor_name);
                // });

                $(".offer-data").html(data.html);
                $('#count').text(data.count);

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
            //alert(promo);
        $(".coupan-msg").html("");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
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
                console.log(r);
                if(e.success == false){
                    $(".coupan-msg").text(r);
                }
                if ((console.log(e.plans), "NaN" != e.plans && null != e.plans && "" != e.plans)) {
                    var o = e.plans;
                    $.each(o, function (e, t) {
                        console.log(t);
                        console.log('id',t.id);
                        $('.oldprice-'+t.id).removeClass('d-none');
                        $('.oldprice-'+t.id).text('₹'+t.actual_price+'.00');
                        $('.save-'+t.id).removeClass('d-none');
                        $('.save-'+t.id).text('Save 20%');
                        $('.current-'+t.id).text('₹'+t.discounted_price);
                            // 1 == $("#" + t.id).length &&
                            //     ($(".promoerror").html("Coupon applied"),
                            //     (curcurrency = "INR" == t.currency ? "inr" : "usd"),
                            //     $("#coupon_" + t.id).html(
                            //         '<h4 class="pg-price"><i class="fa fa-' +
                            //             curcurrency +
                            //             '"></i>' +
                            //             t.discounted_price +
                            //             '<span class="old-price"><i class="fa fa-' +
                            //             curcurrency +
                            //             '"></i>' +
                            //             t.actual_price +
                            //             "</span></h4>"
                            //     ));
                    });
                }
            },
            error: function (e, t, a) {
                console.log("invalid3"), $(".button-loader").hide(), $(".submitpromo").show();
            },
        });
    });

    $(".payment").click(function(){
     if($("#amountid").val() == ""){
        alert("please select you plan");
     }else{

        $(".paymentForm").submit();
        
     }
        
    });

    $(".planid").click(function(){
        let price = $(this).attr('data-id');
        $("#amountid").val(price);
       
    });
   
    });
</script>

@stop