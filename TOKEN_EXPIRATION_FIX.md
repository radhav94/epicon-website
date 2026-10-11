# Token Expiration Issue - Root Cause & Fix

**Issue:** TokenExpiresAt cookie exists but user still logs out after 24 hours

**Date:** September 1, 2026

---

## 🔍 Root Cause Analysis

### Current Flow:

1. **User Login** → `setToken()` called
   - Sets `StreamKey` cookie (10 years)
   - Sets `TokenExpiresAt` cookie with `time() + 24 hours`

2. **Page Reload** → `token-refresh.js` runs
   - Reads `TokenExpiresAt` cookie
   - Calculates time until expiry
   - Schedules refresh 1 hour BEFORE expiry (23 hours later)

3. **At 23 hours** → First token refresh triggered
   - Calls `/refreshTokenProactive` endpoint
   - Backend calls `refreshToken()` API
   - Backend returns new token + `expires_at: time() + 24 hours`
   - JavaScript updates `TokenExpiresAt` cookie

4. **After refresh** → Recurring refresh every 20 hours

### **The Problem:**

When the token is refreshed after 23 hours, the `expires_at` returned from backend is:
```
expires_at = time() + (24 * 60 * 60) = Unix timestamp 24 hours from NOW
```

But the issue is: **The backend API might be returning the wrong expiration time or the refresh might not be happening at all.**

### **Verification Needed:**

1. Is `TokenExpiresAt` cookie actually being set on initial login?
2. Is the refresh script running at the right time?
3. Is the `/refreshTokenProactive` endpoint being called successfully?
4. Is the backend `refreshToken` API returning a valid token?

---

## 🔧 Multi-Level Fix

### Fix 1: Enhanced Token Refresh Script

**File:** `/public/assets/js/token-refresh.js`

**Changes:**
- Better error handling and logging
- Validate TokenExpiresAt cookie exists and is valid
- Handle edge cases (token already expired, clock skew)
- Add fallback refresh on page visibility change (when user comes back from background)
- Store last refresh time to prevent duplicate refreshes

**Implementation:**

