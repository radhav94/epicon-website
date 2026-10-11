# Token Refresh - 5 Hour Strategy

**Status:** ✅ IMPLEMENTED  
**Date:** September 1, 2026  
**Backend Token TTL:** 24 hours  
**Refresh Interval:** Every 5 hours  
**Strategy:** Always keep fresh token, user never logs out

---

## 📋 Problem & Solution

### The Problem:
- Backend token expires after exactly 24 hours
- Previous approach only refreshed at 23 hours
- If user didn't load page at the right time, token could expire
- Users were experiencing unexpected logouts

### The Solution:
- Refresh token **immediately on page load** (get fresh 24-hour token)
- Then refresh **every 5 hours** automatically
- Also refresh when user **returns to browser tab**
- Also refresh when **user leaves page** (beforeunload)
- This ensures token never expires while user is active

---

## 🔄 How It Works

### Timeline (24-Hour Period):

```
T=0h    → User logs in / Page loads
        → 🔄 Initial refresh (fresh token)
        → TokenExpiresAt = T+24h
        → ✅ User logged in with fresh token

T=5h    → ⏰ Automatic refresh #1
        → 🔄 Refresh token
        → TokenExpiresAt = T+29h
        → ✅ Token extended

T=10h   → ⏰ Automatic refresh #2
        → 🔄 Refresh token
        → TokenExpiresAt = T+34h
        → ✅ Token extended

T=15h   → ⏰ Automatic refresh #3
        → 🔄 Refresh token
        → TokenExpiresAt = T+39h
        → ✅ Token extended

T=20h   → ⏰ Automatic refresh #4
        → 🔄 Refresh token
        → TokenExpiresAt = T+44h
        → ✅ Token extended

T=25h   → ⏰ Automatic refresh #5
        → 🔄 Refresh token
        → TokenExpiresAt = T+49h
        → ✅ Token extended

... continues indefinitely
```

### Special Cases:

**User Returns After Tab Was Inactive:**
```
T=0h    → Page loaded, token refreshed
T=6h    → User switches to another tab (page hidden)
T=12h   → User comes back to our tab (page visible)
        → 📱 Visibility change detected
        → 🔄 Refresh token immediately
        → TokenExpiresAt = T+36h
        → ✅ Fresh token for continued use
```

**User Leaves Page:**
```
T=0h    → Page loaded, user browsing
T=3h    → User closes tab or navigates away
        → 👋 beforeunload event fires
        → 🔄 Async refresh (sendBeacon)
        → 💾 Token refreshed in background
        → ✅ Ready for next visit
```

---

## 🔐 Key Features

### 1. Initial Refresh on Page Load
```javascript
// Get fresh token immediately
refreshToken('initial_page_load');
```
✅ Every time user loads the page, get a brand new 24-hour token

### 2. Periodic Refresh Every 5 Hours
```javascript
// Refresh every 5 hours (3x per 24-hour period)
setInterval(function() {
    refreshToken('periodic_5hour');
}, 5 * 60 * 60 * 1000);
```
✅ Keeps token fresh throughout the day
✅ 3 refreshes per 24 hours = safety margin

### 3. Tab Visibility Listener
```javascript
// When user switches back to tab
document.addEventListener('visibilitychange', function() {
    if (document.hidden === false) {
        refreshToken('page_visibility');
    }
});
```
✅ User away from tab for hours → automatic refresh on return
✅ No logout even after long absence

### 4. Page Unload Refresh
```javascript
// When user closes/leaves page
window.addEventListener('beforeunload', function() {
    navigator.sendBeacon('/refreshTokenProactive', data);
});
```
✅ Extends token even when leaving the page
✅ Ready for next visit

### 5. Duplicate Prevention
```javascript
// Skip refresh if already refreshed within 5 seconds
if (now - lastRefreshTime < 5000) {
    return;
}
```
✅ Prevents multiple refreshes at once
✅ Reduces server load

---

## 📊 Comparison: Before vs After

| Scenario | Before | After |
|----------|--------|-------|
| **Page Load** | ❌ Wait 23 hours | ✅ Refresh immediately |
| **After 5 hours** | ❌ No refresh | ✅ Auto-refresh |
| **After 10 hours** | ❌ No refresh | ✅ Auto-refresh |
| **After 15 hours** | ❌ No refresh | ✅ Auto-refresh |
| **After 20 hours** | ❌ No refresh | ✅ Auto-refresh |
| **After 24 hours** | ❌ **TOKEN EXPIRED** | ✅ Already refreshed 4 times |
| **User away 20h, comes back** | ❌ May logout | ✅ Auto-refresh on visibility |
| **User closes browser at 23h** | ❌ May expire | ✅ Refreshed on unload |

---

## 🧪 Testing the 5-Hour Strategy

### Quick Test (5 minutes):

**Step 1: Login**
```
1. Login to the application
2. Open DevTools Console
3. Look for:
   ✅ 🔐 Token refresh system initializing...
   ✅ 📋 Strategy: Refresh every 5 hours to prevent 24-hour backend expiry
   ✅ ✅ StreamKey token found - starting refresh cycle
   ✅ 🔄 Initial token refresh on page load...
   ✅ 📅 Setting up periodic refresh every 5 hours
```

**Step 2: Check Console for Initial Refresh**
```
Wait a few seconds, you should see:
✅ 🔄 Token refresh (initial_page_load) - Time: [current time]
✅ ✅ Token refreshed successfully (initial_page_load)
✅ 📅 New expiry: [24 hours from now]
✅ ⏰ Next refresh in 5 hours at: [5 hours from now]
✅ 💾 Cookies updated - User will stay logged in
```

