@extends('layouts.default')
@section('title','Payment Method')

@section('style')
<style>
    .active{ border-color: #04AA6D !important;
             color: green !important;
        }
</style>
@stop

@section('content')
<?php 
$request = Request();
$userData = $request->session()->get('user');
$subscribData = ''; $id = ''; $name = ''; $plan = ''; $actual_price = ''; $epic_price = ''; $save = '';
if(isset($result) && !empty($result)){
    $id = $result['id'];
    $name = $result['name'];
    $plan = $result['plan'];
    $actual_price = $result['actual_price'];
    $epic_price = $result['epic_price'];
    $save = $result['save'];
    $currency_amt = @$result['currency'];

}
if($currency_amt == 'INR'){
    $cur_var = 'Rs.';
}else{
    $cur_var = '$';
}

?>

<section class="container-fluid mt-4">
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
    </section>
    <section class="container pb-5">
        <form name="checkoutsubscriptionform" method="post" id="checkoutsubscriptionid" action="{{route('saveSubscription')}}">
        @csrf
        <div class="row justify-content-center">
        <input type="hidden" name="payment_type" value="DC" class="card_type" id="card_type">
            <h4 class="text-white text-center mb-4">{{__('Payment Methods')}}</h4>
            <div class="col-12 payment-method">
                <button type="button" class="button-type active" data-attr="DC">
                    <img src="{{ env('AWS_S3_domain').'epicon/assets/images/pm-debit-card.svg' }}" alt="icon">
                    <?php echo __('Debit Card'); ?>
                </button>
                <button type="button" class="button-type" data-attr="CC">
                    <img src="{{ env('AWS_S3_domain').'epicon/assets/images/pm-credit-card.svg' }}" alt="icon">
                    <?php echo __('Credit Card'); ?>
                </button>
                <button type="button" class="button-type" data-attr="NB">
                    <img src="{{ env('AWS_S3_domain').'epicon/assets/images/pm-netbanking.svg' }}" alt="icon">
                    <?php echo __('Net Banking'); ?>
                </button>
                <button type="button" class="button-type" data-attr="UPI">
                    <img src="{{ env('AWS_S3_domain').'epicon/assets/images/pm-UPI.svg' }}" alt="icon">
                    <?php echo __('UPI'); ?>
                </button>
                <button type="button" class="button-type" data-attr="CASH">
                    <img src="{{ env('AWS_S3_domain').'epicon/assets/images/pm-wallet.svg' }}" alt="icon">
                    <?php echo __('Wallet'); ?>
                </button>
            </div>

            {{--<div class="other-payment-option mt-5 pb-5">
                <p class="text-white text-center">{{__('Other Options')}}</p>
                <div class="opt">
                    <button type="button"><img src="{{ env('AWS_S3_domain').'epicon/assets/images/quick-cilver.png' }}" alt="icon"></button>
                    <button type="button"><img src="{{ env('AWS_S3_domain').'epicon/assets/images/google-play.png' }}" alt="icon"></button>
                </div>
            </div>--}}
          
            {{--<input type="hidden" name="key" value="{{$payudata['key']}}"> --}}
            <input type="hidden" name="amount" value="{{$actual_price}}" id="actual_price">
            <input type="hidden" name="amountid" value="{{$data['amountid']}}">
            <input type="hidden" name="coupanstatus" value="{{$data['coupanstatus']}}">
            {{--  <input type="hidden" name="email" value="{{$payudata['email']}}"> 
            <input type="hidden" name="productinfo" value="{{$id}}">
            <input type="hidden" name="furl" value="http://local.epicon-revamp-v3.com/payufail">
            <input type="hidden" name="txnid" value="{{$payudata['txid']}}">
            <input type="hidden" name="firstname" value="{{$payudata['firstname']}}">
            <input type="hidden" name="phone" value="">
            <input type="hidden" name="surl" value="http://local.epicon-revamp-v3.com/payusuccess">
            <input type="hidden" name="hash" value="{{$payudata['has']}}"> --}}
            <div class="continue-payment mt-5">
                <p>{{__('You will be redirected to a third party site to complete the payment')}}</p>
                @if((empty($userData['mobile']) && $userData['mobile']=='' || empty($userData['email']) && $userData['email']=='') && $currency_amt == 'INR')
                      <span id="submit_button"> </span>  
                @else
                <button class="fill-btn px-5" type="submit">{{__('Continue Pay')}} {{$cur_var}} <?=$actual_price?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.75 12C4.75 11.5858 5.08579 11.25 5.5 11.25H19.5C19.9142 11.25 20.25 11.5858 20.25 12C20.25 12.4142 19.9142 12.75 19.5 12.75H5.5C5.08579 12.75 4.75 12.4142 4.75 12Z" fill="#070707"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9697 4.46967C12.2626 4.17678 12.7374 4.17678 13.0303 4.46967L20.0303 11.4697C20.3232 11.7626 20.3232 12.2374 20.0303 12.5303L13.0303 19.5303C12.7374 19.8232 12.2626 19.8232 11.9697 19.5303C11.6768 19.2374 11.6768 18.7626 11.9697 18.4697L18.4393 12L11.9697 5.53033C11.6768 5.23744 11.6768 4.76256 11.9697 4.46967Z" fill="#070707"/>
                      </svg>
                </button>
                @endif
            </div>
        </div>

        {{--<div class="row justify-content-center mt-5">
            <div class="col-sm-10">
                <div class="upi-qr">
                    <div class="left text-white">
                        <h4 class="text-center mb-5">{{__('UPI Payment')}}</h4>
                        <input type="text" placeholder="{{__('UPI Id')}}">
                        <p class="small text-white mb-5 mt-2">{{__('You will receive a payment request on your UPI app')}}</p>
                        
                        <button class="fill-btn m-auto w-100" type="submit">{{__('Continue Pay')}} Rs. <?=$result['actual_price']?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.75 12C4.75 11.5858 5.08579 11.25 5.5 11.25H19.5C19.9142 11.25 20.25 11.5858 20.25 12C20.25 12.4142 19.9142 12.75 19.5 12.75H5.5C5.08579 12.75 4.75 12.4142 4.75 12Z" fill="#070707"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9697 4.46967C12.2626 4.17678 12.7374 4.17678 13.0303 4.46967L20.0303 11.4697C20.3232 11.7626 20.3232 12.2374 20.0303 12.5303L13.0303 19.5303C12.7374 19.8232 12.2626 19.8232 11.9697 19.5303C11.6768 19.2374 11.6768 18.7626 11.9697 18.4697L18.4393 12L11.9697 5.53033C11.6768 5.23744 11.6768 4.76256 11.9697 4.46967Z" fill="#070707"/>
                              </svg>
                        </button>
                       
                    </div>
                    <div class="or">
                        <span>{{__('Or')}}</span>
                    </div>
                    <div class="right text-white text-center">
                        <h4 class="text-center mb-5">{{__('Pay with QR code')}}</h4>
                        <img src="{{ env('AWS_S3_domain').'epicon/assets/images/qr-img.svg' }}" alt="qr">
                    </div>
                </div>
            </div>
        </div>--}}
        </form>
    </section>

    @include('components.update-user-modal')
    @include('components.verify-user-modal')

    @stop