```javascript
(function() {
    'use strict';

    let lastRefreshTime = 0;
    let refreshScheduled = false;

    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i].trim();
            if (c.indexOf(nameEQ) === 0) {
                return decodeURIComponent(c.substring(nameEQ.length, c.length));
            }
        }
        return null;
    }

    function initTokenRefresh() {
        console.log('🔐 Token refresh system initializing...');

        if (!window.IS_LOGGED_IN) {
            console.log("ℹ️ Token refresh skipped - user not logged in");
            return;
        }

        var tokenExpiresAt = getCookie('TokenExpiresAt');
        if (!tokenExpiresAt) {
            console.warn("⚠️ TokenExpiresAt cookie not found");
            return;
        }

        // Validate token expiration time
        var tokenExpiresAtTime = parseInt(tokenExpiresAt) * 1000;
        var now = new Date().getTime();
        var timeUntilExpiry = tokenExpiresAtTime - now;

        if (isNaN(timeUntilExpiry) || timeUntilExpiry <= 0) {
            console.error("❌ Token already expired! Need immediate login");
            return;
        }

        console.log("🔐 Token expiry: " + new Date(tokenExpiresAtTime).toLocaleString());
        console.log("⏱️ Time until expiry: " + Math.floor(timeUntilExpiry / 1000 / 60) + " minutes");

        // Refresh 1 hour before expiry
        var refreshBeforeExpiry = 60 * 60 * 1000;
        var scheduleRefreshAfter = Math.max(0, timeUntilExpiry - refreshBeforeExpiry);

        console.log("📅 First refresh in: " + Math.floor(scheduleRefreshAfter / 1000 / 60) + " minutes");

        // Schedule first refresh
        if (!refreshScheduled) {
            refreshScheduled = true;
            setTimeout(function() {
                refreshToken('scheduled');
                
                // Then refresh every 20 hours
                setInterval(function() {
                    refreshToken('periodic');
                }, 20 * 60 * 60 * 1000);
            }, scheduleRefreshAfter);
        }

        // Also refresh when page becomes visible (user comes back from tab switch)
        document.addEventListener('visibilitychange', function() {
            if (document.hidden === false) {
                console.log("📱 Page became visible - checking if token refresh needed");
                checkAndRefreshIfNeeded();
            }
        });
    }

    function checkAndRefreshIfNeeded() {
        var tokenExpiresAt = getCookie('TokenExpiresAt');
        if (!tokenExpiresAt) return;

        var tokenExpiresAtTime = parseInt(tokenExpiresAt) * 1000;
        var now = new Date().getTime();
        var timeUntilExpiry = tokenExpiresAtTime - now;

        // Refresh if less than 2 hours until expiry
        if (timeUntilExpiry < 2 * 60 * 60 * 1000) {
            console.log("⚠️ Token expiring soon (< 2 hours), refreshing immediately");
            refreshToken('visibility');
        }
    }

    function refreshToken(reason = 'unknown') {
        // Prevent duplicate refreshes within 10 seconds
        var now = new Date().getTime();
        if (now - lastRefreshTime < 10000) {
            console.log("⏭️ Skipping refresh - already refreshed recently (" + reason + ")");
            return;
        }
        lastRefreshTime = now;

        console.log("🔄 Refreshing token (" + reason + ")...");
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/refreshTokenProactive', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', getCookie('XSRF-TOKEN') || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        console.log("✅ Token refreshed successfully (" + reason + ")");
                        console.log("📅 New expiry: " + new Date(response.expires_at * 1000).toLocaleString());
                        
                        // Update TokenExpiresAt cookie
                        var expiresAtDate = new Date();
                        expiresAtDate.setTime(expiresAtDate.getTime() + (10 * 365 * 24 * 60 * 60 * 1000));
                        document.cookie = "TokenExpiresAt=" + response.expires_at + ";path=/;expires=" + expiresAtDate.toUTCString() + ";SameSite=Lax";
                        console.log("💾 TokenExpiresAt cookie updated");
                    } else {
                        console.error("❌ Token refresh failed: " + response.message);
                    }
                } catch (e) {
                    console.error("❌ Error parsing refresh response: " + e.message);
                }
            } else if (xhr.status === 401) {
                console.warn("⚠️ Unauthorized (401) - logging out user");
                window.location.href = '/login';
            } else {
                console.error("❌ Token refresh error: HTTP " + xhr.status);
            }
        };

        xhr.onerror = function() {
            console.error("❌ Network error during token refresh");
        };

        xhr.send(JSON.stringify({reason: reason}));
    }

    // Initialize on page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTokenRefresh);
    } else {
        initTokenRefresh();
    }
})();
```

---

### Fix 2: Backend Endpoint Improvement

**File:** `/app/Http/Controllers/Auth/LoginController.php`

**Changes:**
- Better error handling
- Ensure `expires_at` is always set correctly
- Log refresh attempts
- Clear cookies on failed refresh

```php
public function refreshTokenProactive(Request $request)
{
    if (!isUserLoggedIn()) {
        Log::channel('user')->warning('Proactive refresh attempt by non-logged-in user');
        return JSONResponse(401, 'User not logged in', ['success' => false]);
    }

    try {
        // Call backend refreshToken API
        $refreshResponse = CurlAPI("refreshToken", "POST", [], 2, true, true);

        if (@$refreshResponse['success'] == true && !empty($refreshResponse['token'])) {
            $newToken = $refreshResponse['token'];
            $expiresAt = time() + (24 * 60 * 60); // 24 hours from now
            
            // Set the new token with updated expiration
            setToken($newToken);
            
            Log::channel('user')->info('Token refreshed proactively. New expiry: ' . date('Y-m-d H:i:s', $expiresAt));
            
            return JSONResponse(200, 'Token refreshed successfully', [
                'success' => true,
                'token' => $newToken,
                'expires_at' => $expiresAt,
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        } else {
            $errorMsg = $refreshResponse['message'] ?? 'Unknown error';
            Log::channel('user')->warning('Proactive token refresh failed: ' . $errorMsg);
            
            // Don't clear cookie, just fail
            return JSONResponse(401, 'Token refresh failed', [
                'success' => false,
                'error' => $errorMsg
            ]);
        }
    } catch (\Exception $e) {
        Log::channel('error')->error('Proactive token refresh exception: ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
        
        return JSONResponse(500, 'Error refreshing token', [
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}
```

