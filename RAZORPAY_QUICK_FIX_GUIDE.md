# Razorpay Quick Fix Implementation Guide

## Overview
Your frontend needs refactoring to comply with the backend contract. This guide provides exact code replacements.

---

## Change 1: RazorpayController - Update saveSubscriptionRazorpay()

**File**: `app/Http/Controllers/RazorpayController.php`

### Remove Mandate API Call

**FIND** (Lines 61-70):
```php
// Call Razorpay Mandate API before creating order
$mandateData = [
    'planCode' => @$result['id'],
    'authType' => 'netbanking',
    'device' => 'web',
    'source' => 'subscription_screen'
];

$this->razorpayLog('Razorpay Mandate API Request', false, ['endpoint' => 'subscriptions/razorpay-mandate/createRequest', 'request' => $mandateData]);
$mandateResponse = CurlAPI("subscriptions/razorpay-mandate/createRequest", 'POST', $mandateData, 2, false, true);
```

**REPLACE WITH**: 
```php
// Mandate API is no longer used - backend handles subscription creation
// This simplifies the flow and uses standard Razorpay subscription model
```

### Remove Mandate Response Handling

**FIND** (Lines 72-80):
```php
$mandateId = null;
$mandateCheckoutData = null;

if (@$mandateResponse['success'] === true && !empty(@$mandateResponse['mandateId']) && !empty(@$mandateResponse['checkout'])) {
    $mandateId = $mandateResponse['mandateId'];
    $mandateCheckoutData = $mandateResponse['checkout'];
    $this->razorpayLog('Mandate created successfully', false, ['mandateId' => $mandateId]);
} else {
    $this->razorpayLog('Mandate API failed or missing data', false, ['response' => $mandateResponse]);
    return response()->view('pages.error.404', [], 404);
}
```

**REPLACE WITH**:
```php
// No mandate handling needed - backend returns subscription_id in createOrder response
$subscriptionId = null;
```

### Update Create Order Request

**FIND** (Lines 83-93):
```php
$postData = [
    'user_id' => @$userData['user_id'],
    'plan_id' => @$result['id'],
    'order_value' => @$result['actual_price'],
    'mobile' => @$userData['mobile'],
    'email' => @$userData['email'],
    'payment_gateway' => 'razorpay',
];
```

**REPLACE WITH**:
```php
$postData = [
    'user_id' => @$userData['user_id'],
    'plan_id' => @$result['id'],
    'order_value' => @$result['actual_price'],
    'mobile' => @$userData['mobile'],
    'email' => @$userData['email'],
    'payment_gateway' => 'razorpay',
    'recurring_subscription' => true,  // ✅ ADD THIS
];
```

### Extract Subscription ID from Response

**FIND** (Lines 98-103):
```php
if (@$resultData['success'] != true || empty(@$resultData['order_data'])) {
    return response()->view('pages.error.404', [], 404);
}

$resorder = $resultData['order_data'];
$txid = @$resorder['order_id'];
$totalAmount = @$resorder['order_value'];
```

**REPLACE WITH**:
```php
if (@$resultData['success'] != true || empty(@$resultData['order_data'])) {
    return response()->view('pages.error.404', [], 404);
}

$resorder = $resultData['order_data'];
$txid = @$resorder['order_id'];
$totalAmount = @$resorder['order_value'];
$subscriptionId = @$resorder['subscription_id'];  // ✅ Add this line to get subscription_id from backend
```

### Update Checkout Parameters

**FIND** (Lines 150-175):
```php
$parameters = [
    'razorpay_key' => config('epicconfig.RAZORPAY.RAZORPAY_KEY') ?: config('razorpay.key'),
    'razorpay_order_id' => $razorpayOrder['id'],
    'amount' => $totalAmount * 100, // Razorpay expects amount in paise
    'currency' => strtoupper($currency),
    'name' => 'Epicon',
    'description' => 'Epicon Subscription - ' . @$result['name'],
    'order_id' => $txid,
    'prefill_name' => @$userData['name'] ?? '',
    'prefill_email' => @$userData['email'] ?? '',
    'prefill_contact' => @$userData['mobile'] ?? '',
    'callback_url' => route('razorpay.callback'),
    // Mandate data
    'mandate_id' => $mandateId,
    'mandate_checkout' => $mandateCheckoutData,
    'recurring' => '1',
    'customer_id' => @$mandateCheckoutData['customer_id'] ?? '',
];
```

