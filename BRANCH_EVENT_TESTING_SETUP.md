# ✅ Branch Event Testing Setup

## What Was Added

Added Branch event testing code to `resources/views/layouts/default.blade.php` to verify events are being tracked correctly.

---

## Code Added

### Location
**File**: `resources/views/layouts/default.blade.php`
**Section**: After Branch initialization (Line ~90)

### Test Function
```javascript
// Test Branch Event Logging
window.testBranchEvent = function() {
    branch('logEvent', 'test_event', {  
        user_id: "{{ isUserLoggedIn() ? getUserId() : 'anonymous' }}",  
        order_id: "TEST_ORDER_123",
        timestamp: new Date().toISOString()
    }, function(err) {  
        if (err) {  
            console.error("✗ Branch event error:", err);  
        } else {  
            console.log("✓ Branch event sent successfully");  
        }  
    });
};
```

### Auto-Test on Load (Local Development Only)
```javascript
// Auto-test Branch events on page load (development/testing)
if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
    window.addEventListener('load', function() {
        console.log('🔔 Testing Branch event tracking...');
        window.testBranchEvent();
    });
}
```

---

## How It Works

### Automatic Testing (Development)
- **Trigger**: Page loads on localhost/127.0.0.1
- **Event**: Sends `test_event` to Branch
- **Data**: Includes user_id (or 'anonymous'), order_id, timestamp
- **Logging**: Console shows success/error message

### Manual Testing
Call from browser console anytime:
```javascript
window.testBranchEvent();
```

---

## Checking If Events Hit

### Method 1: Browser Console
1. Open browser DevTools (F12)
2. Go to Console tab
3. On page load, you should see:
   ```
   ✓ Branch event sent successfully
   ```
   OR
   ```
   ✗ Branch event error: <error_details>
   ```

### Method 2: Manual Test in Console
```javascript
// Type this in console:
window.testBranchEvent();

// Then check console for:
// "✓ Branch event sent successfully"
```

### Method 3: Branch Dashboard
1. Go to [Branch Dashboard](https://dashboard.branch.io)
2. Login with Branch account
3. View **Live View** → **Events** tab
4. Filter by `test_event`
5. Should see events coming in real-time

---

## Event Data

Each test event includes:

| Field | Value | Notes |
|-------|-------|-------|
| event_name | `test_event` | Event type identifier |
| user_id | Current user ID or 'anonymous' | ✅ Identifies the user |
| order_id | `TEST_ORDER_123` | Sample order identifier |
| timestamp | Current ISO timestamp | When event was fired |

---

## Expected Console Output

### Success
```
🔔 Testing Branch event tracking...
✓ Branch event sent successfully
```

### Error (if Branch SDK not loaded)
```
Branch init error: [error details]
```

### Error (if event fails)
```
✗ Branch event error: [error details]
```

---

## Testing Scenarios

### Scenario 1: First Time Visitor (Not Logged In)
```
Console shows:
✓ Branch event sent successfully
Event data: user_id = "anonymous"
```

### Scenario 2: Logged In User
```
Console shows:
✓ Branch event sent successfully
Event data: user_id = "919999999999" (actual user ID)
```

### Scenario 3: Production Environment
```
Auto-test is DISABLED on production
(Runs only on localhost/127.0.0.1)
Manual testing still works via console
```

---

## Enabling/Disabling Auto-Test

### Auto-Test Only on Localhost
**Current**: ✅ Enabled on localhost/127.0.0.1 only

### To Disable Auto-Test Everywhere
Remove this code from default.blade.php:
```javascript
if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
    window.addEventListener('load', function() {
        console.log('🔔 Testing Branch event tracking...');
        window.testBranchEvent();
    });
}
```

### To Enable on All Environments
Change to:
```javascript
// Auto-test on all environments
window.addEventListener('load', function() {
    console.log('🔔 Testing Branch event tracking...');
    window.testBranchEvent();
});
```

---

## Production Considerations

✅ **Auto-test is DISABLED on production** (only runs on localhost)  
✅ Manual testing still available via console  
✅ No performance impact  
✅ Real events not affected  

---

## Real Event Tracking

Once testing is confirmed working, track real events:

```javascript
// Track login event
window.trackBranchEvent('login', {
    user_id: "919999999999",
    login_method: "otp"
});

// Track registration event
window.trackBranchEvent('register', {
    user_id: "919999999999",
    signup_method: "email"
});

// Track purchase event
window.trackBranchEvent('purchase', {
    user_id: "919999999999",
    order_id: "ABC123",
    amount: 199,
    currency: "INR"
});
```

---

## Troubleshooting

### "✗ Branch event error" in Console

**Check**:
1. Is Branch SDK loaded?
   ```javascript
   typeof branch // should be 'function'
   ```

2. Is Branch initialized?
   ```javascript
   branch('readFirstReferrerData', function(data) { console.log(data); });
   ```

3. Check network tab for Branch CDN requests
   - Should see: `https://cdn.branch.io/branch-latest.min.js`

### Branch Script Not Loading

**Check**:
1. No CSP (Content Security Policy) blocking cdn.branch.io
2. Network not blocked
3. Ad blocker not blocking Branch

### Events Not Appearing in Branch Dashboard

**Check**:
1. Correct Branch Key used (in code: `key_test_pBvRu3MlTPs4MBzX7a3ZPbdeAFh8rA1m`)
2. Wait 30-60 seconds for data to sync
3. Filters not hiding events (check Live View filters)

---

## Files Modified

| File | Change |
|------|--------|
| `resources/views/layouts/default.blade.php` | Added test event function + auto-test on localhost |

---

## Summary

✅ Branch event test function added  
✅ Auto-test enabled on development (localhost)  
✅ Manual testing available via console  
✅ Console logging for success/failure  
✅ Production-safe (disabled on prod)  

**Status**: Ready to test! Check browser console for ✓ or ✗ messages.
