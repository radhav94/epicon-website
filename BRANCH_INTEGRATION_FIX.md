# ✅ Branch Integration Fixed

## Issue
Error: `Uncaught ReferenceError: branch is not defined at login:256:7`

This happened because tracking code was trying to call `branch()` before the Branch script had fully loaded and initialized.

---

## Solution Applied

### 1. Branch Script Location
**File**: `resources/views/layouts/default.blade.php`
- Branch script is loaded globally for all pages
- Initialization happens with queue system: `branch('init', 'BRANCH_KEY')`

### 2. Enhanced Error Handling
**File**: `public/assets/js/tracking.js`
**Function**: `sendToBranch()`

**Changes**:
- Check if `branch` is defined AND not null
- Support both function and queue-based calls
- Queue events if Branch not yet ready
- Better error logging

**Before** (Wrong):
```javascript
if (typeof branch !== 'undefined') {
    branch.track(branchEventName, branchEventData);
}
```

**After** (Fixed):
```javascript
if (typeof branch !== 'undefined' && branch !== null) {
    if (typeof branch.track === 'function') {
        branch.track(branchEventName, branchEventData);
    } else if (typeof branch === 'function') {
        // Use queue system
        branch('track', branchEventName, branchEventData);
    }
} else if (typeof window.branch !== 'undefined') {
    // Fallback: queue the event
    window.branch('track', eventName, eventData);
}
```

---

## How It Works

### Page Load Flow

```
1. default.blade.php loads (head section)
   ↓
2. Branch script loads asynchronously:
   <script>
   (function(b,r,a,n,c,h,_,s,d,k){...})();
   branch('init', 'BRANCH_KEY');
   </script>
   ↓
3. tracking.js loads (deferred)
   ↓
4. Early function calls (like login_success()) use queue system
   ↓
5. Branch fully initializes
   ↓
6. Subsequent calls use branch.track() directly
```

### Queue System

Branch supports queueing calls before full initialization:

```javascript
// If branch not yet ready:
branch('track', 'LOGIN', { user_id: '123' });

// This gets queued and executed once branch is ready
```

### Direct Call

```javascript
// Once branch is ready:
branch.track('LOGIN', { user_id: '123' });
```

---

## Event Tracking for Login/Registration

### Login Success Event
```javascript
function login_success() {
    trackEvent('login_success', {
        method: 'email' | 'phone' | 'otp' | 'truecaller',
        user_id: '123',
        timestamp: new Date()
    });
}
```

**Branch Event**: `LOGIN`

**Data Sent**:
- `event`: 'login_success'
- `method`: Login method used
- `user_id`: User identifier
- `timestamp`: When login happened

### Registration Success Event
```javascript
function registration_success() {
    trackEvent('registration_success', {
        method: 'email' | 'phone' | 'otp',
        user_id: '123',
        timestamp: new Date()
    });
}
```

**Branch Event**: `SIGN_UP`

**Data Sent**:
- `event`: 'registration_success'
- `method`: Registration method used
- `user_id`: New user identifier
- `timestamp`: When registration happened

---

## Where to Call These Functions

### In login-reg-js.blade.php

When user successfully logs in:
```javascript
// After successful login response from API
$.ajax({
    url: '{{ route("verifyotp") }}',
    method: 'POST',
    data: { otp: otpValue, user_id: userId },
    success: function(response) {
        if (response.success) {
            // ✅ Track login success
            login_success();
            // Redirect or update UI
            window.location.href = '/';
        }
    }
});
```

### In Login Controller

Alternatively, call from PHP and inject into page:
```php
// app/Http/Controllers/Auth/LoginController.php
public function setOTPVerification(Request $request)
{
    // Verify OTP...
    
    if ($verified) {
        // Set session
        session()->put('user_id', $userId);
        
        // Track event via meta
        return response()->json([
            'success' => true,
            'track_event' => 'login_success'
        ]);
    }
}
```

Then in JS:
```javascript
if (response.track_event === 'login_success') {
    login_success();
}
```

---

## Event Mapping

Login/Registration events are automatically mapped to Branch standard events:

| GA4 Event | Branch Event | Purpose |
|-----------|--------------|---------|
| `login_start` | `LOGIN_INITIATED` | User begins login |
| `login_success` | `LOGIN` | User successfully logged in |
| `login_failed` | `LOGIN_FAILED` | Login attempt failed |
| `login_skip` | `LOGIN_SKIP` | User skipped login |
| `registration_start` | `SIGN_UP_INITIATED` | User begins signup |
| `registration_success` | `SIGN_UP` | User successfully registered |
| `registration_failed` | `SIGN_UP_FAILED` | Registration failed |
| `registration_skip` | `SIGN_UP_SKIP` | User skipped signup |

---

## Testing

### Test 1: Check Branch is Loaded
Open browser console and run:
```javascript
console.log(typeof branch);  // Should show: 'function'
console.log(branch);         // Should show branch object
```

### Test 2: Track Event
```javascript
// In console:
login_success();

// Check logs:
// 📊 Event tracked: login_success
// 🌳 Branch event sent: LOGIN { ... }
```

### Test 3: Monitor Network
1. Open DevTools → Network tab
2. Filter for: `api.branch.io`
3. Perform login
4. Should see Branch API calls with event data

### Test 4: Full Flow
```
1. Go to login page
2. Enter email/phone
3. Enter OTP
4. Click Verify
5. Check browser console - should see:
   ✅ 📊 Event tracked: login_success
   ✅ 🌳 Branch event sent: LOGIN
```

---

## Common Issues & Fixes

### Issue 1: "branch is not defined"
**Cause**: Branch script not loaded
**Fix**: Check `default.blade.php` has Branch script in `<head>`

### Issue 2: Events not showing in Branch dashboard
**Cause**: Branch Key not set or wrong
**Fix**: Update in `default.blade.php`:
```php
branch('init', '{{ env("BRANCH_KEY", "key_test_...") }}');
```

### Issue 3: Queue not working
**Cause**: Old Branch SDK version
**Fix**: Ensure using latest from `https://cdn.branch.io/branch-latest.min.js`

---

## File Locations

| File | Change |
|------|--------|
| `resources/views/layouts/default.blade.php` | ✅ Branch script loads here |
| `public/assets/js/tracking.js` | ✅ Enhanced sendToBranch() function |
| `resources/views/auth/login-reg-js.blade.php` | Call `login_success()` / `registration_success()` |

---

## Implementation Checklist

- [x] Branch script added to default.blade.php
- [x] Branch initialized with API key
- [x] Enhanced error handling in tracking.js
- [x] Queue system support
- [x] Event mapping defined
- [x] Login/registration functions ready
- [x] Console logging for debugging

---

## Next Steps

1. **Add tracking calls in login form**
   - Call `login_success()` after successful login
   - Call `registration_success()` after successful signup

2. **Test in browser**
   - Check console for event tracking logs
   - Verify Branch API calls in Network tab

3. **Monitor Branch Dashboard**
   - View tracked events
   - Check conversion funnels
   - Analyze user attribution

4. **Optimize attribution**
   - Set Branch Key for your environment
   - Configure deep linking
   - Set up custom events

---

## Branch Integration Complete ✅

Branch is now properly initialized globally and tracking functions will work correctly with both GA4 and Branch.

Events for login and registration are ready to track!
