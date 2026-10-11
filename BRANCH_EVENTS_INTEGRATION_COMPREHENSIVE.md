# Branch Events - Complete Integration Guide

## Summary

Branch event tracking is configured to track:
✅ User login (OTP, password, social methods)
✅ User registration
✅ Subscription plan selection
✅ Payment method selection
✅ Payment success/failure
✅ Subscription activation

## Quick Implementation

### 1. Add to login-reg-js.blade.php (OTP Login Success - Line ~350)
```javascript
success: function(response) {
    if (response.payload.success == true) {
        login_success();
        // Track login
        if (typeof trackLoginEvent === 'function') {
            trackLoginEvent('otp', {
                user_id: response.payload.user_id,
                signup_method: response.payload.user_signup_method
            });
        }
```

### 2. Add to login-reg-js.blade.php (Password Login Success - Line ~550)
```javascript
success: function(response) {
    if (response.payload.success == true) {
        login_success();
        // Track login
        if (typeof trackLoginEvent === 'function') {
            trackLoginEvent('password', {
                user_id: response.payload.user_id
            });
        }
```

### 3. Add to login-reg-js.blade.php (Registration Success - Line ~450)
```javascript
success: function(response) {
    if (response.payload.success == true) {
        registration_success();
        // Track registration
        if (typeof trackRegistrationEvent === 'function') {
            trackRegistrationEvent(
                $('#mobilenumber').val() || '',
                $('#user_id').val() || '',
                'otp'
            );
        }
```

### 4. Add to payment-method.blade.php (Payment Method Selection)
```javascript
$(".button-type").click(function () {
    var card_type = $(this).attr("data-attr");
    // Track payment method
    if (typeof trackPaymentMethodSelected === 'function') {
        trackPaymentMethodSelected(card_type, 'razorpay');
    }
```

### 5. Add to razorpay.blade.php (Before Checkout Opens)
```javascript
var razorpay = new Razorpay(options);
// Track checkout
if (typeof trackRazorpayCheckoutOpened === 'function') {
    trackRazorpayCheckoutOpened(
        '{{ $parameters['order_id'] }}',
        {{ $parameters['amount'] * 100 }},
        'INR'
    );
}
razorpay.open();
```

### 6. Add to razorpay.blade.php (In Payment Success Handler)
```javascript
handler: function (response) {
    // Track payment success
    if (typeof trackPaymentSuccess === 'function') {
        trackPaymentSuccess(
            document.getElementById('order_id').value,
            response.razorpay_payment_id,
            {{ $parameters['amount'] }},
            'INR'
        );
    }
    document.razorpayform.submit();
}
```

## All Available Functions

```
✅ trackLoginEvent(method, data)
✅ trackRegistrationEvent(email, phone, method)
✅ trackLoginFailed(reason)
✅ trackRegistrationFailed(reason)
✅ trackPlanSelected(planId, planName, price)
✅ trackPaymentMethodSelected(method, gateway)
✅ trackPaymentSuccess(orderId, paymentId, amount)
✅ trackPaymentFailed(orderId, reason)
✅ trackSubscriptionActivated(subscriptionId, planId)
✅ trackCouponApplied(couponCode, discount)
✅ trackRazorpayCheckoutOpened(orderId, amount)
✅ trackOrderCreated(orderId, planId, value)
✅ trackSubscriptionRenewal(subscriptionId, planId)
```

## Status
- Branch Script: ✅ In default.blade.php
- Tracking Functions: ✅ In branch-tracking.js
- Implementation: ⏳ Pending (use examples above)

## Getting Branch Key
1. Go to https://dashboard.branch.io
2. Login
3. Settings → App Settings
4. Copy Branch Key
5. Replace "YOUR_BRANCH_KEY" in default.blade.php