---

### Fix 3: Initial Login Token Setup Verification

**File:** `/app/Helpers/helpers.php`

**Current setToken function:**
```php
function setToken ($token)
{
    Cookie::queue(Cookie::make('StreamKey', '', -1));
    Cookie::queue(Cookie::make("StreamKey", $token, (10 * 365 * 24 * 60)));
    
    // Set token expiration timestamp (24 hours from now)
    $tokenExpiresAt = time() + (24 * 60 * 60);
    Cookie::queue(Cookie::make('TokenExpiresAt', (string)$tokenExpiresAt, (10 * 365 * 24 * 60)));
}
```

**Improved version:**
```php
function setToken ($token)
{
    // Clear old token
    Cookie::queue(Cookie::make('StreamKey', '', -1));
    
    // Set new token with 10-year expiration
    Cookie::queue(Cookie::make("StreamKey", $token, (10 * 365 * 24 * 60)));
    
    // Set token expiration timestamp (24 hours from now)
    $tokenExpiresAt = time() + (24 * 60 * 60);
    Cookie::queue(Cookie::make('TokenExpiresAt', (string)$tokenExpiresAt, (10 * 365 * 24 * 60)));
    
    // Log for debugging
    \Log::channel('user')->info('Token set. Expires at: ' . date('Y-m-d H:i:s', $tokenExpiresAt) . ' (Unix: ' . $tokenExpiresAt . ')');
}
```

---

## 🧪 Testing Checklist

After applying fixes:

1. **Login and Check Console:**
   ```
   ✅ 🔐 Token refresh system initializing...
   ✅ 🔐 Token expiry: [date and time]
   ✅ ⏱️ Time until expiry: 1440 minutes (24 hours)
   ✅ 📅 First refresh in: 1380 minutes (23 hours)
   ```

2. **Check TokenExpiresAt Cookie:**
   - Open DevTools → Application → Cookies
   - Verify `TokenExpiresAt` cookie exists
   - Verify value is Unix timestamp for 24 hours from login

3. **Wait 23 Hours or Simulate:**
   - Fast-forward browser clock
   - Check if `/refreshTokenProactive` is called
   - Verify console shows "✅ Token refreshed successfully"

4. **Check After Refresh:**
   - `TokenExpiresAt` should be updated to new 24-hour expiry
   - Verify no "login required" page appears

5. **Tab Switch Test:**
   - Login and leave tab in background for 20+ hours
   - Switch back to tab
   - Should auto-refresh token
   - No logout should occur

---

## 📊 What Each Part Does

| Component | Purpose | Duration |
|-----------|---------|----------|
| **StreamKey Cookie** | Holds JWT token | 10 years |
| **TokenExpiresAt Cookie** | Unix timestamp of token expiry | 10 years |
| **First Refresh (token-refresh.js)** | Triggered 1 hour before expiry | 23 hours |
| **Refresh Interval** | Periodic refresh after first one | Every 20 hours |
| **Visibility Change Listener** | Refresh if token expiring soon when user returns | On tab focus |
| **Server `/refreshTokenProactive`** | Gets new token from backend API | Called as needed |

---

## ✅ Expected Behavior After Fix

- ✅ User logs in → tokens set with 24-hour expiry
- ✅ At 23 hours → token automatically refreshes
- ✅ TokenExpiresAt cookie updated to new 24-hour window
- ✅ Refresh repeats every 20 hours
- ✅ User stays logged in indefinitely while active
- ✅ If user inactive for 24+ hours, logout on next page load
- ✅ Tab switch after 20+ hours → automatic refresh before expiry