**Step 3: Verify Cookies**
```
DevTools → Application → Cookies
✅ StreamKey: [JWT token]
✅ TokenExpiresAt: [Unix timestamp 24h from now]
```

### Full 5-Hour Test (5 hours):

**Step 1:** Login and note the time  
**Step 2:** Wait 5 hours (or set browser clock forward)  
**Step 3:** Check console for automatic refresh  
**Step 4:** Look for: `✅ Token refreshed successfully (periodic_5hour)`  
**Step 5:** Verify TokenExpiresAt cookie updated to new 24-hour window  

### 24-Hour Extended Test:

**Step 1:** Login at T=0  
**Step 2:** Monitor console periodically  
**Step 3:** Watch for refreshes at:
- T=5h (periodic_5hour)
- T=10h (periodic_5hour)  
- T=15h (periodic_5hour)
- T=20h (periodic_5hour)
- T=24h+ (still refreshed, user not logged out)

✅ **If refreshes happen automatically every 5h → SUCCESS**

### Tab Visibility Test:

**Step 1:** Login and open DevTools  
**Step 2:** Switch to another tab (page becomes hidden)  
**Step 3:** Wait 30+ seconds  
**Step 4:** Switch back to our tab  
**Step 5:** Look for: `📱 Page became visible - refreshing token`  
**Step 6:** Verify: `✅ Token refreshed successfully (page_visibility)`  

✅ **If visibility refresh happens → SUCCESS**

---

## 📝 Console Output Examples

### On Initial Page Load:
```
🔐 Token refresh system initializing...
📋 Strategy: Refresh every 5 hours to prevent 24-hour backend expiry
✅ StreamKey token found - starting refresh cycle
🔄 Initial token refresh on page load...
📅 Setting up periodic refresh every 5 hours
🔄 Token refresh (initial_page_load) - Time: 10:30:45 AM
✅ Token refreshed successfully (initial_page_load)
📅 New expiry: Tue Sep 02, 2026 10:30:45 AM
⏰ Next refresh in 5 hours at: 3:30:45 PM
💾 Cookies updated - User will stay logged in
```

### After 5 Hours (Automatic Periodic Refresh):
```
🔄 Token refresh (periodic_5hour) - Time: 3:30:47 PM
✅ Token refreshed successfully (periodic_5hour)
📅 New expiry: Tue Sep 02, 2026 3:30:47 PM
⏰ Next refresh in 5 hours at: 8:30:47 PM
💾 Cookies updated - User will stay logged in
```

### When User Returns to Tab:
```
📱 Page became visible - refreshing token
🔄 Token refresh (page_visibility) - Time: 4:15:23 PM
✅ Token refreshed successfully (page_visibility)
📅 New expiry: Tue Sep 02, 2026 4:15:23 PM
⏰ Next refresh in 5 hours at: 9:15:23 PM
💾 Cookies updated - User will stay logged in
```

### When User Leaves Page:
```
👋 Page unloading - refreshing token for next visit
(refresh sent via sendBeacon - no response shown)
```

---

## ✅ Success Indicators

✅ Token refreshes immediately on page load  
✅ Token refreshes every 5 hours automatically  
✅ Token refreshes when user switches tabs  
✅ User NEVER logs out after 24 hours (token always fresh)  
✅ Console shows periodic refresh messages  
✅ TokenExpiresAt cookie updates to new 24-hour window  
✅ StreamKey cookie updated with new token  

---

## 🚨 Error Handling

### If Console Shows "StreamKey cookie not found":
- User is not logged in
- This is expected for guests

### If Refresh Returns 401:
- User session expired on backend
- Next API call will fail and redirect to login
- This is expected after extended inactivity

### If Network Error:
- Will retry next scheduled refresh
- Should see error: `❌ Network error during token refresh`
- App continues to function with current token

### If Token Refresh Returns 500:
- Backend error
- Check server logs
- Refresh will retry in 5 hours
- Meanwhile user can still use app with current token

---

## 🔍 Monitoring & Logs

### Check Console:
```javascript
// All refresh attempts logged to console
// Search for: "Token refresh"
```

### Check Server Logs:
```bash
tail -f storage/logs/user/user-*.log

# Look for:
✅ Token refreshed proactively
⏰ Next refresh in 5 hours
```

### Monitor Cookies:
```javascript
// In DevTools Console:
const streamKey = document.cookie.split('StreamKey=')[1].split(';')[0];
const expiresAt = document.cookie.split('TokenExpiresAt=')[1].split(';')[0];
console.log('Token expires at:', new Date(expiresAt * 1000).toLocaleString());
```

---

## 📊 Summary

| Aspect | Details |
|--------|---------|
| **Backend Token TTL** | 24 hours |
| **Frontend Refresh Interval** | 5 hours |
| **Refreshes per 24h** | 3-5 (initial + periodic + visibility + unload) |
| **Initial Refresh** | On every page load |
| **Periodic Refresh** | Every 5 hours |
| **Visibility Refresh** | When user switches back to tab |
| **Unload Refresh** | When user closes/leaves page |
| **Duplicate Prevention** | 5-second cooldown |
| **Result** | User never logs out while active |

---

## 🎯 User Experience

**Before This Fix:**
- User gets logged out after exactly 24 hours 😞
- Unexpected logout while using the app 😞
- Frustrating user experience 😞

**After This Fix:**
- User stays logged in indefinitely while active 😊
- Token automatically refreshes every 5 hours 😊
- No unexpected logouts 😊
- Seamless experience 😊

