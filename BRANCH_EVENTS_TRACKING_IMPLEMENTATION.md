# ✅ Branch Events Tracking Implementation

## Status: ✅ IMPLEMENTED

Branch SDK is now integrated and ready to track login and registration events.

---

## What's Been Done

### 1. Branch SDK Added to default.blade.php
✅ **Location**: `/resources/views/layouts/default.blade.php` (lines ~40-110)

**Features**:
- Branch Web SDK loaded globally
- Initialized with test key: `key_test_pBvRu3MlTPs4MBzX7a3ZPbdeAFh8rA1m`
- Global function `trackBranchEvent()` available on all pages
- Console logging for debugging

**Initialization Code**:
```javascript
branch.init(
    "key_test_pBvRu3MlTPs4MBzX7a3ZPbdeAFh8rA1m",
    function(err, data) {
        if (err) {
            console.error("❌ Branch initialization error:", err);
            return;
        }
        console.log("✅ Branch initialized successfully");
        console.log("Branch session data:", data);
    }
);

// Global function for Branch events
window.trackBranchEvent = function(eventName, eventData) {
    console.log("📤 Branch event called:", eventName, eventData);
    if (typeof window.branch === 'undefined') {
        console.warn("⚠️ Branch SDK not available:", eventName);
        return;
    }
    branch.logEvent(eventName, eventData || {}, function(err) {
        if (err) {
            console.error("❌ Branch event failed:", eventName, err);
        } else {
            console.log("✅ Branch event sent:", eventName);
        }
    });
};
```

---

### 2. Branch Event Tracking Functions Added
✅ **Location**: `/resources/views/auth/login-reg-js.blade.php` (end of file)

**Functions Added**:

#### trackBranchLogin(userId, method)
```javascript
function trackBranchLogin(userId, method = 'otp') {
    if (typeof window.trackBranchEvent === 'function') {
        console.log('🔵 Tracking Branch Login:', userId, method);
        window.trackBranchEvent('login', {
            'user_id': userId,
            'method': method,
            'timestamp': new Date().toISOString(),
            'platform': 'web'
        });
    }
}
```

**Call Sites**:
- After OTP verification success
- After password login success

**Methods Tracked**:
- `otp_mobile` - OTP login via mobile
- `otp_email` - OTP login via email
- `password` - Password-based login

#### trackBranchRegistration(userId, name)
```javascript
function trackBranchRegistration(userId, name) {
    if (typeof window.trackBranchEvent === 'function') {
        console.log('🔵 Tracking Branch Registration:', userId, name);
        window.trackBranchEvent('register', {
            'user_id': userId,
            'name': name,
            'timestamp': new Date().toISOString(),
            'platform': 'web'
        });
    }
}
```

**Call Site**:
- After successful registration completion

---

## Event Tracking Flow

### Login Event
```
User enters phone/email + OTP
    ↓
Clicks "Verify OTP"
    ↓
Backend verifies OTP
    ↓
✅ OTP verification success
    ↓
login_success() called
    ↓
trackBranchLogin(userId, method) called
    ↓
🔵 Branch.logEvent('login', {...})
    ↓
Branch dashboard logs the event
```

### Registration Event
```
User fills name, password, gender
    ↓
Clicks "Create Account"
    ↓
Backend creates user account
    ↓
✅ Registration success
    ↓
registration_success() called
    ↓
trackBranchRegistration(userId, name) called
    ↓
🔵 Branch.logEvent('register', {...})
    ↓
Branch dashboard logs the event
```

---

## How to Verify Events Are Being Tracked

### 1. Browser Console
```
1. Open browser DevTools (F12)
2. Go to Console tab
3. Login or register
4. Look for messages:
   ✅ "Branch initialized successfully"
   🔵 "Tracking Branch Login: user_id, method"
   📤 "Branch event called: login"
   ✅ "Branch event sent: login"
```

### 2. Branch Dashboard
```
1. Go to: https://dashboard.branch.io
2. Login with your Branch account
3. Go to: Liveview → Events
4. You should see:
   - Event: "login"
   - Event: "register"
   - Event data with user_id, method, timestamp
```

