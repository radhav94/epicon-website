# Debug: StreamKey Cookie Not Found

**Status:** Investigation needed  
**Issue:** Script says "StreamKey cookie not found" but you can see it in DevTools

---

## Troubleshooting Steps

### Step 1: Check the Console Output

**Open DevTools Console (F12) and look for:**

```
🚀 Token refresh script loaded and starting...
⏳ Document still loading - waiting for DOMContentLoaded
✅ DOMContentLoaded fired
🔐 Token refresh system initializing...
📋 Debug: IS_LOGGED_IN = [true or false]
📋 Debug: Full cookies = [cookie string]
🔍 Debug: getCookie("StreamKey") returned: [token or null]
```

**Copy the output and share these specifically:**
- IS_LOGGED_IN value (true or false?)
- Full cookies string
- getCookie("StreamKey") result

### Step 2: Run This in Console

**Paste this command in DevTools Console:**

```javascript
console.log("=== STREAMKEY DEBUG ===");
console.log("1. IS_LOGGED_IN:", window.IS_LOGGED_IN);
console.log("2. Full document.cookie:", document.cookie);
console.log("3. Has 'StreamKey':", document.cookie.includes('StreamKey'));

// Try to manually get StreamKey
var nameEQ = "StreamKey=";
var ca = document.cookie.split(';');
for (var i = 0; i < ca.length; i++) {
    var c = ca[i].trim();
    console.log("Cookie " + i + ":", c.substring(0, 50) + "...");
    if (c.indexOf(nameEQ) === 0) {
        console.log("FOUND StreamKey:", c.substring(nameEQ.length, nameEQ.length + 30) + "...");
    }
}
```

**Expected output:**
```
=== STREAMKEY DEBUG ===
1. IS_LOGGED_IN: true
2. Full document.cookie: StreamKey=eyJhbGc...; TokenExpiresAt=17252...
3. Has 'StreamKey': true
Cookie 0: StreamKey=eyJhbGc...
FOUND StreamKey: eyJhbGc...
```

### Step 3: Manually Trigger Initialization

If the script failed to find the cookie, try initializing it manually:

```javascript
// In DevTools Console:
window.__initTokenRefresh()
```

This will run the initialization with all debug logging.

---

## Possible Issues & Solutions

### Issue 1: IS_LOGGED_IN is FALSE

**Console shows:**
```
IS_LOGGED_IN: false
```

**Solution:**
- You might not be fully logged in
- Try logging out and logging in again
- Check if there's a session issue

**Check:**
```javascript
// In console:
console.log("User logged in?", window.IS_LOGGED_IN);
console.log("Has session?", !!document.cookie.includes('XSRF-TOKEN'));
```

---

### Issue 2: StreamKey Doesn't Exist in Cookies

**Console shows:**
```
Full document.cookie: XSRF-TOKEN=...; ...
// NO StreamKey
```

**Solution:**
- Login process might not be setting the cookie
- Cookie might be HttpOnly (hidden from JavaScript)
- Check backend login response

**Check:**
```javascript
// Check what cookies exist
document.cookie.split(';').forEach(c => {
    console.log(c.split('=')[0].trim());
});
```

**Expected cookies:**
```
StreamKey (JWT token)
TokenExpiresAt (Expiration time)
XSRF-TOKEN (CSRF protection)
```

---

### Issue 3: Cookie is HttpOnly

**Solution:** If StreamKey has HttpOnly flag, JavaScript can't read it!

**Check in DevTools:**
1. Open DevTools → Application → Cookies
2. Click on cookie
3. Look for "HttpOnly" checkbox
   - ✅ Checked = JavaScript can't read it
   - ❌ Unchecked = JavaScript can read it

**If HttpOnly is checked:**
- Backend set it wrong
- Token refresh script can't work with HttpOnly cookies
- Need to change backend to NOT set HttpOnly for StreamKey

---

## What to Share for Debugging

When you run the commands above, please share:

1. **Console output from token-refresh.js:**
```
IS_LOGGED_IN = ?
Full cookies = ?
getCookie("StreamKey") = ?
```

2. **Manual cookie check output:**
```
Has 'StreamKey': true/false
Cookie list with first 50 chars
```

3. **DevTools Application → Cookies screenshot:**
- Does StreamKey cookie exist?
- Is it HttpOnly? (checked or unchecked?)
- What's the Path?
- What's the Domain?

4. **Current page URL:**
- Where did you get this error?
- Were you just logged in?
- Did you refresh the page?

---

## Quick Checklist

- [ ] Logged in successfully?
- [ ] DevTools shows StreamKey in cookies?
- [ ] IS_LOGGED_IN shows true in console?
- [ ] document.cookie contains "StreamKey"?
- [ ] StreamKey is NOT HttpOnly?
- [ ] Ran window.__initTokenRefresh() manually?

---

## Possible Fix: Manual Initialization

If the script can't find the cookie automatically, try this in console:

```javascript
// Force the system to initialize after waiting
setTimeout(() => {
    console.log("=== Manual Init Attempt ===");
    console.log("IS_LOGGED_IN:", window.IS_LOGGED_IN);
    console.log("Has StreamKey:", document.cookie.includes('StreamKey'));
    if (window.IS_LOGGED_IN && document.cookie.includes('StreamKey')) {
        console.log("Calling init...");
        window.__initTokenRefresh();
    } else {
        console.log("Missing: IS_LOGGED_IN or StreamKey");
    }
}, 3000);
```

---

## Debug Console Available

The token refresh script now exposes a function for manual testing:

```javascript
// Manually trigger initialization:
window.__initTokenRefresh()

// Check if active:
window.__tokenRefreshActive

// Check interval ID:
window.__tokenRefreshInterval
```

---

## Next Steps

1. **Run the console commands** above and share output
2. **Check Application → Cookies** and verify StreamKey exists
3. **Verify IS_LOGGED_IN is true** 
4. **Try manual init** with `window.__initTokenRefresh()`

Once I see the console output, I can pinpoint the exact issue!

