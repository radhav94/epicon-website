# Branch GTM Web Integration - Compliance Audit

## Reference Document
- **Source:** https://help.branch.io/developer-hub/docs/gtm-web
- **Last Reviewed:** September 1, 2026

---

## ✅ What's Already Implemented

### 1. **Branch Web SDK Installation** ✅
- **Status:** DONE
- **Location:** `/resources/views/layouts/default.blade.php` (lines 77-170)
- **Implementation:**
  - SDK loaded from `https://cdn.branch.io/branch-latest.min.js`
  - Async loading enabled
  - Proper initialization with Branch key: `key_test_pBvRu3MlTPs4MBzX7a3ZPbdeAFh8rA1m`
  - Works on all domains (no domain restrictions)

### 2. **Branch SDK Initialization** ✅
- **Status:** DONE
- **Method:** `branch.init(key, callback)`
- **Callback:** Logs initialization success/error to console

### 3. **Data Layer Setup** ✅
- **Status:** DONE
- **Location:** `/resources/views/layouts/default.blade.php` (lines 173-182)
- **Current Data:**
  ```javascript
  window.dataLayer = window.dataLayer || [];
  window.dataLayer.push({
      'client_ga_id': '374718823',
      'content_type': title,
      'platform_type': 'web',
      'environment': 'develop',
  });
  ```

### 4. **Google Tag Manager (GTM) Setup** ✅
- **Status:** DONE
- **Container ID:** `GTM-PS5WQPB`
- **Implementation:** Deferred loading after first paint for performance
- **Location:** `/resources/views/layouts/default.blade.php` (lines 185-197)

### 5. **Event Tracking** ✅
- **Status:** PARTIALLY DONE
- **Current Events:**
  - `TEST_BRANCH_EVENT` - Test event on all pages
  - `page_view_test` - Page view test event (after 1 second)
  - `payment_successful` - Payment success tracking (thankyou.blade.php)
  - `subscription_activated` - Subscription activation tracking (thankyou.blade.php)

---

## ❌ What's Missing or Needs Improvement

### 1. **User Identity Management** ❌ MISSING
- **Requirement:** Set user identities when user logs in
- **Branch Method:** `branch.setIdentity(userIdentifier)`
- **What's Needed:**
  - Call `branch.setIdentity()` after user login
  - Pass unique user identifier (user_id, email, etc.)
  - Set in data layer before GTM script
  
**Current Status:** Not implemented

**Recommended Implementation:**
```javascript
// After successful login, add to your login controller
window.dataLayer = window.dataLayer || [];
window.dataLayer.push({
    'user_id': '{{ auth()->user()->id }}',
    'user_email': '{{ auth()->user()->email }}',
    'user_phone': '{{ auth()->user()->phone }}'
});

// Then call Branch setIdentity
if (typeof window.branch !== 'undefined') {
    branch.setIdentity('{{ auth()->user()->id }}');
}
```

---

### 2. **User Data in Data Layer** ❌ NEEDS EXPANSION
- **Current:** Only has `client_ga_id`, `content_type`, `platform_type`, `environment`
- **Missing Customer Data:**
  - `customerID` / `user_id` (should be set when logged in)
  - `user_email`
  - `user_phone`
  - `subscription_status` (active/inactive/expired)
  - `device_fingerprint` (already have SHA-256 hash - good!)

**Recommended Data Layer Enhancement:**
```javascript
window.dataLayer = window.dataLayer || [];
window.dataLayer.push({
    'client_ga_id': '374718823',
    'content_type': title,
    'platform_type': 'web',
    'environment': 'develop',
    'customerID': '{{ isUserLoggedIn() ? auth()->user()->id : "guest" }}',
    'user_email': '{{ isUserLoggedIn() ? auth()->user()->email : "" }}',
    'user_phone': '{{ isUserLoggedIn() ? auth()->user()->phone : "" }}',
    'subscription_status': '{{ isUserLoggedIn() ? getSubscriptionStatus() : "none" }}',
    'device_fingerprint': '{{ getUserAgent() }}'
});
```

---

### 3. **Commerce Event Tracking** ❌ NEEDS EXPANSION
- **Current:** Only has payment_successful and subscription_activated
- **Missing Commerce Events (per GTM-Web doc):**
  - `view_item` - When user views content
  - `add_to_wishlist` - When user adds to wishlist
  - `view_cart` - When user views subscription plans
  - `begin_checkout` - When user starts payment process
  - `add_payment_info` - When payment method selected
  - `purchase` - Complete purchase (currently only on thankyou)
  - `refund` - When subscription cancelled

