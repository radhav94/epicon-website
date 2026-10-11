# JWT Token Refresh - Testing Guide

## Overview
This document describes how to test the proactive JWT token refresh mechanism that prevents users from being automatically logged out after 24 hours.

---

## How It Works

### Flow Diagram
```
User Login
    ↓
Backend generates JWT token (24hr expiry)
    ↓
setToken() stores StreamKey cookie + TokenExpiresAt cookie
    ↓
Page loads → token-refresh.js executes
    ↓
Reads TokenExpiresAt cookie, calculates time until expiry
    ↓
Schedules refresh for 1 hour BEFORE expiration
    ↓
Frontend calls POST /refreshTokenProactive
    ↓
Backend calls refreshToken API → gets new token
    ↓
setToken() updates StreamKey + TokenExpiresAt
    ↓
User stays logged in indefinitely
    ↓
Every 20 hours: refresh repeats
```

---

## Testing Scenarios

### ✅ Test 1: Token Refresh Endpoint Works
**Goal:** Verify the backend endpoint can refresh tokens

**Steps:**
1. Log in to the app
2. Open browser DevTools → Network tab
3. Wait ~30 seconds, then manually call the refresh endpoint:
```javascript
fetch('/refreshTokenProactive', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
        'X-Requested-With': 'XMLHttpRequest'
    }
})
.then(r => r.json())
.then(data => console.log('Response:', data));
```

**Expected Result:**
- Response: `{ success: true, token: "new_jwt_token", expires_at: 1234567890 }`
- New token should be different from old one
- Status: 200

**Verification:**
- ✅ Check Network tab → new token received
- ✅ Check Cookies → `TokenExpiresAt` updated to future timestamp
- ✅ Check Cookies → `StreamKey` updated to new token

---

### ✅ Test 2: Token Refresh Logging
**Goal:** Verify console logs show token refresh scheduling

**Steps:**
1. Log in to the app
2. Open browser DevTools → Console tab
3. Look for token refresh initialization logs

**Expected Logs:**
```
🔐 Token refresh system initializing...
🔐 Token expiry time: [Date/Time 24 hours from login]
⏱️ Time until expiry: 1440 minutes (24 hours)
📅 Scheduling first token refresh in: 1380 minutes (23 hours)
```

**Verification:**
- ✅ Logs appear on every page load
- ✅ Time calculations are correct (23 hours from now)
- ✅ No errors in console

---

### ✅ Test 3: Proactive Refresh Before Expiry (Simulated)
**Goal:** Verify refresh happens before token expires

**Steps:**
1. Log in to the app
2. In console, modify token expiration to be very soon:
```javascript
// Set expiration to 2 minutes from now (instead of 24 hours)
var expiresIn = Math.floor(Date.now() / 1000) + (2 * 60);
document.cookie = `TokenExpiresAt=${expiresIn};path=/;SameSite=Lax`;
console.log('TokenExpiresAt set to 2 minutes from now');
```

3. Refresh the page
4. Watch console for refresh logs

**Expected Result:**
- Console shows: `📅 Scheduling first token refresh in: 0-60 minutes`
- Refresh happens immediately (within 1 minute)
- After refresh: `✅ Token refreshed successfully`
- New expiration timestamp appears

**Verification:**
- ✅ Refresh happens within 1 minute (before 2-minute expiry)
- ✅ New token is generated
- ✅ TokenExpiresAt cookie updated to future time

---

### ✅ Test 4: Recurring Refresh Every 20 Hours
**Goal:** Verify recurring refresh is set up after first refresh

**Steps:**
1. Complete Test 3 (simulated refresh)
2. Wait 2 minutes
3. In console, set expiration to 2 minutes again:
```javascript
// Set expiration to 2 minutes from now (again)
var expiresIn = Math.floor(Date.now() / 1000) + (2 * 60);
document.cookie = `TokenExpiresAt=${expiresIn};path=/;SameSite=Lax`;
console.log('TokenExpiresAt set to 2 minutes from now again');
```

4. Wait and watch for automatic refresh

**Expected Result:**
- Refresh happens automatically (recurring interval kicks in)
- Console shows: `🔄 Calling token refresh endpoint...`
- After ~30 seconds: `✅ Token refreshed successfully`

**Verification:**
- ✅ Second refresh happens without page reload
- ✅ Recurring interval is active
- ✅ No manual intervention needed

---

### ✅ Test 5: Cookie Tracking Across Pages
**Goal:** Verify TokenExpiresAt cookie persists across page navigation

**Steps:**
1. Log in to the app
2. Open browser DevTools → Application → Cookies
3. Find `TokenExpiresAt` cookie, note the value
4. Navigate to different pages (Home → Detail → Search, etc.)
5. Check `TokenExpiresAt` value on each page

**Expected Result:**
- `TokenExpiresAt` value remains the same across all pages
- Only updates when token is refreshed

**Verification:**
- ✅ Cookie value stable during navigation
- ✅ Cookie persists for entire session
- ✅ Value matches expiration time shown in logs

---

### ✅ Test 6: Network Error Handling
**Goal:** Verify graceful handling if refresh fails

**Steps:**
1. Log in to the app
2. Set token to expire in 2 minutes (from Test 3)
3. Go to Network tab and throttle to "Offline"
4. Wait for refresh to be triggered
5. Watch console for error handling

