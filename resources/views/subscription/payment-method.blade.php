@extends('layouts.default')
@section('title','New homepage')

@section('style')

@stop

@section('content')
<?php 

$request = Request();

$userData = $request->session()->get('user');


$subscribData = ''; $id = ''; $name = ''; $plan = ''; $actual_price = ''; $epic_price = ''; $save = '';
//dd($result);
if(isset($result) && !empty($result)){
    $id = $result['id'];
    $name = $result['name'];
    $plan = $result['plan'];
    $actual_price = $result['actual_price'];
    $epic_price = $result['epic_price'];
    $save = $result['save'];
}
?>
<section class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <a href="subscription.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M26.3359 15.9987C26.3359 16.551 25.8882 16.9987 25.3359 16.9987L6.66927 16.9987C6.11699 16.9987 5.66927 16.551 5.66927 15.9987C5.66927 15.4464 6.11699 14.9987 6.66927 14.9987L25.3359 14.9987C25.8882 14.9987 26.3359 15.4464 26.3359 15.9987Z" fill="white"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7097 26.0391C16.3192 26.4297 15.686 26.4297 15.2955 26.0391L5.96217 16.7058C5.57164 16.3153 5.57164 15.6821 5.96217 15.2916L15.2955 5.95826C15.686 5.56773 16.3192 5.56773 16.7097 5.95826C17.1002 6.34878 17.1002 6.98195 16.7097 7.37247L8.08349 15.9987L16.7097 24.6249C17.1002 25.0154 17.1002 25.6486 16.7097 26.0391Z" fill="white"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>
    <section class="container pb-5">
        <form name="checkoutsubscriptionform" method="post" id="checkoutsubscriptionid" action="{{route('saveSubscription')}}">
        @csrf
        <div class="row justify-content-center">
            <h4 class="text-white text-center mb-4">Payment Methods</h4>
            <div class="col-12 payment-method">
                <button type="button">
                    <img src="{{ asset('/img/pm-debit-card.svg') }}" alt="icon">
                    Debit Card
                    <input type="radio" name="payment_type" value="DC" id="debit-card" checked>
                </button>
                <button type="button">
                    <img src="{{ asset('/img/pm-credit-card.svg') }}" alt="icon">
                    Credit Card
                    <input type="radio" name="payment_type" value="CC" id="credit-card">
                </button>
                <button type="button">
                    <img src="{{ asset('/img/pm-netbanking.svg') }}" alt="icon">
                    Net Banking
                    <input type="radio" name="payment_type" value="NB" id="netbanking">
                </button>
                <button type="button">
                    <img src="{{ asset('/img/pm-UPI.svg') }}" alt="icon">
                    UPI
                    <input type="radio" name="payment_type" value="UPI" id="upi">
                </button>
                <button type="button">
                    <img src="{{ asset('/img/pm-wallet.svg') }}" alt="icon">
                    Wallet
                    <input type="radio" name="payment_type" value="CASH" id="wallet">
                </button>
            </div>

            <div class="other-payment-option mt-5 pb-5">
                <p class="text-white text-center">Other Options</p>
                <div class="opt">
                    <button type="button"><img src="{{ asset('/img/quick-cilver.png') }}" alt="icon"></button>
                    <button type="button"><img src="{{ asset('/img/google-play.png') }}" alt="icon"></button>
                </div>
            </div>
          
            {{--<input type="hidden" name="key" value="{{$payudata['key']}}"> --}}
            <input type="hidden" name="amount" value="{{$actual_price}}">
            <input type="hidden" name="amountid" value="{{$data['amountid']}}">
            <input type="hidden" name="coupanstatus" value="{{$data['coupanstatus']}}">
            {{--  <input type="hidden" name="email" value="{{$payudata['email']}}"> 
            <input type="hidden" name="productinfo" value="{{$id}}">
            <input type="hidden" name="furl" value="http://local.epicon-revamp-v3.com/payufail">
            <input type="hidden" name="txnid" value="{{$payudata['txid']}}">
            <input type="hidden" name="firstname" value="{{$payudata['firstname']}}">
            <input type="hidden" name="phone" value="9819208025">
            <input type="hidden" name="surl" value="http://local.epicon-revamp-v3.com/payusuccess">
            <input type="hidden" name="hash" value="{{$payudata['has']}}"> --}}
            <div class="continue-payment mt-5">
                <p>You will be redirected to a third party site to complete the payment</p>
                <button class="fill-btn px-5" type="submit">Continue Pay Rs. <?=$result['actual_price']?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.75 12C4.75 11.5858 5.08579 11.25 5.5 11.25H19.5C19.9142 11.25 20.25 11.5858 20.25 12C20.25 12.4142 19.9142 12.75 19.5 12.75H5.5C5.08579 12.75 4.75 12.4142 4.75 12Z" fill="#070707"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9697 4.46967C12.2626 4.17678 12.7374 4.17678 13.0303 4.46967L20.0303 11.4697C20.3232 11.7626 20.3232 12.2374 20.0303 12.5303L13.0303 19.5303C12.7374 19.8232 12.2626 19.8232 11.9697 19.5303C11.6768 19.2374 11.6768 18.7626 11.9697 18.4697L18.4393 12L11.9697 5.53033C11.6768 5.23744 11.6768 4.76256 11.9697 4.46967Z" fill="#070707"/>
                      </svg>
                </button>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-sm-10">
                <div class="upi-qr">
                    <div class="left text-white">
                        <h4 class="text-center mb-5">UPI Payment</h4>
                        <input type="text" placeholder="UPI Id">
                        <p class="small text-white mb-5 mt-2">You will receive a payment request on your UPI app</p>
                        <button class="fill-btn m-auto w-100" type="submit">Continue Pay Rs. <?=$result['actual_price']?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.75 12C4.75 11.5858 5.08579 11.25 5.5 11.25H19.5C19.9142 11.25 20.25 11.5858 20.25 12C20.25 12.4142 19.9142 12.75 19.5 12.75H5.5C5.08579 12.75 4.75 12.4142 4.75 12Z" fill="#070707"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9697 4.46967C12.2626 4.17678 12.7374 4.17678 13.0303 4.46967L20.0303 11.4697C20.3232 11.7626 20.3232 12.2374 20.0303 12.5303L13.0303 19.5303C12.7374 19.8232 12.2626 19.8232 11.9697 19.5303C11.6768 19.2374 11.6768 18.7626 11.9697 18.4697L18.4393 12L11.9697 5.53033C11.6768 5.23744 11.6768 4.76256 11.9697 4.46967Z" fill="#070707"/>
                              </svg>
                        </button>
                    </div>
                    <div class="or">
                        <span>Or</span>
                    </div>
                    <div class="right text-white text-center">
                        <h4 class="text-center mb-5">Pay with QR code</h4>
                        <img src="{{ asset('/img/qr-img.svg') }}" alt="qr">
                    </div>
                </div>
            </div>
        </div>
        </form>
    </section>

    @stop

@section('script')


@stop