---

### 4. **Event Logging Infrastructure** ❌ MISSING
- **Current:** Using `branch.logEvent()` directly (old method)
- **Recommended:** Use `branch.trackCommerceEvent()` for e-commerce events
  
**Note:** The GTM doc shows `branch.logEvent()` - your implementation is correct, but not leveraging full commerce tracking API

---

### 5. **Cross-Platform User Identification** ❌ MISSING
- **Branch Method:** `branch.crossPlatformIds()`
- **Use Case:** Track same user across web, iOS, Android
- **Current Status:** Not used
- **Recommendation:** Optional, but useful if you have mobile apps

---

### 6. **Browser Fingerprint Tracking** ✅ PARTIALLY DONE
- **Status:** You have device fingerprint (SHA-256 hash in getUserAgent())
- **Branch Method:** `branch.getBrowserFingerprintId()`
- **Recommendation:** Add to data layer for better tracking

---

### 7. **Dynamic Data Layer Updates** ❌ NEEDS IMPLEMENTATION
- **Issue:** Data layer is static (only set once on page load)
- **GTM Requirement:** Should push updates when state changes
  - After login: Update user data
  - After logout: Clear user data  
  - After plan selection: Add plan data
  - After payment: Add transaction data

**Current Status:** Not implemented

---

### 8. **Event Callback Handling** ✅ DONE
- **Status:** Your implementation includes error callbacks
- **Good Practice:** You're checking `if (err)` in logEvent callbacks

---

## 📋 Summary: What's Missing

| Feature | Status | Priority | Effort |
|---------|--------|----------|--------|
| User Identity Setup | ❌ Missing | **HIGH** | Low |
| Enhanced Data Layer | ❌ Missing | **HIGH** | Low |
| Login Event Tracking | ❌ Missing | **HIGH** | Medium |
| Logout Event Tracking | ❌ Missing | **HIGH** | Low |
| Commerce Events (full set) | ⚠️ Partial | **MEDIUM** | Medium |
| Dynamic Data Layer Updates | ❌ Missing | **MEDIUM** | Medium |
| Cross-Platform IDs | ❌ Missing | **LOW** | Low |
| Subscription State Tracking | ❌ Missing | **MEDIUM** | Low |

---

## 🎯 Recommended Implementation Plan

### Phase 1 (Critical)
1. Add user identity setup in login handler
2. Enhance data layer with user/subscription data
3. Add logout event tracking
4. Add login event tracking

### Phase 2 (Important)
5. Add dynamic data layer updates on state changes
6. Implement all commerce events (view_item, add_to_cart, begin_checkout, purchase)
7. Add subscription state tracking

### Phase 3 (Nice-to-Have)
8. Add cross-platform ID tracking (if mobile apps exist)
9. Add advanced browser fingerprinting

---

## Files That Need Updates

1. **`/resources/views/layouts/default.blade.php`**
   - Enhance data layer with user/subscription data
   - Add user identity setup after login check

2. **`/resources/views/auth/login-reg-js.blade.php`**
   - Track `user_login` event after successful login
   - Push login data to data layer
   - Call `branch.setIdentity()`

3. **`/resources/views/auth/login-reg-popup.blade.php`**
   - Track `user_logout` event when user logs out
   - Clear user data from data layer

4. **`/resources/views/subscription/subscription.blade.php`**
   - Track `view_subscription_plans` event
   - Update data layer with selected plan

5. **`/resources/views/subscription/payment-method.blade.php`**
   - Track `payment_method_selected` event
   - Track `begin_checkout` event

6. **`/resources/views/subscription/thankyou.blade.php`** (Already Updated ✅)
   - Already has `payment_successful` and `subscription_activated`

---

## GTM Documentation Reference

**Per GTM-Web Doc Requirements:**

✅ = Implemented  
⚠️ = Partially Implemented  
❌ = Not Implemented

- ✅ Branch Web SDK Installation
- ✅ Branch SDK Initialization  
- ✅ Data Layer Setup
- ✅ Google Tag Manager (GTM) Installation
- ⚠️ Event Tracking (basic only)
- ❌ **User Identity Management (branch.setIdentity())**
- ❌ **Custom Event Variables**
- ❌ **Dynamic Data Layer Updates**

---

## Next Steps

Would you like me to implement any of these improvements? I recommend starting with:

1. **User Identity Setup** - Call `branch.setIdentity()` after login
2. **Enhanced Data Layer** - Add user/subscription data to window.dataLayer
3. **Login/Logout Events** - Track these critical user actions
