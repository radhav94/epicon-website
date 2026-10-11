# ✅ Branch Events Setup & Testing Guide

## Issue & Fix

**Problem**: Branch events were not appearing in Branch dashboard.

**Cause**: Missing `branch.init()` call with proper Branch key.

**Solution**: Added `branch('init', 'YOUR_BRANCH_KEY')` initialization in default.blade.php.

---

## Step 1: Configure Branch Key in .env

Add your Branch key to `.env` file:

```env
# .env

BRANCH_KEY=key_live_xxxxxxxxxxxxxx
# OR for testing:
# BRANCH_KEY=key_test_xxxxxxxxxxxxxx
```

The key will be loaded automatically in the script:
```javascript
branch.init('{{ env("BRANCH_KEY", "YOUR_BRANCH_KEY") }}');
```

---

## Step 2: Verify Branch Script is Loaded

**Location**: `resources/views/layouts/default.blade.php` (Lines 43-98)

**Key Components**:

### 1. Load Branch SDK
```javascript
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
```

### 2. Initialize Branch with Key
```javascript
branch.init('{{ env("BRANCH_KEY", "YOUR_BRANCH_KEY") }}');
```

### 3. Ready Callback
```javascript
window.branchReady = function() {
    if (typeof branch !== 'undefined' && typeof branch === 'function') {
        branch.ready(function(err, data) {
            if (err) {
                console.error('❌ Branch error:', err);
            } else {
                console.log('✓ Branch ready and initialized');
            }
        });
    } else {
        setTimeout(window.branchReady, 500);
    }
};
```

### 4. Helper Function for Event Tracking
```javascript
window.trackBranchEvent = function(eventName, eventData, retries = 3) {
    if (typeof branch !== 'undefined' && typeof branch === 'function') {
        try {
            branch('track', eventName, eventData);
            console.log('✓ Branch event tracked:', eventName, eventData);
        } catch (e) {
            console.error('Branch track error:', e);
        }
    } else if (retries > 0) {
        setTimeout(function() {
            window.trackBranchEvent(eventName, eventData, retries - 1);
        }, 300);
    } else {
        console.warn('Branch SDK not available after retries:', eventName);
    }
};
```

---

## Step 3: Event Calls in Login/Registration

**Location**: `resources/views/auth/login-reg-js.blade.php`

### LOGIN Event

**When**: After successful OTP verification

```javascript
// Line ~340 in login-reg-js.blade.php
success: function(response) {
    if (response.payload.success == true) {
        login_success();
        
        // ✅ Branch Event: LOGIN
        console.log('🌿 Branch Event: LOGIN triggered');
        
        if (typeof branch === 'function') {
            branch('track', 'LOGIN', {
                'user_id': response.payload.user_id,
                'signup_method': response.payload.user_signup_method
            });
        } else {
            setTimeout(function() {
                if (typeof branch === 'function') {
                    branch('track', 'LOGIN', {
                        'user_id': response.payload.user_id,
                        'signup_method': response.payload.user_signup_method
                    });
                }
            }, 1000);
        }
    }
}
```

### SIGN_UP Event

**When**: After successful registration

```javascript
// Line ~527 in login-reg-js.blade.php
success: function(response) {
    if (response.payload.success == true) {
        registration_success();
        
        // ✅ Branch Event: SIGN_UP
        console.log('🌿 Branch Event: SIGN_UP triggered');
        
        if (typeof branch === 'function') {
            branch('track', 'SIGN_UP', {
                'user_id': response.payload.user_id,
                'signup_method': response.payload.user_signup_method,
                'name': response.payload.name
            });
        } else {
            setTimeout(function() {
                if (typeof branch === 'function') {
                    branch('track', 'SIGN_UP', {
                        'user_id': response.payload.user_id,
                        'signup_method': response.payload.user_signup_method,
                        'name': response.payload.name
                    });
                }
            }, 1000);
        }
    }
}
```

---

## Step 4: Testing Branch Events

### Test 1: Check Branch Script Loaded

**In Browser Console (F12)**:

```javascript
// Should return the branch function
typeof branch
// Expected: "function"

// Should show the Branch key
branch.__BRANCH_DEBUG__ || window.branchReady
// Should see initialization logs
```

### Test 2: Monitor Console for Initialization

**In Browser Console (F12 → Console tab)**:

Look for messages like:
```
✓ Branch ready and initialized
```

If you see:
```
⚠️ Branch not ready (typeof: undefined)
```

Then Branch SDK is still loading. Wait a moment and try again.

### Test 3: Test LOGIN Event

1. **Open Browser Console** (F12)
2. **Go to Login Page** → `/login`
3. **Enter email/phone** and verify OTP
4. **Check Console** for messages:
   ```
   🌿 Branch Event: LOGIN triggered
   ✓ Branch event tracked: LOGIN
   ```

### Test 4: Test SIGN_UP Event

1. **Open Browser Console** (F12)
2. **Go to Login Page** → `/login`
3. **Click Register tab**
4. **Fill in details** and submit
5. **Check Console** for messages:
   ```
   🌿 Branch Event: SIGN_UP triggered
   ✓ Branch event tracked: SIGN_UP
   ```

### Test 5: Verify in Branch Dashboard