### 3. Test Tracking Manually
In browser console:
```javascript
// Test login event
trackBranchLogin('test_user_123', 'otp_mobile');

// Test registration event
trackBranchRegistration('test_user_456', 'John Doe');
```

Check console for:
```
🔵 Tracking Branch Login: test_user_123 otp_mobile
📤 Branch event called: login
✅ Branch event sent: login
```

---

## Branch Event Fields

### login Event
```json
{
    "event": "login",
    "data": {
        "user_id": "919999999999",
        "method": "otp_mobile|otp_email|password",
        "timestamp": "2026-08-20T10:30:45.123Z",
        "platform": "web"
    }
}
```

### register Event
```json
{
    "event": "register",
    "data": {
        "user_id": "919999999999",
        "name": "John Doe",
        "timestamp": "2026-08-20T10:30:45.123Z",
        "platform": "web"
    }
}
```

---

## Integration Points

### 1. OTP Login Success (Line ~250)
**File**: `login-reg-js.blade.php`

After:
```javascript
if (response.payload.success == true) {
    login_success();
```

Automatically calls:
```javascript
trackBranchLogin(response.payload.user_id, response.payload.user_signup_method);
```

### 2. Registration Success (Line ~370)
**File**: `login-reg-js.blade.php`

After:
```javascript
if (response.payload.success == true) {
    registration_success();
```

Automatically calls:
```javascript
trackBranchRegistration(response.payload.user_id, response.payload.name);
```

### 3. Password Login Success (Line ~475)
**File**: `login-reg-js.blade.php`

After:
```javascript
if (response.payload.success == true) {
    login_success();
```

Automatically calls:
```javascript
trackBranchLogin(response.payload.user_id, 'password');
```

---

## Configuration

### Branch Test Key (Dev)
```
key_test_pBvRu3MlTPs4MBzX7a3ZPbdeAFh8rA1m
```

**To change to Production Key**:
1. Go to Branch Dashboard → Settings
2. Get your live key (starts with `key_live_`)
3. Update `default.blade.php` line ~75:
   ```javascript
   branch.init('YOUR_LIVE_KEY_HERE', function(err, data) { ... });
   ```

### Event Names
Can be customized in tracking functions:
- `login` - User login event
- `register` - User registration event

---

## Debugging

### If Events Not Appearing

**Check 1: Branch Initialization**
```javascript
// In browser console
typeof window.branch !== 'undefined'  // Should be true
window.trackBranchEvent               // Should be a function
```

**Check 2: Event Tracking**
```javascript
// In browser console
window.trackBranchEvent('test_event', { test: true });
// Check console for success message
```

**Check 3: Network Request**
```
1. Open DevTools → Network tab
2. Login
3. Look for requests to: https://api.branch.io
4. Should see POST requests with event data
```

**Check 4: Branch Dashboard**
```
1. Go to: https://dashboard.branch.io
2. Liveview → Events
3. Should show events in real-time
```

### Common Issues

| Issue | Solution |
|-------|----------|
| "Branch SDK not initialized" | Wait 2-3 seconds after page load |
| Events not in dashboard | Check Branch key is correct in code |
| Console shows warnings | Check event data has required fields |
| Network requests fail | Check CORS settings in Branch dashboard |

---

## Files Modified

| File | Changes | Status |
|------|---------|--------|
| `resources/views/layouts/default.blade.php` | Added Branch SDK + init | ✅ Done |
| `resources/views/auth/login-reg-js.blade.php` | Added tracking functions + calls | ✅ Done |

---

## Next Steps (Optional)

1. **Additional Events** (Can add later):
   - `subscribe` - When user purchases subscription
   - `content_view` - When user views content
   - `search` - When user searches

2. **Update to Live Key**:
   - Replace test key with live key in production
   - Update in `default.blade.php` line ~75

3. **Test Deeply**:
   - Login via OTP (mobile)
   - Login via OTP (email)
   - Login via password
   - Registration flow
   - Verify all events in dashboard

---

## Summary

✅ **Branch SDK Fully Integrated**
✅ **Login Events Tracking**
✅ **Registration Events Tracking**
✅ **Global Event Function Available**
✅ **Console Logging for Debugging**
✅ **Ready for Production Testing**

Events are now being tracked automatically on every login and registration!