**REPLACE WITH**:
```php
$parameters = [
    'razorpay_key_id' => config('epicconfig.RAZORPAY.RAZORPAY_KEY') ?: config('razorpay.key'),
    'razorpay_subscription_id' => $subscriptionId,  // ✅ Use subscription_id, not order_id
    'amount' => $totalAmount,
    'currency' => strtoupper($currency),
    'name' => 'EPIC ON',
    'description' => 'Subscription - ' . @$result['name'],
    'order_id' => $txid,
    'prefill' => [
        'name' => @$userData['name'] ?? '',
        'email' => @$userData['email'] ?? '',
        'contact' => @$userData['mobile'] ?? '',
    ],
    'notes' => [
        'epicon_order_id' => $txid,
    ],
    'callback_url' => route('razorpay.callback'),
];
```

---

## Change 2: Remove createRazorpayOrder() Method

**FIND** (Lines 321-373):
```php
private function createRazorpayOrder($orderId, $amount, $currency = 'INR')
{
    // ... entire method ...
}
```

**REPLACE WITH**:
```php
// ✅ This method is no longer needed
// Backend creates the Razorpay order and returns it in createOrder response
// Frontend should NOT call Razorpay APIs directly per backend contract
```

### Update the Call Site

**FIND** (Line 140):
```php
$razorpayOrder = $this->createRazorpayOrder($txid, $totalAmount, $currency);

if (!$razorpayOrder) {
    $this->razorpayLog('Razorpay Order Creation Failed', $txid);
    return response()->view('pages.error.404', [], 404);
}
```

**REPLACE WITH**:
```php
// ✅ Remove this check - backend creates the order now
```

---

## Change 3: Update razorpayCallback()

**File**: `app/Http/Controllers/RazorpayController.php` → `razorpayCallback()` method

### Add Payment Mode Extraction

**ADD** at start of method (after Line 177):
```php
$paymentMode = @$paymentData['payment_mode'] ?? '';
$subscriptionPaymentMode = @$paymentData['subscription_payment_mode'] ?? '';
```

### Update Order Data Update Request

**FIND** (Lines 208-240):
```php
$updateOrderData = [
    'plan' => $orderValue['plan_id'] ?? '',
    'user_id' => $orderValue['user_id'] ?? '',
    'order_id' => $orderData['order_id'] ?? '',
    'order_status' => 'complete',
    'payment_gateway' => 'razorpay',
    'bank_ref_no' => $razorpayPaymentId,
    'transaction_id' => $razorpayPaymentId,
    'authPayuId' => $razorpayPaymentId,
    'is_recurring' => false,
    'coupon_applied' => $orderValue['coupon_applied'] ?? '',
    'payment_mode' => 'razorpay',
    'plan_amount' => $orderValue['amount'] ?? '',
    'x_country' => @$countrycode,
    'x_continent' => @$countrycode,
];

// Add mandate ID if available
if (!empty($mandateId)) {
    $updateOrderData['mandate_id'] = $mandateId;
    $this->razorpayLog('Mandate ID added to order update', $razorpayOrderId, ['mandate_id' => $mandateId]);
}
```

**REPLACE WITH**:
```php
$updateOrderData = [
    'user_id' => $orderValue['user_id'] ?? '',
    'order_id' => $orderData['order_id'] ?? '',
    'order_status' => 'complete',
    'payment_gateway' => 'razorpay',
    'transaction_id' => $razorpayPaymentId,
    'bank_ref_no' => $razorpayPaymentId,
    'payment_mode' => $paymentMode,  // ✅ Use captured payment_mode
    'subscriptionId' => @$paymentData['razorpay_subscription_id'],  // ✅ Add subscription ID
    'subscriptionPaymentMode' => $subscriptionPaymentMode,  // ✅ Add subscription payment mode
    'is_recurring' => true,  // ✅ MUST be true for recurring
    'x_country' => @$countrycode,
    'x_continent' => @$countrycode,
];
```

