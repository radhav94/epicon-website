# Token Refresh - Verification Steps

**Purpose:** Verify the token refresh system is working correctly after the fix  
**Time Required:** 5-10 minutes for basic checks, 24+ hours for full verification

---

## ⚡ Quick Checks (5 minutes)

### Step 1: Clear Browser Cache & Login
```bash
1. Open DevTools (F12)
2. Application → Cookies → Delete all
3. Clear cache (Ctrl+Shift+Del)
4. Close browser completely
5. Reopen and login
```

### Step 2: Check Console for Initialization
```javascript
// After login, open DevTools Console and look for:

✅ 🔐 Token refresh system initializing...
✅ 🔐 Token expiry time: [Your Date Time]
✅ ⏱️ Time until expiry: 1440 minutes (should be ~24 hours)
✅ 📅 Scheduling first token refresh in: 1380 minutes (should be ~23 hours)
```

✅ **If you see these 4 messages → PASS**  
❌ **If not → Issue with token-refresh.js initialization**

### Step 3: Verify TokenExpiresAt Cookie
```
DevTools → Application → Cookies → your-domain.com
Look for: TokenExpiresAt

Value should be: Unix timestamp (e.g., 1725350400)
Domain: your-domain.com
Path: /
Expires: 10 years from now
SameSite: Lax
```

✅ **If cookie exists with valid Unix timestamp → PASS**  
❌ **If missing or invalid → Issue with setToken() in backend**

### Step 4: Verify StreamKey Cookie
```
DevTools → Application → Cookies → your-domain.com
Look for: StreamKey

Value: Your JWT token (long string)
Domain: your-domain.com
Path: /
Expires: 10 years from now
HttpOnly: Yes (should be for security)
```

✅ **If both cookies exist → PASS**  
❌ **If missing → Issue with token setup**

---

## 🔍 Medium Checks (30 minutes)

### Step 5: Monitor Network Requests
```
1. Open DevTools → Network tab
2. Keep the page open for 5+ minutes
3. Look for POST requests to /refreshTokenProactive
4. Click on the request and check:
   - Status: 200 (success)
   - Response: { "success": true, "expires_at": [timestamp] }
```

✅ **If you see successful requests → PASS**  
❌ **If no requests appear → Check if 23 hours from login yet**  
❌ **If 401 or 500 errors → Issue with backend endpoint**

### Step 6: Check Server Logs
```bash
# Check user activity logs
tail -f storage/logs/user/user-*.log

# Look for messages like:
✅ Token set. Expires at: [time] (Unix: [timestamp])
✅ Token refreshed proactively. New expiry: [time]
```

✅ **If you see these logs → PASS**  
❌ **If no logs appear → Check if logging is configured**

### Step 7: Test Tab Switch Scenario
```
1. Login to the app
2. Leave app in one tab
3. Open DevTools in that tab
4. Switch to a different browser tab for 30+ seconds
5. Switch back to the app tab
6. Check console for:
```

```javascript
// You should see:
📱 Page became visible - checking if token refresh needed
// And possibly:
🔄 Calling token refresh endpoint (visibility)...
✅ Token refreshed successfully (visibility)
```

✅ **If you see visibility refresh message → PASS**  
❌ **If not → Tab visibility listener may not be working**

---

## 📅 Long-Term Checks (24+ hours)

### Step 8: Schedule Token Refresh Test
```
1. Login at time: T=0 (note the exact time)
2. Leave browser open or visit periodically
3. At T=23 hours, monitor the console/network
4. Look for automatic token refresh
5. Verify TokenExpiresAt cookie updates to T+24 hours
```

**Expected Timeline:**
```
T=0h: Login
     ✅ TokenExpiresAt = T+24h

T=23h: Auto-refresh triggered
      ✅ POST /refreshTokenProactive
      ✅ TokenExpiresAt = T+47h (T + 23h + 24h)
      ✅ Console: "✅ Token refreshed successfully (scheduled)"

T=43h: Second auto-refresh
      ✅ POST /refreshTokenProactive
      ✅ TokenExpiresAt = T+67h
      
T=63h: Third auto-refresh
      ✅ POST /refreshTokenProactive
      ✅ TokenExpiresAt = T+87h
```

✅ **If refreshes happen automatically → PASS**  
❌ **If user logs out at T=24h → Still has the original issue**

### Step 9: Test After 24 Hours Inactivity
```
1. Login at T=0
2. Don't visit the page for 25+ hours
3. Come back to the page
4. Check if still logged in
```

✅ **If still logged in → PASS** (tab visibility listener did its job)  
❌ **If logged out → Issue with visibility refresh**

