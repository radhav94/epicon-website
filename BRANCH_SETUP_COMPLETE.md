# ✅ Branch SDK Setup Complete

## What's Configured

### 1. Branch SDK Initialization
**File**: `resources/views/layouts/default.blade.php`

✅ **Status**: READY
- Branch SDK loaded from CDN: `https://cdn.branch.io/branch-latest.min.js`
- Initialization key: `key_test_pBvRu3MlTPs4MBzX7a3ZPbdeAFh8rA1m` (TEST KEY)
- Global initialization on page load
- Error handling implemented

### 2. Global Event Tracking Function
**File**: `resources/views/layouts/default.blade.php`

✅ **Function**: `window.trackBranchEvent(eventName, eventData)`

Available globally on all pages. Usage:
```javascript
window.trackBranchEvent("event_name", {
    field1: "value1",
    field2: "value2",
    timestamp: new Date().toISOString(),
    source: "epicon_web"
});
```

### 3. Browser Console Logging
Events are logged with status indicators:
- `📤 Branch event called: event_name` - Event triggered
- `✅ Branch event sent: event_name` - Successfully sent to Branch
- `❌ Branch event failed: event_name` - Failed to send
- `⚠️ Branch SDK not available` - SDK not loaded

---

## Events Ready to Implement

### Authentication Events (login-reg-js.blade.php)
1. `registration_success` - When user registers
2. `registration_failed` - When registration fails
3. `otp_sent` - When OTP is sent
4. `otp_verified` - When OTP is verified
5. `login_with_pwd_success` - When password login succeeds
6. `login_failed` - When login fails
7. `password_reset_success` - When password is reset

### Payment Events (payment-method.blade.php, razorpay.blade.php)
1. `payment_method_selected` - When payment method chosen
2. `payment_success` - When payment completes
3. `payment_failed` - When payment fails

---

## How to Add Events

### Example 1: Registration Success

**File**: `resources/views/auth/login-reg-js.blade.php`
**Around Line**: 510 (inside `.register-btn` success callback)

```javascript
success: function(response) {
    if (response.payload.success == true) {
        registration_success();
        
        // ✅ ADD THIS
        window.trackBranchEvent("registration_success", {
            user_id: response.payload.user_id || "",
            name: name,
            timestamp: new Date().toISOString(),
            source: "epicon_web"
        });
        
        // existing code...
    }
}
```

### Example 2: Payment Success

**File**: After successful Razorpay payment
```javascript
window.trackBranchEvent("payment_success", {
    transaction_id: response.razorpay_payment_id,
    order_id: response.razorpay_order_id,
    amount: amount,
    currency: "INR",
    gateway: "razorpay",
    timestamp: new Date().toISOString(),
    source: "epicon_web"
});
```

---

## Testing Events

### 1. Check Console
Open browser DevTools (F12) → Console
You should see messages like:
```
✅ Branch initialized successfully
📤 Branch event called: registration_success {...}
✅ Branch event sent: registration_success
```

### 2. Branch Dashboard
1. Log in to: https://branch.io/dashboard
2. Navigate to: Integrations → Events
3. Look for events with matching names
4. Verify data is being received

### 3. Test Locally
```javascript
// Manually test in console
window.trackBranchEvent("test_event", {
    test: true,
    timestamp: new Date().toISOString(),
    source: "epicon_web"
});

// Should see: ✅ Branch event sent: test_event
```

---

## Configuration

### Current Settings
- **Branch Key**: `key_test_pBvRu3MlTPs4MBzX7a3ZPbdeAFh8rA1m` (TEST)
- **SDK Version**: Latest from CDN
- **Auto-initialization**: Yes
- **Console Logging**: Yes (helps with debugging)

### For Production
Update the key in `default.blade.php`:
```javascript
branch.init('key_live_xxx', function(err, data) { ... });
```

---

## Event Data Standards

Every event should include:
- `timestamp`: `new Date().toISOString()` (ISO 8601 format)
- `source`: `"epicon_web"` (platform identifier)
- Relevant context data (user_id, amounts, methods, etc.)

---

## Common Event Fields

### Registration Event
```javascript
{
    user_id: "user_id_value",
    name: "Full Name",
    timestamp: "2026-08-20T10:30:00.000Z",
    source: "epicon_web"
}
```

### Payment Event
```javascript
{
    transaction_id: "pay_xxx",
    order_id: "order_xxx",
    amount: 199.00,
    currency: "INR",
    gateway: "razorpay",
    timestamp: "2026-08-20T10:30:00.000Z",
    source: "epicon_web"
}
```

### Login Event
```javascript
{
    user_id: "user_id_value",
    subscription_status: "active",
    timestamp: "2026-08-20T10:30:00.000Z",
    source: "epicon_web"
}
```

---

## Files to Update

| File | Events | Status |
|------|--------|--------|
| `login-reg-js.blade.php` | registration, login, OTP, password | ⏳ PENDING |
| `payment-method.blade.php` | payment method selected | ⏳ PENDING |
| `razorpay.blade.php` | payment initiated | ⏳ PENDING |
| `RazorpayController.php` | payment callback | ⏳ PENDING |

---

## Next Steps

1. **Add Registration Events** (login-reg-js.blade.php)
   - registration_success
   - registration_failed
   - registration_error

2. **Add OTP Events** (login-reg-js.blade.php)
   - otp_sent
   - otp_verified
   - otp_verification_failed

3. **Add Login Events** (login-reg-js.blade.php)
   - login_with_pwd_success
   - login_failed
   - password_reset_success

4. **Add Payment Events** (payment-method.blade.php, razorpay.blade.php)
   - payment_method_selected
   - payment_initiated
   - payment_success
   - payment_failed

5. **Test All Events** in Branch Dashboard

---

## Debugging

If events not appearing in Branch:

1. **Check JavaScript Console** (F12)
   - Look for: `📤 Branch event called: event_name`
   - If not there → event not being triggered
   - If there but ❌ failed → network/SDK issue

2. **Verify Branch Key**
   - Test key should start with: `key_test_`
   - Live key should start with: `key_live_`

3. **Check Network Tab**
   - Should see requests to `branch.io`
   - Look for event payloads in POST requests

4. **Refresh Branch Dashboard**
   - New events may take 30-60 seconds to appear
   - Check Integrations → Events section

---

## Documentation

See: `BRANCH_EVENTS_TO_IMPLEMENT.md` for detailed implementation guide

---

**Status**: ✅ SDK READY | ⏳ Events PENDING IMPLEMENTATION