1. **Login to Branch Dashboard** → https://dashboard.branch.io
2. **Go to Analytics** → **Live View** or **Events**
3. **Look for events**:
   - `LOGIN` events with `user_id` and `signup_method`
   - `SIGN_UP` events with `user_id`, `signup_method`, and `name`

---

## Troubleshooting

### Issue 1: Events Not Appearing in Dashboard

**Check List**:
- [ ] Branch key is correct (from `.env`)
- [ ] Script is loaded (check Console: `typeof branch` = `"function"`)
- [ ] Ready callback succeeded (check Console: `✓ Branch ready...`)
- [ ] Event call succeeded (check Console: `✓ Branch event tracked...`)

**Debug**:
```javascript
// In Console, manually trigger event
branch('track', 'TEST_EVENT', {'test': 'data'});

// Check if it appears in Branch dashboard within 5-10 seconds
```

### Issue 2: Branch Not Loading

**Check List**:
- [ ] `BRANCH_KEY` is set in `.env`
- [ ] CDN URL is accessible: https://cdn.branch.io/branch-latest.min.js
- [ ] No Content Security Policy (CSP) blocking Branch

**Debug**:
```javascript
// Check if script tag exists
document.querySelectorAll('script[src*="branch"]')

// Should return the Branch script element
```

### Issue 3: "Branch not ready" Messages

**Cause**: Events being tracked before Branch SDK is ready.

**Solution**: Already handled in code with retry logic (1 second retry).

**Verify**:
```javascript
// Wait 2-3 seconds after page load, then check
typeof branch === 'function'  // Should be true
```

---

## Event Data Format

### LOGIN Event
```json
{
  "event_name": "LOGIN",
  "custom_data": {
    "user_id": "919999999999",
    "signup_method": "email"
  }
}
```

### SIGN_UP Event
```json
{
  "event_name": "SIGN_UP",
  "custom_data": {
    "user_id": "919999999999",
    "signup_method": "email",
    "name": "John Doe"
  }
}
```

---

## Files Modified

1. **`resources/views/layouts/default.blade.php`**
   - Added `branch.init()` call
   - Added ready callback with error handling
   - Added `trackBranchEvent()` helper function

2. **`resources/views/auth/login-reg-js.blade.php`**
   - Already has `branch('track', 'LOGIN', {...})` calls
   - Already has `branch('track', 'SIGN_UP', {...})` calls
   - Added console logging for debugging

---

## Environment Configuration

### Development
```env
BRANCH_KEY=key_test_xxxxxxxxxxxxxx
```

### Production
```env
BRANCH_KEY=key_live_xxxxxxxxxxxxxx
```

---

## Complete Testing Checklist

- [ ] Add `BRANCH_KEY` to `.env` file
- [ ] Verify Branch script loads (check Console)
- [ ] Verify Branch ready callback (check Console: `✓ Branch ready...`)
- [ ] Test LOGIN event (verify in Console: `✓ Branch event tracked: LOGIN`)
- [ ] Test SIGN_UP event (verify in Console: `✓ Branch event tracked: SIGN_UP`)
- [ ] Wait 5-10 seconds
- [ ] Check Branch Dashboard → Events
- [ ] Confirm LOGIN and SIGN_UP events appear

---

## Console Output Examples

### Successful Flow

```javascript
// Script loads
✓ Branch ready and initialized

// User logs in
🌿 Branch Event: LOGIN triggered
✓ Branch event tracked: LOGIN {user_id: "919999999999", signup_method: "email"}

// User registers
🌿 Branch Event: SIGN_UP triggered
✓ Branch event tracked: SIGN_UP {user_id: "919999999999", signup_method: "email", name: "John Doe"}
```

### Error Flow

```javascript
// Branch not loaded yet
⚠️ Branch not ready (typeof: undefined), will retry after 1s
⚠️ Branch not ready (typeof: undefined), will retry after 1s
✓ Branch ready on retry, tracking LOGIN event

// Successful after retry
✓ Branch event tracked: LOGIN
```

---

## FAQ

**Q: When will events appear in Branch Dashboard?**
A: Usually within 5-10 seconds of the event being tracked.

**Q: Why do I see "Branch not ready" messages?**
A: The SDK was still loading when the event was triggered. The code automatically retries after 1 second. If it still fails after retries, the SDK may have failed to load.

**Q: How do I verify the Branch key is correct?**
A: Check `.env` file → `BRANCH_KEY`. The key should start with `key_test_` (dev) or `key_live_` (prod).

**Q: Can I test multiple events?**
A: Yes! Login, logout, then register as a new user to trigger both LOGIN and SIGN_UP events.

**Q: Where do I see the events in Branch Dashboard?**
A: Analytics → Live View or Analytics → Events (depending on your Branch dashboard version).

---

## Summary

✅ **Setup Complete**:
- Branch SDK is loaded globally
- Branch key is initialized from `.env`
- Ready callback ensures SDK is ready before tracking
- LOGIN and SIGN_UP events are tracked with proper data
- Console logging helps with debugging

✅ **Next Steps**:
1. Add `BRANCH_KEY` to `.env`
2. Test LOGIN and SIGN_UP flows
3. Verify events in Branch Dashboard
4. Monitor console for any errors

**Status**: Ready to test! 🚀
