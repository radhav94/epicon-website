# Clarity & Branch Events - Domain-Based Loading

## Overview

Both **Microsoft Clarity** and **Branch SDK** are now configured to load only on production domains:
- `www.epicon.in`
- `epicon.in`

On other domains (staging, local development, testing), these scripts are skipped to prevent unnecessary tracking and API calls.

---

## Changes Made

### 1. Branch Web SDK (default.blade.php)

**Before:**
- Branch SDK always loaded on all domains

**After:**
- Domain check added before SDK initialization
- Only loads on `www.epicon.in` or `epicon.in`
- On other domains, provides fallback `trackBranchEvent()` function to prevent JavaScript errors

```javascript
// Only load on production domains
var host = window.location.hostname;
var isProductionDomain = host === 'www.epicon.in' || host === 'epicon.in';

if (!isProductionDomain) {
    console.log("⚠️ Branch SDK skipped - not on production domain");
    window.trackBranchEvent = function() {};  // Fallback function
    return;
}

// SDK initialization code...
```

### 2. Microsoft Clarity Script (default.blade.php)

**Before:**
- Clarity always loaded on all domains

**After:**
- Domain check added before loading
- Only loads on `www.epicon.in` or `epicon.in`
- Skipped with warning message on other domains

```javascript
// Only load on production domains
var host = window.location.hostname;
var isProductionDomain = host === 'www.epicon.in' || host === 'epicon.in';

if (!isProductionDomain) {
    console.log("⚠️ Clarity script skipped - not on production domain");
    return;
}

// Clarity initialization code...
```

---

## Browser Console Output

### On Production Domains (www.epicon.in / epicon.in)

```
✅ Branch initialized successfully
Branch session data: {...}
📤 Branch event called: user_login {...}
✅ Branch event sent: user_login
```

### On Staging/Development Domains

```
⚠️ Branch SDK skipped - not on production domain
⚠️ Clarity script skipped - not on production domain
```

---

## What This Means

| Environment | Domain | Branch | Clarity | Events Tracked |
|-------------|--------|--------|---------|-----------------|
| Production | www.epicon.in | ✅ Yes | ✅ Yes | ✅ All events tracked |
| Production | epicon.in | ✅ Yes | ✅ Yes | ✅ All events tracked |
| Staging | contentapistg... | ❌ No | ❌ No | ❌ No tracking |
| Local Dev | localhost:8000 | ❌ No | ❌ No | ❌ No tracking |
| Testing | any other | ❌ No | ❌ No | ❌ No tracking |

---

## Branch Event Functions Still Available

Even on non-production domains, the following functions will work without errors:

```javascript
// These functions exist everywhere but only send data on production
trackLoginEvent('otp')
trackSignUp('otp')
trackViewItem([...])
trackPaymentSuccess(orderId, paymentId, amount)
trackSubscriptionActivated(subscriptionId, planId, planName, validityDays)
trackSearch('query')
// ... and all other tracking functions
```

On non-production domains, these calls are silently ignored (fallback to empty function).

---

## Testing Domain-Based Loading

### Check if Branch is Loaded

Open browser console and run:

```javascript
// Production domain
if (window.branch) {
    console.log("✅ Branch SDK loaded");
} else {
    console.log("❌ Branch SDK not loaded");
}
```

### Check if Clarity is Loaded

```javascript
// Production domain
if (window.clarity) {
    console.log("✅ Clarity loaded");
} else {
    console.log("❌ Clarity not loaded");
}
```

### Force Test (for development only)

If you need to test Branch/Clarity on non-production domain:

```javascript
// Open browser console and manually test
window.trackBranchEvent('test_event', {test: true});
```

---

## Console Messages Reference

| Message | Meaning | Action |
|---------|---------|--------|
| `⚠️ Branch SDK skipped - not on production domain` | Branch not loaded | Normal on staging/dev |
| `⚠️ Clarity script skipped - not on production domain` | Clarity not loaded | Normal on staging/dev |
| `✅ Branch initialized successfully` | Branch is active | Events will track |
| `📤 Branch event called: EVENT_NAME` | Event triggered | Check console for result |
| `✅ Branch event sent: EVENT_NAME` | Event successfully sent | Data tracked |
| `❌ Branch event failed: EVENT_NAME` | Event failed to send | Check network/permissions |

---

## Domain Check Logic

The domain check uses simple hostname matching:

```javascript
var host = window.location.hostname;  // Gets: "www.epicon.in", "epicon.in", "localhost", etc.
var isProductionDomain = host === 'www.epicon.in' || host === 'epicon.in';
```

### Examples

| Hostname | Matches | Result |
|----------|---------|--------|
| `www.epicon.in` | ✅ | Branch/Clarity load |
| `epicon.in` | ✅ | Branch/Clarity load |
| `www.epicon.in:443` | ❌ | Won't match (port included) |
| `staging.epicon.in` | ❌ | Branch/Clarity skipped |
| `contentapistg-njsapi.epicon.in` | ❌ | Branch/Clarity skipped |
| `localhost:8000` | ❌ | Branch/Clarity skipped |
| `192.168.1.1:8000` | ❌ | Branch/Clarity skipped |

---

## For Different Staging URLs

If your staging uses different URLs, update the domain check:

**Current:**
```javascript
var isProductionDomain = host === 'www.epicon.in' || host === 'epicon.in';
```

**If you want to include staging:**
```javascript
var isProductionDomain = 
    host === 'www.epicon.in' || 
    host === 'epicon.in' ||
    host === 'staging.epicon.in' ||  // Add staging domain
    host === 'test.epicon.in';       // Add test domain
```

---

## Files Modified

- `/Users/in10/Desktop/projects/epicon-web/resources/views/layouts/default.blade.php`
  - Branch Web SDK initialization (line ~85)
  - Microsoft Clarity script (line ~185)

---

## Deployment Notes

**No additional deployment steps needed.** The changes are already in place.

When code deploys to:
- **Production** (`www.epicon.in` / `epicon.in`): Branch + Clarity load automatically
- **Staging**: Branch + Clarity are skipped automatically
- **Local dev**: Branch + Clarity are skipped automatically

---

## Troubleshooting

### Issue: Branch events not tracking on production

1. Check browser console for errors
2. Verify domain is exactly `www.epicon.in` or `epicon.in` (no extra subdomains)
3. Check if `trackBranchEvent()` function exists:
   ```javascript
   typeof window.trackBranchEvent === 'function'  // Should be true
   ```

### Issue: Trying to test on staging but want Branch working

Temporarily modify the domain check (for testing only):
```javascript
// In browser console, for temporary testing:
window.trackBranchEvent = function(event, data) {
    console.log('Test event:', event, data);
};
```

---

## Summary

✅ **Branch SDK** - Loads only on production domains  
✅ **Clarity** - Loads only on production domains  
✅ **All event functions** - Still available on all domains (silent no-op on non-prod)  
✅ **Console logging** - Clear messages show what's active  
✅ **No breaking changes** - Works transparently on all environments  

Events track data only when users access `www.epicon.in` or `epicon.in`.