@section('script')
<script>
$(document).ready(function(){
    $(".button-type").click(function () {
        var card_type = $(this).attr("data-attr");
        $("#card_type").val(card_type);   
        $(".button-type").removeClass("active");
        $(this).addClass("active");
            
    });
});

perfEntries = performance.getEntriesByType("navigation");
if (perfEntries[0].type === "back_forward") {
    window.location.reload(true);
}

</script>

@if((empty($userData['mobile']) && $userData['mobile']=='' || empty($userData['email']) && $userData['email']=='') && $currency_amt == 'INR')
<script>
$(document).ready(function(){

    $('#update_user_modal').modal('show');
    //$('#verifyotpmodal').modal('show');
    $(".updateProfile").click(function (e) {
        var userdetail = $(".userdetail").val();
        var type = $(".userdetail").attr('data-id');
        var actual_price = $("#actual_price").val();
        var stdcodeval = $(".stdcode").val();
        $(".errMessage").text('');
        if(userdetail == ''){
            $(".errMessage").text('This field is required and cannot be empty.');
            return false;
        }
        else{
            if(type == 'email'){
                if( !validateEmail(userdetail)){
                   $(".errMessage").text('You have entered an invalid email address.');
                    return false;   
                
                }
            }else{
                if( !validatePhone(userdetail)){
                   $(".errMessage").text('You have entered an invalid mobile number.');
                    return false;   
                
                }
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            var ajaxurl = APP_URL+'/sendOtpAjax';
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {userdetail:userdetail,type:type,price:actual_price,stdcode:stdcodeval},
                dataType: 'json',
                success: function (res) {
                    console.log(res.success);
                    if(res.success == true){
                        $('#update_user_modal').modal('hide');
                        $("#userdata").text(userdetail);
                        $('#verifyotpmodal').modal('show');
                    }
                    //$("#submit_button").html(res.html);
                },
                error: function (e) {
                },
            });
        }
    });

    // user update verify OTP

    $("#veryfy_submit").click(function (e) {
            e.preventDefault();
            var userdetail = $(".userdetail").val();
            var type = $(".userdetail").attr('data-id');
            var actual_price = $("#actual_price").val();
            var stdcodeval = $(".stdcode").val();
            $(".errMessage").text('');
            var valid = true;
            $('.vpin').each(function() {
                if ($(this).val() === '') {
                    valid = false;
                    return false; // Exit the loop early if an invalid input is found
                }
            });
            
            if (valid) {
                $('#err_message').text('');
            } else {
                $('#err_message').text('Please fill in all input boxes.');
            }
                
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var formData = $('#verifyUserOtp').serialize()+ "&userdetail=" + userdetail+"&type=" + type+"&price=" + actual_price+"&stdcode="+stdcodeval;
        var ajaxurl = APP_URL+'/verifyOtpAjax';
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (res) {
                console.log(res.success);
                if(res.success == true){
                    $('#verifyotpmodal').modal('hide');
                    $("#submit_button").html(res.html);
                    showToaster(res.message, 1);
                }else{
                    showToaster(res.message, 2);
                }
            },
            error: function (e) {
            },
        });
    });

    $("input.vpin").keyup(function(event) {
    if ($(this).val().length == 1) {
      $(this).nextAll('input.vpin').first().focus();
    } else if ($(this).val().length > 1) {
      var new_val = $(this).val().substring(1, 2);
      $(this).val(new_val);
      $(this).nextAll('input.vpin').first().focus();
    }
  });
  $("input.vpin").keydown(function(event) {
    if (event.keyCode == 8 && $(this).val().length == 0) {
      if ($(this).prev('input.vpin')) {
        $(this).prev('input.vpin').focus();
      }
    }
  });

  $("#mob-number").on( 'keypress', function( e ){
    if (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) {
        e.preventDefault();
    }
}); 

$(".userdetail").on("keyup", function (e) {
    $(".errMessage").text('');
});

});

function validateEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
function validatePhone(phone_number) {
    var filter =  /^(0|91)?[6-9][0-9]{9}$/;    
    if (filter.test(phone_number)) {
        return true;
    }
    else {
        return false;
    }
}
</script>
@endif
@stop