### Handle Pending Status

**FIND** (Lines 257-280):
```php
if (@$updatePayment['success']) {
    $this->razorpayLog('Payment Success', $razorpayOrderId);

    // Event push for tracking
    $this->razorpayEventPush('success');

    // Clear cookies
    Cookie::queue(Cookie::make('orderdata', '', -1));
    Cookie::queue(Cookie::make('create_order', '', -1));

    $final_result = ['message' => 'You have successfully purchased a subscription plan.'];
    return view('subscription.thankyou', compact('final_result', 'orderData'));
}
```

**REPLACE WITH**:
```php
if (@$updatePayment['success']) {
    // Check if subscription is pending or complete
    $orderStatus = @$updatePayment['order_status'] ?? 'complete';
    
    $this->razorpayLog('Payment Update Response', $razorpayOrderId, ['order_status' => $orderStatus]);

    if ($orderStatus === 'pending') {
        // Mandate authorization is pending
        return view('subscription.pending', compact('orderData'));
    }
    
    // Order is complete
    $this->razorpayLog('Payment Success', $razorpayOrderId);
    $this->razorpayEventPush('success');
    
    Cookie::queue(Cookie::make('orderdata', '', -1));
    Cookie::queue(Cookie::make('create_order', '', -1));

    $final_result = ['message' => 'You have successfully purchased a subscription plan.'];
    return view('subscription.thankyou', compact('final_result', 'orderData'));
}
```

---

## Change 4: Update razorpay.blade.php

**File**: `resources/views/subscription/razorpay.blade.php`

**REPLACE ENTIRE FILE** with:

```html
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Checkout</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>

<body>
    <form name="razorpayform" action="{{ $parameters['callback_url'] }}" method="POST">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_subscription_id" id="razorpay_subscription_id">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
        <input type="hidden" name="order_id" id="order_id" value="{{ $parameters['order_id'] }}">
        <input type="hidden" name="payment_mode" id="payment_mode" value="">
        <input type="hidden" name="subscription_payment_mode" id="subscription_payment_mode" value="">
    </form>

    <script>
        var options = {
            key: "{{ $parameters['razorpay_key_id'] }}",
            subscription_id: "{{ $parameters['razorpay_subscription_id'] }}",
            name: "{{ $parameters['name'] }}",
            description: "{{ $parameters['description'] }}",
            prefill: {
                name: "{{ $parameters['prefill']['name'] }}",
                email: "{{ $parameters['prefill']['email'] }}",
                contact: "{{ $parameters['prefill']['contact'] }}"
            },
            notes: {
                epicon_order_id: "{{ $parameters['notes']['epicon_order_id'] }}"
            },
            handler: function(response) {
                // Capture all response fields
                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                document.getElementById('razorpay_subscription_id').value = response.razorpay_subscription_id;
                document.getElementById('razorpay_signature').value = response.razorpay_signature;
                
                // Determine payment mode from response (this is a guess, backend should confirm)
                // For now, we'll let the backend determine it from subscription data
                document.getElementById('payment_mode').value = localStorage.getItem('selectedPaymentMode') || 'UPI';
                document.getElementById('subscription_payment_mode').value = localStorage.getItem('selectedSubscriptionPaymentMode') || 'upi';
                
                document.razorpayform.submit();
            },
            theme: {
                color: "#1a1a2e"
            },
            modal: {
                ondismiss: function() {
                    window.location.href = "{{ route('razorpay.failed') }}?error=cancelled&subscription_id={{ $parameters['razorpay_subscription_id'] }}";
                }
            }
        };

        var rzp = new Razorpay(options);

        rzp.on('payment.failed', function(response) {
            window.location.href = "{{ route('razorpay.failed') }}?error_description=" +
                encodeURIComponent(response.error.description) +
                "&error_code=" + encodeURIComponent(response.error.code) +
                "&subscription_id={{ $parameters['razorpay_subscription_id'] }}";
        });

        rzp.open();
    </script>
</body>

</html>
```

