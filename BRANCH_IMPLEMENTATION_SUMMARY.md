# ✅ Branch Event Tracking - Implementation Summary

## Quick Overview

Branch is now fully integrated to track login and registration events on your web platform.

---

## What Was Done

### ✅ 1. Branch SDK in default.blade.php
- **Status**: ✅ Already present and initialized
- **Location**: `/resources/views/layouts/default.blade.php`
- **Key**: `key_test_pBvRu3MlTPs4MBzX7a3ZPbdeAFh8rA1m`
- **Function**: `window.trackBranchEvent(eventName, eventData)`

### ✅ 2. Tracking Functions in login-reg-js.blade.php
- **Status**: ✅ Added at end of file
- **Functions**:
  - `trackBranchLogin(userId, method)` - Track logins
  - `trackBranchRegistration(userId, name)` - Track registrations

---

## How It Works

### When User Logs In via OTP
```
1. User enters phone/email + OTP
2. Clicks "Verify OTP"
3. Backend verifies → Success ✅
4. login_success() called
5. trackBranchLogin(userId, 'otp_mobile') called
6. 🔵 Branch tracks the event
7. Data appears in Branch Dashboard
```

### When User Registers
```
1. User fills name, password, gender
2. Clicks "Create Account"
3. Backend creates account → Success ✅
4. registration_success() called
5. trackBranchRegistration(userId, name) called
6. 🔵 Branch tracks the event
7. Data appears in Branch Dashboard
```

---

## Testing Instructions

### Step 1: Open Browser Console
```
1. Go to website
2. Press F12 (Open DevTools)
3. Go to "Console" tab
```

### Step 2: Look for Branch Initialization
```
Expected to see:
✅ "Branch initialized successfully"
✅ "Branch session data: {...}"
```

### Step 3: Login/Register
```
1. Click Login button
2. Enter phone/email + OTP
3. Click Verify
```

### Step 4: Check Console for Events
```
Expected to see:
🔵 "Tracking Branch Login: 919999999999, otp_mobile"
📤 "Branch event called: login"
✅ "Branch event sent: login"
```

### Step 5: Verify in Branch Dashboard
```
1. Go to: https://dashboard.branch.io
2. Login with Branch account
3. Go to: Liveview → Events
4. Should see "login" event with user_id and method
```

---

## Events Being Tracked

### login Event
Sent when user successfully logs in

**Data Tracked**:
- `user_id` - User phone or email
- `method` - How they logged in:
  - `otp_mobile` - OTP via mobile
  - `otp_email` - OTP via email
  - `password` - Password login
- `timestamp` - When it happened
- `platform` - "web"

**Example**:
```javascript
{
  "event": "login",
  "user_id": "919999999999",
  "method": "otp_mobile",
  "timestamp": "2026-08-20T10:30:45.123Z",
  "platform": "web"
}
```

### register Event
Sent when user successfully registers

**Data Tracked**:
- `user_id` - New user phone or email
- `name` - User's name
- `timestamp` - When it happened
- `platform` - "web"

**Example**:
```javascript
{
  "event": "register",
  "user_id": "919999999999",
  "name": "John Doe",
  "timestamp": "2026-08-20T10:30:45.123Z",
  "platform": "web"
}
```

---

## Files Modified

| File | What Changed | Status |
|------|--------------|--------|
| `default.blade.php` | Branch SDK + init already there | ✅ Verified |
| `login-reg-js.blade.php` | Added tracking functions | ✅ Done |

---

## Why Events Might Not Show

### 1. Branch SDK Not Loading
**Check**: In console, type `typeof window.branch`
- If "undefined" = SDK didn't load
- Solution: Wait 2-3 seconds and refresh

### 2. Branch Key Wrong
**Check**: In `default.blade.php` line ~75
- Key should be: `key_test_pBvRu3MlTPs4MBzX7a3ZPbdeAFh8rA1m`
- If different, update it

### 3. Event Function Not Called
**Check**: In login-reg-js.blade.php
- Look for `trackBranchLogin()` call after `login_success()`
- Look for `trackBranchRegistration()` call after `registration_success()`

### 4. Network Blocked
**Check**: In DevTools → Network tab
- Login and look for requests to `api.branch.io`
- If not there, check if ad-blocker is enabled
- Solution: Disable ad-blocker

---

## Quick Debug Commands

Run these in browser console:

```javascript
// Check if Branch is loaded
typeof window.branch !== 'undefined'  // Should return: true

// Check if tracking function exists
typeof window.trackBranchEvent        // Should return: "function"

// Manually test tracking
window.trackBranchEvent('test_login', {
  user_id: 'test_user',
  method: 'test'
});
// Should see: ✅ "Branch event sent: test_login"
```

---

## For Production

When moving to production:

1. **Get Live Key** from Branch Dashboard
2. **Update in default.blade.php** (Line ~75):
   ```javascript
   branch.init('key_live_YOUR_ACTUAL_KEY', function(err, data) { ... });
   ```
3. **Test** Login/Register again
4. **Verify** Events show in Production dashboard

---

## Support

If events aren't showing:

1. ✅ Check Branch SDK is initialized (console check above)
2. ✅ Check event functions are present (login-reg-js.blade.php)
3. ✅ Check Branch Key is correct (default.blade.php)
4. ✅ Check network requests (DevTools → Network tab)
5. ✅ Check Branch Dashboard (Liveview → Events)

---

## Summary

✅ **Branch fully integrated**
✅ **Login events tracked automatically**
✅ **Registration events tracked automatically**
✅ **Console logging enabled for debugging**
✅ **Ready for testing**

**Next**: Test it by logging in and watching the events in your Branch Dashboard!