**Expected Result:**
- Console shows: `❌ Network error during token refresh`
- User remains logged in (doesn't crash)
- No infinite refresh loops
- When network comes back: next scheduled refresh works

**Verification:**
- ✅ No crashes or errors in console
- ✅ User can still interact with app
- ✅ After network restored, next refresh succeeds

---

### ✅ Test 7: Unauthorized Response (401)
**Goal:** Verify logout when token refresh fails with 401

**Steps:**
1. Log in to the app
2. Set token to expire in 2 minutes
3. In console, simulate invalid token by manually clearing cookies:
```javascript
// In browser: Force 401 by using invalid token in next request
// (This requires backend to return 401 for invalid tokens)
```

**Expected Result:**
- If backend returns 401: `⚠️ Unauthorized - logging out user`
- Redirect to `/login` page
- User session ends gracefully

**Verification:**
- ✅ Proper logout flow on 401
- ✅ Redirect to login page works
- ✅ No error messages to user

---

### ✅ Test 8: Logged-Out Users Not Affected
**Goal:** Verify token refresh doesn't run for non-logged-in users

**Steps:**
1. Open app WITHOUT logging in
2. Open DevTools → Console
3. Check for token refresh logs

**Expected Result:**
- No token refresh logs appear
- Console shows: `ℹ️ Token refresh skipped - user not logged in`
- No errors

**Verification:**
- ✅ Script detects logged-out state via `window.IS_LOGGED_IN`
- ✅ No unnecessary API calls for guests
- ✅ No errors in console

---

### ✅ Test 9: Long Session (23 Hours)
**Goal:** Verify token refresh happens automatically during extended session

**Steps:**
1. Log in to the app at time: 10:00 AM
2. Leave app running (or check logs later)
3. At approximately 9:00 AM next day (23 hours later):
   - Check browser console
   - Check Server logs (storage/logs/user/*)

**Expected Result:**
- Console shows refresh logs at ~9:00 AM
- Server logs show: `Token refreshed proactively at: [timestamp]`
- User can continue using app without interruption

**Verification:**
- ✅ Refresh happens before 24-hour mark
- ✅ Server logs confirm API was called
- ✅ No user is logged out

---

## Quick Manual Test (5 minutes)

```javascript
// In browser console after logging in:

// 1. Check token expiry
console.log('Token expires at:', new Date(getCookie('TokenExpiresAt') * 1000));

// 2. Simulate refresh
fetch('/refreshTokenProactive', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'X-Requested-With': 'XMLHttpRequest'
    }
})
.then(r => r.json())
.then(data => {
    console.log('Refresh response:', data);
    if (data.success) {
        console.log('✅ Token refreshed! New expiry:', new Date(data.expires_at * 1000));
    }
});

// 3. Check updated cookie
setTimeout(() => console.log('Updated expires at:', new Date(getCookie('TokenExpiresAt') * 1000)), 1000);

// Helper function
function getCookie(name) {
    const nameEQ = name + "=";
    return document.cookie.split(';').find(c => c.trim().indexOf(nameEQ) === 0)?.substring(nameEQ.length);
}
```

---

## Server Logs to Check

After testing, check these logs:

**Token Refresh Logs:**
```bash
tail -f storage/logs/user/laravel.log | grep "Token refreshed"
```

**Error Logs:**
```bash
tail -f storage/logs/laravel.log | grep -i "error"
```

**All Requests:**
```bash
grep "refreshTokenProactive" storage/logs/laravel.log
```

---

## Expected Console Output (Full Cycle)

```javascript
🔐 Token refresh system initializing...
🔐 Token expiry time: Thu Aug 28 2026 10:30:45 GMT
⏱️ Time until expiry: 1440 minutes
📅 Scheduling first token refresh in: 1380 minutes
[... wait 23 hours ...]
🔄 Calling token refresh endpoint...
✅ Token refreshed successfully
📅 New expiry: Thu Aug 29 2026 10:30:45 GMT
[... every 20 hours after ...]
🔄 Calling token refresh endpoint...
✅ Token refreshed successfully
```

---

## Troubleshooting

| Issue | Solution |
|-------|----------|
| Token refresh logs don't appear | Check `window.IS_LOGGED_IN` is `true`; check TokenExpiresAt cookie exists |
| 401 errors on refresh | Verify backend `refreshToken` API is working; check API response |
| User still logged out after 24hrs | Verify token-refresh.js is loaded; check Console for errors; clear browser cache |
| Multiple refresh calls | Normal - after first refresh, recurring interval runs every 20 hours |
| TokenExpiresAt cookie not set | Verify setToken() updates; check cookies are enabled in browser |

---

## Summary

✅ **Token Refresh is Working When:**
1. TokenExpiresAt cookie is created on login
2. token-refresh.js loads on every page
3. Console shows scheduling logs
4. Refresh endpoint responds with new token before 24-hour expiry
5. User can browse indefinitely without auto-logout

✅ **Implementation Details:**
- **When:** Refresh scheduled 1 hour before 24-hour expiry
- **Frequency:** Every 20 hours after first refresh
- **Endpoint:** `POST /refreshTokenProactive`
- **Response:** `{ success: true, token, expires_at }`
- **Cookies:** TokenExpiresAt updated with new expiration timestamp