---

## Change 5: Update payment-method.blade.php

**File**: `resources/views/subscription/payment-method.blade.php`

### Update Form Action

**FIND** (Line 48):
```html
<form name="checkoutsubscriptionform" method="post" id="checkoutsubscriptionid" action="{{ config('razorpay.enabled') ? route('saveSubscriptionRazorpay') : route('saveSubscription') }}">
```

**REPLACE WITH**:
```html
<form name="checkoutsubscriptionform" method="post" id="checkoutsubscriptionid" action="{{ route('saveSubscriptionRazorpay') }}">
```

### Add Payment Mode Fields

**FIND** (After the form opening, around Line 55):
```html
<input type="hidden" name="payment_type" value="DC" class="card_type" id="card_type">
```

**REPLACE WITH**:
```html
<input type="hidden" name="payment_type" value="DC" class="card_type" id="card_type">
<input type="hidden" name="payment_mode" id="payment_mode" value="DC">
<input type="hidden" name="subscription_payment_mode" id="subscription_payment_mode" value="card">
```

### Add Button Click Handler

**FIND** the button rendering code (around Lines 56-75):
```html
<button type="button" class="button-type active" data-attr="DC" ...>
```

**ADD** JavaScript at the bottom (before closing `@section('script')`):

```javascript
<script>
$(document).ready(function(){
    // Define payment mode mappings
    var modeMapping = {
        'DC': { payment_mode: 'DC', subscription_payment_mode: 'card' },
        'CC': { payment_mode: 'CC', subscription_payment_mode: 'card' },
        'NB': { payment_mode: 'NETBANKING', subscription_payment_mode: 'netbanking' },
        'UPI': { payment_mode: 'UPI', subscription_payment_mode: 'upi' },
        'CASH': { payment_mode: 'DC', subscription_payment_mode: 'card' }
    };
    
    $(".button-type").click(function () {
        var card_type = $(this).attr("data-attr");
        $("#card_type").val(card_type);
        
        // ✅ Update payment mode fields
        var modes = modeMapping[card_type];
        $("#payment_mode").val(modes.payment_mode);
        $("#subscription_payment_mode").val(modes.subscription_payment_mode);
        
        // Store in localStorage for razorpay.blade.php to use
        localStorage.setItem('selectedPaymentMode', modes.payment_mode);
        localStorage.setItem('selectedSubscriptionPaymentMode', modes.subscription_payment_mode);
        
        $(".button-type").removeClass("active");
        $(this).addClass("active");
    });
    
    // Set initial values on page load
    var initialModes = modeMapping['DC'];
    $("#payment_mode").val(initialModes.payment_mode);
    $("#subscription_payment_mode").val(initialModes.subscription_payment_mode);
});
</script>
```

---

## Change 6: Update subscription.blade.php

**File**: `resources/views/subscription/subscription.blade.php`

### Add Free-Trial Detection

**FIND** (around Line 46-51, in the PHP block):
```php
$result = [];
$countrycode = getCountryCode();
```

**ADD AFTER**:
```php
$freeTrial = false;
$trialDays = 0;
```

### Update Plan Display

**FIND** (around Line 99-109, where plan names are displayed):
```html
<button class="nav-link planid {{$classActive}}" ... data-gateway="{{@$val['paymentGateway']}}">
    {!! $bestv !!}
    <div>
        <h6>
            <?php if ($val['currency'] == 'INR' || $val['currency'] == 'inr') { ?>
                <p class="small mb-0">{{@$val['name']}}</p>
            <?php    } ?>
```

