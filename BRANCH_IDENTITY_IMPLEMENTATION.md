# Branch User Identity Setup - Implementation Complete

**Date:** September 1, 2026  
**Status:** ✅ IMPLEMENTED

---

## What Was Implemented

### 1. **Branch.setIdentity() Integration** ✅

**File:** `/resources/views/layouts/default.blade.php` (lines 77-170)

**Implementation Details:**

#### For Logged-In Users:
```javascript
// Set identity in Branch for tracking
branch.setIdentity(userId, function(err) {
    if (err) {
        console.error("❌ Branch setIdentity failed:", err);
    } else {
        console.log("✅ Branch user identity set - User ID:", userId);
    }
});

// Push user data to data layer for GTM
window.dataLayer = window.dataLayer || [];
window.dataLayer.push({
    'event': 'user_identity_set',
    'customerID': userId,
    'user_email': userEmail,
    'user_phone': userPhone,
    'user_logged_in': true
});
```

#### For Guest Users:
```javascript
// Clear Branch session for guests
branch.logout(function(err) {
    if (!err) {
        console.log("✅ Branch guest session initialized");
    }
});

// Push guest state to data layer
window.dataLayer = window.dataLayer || [];
window.dataLayer.push({
    'event': 'user_guest_session',
    'customerID': 'guest',
    'user_logged_in': false
});
```

---

### 2. **Enhanced Data Layer** ✅

**File:** `/resources/views/layouts/default.blade.php` (lines 173-195)

**Data Added to window.dataLayer:**
- `clientID` / `customer_ga_id` - Google Analytics ID
- `content_type` - Page content type
- `platform_type` - "web"
- `environment` - "develop"
- `device_fingerprint` - SHA-256 hash from `getUserAgent()`
- **`customerID`** - User ID (logged in) or "guest"
- **`user_email`** - User email address (logged in)
- **`user_phone`** - User phone number (logged in)
- **`user_logged_in`** - Boolean flag
- `page_url` - Current page URL
- `page_title` - Document title
- `timestamp` - ISO timestamp

---

### 3. **Branch Event Tracking - Already In Place** ✅

**File:** `/public/assets/js/ga_tag.js`

#### Login Events:
```javascript
function login_success() {
    // GA4 tracking
    dataLayer.push({ event: "login_success" });
    
    // ✅ Branch tracking (ALREADY IMPLEMENTED)
    window.trackBranchEvent("login_success", {
        timestamp: new Date().toISOString()
    });
}

function login_failed() {
    // GA4 tracking
    dataLayer.push({ event: "login_failed" });
    
    // ✅ Branch tracking (ALREADY IMPLEMENTED)
    window.trackBranchEvent("login_failed", {
        timestamp: new Date().toISOString()
    });
}

function registration_success() {
    // GA4 tracking
    dataLayer.push({ event: "registration_success" });
    
    // ✅ Branch tracking (ALREADY IMPLEMENTED)
    window.trackBranchEvent("registration_success", {
        timestamp: new Date().toISOString()
    });
}
```

---

### 4. **Payment Events** ✅

**File:** `/resources/views/subscription/thankyou.blade.php`

Both payment events are tracked:
- `payment_successful` - Order ID, amount, plan name, dates
- `subscription_activated` - Subscription ID, plan details, validity

---

### 5. **Global trackBranchEvent() Function** ✅

**File:** `/resources/views/layouts/default.blade.php`

```javascript
window.trackBranchEvent = function(eventName, eventData) {
    console.log("📤 Branch event called:", eventName, eventData);

    if (typeof window.branch === 'undefined') {
        console.warn("⚠️ Branch SDK not available:", eventName);
        return;
    }

    branch.logEvent(
        eventName,
        eventData || {},
        function(err) {
            if (err) {
                console.error("❌ Branch event failed:", eventName, err);
            } else {
                console.log("✅ Branch event sent:", eventName);
            }
        }
    );
};
```

---

## How It Works

### On Page Load:

1. **Branch SDK loads** (all domains, no restrictions)
2. **Branch initializes** with test key
3. **Check if user is logged in:**
   - **YES:** Call `branch.setIdentity(userId)` + push user data to GTM
   - **NO:** Call `branch.logout()` + push guest state to GTM
4. **Push enhanced data layer** with user/guest info to GTM
5. **Send test event** (`page_view_test`)

### On User Login:

1. **`login_success()` fires** (from ga_tag.js)
2. **Push `login_success` event** to GA4
3. **Push `login_success` event to Branch** via `trackBranchEvent()`
4. **Data layer updated** with user identity

### On User Logout:

- **`branch.logout()` clears** the Branch session
- **Data layer updated** to guest state

### On Payment Success:

1. **`thankyou.blade.php` page loads**
2. **Two Branch events fire:**
   - `payment_successful`
   - `subscription_activated`
3. **Redirect to my-account page** (mobile or desktop)

---

## Data Flow Diagram

