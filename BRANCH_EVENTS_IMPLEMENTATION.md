# Branch Events Implementation Guide

## Overview

Branch events are called using the `trackBranchEvent()` helper function, similar to GA4 events. This document provides examples for all key user flows: Login, Registration, Subscription Purchase, etc.

---

## Helper Function

First, ensure you have this helper function in your JavaScript or create it in `ga_tag.js`:

```javascript
/**
 * Track Branch events
 * @param {string} eventName - Name of the event
 * @param {object} eventData - Event data object
 */
function trackBranchEvent(eventName, eventData = {}) {
    if (typeof branch !== 'undefined' && branch) {
        try {
            // Log to console for debugging
            console.log('🌿 Branch Event:', eventName, eventData);
            
            // Call Branch event tracking
            branch.track(eventName, eventData);
            
            // Also send to GA4 if available
            if (typeof gtag !== 'undefined') {
                gtag('event', eventName, eventData);
            }
        } catch (error) {
            console.error('Branch tracking error:', error);
        }
    } else {
        console.warn('Branch SDK not loaded');
    }
}
```

---

## Event Examples

### 1. Login Event

**Location**: `resources/views/auth/login-reg-js.blade.php`

```javascript
// On successful OTP verification / Login
trackBranchEvent('user_login', {
    user_id: "{{ isUserLoggedIn() ? getUserId() : 'anonymous' }}",
    login_method: 'otp',  // or 'password', 'truecaller', 'google', 'facebook'
    timestamp: new Date().toISOString(),
    country: "{{ getCountryCode() }}",
    device_type: 'web'
});
```

### 2. Registration Event

**Location**: `resources/views/auth/login-reg-js.blade.php`

```javascript
// On successful registration
trackBranchEvent('user_registration', {
    user_id: "{{ isUserLoggedIn() ? getUserId() : 'anonymous' }}",
    email: userEmail,  // Captured from form
    phone: userPhone,  // Captured from form
    signup_method: 'otp',  // or 'password', 'truecaller', 'social'
    timestamp: new Date().toISOString(),
    country: "{{ getCountryCode() }}",
    device_type: 'web'
});
```

### 3. Plan View Event

**Location**: `resources/views/subscription/subscription.blade.php`

```javascript
// When user views subscription plans
trackBranchEvent('view_subscription_plans', {
    user_id: "{{ isUserLoggedIn() ? getUserId() : 'anonymous' }}",
    total_plans: {{ count($plandata ?? []) }},
    free_trial_available: {{ $hasFreeTrialEligibility ? 'true' : 'false' }},
    timestamp: new Date().toISOString()
});
```

### 4. Plan Select Event

**Location**: `resources/views/subscription/subscription.blade.php`

```javascript
// When user selects a plan to buy
$('.buy-now-btn').click(function() {
    const planId = $(this).data('plan-id');
    const planName = $(this).data('plan-name');
    const planPrice = $(this).data('plan-price');
    
    trackBranchEvent('plan_selected', {
        user_id: "{{ isUserLoggedIn() ? getUserId() : 'anonymous' }}",
        plan_id: planId,
        plan_name: planName,
        plan_price: planPrice,
        currency: "INR",
        timestamp: new Date().toISOString()
    });
});
```

### 5. Payment Method Selection

**Location**: `resources/views/subscription/payment-method.blade.php`

```javascript
// When user selects payment method
$(".button-type").click(function () {
    const card_type = $(this).attr("data-attr");
    
    trackBranchEvent('payment_method_selected', {
        user_id: "{{ isUserLoggedIn() ? getUserId() : 'anonymous' }}",
        payment_method: card_type,  // DC, CC, NB, UPI, CASH
        payment_gateway: 'razorpay',
        timestamp: new Date().toISOString()
    });
});
```

### 6. Order Created Event

**Location**: `app/Http/Controllers/RazorpayController.php` (via AJAX response)

```javascript
// After createOrder API response
trackBranchEvent('order_created', {
    user_id: "{{ getUserId() }}",
    order_id: responseData.order_id,
    plan_id: responseData.plan_id,
    order_value: responseData.order_value,
    currency: "INR",
    timestamp: new Date().toISOString()
});
```

### 7. Razorpay Checkout Opened