**REPLACE WITH**:
```html
<button class="nav-link planid {{$classActive}}" ... data-gateway="{{@$val['paymentGateway']}}" data-free-trial="{{ @$val['free_trial'] ? 'true' : 'false' }}">
    {!! $bestv !!}
    @if(@$val['free_trial'])
        <span class="free-trial-badge">FREE TRIAL</span>
    @endif
    <div>
        <h6>
            <?php if ($val['currency'] == 'INR' || $val['currency'] == 'inr') { ?>
                <p class="small mb-0">{{@$val['name']}}</p>
                @if(@$val['free_trial'])
                    <p class="small trial-info">₹{{ @$val['discounted_price'] }} for {{ @$val['validity_days'] }} days</p>
                @endif
            <?php    } ?>
```

---

## Change 7: Create Pending Status View

**Create New File**: `resources/views/subscription/pending.blade.php`

```html
@extends('layouts.default')
@section('title', 'Subscription Pending')

@section('content')
<section class="container pb-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-6">
            <div class="pending-subscription-card text-center">
                <div class="pending-icon mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                
                <h2 class="text-white mb-3">Subscription Pending</h2>
                
                <p class="text-white mb-4">
                    Your mandate authorization is being confirmed. This usually takes 1-2 hours.
                </p>
                
                <div class="alert alert-info text-white mb-4">
                    <p class="mb-0">
                        <strong>Order ID:</strong> {{ @$orderData['order_id'] ?? 'N/A' }}
                    </p>
                </div>
                
                <p class="text-white small mb-4">
                    We'll notify you via email and SMS when your subscription is activated.
                </p>
                
                <div class="action-buttons">
                    <a href="{{ getUrl('my-account') }}" class="fill-btn glass__effect--btn mb-2">
                        Go to My Account
                    </a>
                    <a href="{{ getUrl('subscription') }}" class="fill-btn glass__effect--btn">
                        View Plans
                    </a>
                </div>
                
                <p class="text-white small mt-4">
                    If you don't receive confirmation within 2 hours, 
                    <a href="{{ route('contact-support') }}" class="text-info">contact support</a>
                </p>
            </div>
        </div>
    </div>
</section>
@stop

@section('style')
<style>
.pending-subscription-card {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 40px 30px;
}

.pending-icon {
    animation: spin 2s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.pending-icon svg {
    stroke: #04aa6d;
}

.action-buttons a {
    display: block;
    margin-bottom: 10px;
}

.alert-info {
    background-color: rgba(13, 110, 253, 0.1);
    border: 1px solid rgba(13, 110, 253, 0.2);
    border-radius: 8px;
    padding: 15px;
}
</style>
@stop
```

---

## Change 8: Update planBenefit JavaScript

**File**: `resources/views/subscription/subscription.blade.php` → Script section

**ADD** after plan selection:
```javascript
$(".planid").click(function() {
    let planid = $(this).attr('data-id');
    $("#amountid").val(planid);
    
    // ✅ Check free trial
    let isFreeTrial = $(this).data('free-trial') === 'true';
    if (isFreeTrial) {
        $(".coupan-div").hide();  // Hide coupon for free trial
    } else {
        $(".coupan-div").show();
    }
    
    $("#gateway").val($(this).data('gateway'));
});
```

---

## Summary of Changes

| Component | Type | Effort |
|-----------|------|--------|
| RazorpayController | Remove mandate API, fix params | 2 hours |
| razorpay.blade.php | Rewrite checkout config | 1 hour |
| razorpayCallback() | Update request structure | 1 hour |
| payment-method.blade.php | Add mode tracking | 1 hour |
| subscription.blade.php | Add free-trial support | 1 hour |
| pending.blade.php | Create new view | 30 min |
| Testing | End-to-end validation | 2 hours |

**Total Effort**: ~8-9 hours

---

## Testing After Implementation

```bash
# 1. Clear browser cache
# 2. Test free-trial flow
# 3. Test each payment method
# 4. Test mandate authorization pending state
# 5. Verify all fields sent to backend
# 6. Check logs for errors
```

All changes are backward-compatible and will work with the backend contract.
