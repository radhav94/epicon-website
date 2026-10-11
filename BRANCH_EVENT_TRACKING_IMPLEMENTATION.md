# Branch Event Tracking Implementation Guide

## Overview

A global `trackBranchEvent()` function is already initialized in `default.blade.php` for tracking all custom events across the application.

---

## Global Function Setup

**File**: `resources/views/layouts/default.blade.php`
**Status**: ✅ Already configured

### Function Definition

```javascript
// Global function for Branch custom events
window.trackBranchEvent = function(eventName, eventData) {
    console.log("📤 Calling Branch event:", eventName, eventData);
    
    branch.logEvent(
        eventName,
        eventData || {},
        function(err) {
            if (err) {
                console.error("❌ Branch event failed:", eventName, err);
            } else {
                console.log("✅ Branch event sent:", eventName);
            }
        }
    );
};
```

### How It Works

1. Accepts `eventName` (string) and `eventData` (object)
2. Logs to console for debugging
3. Sends to Branch with error handling
4. Automatically reports success/failure

---

## Usage Examples

### Example 1: Login Event

**File**: `resources/views/auth/login-reg-js.blade.php`

```javascript
// After successful login
trackBranchEvent("user_login", {
    user_id: "{{ isUserLoggedIn() ? getUserId() : 'anonymous' }}",
    login_method: "otp",
    timestamp: new Date().toISOString(),
    source: "web"
});
```

### Example 2: Registration Event

**File**: `resources/views/auth/login-reg-js.blade.php`

```javascript
// After successful registration
trackBranchEvent("user_signup", {
    user_id: "{{ isUserLoggedIn() ? getUserId() : 'anonymous' }}",
    signup_method: "email_otp",
    timestamp: new Date().toISOString(),
    source: "web",
    country: "{{ getCountryCode() }}"
});
```

### Example 3: Subscription Purchase Event

**File**: `resources/views/subscription/razorpay.blade.php`

```javascript
// After payment completion
trackBranchEvent("purchase", {
    user_id: "{{ isUserLoggedIn() ? getUserId() : 'anonymous' }}",
    order_id: "TEST_ORDER_123",
    plan_id: "epic_in_pl_1",
    amount: 199,
    currency: "INR",
    payment_method: "razorpay",
    subscription_type: "monthly",
    timestamp: new Date().toISOString()
});
```

---

## Standard Event Data Structure

```javascript
{
    user_id: "unique_user_id or 'anonymous'",
    timestamp: new Date().toISOString(),
    source: "web",
    // ... event-specific fields ...
}
```

---

## Implementation in Login/Registration

### Add to login-reg-js.blade.php

After successful login:
```javascript
trackBranchEvent("user_login", {
    user_id: response.user_id,
    login_method: "otp",
    timestamp: new Date().toISOString(),
    source: "web"
});
```

After successful registration:
```javascript
trackBranchEvent("user_signup", {
    user_id: response.user_id,
    signup_method: "email_otp",
    timestamp: new Date().toISOString(),
    source: "web",
    country: "{{ getCountryCode() }}"
});
```

---

## Testing

### Test in Browser Console

```javascript
trackBranchEvent("test_event", {
    user_id: "test_user_123",
    timestamp: new Date().toISOString()
});
```

Expected output:
```
📤 Calling Branch event: test_event
✅ Branch event sent: test_event
```

---

## Status

✅ **Already Set Up**:
- Branch SDK loaded in default.blade.php
- trackBranchEvent() function available globally
- Ready to use

✅ **Next Steps**:
1. Add trackBranchEvent() calls to login success handler
2. Add trackBranchEvent() calls to registration success handler
3. Add trackBranchEvent() calls to payment success handler
4. Test in browser and verify in Branch Dashboard

