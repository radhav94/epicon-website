# Branch Events Quick Reference

## Setup

Add Branch script to `resources/views/layouts/default.blade.php`:

```html
<head>
    <!-- Branch Script -->
    <script>
    (function(b,r,a,n,c,h,_){
        if(!b[n]){
            b[n]=function(){b[n].q.push(arguments)};
            b[n].q=[];
        }
        h=r.createElement('script');
        h.async=1;
        h.src=a;
        _=r.getElementsByTagName('script')[0];
        _.parentNode.insertBefore(h,_);
    })(window,document,'https://cdn.branch.io/branch-latest.min.js','branch');

    branch('init', 'YOUR_BRANCH_KEY');
    </script>

    <!-- Branch Tracking Helper -->
    <script src="{{ asset('assets/js/branch-tracking.js') }}"></script>
</head>
```

---

## Quick Examples

### Login Success

```javascript
trackLoginEvent('otp', {
    user_id: "{{ isUserLoggedIn() ? getUserId() : 'anonymous' }}",
    email: userEmail,
    phone: userPhone
});
```

### Registration Success

```javascript
trackRegistrationEvent(
    'user@example.com',
    '919999999999',
    'otp',
    { country: "{{ getCountryCode() }}" }
);
```

### Select Subscription Plan

```javascript
trackPlanSelected(
    'epic_in_pl_1',
    'Premium',
    199,
    'INR'
);
```

### Select Payment Method

```javascript
trackPaymentMethodSelected(
    'UPI',
    'razorpay'
);
```

### Payment Success

```javascript
trackPaymentSuccess(
    '12345',
    'pay_xxx',
    199,
    'INR',
    { subscription_id: 'sub_xxx' }
);
```

### Payment Failed

```javascript
trackPaymentFailed(
    '12345',
    'user_cancelled'
);
```

### Subscription Activated

```javascript
trackSubscriptionActivated(
    'sub_xxx',
    'epic_in_pl_1',
    'Premium',
    30,
    { is_free_trial: false }
);
```

### Apply Coupon

```javascript
trackCouponApplied(
    'SAVE50',
    50,
    149
);
```

---

## Helper Functions Available

| Function | Usage |
|----------|-------|
| `trackBranchEvent(name, data)` | Generic event tracking |
| `trackLoginEvent(method, data)` | Login events |
| `trackRegistrationEvent(email, phone, method, data)` | Registration events |
| `trackPlanSelected(id, name, price, currency, data)` | Plan selection |
| `trackPaymentMethodSelected(method, gateway, data)` | Payment method selection |
| `trackPaymentSuccess(orderId, paymentId, amount, currency, data)` | Successful payment |
| `trackPaymentFailed(orderId, reason, data)` | Failed payment |
| `trackSubscriptionActivated(subId, planId, name, days, data)` | Subscription activation |
| `trackCouponApplied(code, discount, finalPrice, data)` | Coupon application |
| `trackViewSubscriptionPlans(total, hasFreeTrialEligibility, data)` | View plans |
| `trackRazorpayCheckoutOpened(orderId, amount, currency, data)` | Razorpay opened |
| `trackLoginFailed(reason, data)` | Failed login |
| `trackRegistrationFailed(reason, data)` | Failed registration |
| `trackOrderCreated(orderId, planId, amount, currency, data)` | Order creation |
| `trackSubscriptionRenewal(subId, planId, amount, currency, data)` | Subscription renewal |

---

## Complete Flow Example

```javascript
// 1. View subscription page
trackViewSubscriptionPlans(3, true, { 
    user_id: userId 
});

// 2. Select plan
trackPlanSelected('epic_in_pl_1', 'Premium', 199, 'INR', {
    user_id: userId
});

// 3. Go to payment method selection
// (Navigate to payment-method.blade.php)

// 4. Select payment method
trackPaymentMethodSelected('UPI', 'razorpay', {
    user_id: userId
});

// 5. Payment successful
trackPaymentSuccess('12345', 'pay_abc123', 199, 'INR', {
    user_id: userId,
    subscription_id: 'sub_xyz789'
});

// 6. Subscription activated
trackSubscriptionActivated('sub_xyz789', 'epic_in_pl_1', 'Premium', 30, {
    user_id: userId,
    is_free_trial: false
});
```

---

## Integration Locations

### Login Page
**File**: `resources/views/auth/login-reg-js.blade.php`
- `trackLoginEvent()` on successful verification
- `trackLoginFailed()` on error

### Registration Page  
**File**: `resources/views/auth/login-reg-js.blade.php`
- `trackRegistrationEvent()` on successful signup
- `trackRegistrationFailed()` on error

### Subscription Page
**File**: `resources/views/subscription/subscription.blade.php`
- `trackViewSubscriptionPlans()` on page load
- `trackPlanSelected()` when clicking "Buy Now"
- `trackCouponApplied()` when applying coupon

### Payment Method Selection
**File**: `resources/views/subscription/payment-method.blade.php`
- `trackPaymentMethodSelected()` when clicking payment method

### Razorpay Checkout
**File**: `resources/views/subscription/razorpay.blade.php`
- `trackRazorpayCheckoutOpened()` when modal opens
- `trackPaymentSuccess()` in handler on success
- `trackPaymentFailed()` on dismissal/cancellation

---

## Testing

### Console Output
```javascript
// You should see in browser console:
🌿 Branch Event: user_login Object {
    user_id: "919999999999",
    login_method: "otp",
    timestamp: "2026-08-20T10:30:00.000Z",
    ...
}
```

### Check Branch Dashboard
1. Go to Branch Dashboard
2. Events → Live View
3. Select time range
4. You should see your events in real-time

### GA4 Integration
Events are automatically sent to GA4 if gtag is available.

---

## Key Points

✅ **Always Include**:
- user_id (for logged-in users)
- timestamp
- relevant context (plan_id, payment_id, etc.)

✅ **Event Names**:
- Use snake_case
- Be descriptive
- Use prefixes (user_, payment_, subscription_)

✅ **Data Privacy**:
- Don't send passwords or sensitive data
- Don't use PII in event names
- Use user_id only (no email/phone in event name)

---

## Files

- **Setup**: `resources/views/layouts/default.blade.php`
- **Helper**: `public/assets/js/branch-tracking.js`
- **Implementation**: `BRANCH_EVENTS_IMPLEMENTATION.md`
- **This file**: `BRANCH_EVENTS_QUICK_REFERENCE.md`

---

## Next Steps

1. ✅ Add Branch script to default.blade.php
2. ✅ Include branch-tracking.js in your templates
3. ✅ Add trackBranchEvent() calls to key pages
4. ✅ Test in development
5. ✅ Monitor in Branch Dashboard
6. ✅ Deploy to production

Done! 🎉
