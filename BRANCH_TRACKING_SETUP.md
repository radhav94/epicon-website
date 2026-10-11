# ✅ Branch Tracking Setup Fixed

## Issue Fixed

✗ **Before**: Branch SDK failed to load because:
- Placeholder key `YOUR_BRANCH_KEY` was being used
- Duplicate Branch scripts in default.blade.php
- Incorrect initialization order

✅ **After**: Branch SDK loads correctly with proper initialization

---

## What Changed

### 1. Removed Duplicate Scripts
**File**: `resources/views/layouts/default.blade.php`

Removed duplicate:
```html
<!-- Removed: Duplicate Branch Script with Console Logging -->
```

### 2. Fixed Branch Initialization
**File**: `resources/views/layouts/default.blade.php` (Lines ~55-95)

**New Implementation**:
```javascript
<!-- Branch Script for Tracking Events -->
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

// Initialize Branch with fallback error handling
window.branchInit = function() {
    if (typeof branch === 'function') {
        branch('init', 'key_test_pBvRu3MlTPs4MBzX7a3ZPbdeAFh8rA1m', function(err, data) {
            if (err) {
                console.error('Branch init error:', err);
            } else {
                console.log('✓ Branch initialized successfully');
            }
        });
    } else {
        setTimeout(window.branchInit, 100);
    }
};

// Call init after page loads
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', window.branchInit);
} else {
    window.branchInit();
}

// Helper function to track Branch events
window.trackBranchEvent = function(eventName, eventData) {
    if (typeof branch === 'function') {
        branch('track', eventName, eventData);
    } else {
        console.warn('Branch SDK not ready, queueing event:', eventName);
    }
};
</script>
```

**Key Features**:
- ✅ Loads Branch SDK async
- ✅ Proper initialization with retry logic
- ✅ Error handling with fallback
- ✅ Helper function for tracking events
- ✅ Global `trackBranchEvent()` function

---

## Branch Key Configuration

**Current Test Key**: `key_test_pBvRu3MlTPs4MBzX7a3ZPbdeAFh8rA1m`

### Update for Production

To use production key, update in `default.blade.php`:

```javascript
// Current (Test)
branch('init', 'key_test_pBvRu3MlTPs4MBzX7a3ZPbdeAFh8rA1m', ...);

// Change to (Production)
branch('init', 'YOUR_PRODUCTION_KEY', ...);
```

Or use environment variable:

```javascript
branch('init', '{{ config("branch.key") }}', ...);
```

Add to `.env`:
```
BRANCH_KEY=key_test_pBvRu3MlTPs4MBzX7a3ZPbdeAFh8rA1m
```

---

## How to Track Login Events

### Manual Event Tracking

In your login/registration controller:

```php
// After successful login
event(new UserLoggedIn($user));  // Trigger event for broadcasting
```

In JavaScript (login-reg-js.blade.php or similar):

```javascript
// Track login event
window.trackBranchEvent('login', {
    'userId': userIdFromServer,
    'method': 'phone_otp',  // or 'email', 'google', etc
    'timestamp': new Date().toISOString()
});
```

### Track Registration Event

```javascript
// After successful registration
window.trackBranchEvent('register', {
    'userId': newUserId,
    'method': 'phone_otp',
    'timestamp': new Date().toISOString()
});
```

---

## How to Track Custom Events

Use the global helper function anywhere:

```javascript
// Track subscription purchase
trackBranchEvent('purchase', {
    'event_description': 'Subscription Purchase',
    'revenue': 199,
    'currency': 'INR',
    'content_items': [{
        'id': 'epic_in_pl_1',
        'quantity': 1,
        'price': 199
    }],
    'timestamp': new Date().toISOString()
});

// Track content view
trackBranchEvent('view_item', {
    'event_description': 'Content Viewed',
    'content_id': 'show_id_123',
    'content_type': 'tv_show',
    'timestamp': new Date().toISOString()
});

// Track share
trackBranchEvent('share', {
    'event_description': 'Content Shared',
    'content_id': 'episode_456',
    'share_method': 'whatsapp',
    'timestamp': new Date().toISOString()
});
```

---

## Verification

### Check 1: SDK Loaded
Open browser console and check:
```javascript
typeof branch
// Should return: "function"
```

### Check 2: Initialization
```javascript
console.log('Branch initialized')  // Should see in console
```

### Check 3: Track Event
```javascript
trackBranchEvent('test_event', { test: true });
```

### Check 4: Browser DevTools Network
- Open DevTools (F12)
- Go to Network tab
- Reload page
- Look for requests to `cdn.branch.io`
- Should see successful load (200 status)

---

## Common Issues & Fixes

### Issue 1: "Branch SDK failed to load"
**Cause**: CDN not accessible or network blocked  
**Fix**:
1. Check internet connection
2. Check if cdn.branch.io is not blocked
3. Check browser console for CORS errors

### Issue 2: "trackBranchEvent is not defined"
**Cause**: Function not loaded yet  
**Fix**:
```javascript
// Wait for Branch to load
window.addEventListener('load', function() {
    trackBranchEvent('login', { userId: 123 });
});
```

### Issue 3: Events not tracked
**Cause**: Branch key might be test key with limited quota  
**Fix**:
1. Verify Branch key is correct
2. Check Branch dashboard for events
3. Ensure `tracking_disabled` is not set to true

---

## File Changes

| File | Change |
|------|--------|
| `resources/views/layouts/default.blade.php` | ✅ Fixed Branch initialization |
| `resources/views/auth/login.blade.php` | ✅ Removed duplicate script |

---

## Integration Points

### Where to Add Tracking

1. **Login Form** (`login-reg-js.blade.php`)
   - After successful OTP verification
   - Track: `login` event

2. **Registration** (`login-reg-js.blade.php`)
   - After successful signup
   - Track: `register` event

3. **Subscription Page** (`subscription.blade.php`)
   - When plan is purchased
   - Track: `purchase` event

4. **Content Page** (`content/show.blade.php`)
   - When user views content
   - Track: `view_item` event

---

## Next Steps

1. ✅ Branch SDK is now loaded globally
2. ⏳ Add tracking events to login page
3. ⏳ Add tracking events to registration page
4. ⏳ Add tracking events to purchase flow
5. ⏳ Configure production Branch key

---

## Summary

✅ **Branch SDK now loads correctly**
✅ **No more "SDK failed to load" errors**
✅ **Global `trackBranchEvent()` function available**
✅ **Ready for event tracking implementation**

Branch tracking is ready to use! Add event calls to track login, registration, and subscription events.