**Location**: `resources/views/subscription/razorpay.blade.php`

```javascript
// When Razorpay modal opens
trackBranchEvent('razorpay_checkout_opened', {
    user_id: "{{ isUserLoggedIn() ? getUserId() : 'anonymous' }}",
    order_id: "{{ $parameters['order_id'] }}",
    amount: {{ $parameters['amount'] }},
    currency: "INR",
    timestamp: new Date().toISOString()
});

var razorpay = new Razorpay(options);
razorpay.open();
```

### 8. Payment Success Event

**Location**: `resources/views/subscription/razorpay.blade.php`

```javascript
// In Razorpay handler function
handler: function (response) {
    // Track successful payment
    trackBranchEvent('payment_successful', {
        user_id: "{{ isUserLoggedIn() ? getUserId() : 'anonymous' }}",
        order_id: response.razorpay_order_id,
        payment_id: response.razorpay_payment_id,
        subscription_id: response.razorpay_subscription_id,
        amount: {{ $parameters['amount'] }},
        currency: "INR",
        payment_method: localStorage.getItem('selectedPaymentMode') || 'DC',
        timestamp: new Date().toISOString()
    });
    
    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
    document.getElementById('razorpay_subscription_id').value = response.razorpay_subscription_id;
    document.getElementById('razorpay_signature').value = response.razorpay_signature;
    document.razorpayform.submit();
}
```

### 9. Payment Failed Event

**Location**: `resources/views/subscription/razorpay.blade.php`

```javascript
// In Razorpay error handler
modal: {
    ondismiss: function() {
        // Track payment cancellation
        trackBranchEvent('payment_failed', {
            user_id: "{{ isUserLoggedIn() ? getUserId() : 'anonymous' }}",
            order_id: "{{ $parameters['order_id'] }}",
            reason: 'user_cancelled',
            timestamp: new Date().toISOString()
        });
        
        window.location.href = "{{ route('razorpay.failed') }}";
    }
}
```

### 10. Subscription Activated Event

**Location**: Response callback after payment success

```javascript
// When subscription is activated (from backend response)
trackBranchEvent('subscription_activated', {
    user_id: "{{ getUserId() }}",
    subscription_id: responseData.subscription_id,
    plan_id: responseData.plan_id,
    plan_name: responseData.plan_name,
    subscription_price: responseData.subscription_price,
    validity_days: responseData.validity_days,
    is_free_trial: responseData.is_free_trial,
    timestamp: new Date().toISOString()
});
```

### 11. Subscription Renewal

**Location**: Page load / subscription check

```javascript
// When subscription renews (if applicable)
trackBranchEvent('subscription_renewed', {
    user_id: "{{ isUserLoggedIn() ? getUserId() : 'anonymous' }}",
    subscription_id: subscriptionData.id,
    plan_id: subscriptionData.plan_id,
    renewal_amount: subscriptionData.renewal_price,
    currency: "INR",
    timestamp: new Date().toISOString()
});
```

### 12. Coupon Applied

**Location**: `resources/views/subscription/subscription.blade.php`

```javascript
// When user applies coupon code
$('#apply-coupon-btn').click(function() {
    const couponCode = $('#coupon-input').val();
    
    trackBranchEvent('coupon_applied', {
        user_id: "{{ isUserLoggedIn() ? getUserId() : 'anonymous' }}",
        coupon_code: couponCode,
        discount_amount: discountAmount,
        final_price: finalPrice,
        timestamp: new Date().toISOString()
    });
});
```

---

## Complete Integration Example

### Login Flow

**File**: `resources/views/auth/login-reg-js.blade.php`

```javascript
// After OTP verification success
$(".verifyotp").click(function (e) {
    e.preventDefault();
    
    // ... OTP verification code ...
    
    $.ajax({
        type: 'POST',
        url: ajaxurl,
        data: formData,
        dataType: 'json',
        success: function (res) {
            if(res.success == true) {
                // Track successful login
                trackBranchEvent('user_login', {
                    user_id: res.user_id,
                    login_method: 'otp',
                    email: userEmail,
                    phone: userPhone,
                    timestamp: new Date().toISOString(),
                    country: "{{ getCountryCode() }}"
                });
                
                // Redirect to home
                window.location.href = "{{ route('homepage') }}";
            }
        },
        error: function (e) {
            trackBranchEvent('login_failed', {
                reason: 'verification_error',
                timestamp: new Date().toISOString()
            });
        }
    });
});
```

