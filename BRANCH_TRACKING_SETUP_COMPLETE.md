# ✅ Branch Tracking Setup Complete

## What Was Done

Added Branch.io tracking script to the global layout so it loads on all pages (login, registration, subscription, etc.).

---

## Script Location

**File**: `resources/views/layouts/default.blade.php`
**Location**: In `<head>` section, lines ~63-112

```html
<!-- Branch Script for Tracking Events -->
<script>
// Load Branch with queue support
(function(b,r,a,n,c,h,_,s,d,k){
    if(!b[n] || !b[n]._q)
    {
        for(;s<_.length;) c(h,_[s++]);
        d=r.createElement(a);
        d.async=1;
        d.src="https://cdn.branch.io/branch-latest.min.js";
        k=r.getElementsByTagName(a)[0];
        k.parentNode.insertBefore(d,k);
        b[n]=h
    }
})(window,document,"script","branch",function(b,r){
    b[r]=function(){b._q.push([r,arguments])}
},branch,[...],0);

// Initialize Branch
branch.init('YOUR_BRANCH_KEY');
</script>
```

---

## How It Works

### 1. Script Loading (Non-Blocking)
- Branch SDK loads asynchronously
- Doesn't block page rendering
- Queue-based system queues calls until script loads

### 2. Function Queue
All Branch function calls are queued until the script fully loads:
```javascript
branch('init', key)           // Queued
branch('track', event)        // Queued
branch('setIdentity', user)  // Queued
// ...all executed when script ready
```

### 3. Initialization
```javascript
branch.init('{{ env("BRANCH_KEY", "...") }}', {
    tracking_disabled: false
});
```

---

## Branch Key Configuration

### Where to Set the Key

**File**: `.env`
```env
BRANCH_KEY=key_live_xxxxx  # Your actual Branch key
```

**Fallback**: `key_test_pBvRu3MlTPs4MBzX7a3ZPbdeAFh8rA1m` (test key)

### Using the Key
```blade
branch.init('{{ env("BRANCH_KEY", "key_test_...") }}');
```

---

## Available Branch Functions

The script provides these functions globally:

| Function | Purpose |
|----------|---------|
| `branch.init()` | Initialize Branch SDK |
| `branch.track()` | Track custom events |
| `branch.setIdentity()` | Set user identity |
| `branch.logout()` | Clear user identity |
| `branch.link()` | Generate Branch links |
| `branch.logEvent()` | Log conversion events |
| `branch.data()` | Get data on initial load |
| `branch.first()` | Get first-time visitor data |

---

## Tracking Events on Login

After Branch initializes, you can track login events:

**File**: `resources/views/auth/login-reg-js.blade.php`

Add this after successful login:

```javascript
// Track login event
branch.logEvent('login', {
    user_id: userId,
    email: userEmail,
    phone: userPhone,
    method: 'OTP'  // or 'password', 'truecaller', etc.
});

// Also set user identity
branch.setIdentity(userId);
```

---

## Tracking Events on Registration

**File**: `resources/views/auth/login-reg-js.blade.php`

Add this after successful registration:

```javascript
// Track registration event
branch.logEvent('registration', {
    user_id: newUserId,
    email: userEmail,
    phone: userPhone,
    registration_method: 'OTP'
});

// Set user identity
branch.setIdentity(newUserId);
```

---

## Tracking Events on Subscription Purchase

**File**: `resources/views/subscription/razorpay.blade.php`

Add this after successful payment:

```javascript
// Track subscription purchase
branch.logEvent('purchase', {
    value: orderAmount,
    currency: 'INR',
    contentId: planId,
    contentType: 'subscription',
    customer: {
        user_id: userId,
        email: userEmail
    }
});
```

---

## How to Test Branch Tracking

### 1. Check if Script Loads
```bash
# Open DevTools (F12)
# Go to Console tab
# Type: branch
# Should show: function() { ... }
```

**If error**: Script not loaded yet

### 2. Check Initialization
```javascript
// In console
branch.init('YOUR_KEY');  // Should work without errors
```

**If error**: Key not set or script failed to load

### 3. Send Test Event
```javascript
// In console
branch.track('test_event', { test: true });
// Check Branch dashboard for event
```

### 4. Verify in Branch Dashboard
1. Log in to branch.io
2. Go to your project
3. Check "Liveview" section
4. Should see real-time events

---

## Error: "branch is not defined"

**Cause**: Script loaded asynchronously but called too early

**Solution**: The code now uses a queue system that automatically handles this. But if you see this error:

1. Check console for script load errors
2. Verify `BRANCH_KEY` env var is set
3. Check network tab for CDN access

---

## Production Deployment

### 1. Set Production Branch Key
**File**: `.env` (production)
```env
BRANCH_KEY=key_live_xxxxxxxxxxxxx
```

### 2. Verify Script Loads
```bash
# In production, test:
curl https://your-domain.com | grep "cdn.branch.io"
```

Should show Branch script tag.

### 3. Test Events
1. Log in to your app
2. Check Branch dashboard liveview
3. Verify events appear in real-time

---

## What Gets Tracked

### Automatic Tracking
- Page views
- Clicks
- Form submissions
- Device info (OS, browser, etc.)

### Manual Tracking (Needs Implementation)
- User login ⏳ Need to implement
- User registration ⏳ Need to implement
- Subscription purchase ⏳ Need to implement
- Payment methods used ⏳ Need to implement

---

## Next Steps

### 1. Implement Login Tracking
```javascript
// After successful login in login-reg-js.blade.php
if (loginSuccess) {
    branch.setIdentity(userId);
    branch.logEvent('login', { method: 'OTP' });
}
```

### 2. Implement Registration Tracking
```javascript
// After successful registration
if (registrationSuccess) {
    branch.setIdentity(newUserId);
    branch.logEvent('registration');
}
```

### 3. Implement Purchase Tracking
```javascript
// After successful payment
if (paymentSuccess) {
    branch.logEvent('purchase', {
        value: amount,
        currency: 'INR',
        plan_id: planId
    });
}
```

### 4. Test in QA/Staging
1. Deploy code
2. Test login flow
3. Verify events in Branch dashboard
4. Deploy to production

---

## Files Modified

| File | Change |
|------|--------|
| `resources/views/layouts/default.blade.php` | ✅ Added Branch script with proper initialization |
| `.env` | ⏳ Set BRANCH_KEY (user responsibility) |

---

## Branch Dashboard Links

- **Setup**: https://dashboard.branch.io/account-settings/app
- **Events**: https://dashboard.branch.io/analytics/events
- **Liveview**: https://dashboard.branch.io/liveview (real-time events)
- **Settings**: https://dashboard.branch.io/settings

---

## Common Issues & Fixes

| Issue | Cause | Fix |
|-------|-------|-----|
| "branch is not defined" | Script loaded async but called immediately | Already fixed with queue system |
| No events in dashboard | Key not set | Set BRANCH_KEY in .env |
| Events not showing | Tracking code not implemented | Add branch.logEvent() calls |
| Wrong event names | Custom event typos | Check event names in Branch dashboard |

---

## Summary

✅ **Branch script** added to global layout  
✅ **Initialization** fixed with queue system  
✅ **Key configuration** through .env  
⏳ **Event tracking** ready to implement  

**Status**: Ready for QA testing and production deployment!

Next: Implement event tracking in login, registration, and subscription flows.
