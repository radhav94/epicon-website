# Branch Events Implementation Guide

## Overview

Implement comprehensive Branch event tracking throughout the application using the global `window.trackBranchEvent()` function available in `default.blade.php`.

## Global Function Usage

```javascript
window.trackBranchEvent(eventName, eventData);
```

**Example**:
```javascript
window.trackBranchEvent("registration_success", {
    user_id: "user123",
    name: "John Doe",
    timestamp: new Date().toISOString(),
    source: "epicon_web"
});
```

---

## Authentication Events to Track

### 1. Registration Success
**Location**: `login-reg-js.blade.php` - `.register-btn` success callback
```javascript
window.trackBranchEvent("registration_success", {
    user_id: response.payload.user_id || "",
    name: name,
    timestamp: new Date().toISOString(),
    source: "epicon_web"
});
```

### 2. Registration Failed
**Location**: `login-reg-js.blade.php` - `.register-btn` error callback
```javascript
window.trackBranchEvent("registration_failed", {
    error_message: response.payload.response.message || "Registration failed",
    timestamp: new Date().toISOString(),
    source: "epicon_web"
});
```

### 3. OTP Sent
**Location**: `login-reg-js.blade.php` - `.login-get-otp` success callback
```javascript
window.trackBranchEvent("otp_sent", {
    user_id: response.payload.user_id,
    method: response.payload.user_signup_method || "MOBILE",
    timestamp: new Date().toISOString(),
    source: "epicon_web"
});
```

### 4. OTP Verified
**Location**: `login-reg-js.blade.php` - `.verify-btn` success callback
```javascript
window.trackBranchEvent("otp_verified", {
    user_id: response.payload.user_id,
    method: signup_method,
    is_verified: response.payload.response.is_verified,
    timestamp: new Date().toISOString(),
    source: "epicon_web"
});
```

### 5. Login with Password Success
**Location**: `login-reg-js.blade.php` - `.continue-login-btn` success callback
```javascript
window.trackBranchEvent("login_with_pwd_success", {
    user_id: response.payload.user_id || "",
    subscription_status: response.payload.subplan_status || "none",
    timestamp: new Date().toISOString(),
    source: "epicon_web"
});
```

### 6. Login Failed
**Location**: `login-reg-js.blade.php` - `.continue-login-btn` error callback
```javascript
window.trackBranchEvent("login_failed", {
    error_message: response.payload.response.message,
    timestamp: new Date().toISOString(),
    source: "epicon_web"
});
```

### 7. Password Reset Success
**Location**: `login-reg-js.blade.php` - `.reset-pwd-btn` success callback
```javascript
window.trackBranchEvent("password_reset_success", {
    user_id: user_id,
    timestamp: new Date().toISOString(),
    source: "epicon_web"
});
```

---

## Subscription/Payment Events to Track

### 8. Payment Method Selected
**Location**: `payment-method.blade.php`
```javascript
window.trackBranchEvent("payment_method_selected", {
    payment_method: "DC", // "DC", "CC", "UPI", "NB", etc.
    gateway: "razorpay",
    timestamp: new Date().toISOString(),
    source: "epicon_web"
});
```

### 9. Payment Success
**Location**: After successful payment
```javascript
window.trackBranchEvent("payment_success", {
    transaction_id: transactionId,
    order_id: orderId,
    amount: amount,
    currency: "INR",
    gateway: "razorpay",
    timestamp: new Date().toISOString(),
    source: "epicon_web"
});
```

### 10. Payment Failed
**Location**: On payment failure
```javascript
window.trackBranchEvent("payment_failed", {
    order_id: orderId,
    error_message: errorMessage,
    gateway: "razorpay",
    timestamp: new Date().toISOString(),
    source: "epicon_web"
});
```

---

## Implementation Notes

- Function is globally available as: `window.trackBranchEvent()`
- All events are logged to browser console for debugging
- Always include `timestamp` and `source` fields
- Use snake_case for event names
- Events sent asynchronously (no UI impact)