### Registration Flow

```javascript
// After registration success
$.ajax({
    type: 'POST',
    url: ajaxurl,
    data: formData,
    dataType: 'json',
    success: function (res) {
        if(res.success == true) {
            // Track successful registration
            trackBranchEvent('user_registration', {
                user_id: res.user_id,
                email: email,
                phone: phone,
                signup_method: 'otp',
                timestamp: new Date().toISOString()
            });
            
            // Show success message
            showToaster('Registration successful!', 1);
        }
    }
});
```

### Subscription Purchase Flow

```javascript
// 1. View plans
trackBranchEvent('view_subscription_plans', {
    user_id: "{{ getUserId() }}",
    total_plans: 3,
    timestamp: new Date().toISOString()
});

// 2. Select plan
trackBranchEvent('plan_selected', {
    user_id: "{{ getUserId() }}",
    plan_id: 'epic_in_pl_1',
    plan_name: 'Premium',
    plan_price: 199,
    timestamp: new Date().toISOString()
});

// 3. Select payment method
trackBranchEvent('payment_method_selected', {
    user_id: "{{ getUserId() }}",
    payment_method: 'UPI',
    timestamp: new Date().toISOString()
});

// 4. Payment successful
trackBranchEvent('payment_successful', {
    user_id: "{{ getUserId() }}",
    order_id: 12345,
    payment_id: 'pay_xxx',
    amount: 199,
    timestamp: new Date().toISOString()
});

// 5. Subscription activated
trackBranchEvent('subscription_activated', {
    user_id: "{{ getUserId() }}",
    subscription_id: 'sub_xxx',
    plan_id: 'epic_in_pl_1',
    validity_days: 30,
    timestamp: new Date().toISOString()
});
```

---

## Event Data Standards

### Common Fields (All Events)

```javascript
{
    user_id: "{{ isUserLoggedIn() ? getUserId() : 'anonymous' }}",
    timestamp: new Date().toISOString(),
    country: "{{ getCountryCode() }}",
    device_type: 'web',
    app_version: 'web_v1'
}
```

### Event Names Convention

- Use snake_case: `user_login`, `payment_successful`
- Be descriptive: `razorpay_checkout_opened` not just `checkout`
- Prefix for category: `payment_`, `subscription_`, `user_`, etc.

### Common Event Data

```javascript
// Login/Auth
user_id, login_method, email, phone, signup_method

// Subscription
plan_id, plan_name, plan_price, subscription_id, validity_days, is_free_trial

// Payment
order_id, payment_id, amount, currency, payment_method, payment_gateway

// Error
reason, error_code, error_message
```

---

## Debugging

### Check if Branch is Loaded

```javascript
// In browser console
console.log(typeof branch !== 'undefined' ? 'Branch loaded' : 'Branch not loaded');
```

### Monitor Events in Console

```javascript
// Add console logging to trackBranchEvent
console.log('🌿 Branch Event:', eventName, eventData);
```

### View in Branch Dashboard

1. Go to Branch dashboard
2. Navigate to Events → Live View
3. You should see your events in real-time

---

## Best Practices

✅ **Do**:
- Include user_id for all authenticated users
- Use consistent event names across app and web
- Include timestamp for all events
- Track both success and failure events
- Use GA4 compatible event names

❌ **Don't**:
- Send sensitive data (passwords, API keys)
- Use PII in event names
- Send overly nested objects
- Track every single interaction (be selective)

---

## Testing Checklist

- [ ] Branch SDK loads on page load
- [ ] Events appear in console
- [ ] Events appear in Branch dashboard
- [ ] GA4 events sync properly
- [ ] User IDs match across systems
- [ ] Timestamps are correct
- [ ] Payment events include all required fields
- [ ] Test on multiple devices/browsers

---

## Summary

Branch events are called using `trackBranchEvent()` helper with:
- Event name (snake_case)
- Event data object (includes user_id, timestamp, etc.)
- Same structure as GA4 events

Track key user flows: login, registration, plan selection, payment, subscription activation.

Use for attribution, analytics, and user journey understanding.