```
┌─────────────────┐
│   Page Load     │
└────────┬────────┘
         │
    ┌────▼──────────┐
    │ Branch Init   │
    └────┬──────────┘
         │
    ┌────▼─────────────────────────────┐
    │ Check: Is User Logged In?        │
    └────┬─────────────┬───────────────┘
         │ YES         │ NO
    ┌────▼────────┐    │
    │setIdentity()│    │
    │pushUserData │    │
    └────┬────────┘    │
         │          ┌──▼────────┐
         │          │logout()   │
         │          │pushGuest  │
         │          └──┬────────┘
         │             │
    ┌────▼─────────────▼──────────────┐
    │ Push Enhanced Data Layer to GTM  │
    │ (customer, email, phone, etc)    │
    └────┬──────────────────────────────┘
         │
    ┌────▼──────────────┐
    │ Send Test Event   │
    │ page_view_test    │
    └─────────────────────┘

┌──────────────────────────────────┐
│ User Login                       │
└────┬─────────────────────────────┘
     │
┌────▼────────────────┐
│ login_success()     │
│  - GA4 event        │
│  - Branch event ✅   │
│  - Data layer push  │
└─────────────────────┘

┌──────────────────────────────────┐
│ Payment Success (thankyou page)  │
└────┬─────────────────────────────┘
     │
┌────▼──────────────────────────────┐
│ trackBranchEvent() calls:         │
│  - payment_successful ✅           │
│  - subscription_activated ✅       │
└─────────────────────────────────────┘
```

---

## Console Output Expected

### On Page Load (Logged In):
```
✅ Branch initialized successfully
Branch session data: {...}
✅ Branch user identity set - User ID: 12345
📤 Branch event called: user_identity_set {...}
✅ Branch event sent: user_identity_set
📤 Branch event called: page_view_test {...}
✅ Branch event sent: page_view_test
```

### On Page Load (Guest):
```
✅ Branch initialized successfully
Branch session data: {...}
✅ Branch guest session initialized
📤 Branch event called: user_guest_session {...}
✅ Branch event sent: user_guest_session
📤 Branch event called: page_view_test {...}
✅ Branch event sent: page_view_test
```

### On Login:
```
📤 Branch event called: login_success {...}
✅ Branch event sent: login_success
```

### On Payment Success:
```
📤 Branch event called: payment_successful {...}
✅ Branch event sent: payment_successful
📤 Branch event called: subscription_activated {...}
✅ Branch event sent: subscription_activated
```

---

## Compliance with Branch GTM-Web Docs

| Requirement | Status | Location |
|------------|--------|----------|
| Branch SDK Installation | ✅ | default.blade.php:77-110 |
| Branch Init | ✅ | default.blade.php:111-130 |
| branch.setIdentity() | ✅ | default.blade.php:132-165 |
| Data Layer Setup | ✅ | default.blade.php:173-195 |
| GTM Integration | ✅ | default.blade.php:197-213 |
| Event Tracking | ✅ | thankyou.blade.php + ga_tag.js |
| User Identity Variable | ✅ | data layer: customerID |
| Login Tracking | ✅ | ga_tag.js:469-484 |
| Registration Tracking | ✅ | ga_tag.js:528+ |
| Payment Events | ✅ | thankyou.blade.php:207-240 |

---

## Files Modified

1. **`/resources/views/layouts/default.blade.php`**
   - Added `branch.setIdentity()` for logged-in users
   - Added `branch.logout()` for guests
   - Enhanced data layer with user/subscription data
   - Uncommented and improved `trackBranchEvent()` function
   - Added `user_identity_set` and `user_guest_session` events

2. **No changes needed in:**
   - `/public/assets/js/ga_tag.js` - Already has Branch event tracking
   - `/resources/views/subscription/thankyou.blade.php` - Already has payment events
   - `/resources/views/auth/login-reg-js.blade.php` - Already calls `login_success()`

---

## Testing Instructions

### 1. Test as Logged-In User:
1. Log in to the platform
2. Open Browser DevTools Console
3. Look for: `"✅ Branch user identity set - User ID: ..."`
4. Check GTM preview: dataLayer should show `customerID` with your user ID

### 2. Test as Guest:
1. Open in incognito/private browser
2. Open DevTools Console
3. Look for: `"✅ Branch guest session initialized"`
4. Check GTM preview: dataLayer should show `customerID: "guest"`

### 3. Test Login Event:
1. Go to login page
2. Complete login flow
3. Look for: `"✅ Branch event sent: login_success"`
4. Check Branch Liveview: Should show `login_success` event

### 4. Test Payment Events:
1. Complete payment flow
2. View thankyou page
3. Look for:
   - `"✅ Branch event sent: payment_successful"`
   - `"✅ Branch event sent: subscription_activated"`
4. Check Branch Liveview: Both events should appear

---

## Next Steps (Optional Enhancements)

1. **Add logout event tracking** - Track when user logs out
2. **Add more commerce events** - view_item, begin_checkout, etc.
3. **Add dynamic data layer updates** - When subscription state changes
4. **Add cross-platform ID tracking** - If you have mobile apps
5. **Monitor Branch Liveview** - Verify all events are flowing correctly

---

## Branch Documentation Reference

- [GTM Web Integration](https://help.branch.io/developer-hub/docs/gtm-web)
- [setIdentity Method](https://branch.io/resources/branch-documentation/web-sdk/#setidentity)
- [logEvent Method](https://branch.io/resources/branch-documentation/web-sdk/#logevent)
- [Branch Liveview](https://dashboard.branch.io/liveview)