### Step 10: Test Browser Close/Reopen
```
1. Login at T=0
2. Close browser completely at T=20h
3. Reopen browser at T=24.5h
4. Go back to the app
5. Check if still logged in
```

⚠️ **Expected: Logged out** (fresh page load, token expired)  
✅ **This is correct behavior** - you need to be within 24-hour window

```
1. Login at T=0
2. Close browser completely at T=22h
3. Reopen browser at T=22.5h (still within 24h)
4. Go back to the app
5. Check if still logged in
```

✅ **If still logged in → PASS**  
✅ **If token auto-refreshes on page load → PASS**

---

## 🐛 Troubleshooting

### Console shows: "TokenExpiresAt cookie not found"
**Cause:** Cookie not set on login  
**Fix:**
```
1. Check setToken() function in helpers.php
2. Verify setToken() is being called during login
3. Check if cookies are enabled in browser
4. Check if domain/path settings are correct
```

### Console shows: "Token already expired!"
**Cause:** TokenExpiresAt timestamp is in the past  
**Fix:**
```
1. Check server time synchronization
2. Verify setToken() is setting correct Unix timestamp
3. Check if TokenExpiresAt is being updated on refresh
4. May need: ntpdate -s time.nist.gov (server time)
```

### POST /refreshTokenProactive returns 401
**Cause:** User not authenticated on backend  
**Fix:**
```
1. Check if StreamKey cookie is still valid
2. Verify backend refreshToken API is working
3. Check authentication middleware
4. Check if session has expired on server
```

### POST /refreshTokenProactive returns 500
**Cause:** Backend error  
**Fix:**
```
1. Check storage/logs/error/error-*.log
2. Check storage/logs/user/user-*.log
3. Verify refreshToken API endpoint is accessible
4. Check for PHP errors in server logs
```

### Token refresh happens but TokenExpiresAt doesn't update
**Cause:** Cookie update failed on frontend  
**Fix:**
```
1. Check if cookies are enabled
2. Verify SameSite setting allows cookie update
3. Check for JavaScript errors in console
4. Clear cache and retry
```

### User logs out at exactly 24 hours
**Cause:** Token refresh not happening in time  
**Fix:**
```
1. Verify first refresh is scheduled for 1380 minutes (~23 hours)
2. Check if browser was closed before refresh time
3. Check network for failed /refreshTokenProactive calls
4. Check server logs for refresh failures
5. Verify both cookies (StreamKey and TokenExpiresAt) exist
```

---

## ✅ Final Verification Checklist

- [ ] Console shows "Token refresh system initializing..." on page load
- [ ] TokenExpiresAt cookie exists with valid Unix timestamp
- [ ] StreamKey cookie exists with JWT token
- [ ] No JavaScript errors in console
- [ ] Server logs show "Token set" on login
- [ ] Tab switch triggers visibility refresh (if < 2 hours to expiry)
- [ ] First auto-refresh happens around 23 hours
- [ ] Auto-refresh updates TokenExpiresAt cookie
- [ ] Periodic refresh happens every 20 hours
- [ ] User stays logged in after 24 hours
- [ ] POST /refreshTokenProactive returns 200 with valid response
- [ ] No 401/403 errors during refresh
- [ ] No 500 errors from backend

---

## 📞 Debug Commands

### Check if refreshToken API is working:
```bash
curl -X POST https://backend-api/refreshToken \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json"

# Should return: { "success": true, "token": "..." }
```

### Check server time (should match browser):
```javascript
// In DevTools Console:
console.log("Server time:", new Date({{ time() * 1000 }}));
console.log("Browser time:", new Date());
// Should be within 1 second of each other
```

### Monitor all cookies:
```javascript
// In DevTools Console:
document.cookie.split('; ').forEach(c => {
  const [name, value] = c.split('=');
  console.log(name + ':', decodeURIComponent(value).substring(0, 50));
});
```

### Check token expiration:
```javascript
// In DevTools Console:
const exp = parseInt(document.cookie.split('TokenExpiresAt=')[1].split(';')[0]);
const now = Math.floor(Date.now() / 1000);
const diff = exp - now;
console.log('Expires in:', Math.floor(diff / 3600), 'hours', Math.floor((diff % 3600) / 60), 'minutes');
```

---

## 📊 Success Indicators

✅ All tests pass → Token refresh working correctly  
✅ User stays logged in for 24+ hours → Success  
✅ Auto-refresh happens invisibly → Good UX  
✅ No console errors → Clean implementation  
✅ Server logs show refresh attempts → Proper tracking  

