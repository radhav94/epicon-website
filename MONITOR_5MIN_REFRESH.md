# Monitor 5-Minute Token Refresh Testing

**Purpose:** Verify token refresh is being called every 5 minutes  
**Test Duration:** 15 minutes minimum (to see at least 3 refresh cycles)

---

## Quick Start (2 Steps)

### Step 1: Start Dev Server & Login
```bash
# Terminal 1: Start server
cd /Users/in10/Desktop/projects/epicon-web
php artisan serve

# Then:
# 1. Open http://localhost:8000
# 2. Login with: anike4@yopmail.com / Test@123
# 3. Keep page open (don't close or navigate away)
```

### Step 2: Monitor Logs in Real Time
```bash
# Terminal 2: Watch logs (opens immediately)
tail -f storage/logs/user/user-*.log | grep -E "(🔄|Token refresh|initiated|response)"

# Or for all logs:
tail -f storage/logs/user/user-*.log
```

---

## What to Expect

### Console Output (DevTools)
```
✅ 🔐 Token refresh system initializing...
✅ 📋 Strategy: Refresh every 5 minutes (for testing)
✅ ✅ StreamKey token found - starting refresh cycle
✅ 🔄 Initial token refresh on page load...
🔄 Token refresh (initial_page_load) - Time: 10:45:59 AM

[Wait 5 minutes...]

🔄 Token refresh (periodic_5min) - Time: 10:50:59 AM
✅ Token refreshed successfully (periodic_5min)

[Wait 5 minutes...]

🔄 Token refresh (periodic_5min) - Time: 10:55:59 AM
✅ Token refreshed successfully (periodic_5min)

[Wait 5 minutes...]

🔄 Token refresh (periodic_5min) - Time: 11:00:59 AM
✅ Token refreshed successfully (periodic_5min)
```

### Server Logs Output
```
🔄 Proactive token refresh initiated (reason: initial_page_load)
📤 Backend response: {"success":false,"message":"Token does not exist"}

[5 minutes later...]

🔄 Proactive token refresh initiated (reason: periodic_5min)
📤 Backend response: {"success":false,"message":"Token does not exist"}

[5 minutes later...]

🔄 Proactive token refresh initiated (reason: periodic_5min)
📤 Backend response: {"success":false,"message":"Token does not exist"}
```

---

## Testing Steps

### Step 1: Login (0:00)
```
1. Open http://localhost:8000
2. Login
3. Open DevTools Console (F12)
4. Look for: "✅ Initial token refresh on page load..."
```

### Step 2: First Refresh Attempt (0:00 - 0:05)
```
1. Check console for: "✅ Token refreshed successfully (initial_page_load)"
2. Note the timestamp
3. Check server logs for refresh attempt
```

### Step 3: Wait for First Periodic Call (5:00)
```
1. Keep page open
2. After exactly 5 minutes, check console
3. Should see: "Token refresh (periodic_5min)" message
4. Check server logs for the refresh attempt
```

### Step 4: Wait for Second Periodic Call (10:00)
```
1. After another 5 minutes (10 min total)
2. Check console again
3. Should see another periodic refresh
```

### Step 5: Wait for Third Periodic Call (15:00)
```
1. After another 5 minutes (15 min total)
2. Check console again
3. Should see third periodic refresh
```

---

## Console Commands to Monitor

### Run This in DevTools Console to See All Refresh Attempts
```javascript
// Show all refresh attempts in table format
const refreshLog = [];
const originalLog = console.log;
console.log = function(...args) {
    if (args.join(' ').includes('🔄') || args.join(' ').includes('Token refresh')) {
        refreshLog.push({
            time: new Date().toLocaleTimeString(),
            message: args.join(' ')
        });
    }
    originalLog.apply(console, args);
};

// View collected refreshes
window.showRefreshLog = function() {
    console.table(refreshLog);
};

// Call this to see all collected refresh attempts
window.showRefreshLog();
```

### Simple Status Check
```javascript
// Paste this to see current refresh status
console.log("=== TOKEN REFRESH STATUS ===");
console.log("1. System Initialized:", !!window.__tokenRefreshInterval);
console.log("2. Interval Active:", window.__tokenRefreshInterval > 0);
console.log("3. Current Time:", new Date().toLocaleTimeString());
console.log("4. Interval ID:", window.__tokenRefreshInterval);
```

---

## Monitoring the Logs

### Open Multiple Log Windows
```bash
# Terminal 2 - User logs (refresh logs)
tail -f storage/logs/user/user-*.log

# Terminal 3 - API logs (backend calls)
tail -f storage/logs/api/api-*.log

# Terminal 4 - Error logs
tail -f storage/logs/error/error-*.log
```

### Filter for Refresh Attempts Only
```bash
# Only show refresh-related logs
tail -f storage/logs/user/user-*.log | grep -i "refresh\|🔄"

# Show with timestamps
tail -f storage/logs/user/user-*.log | grep -E "(🔄|Proactive token refresh)"
```

---

## Expected Log Sequence

**At Login (0:00):**
```
[timestamp] DEV.INFO: 🔄 Proactive token refresh initiated (reason: initial_page_load)
[timestamp] DEV.INFO: 📤 Backend response: {"success":false,"message":"Token does not exist"}
[timestamp] DEV.WARNING: ❌ Proactive token refresh failed (reason: initial_page_load): Token does not exist
```

**Every 5 Minutes (5:00, 10:00, 15:00, etc.):**
```
[timestamp] DEV.INFO: 🔄 Proactive token refresh initiated (reason: periodic_5min)
[timestamp] DEV.INFO: 📤 Backend response: {"success":false,"message":"Token does not exist"}
[timestamp] DEV.WARNING: ❌ Proactive token refresh failed (reason: periodic_5min): Token does not exist
```

---

## Checklist - What Should Happen

### ✅ Initial Refresh (On Login):
- [ ] Console shows "Initial token refresh on page load..."
- [ ] Server logs show refresh attempt with reason: `initial_page_load`
- [ ] Backend response logged (even if error)

### ✅ First Periodic Refresh (5 minutes after login):
- [ ] Console shows "Token refresh (periodic_5min)"
- [ ] Server logs show refresh attempt with reason: `periodic_5min`
- [ ] Time is exactly ~5 minutes after initial refresh

### ✅ Second Periodic Refresh (10 minutes after login):
- [ ] Console shows another "Token refresh (periodic_5min)"
- [ ] Server logs show another refresh attempt
- [ ] Time is exactly ~5 minutes after first periodic refresh

### ✅ Third Periodic Refresh (15 minutes after login):
- [ ] Console shows another "Token refresh (periodic_5min)"
- [ ] Server logs show another refresh attempt
- [ ] Pattern is consistent every 5 minutes

### ✅ Log Entries Consistent:
- [ ] Each refresh has unique timestamp
- [ ] Reason changes appropriately (initial_page_load vs periodic_5min)
- [ ] No errors in console (only backend rejection which is expected)

---

## If Nothing Shows Up

### Check 1: Page Loaded?
```javascript
// In console:
window.IS_LOGGED_IN  // Should be: true
document.cookie      // Should show: StreamKey and TokenExpiresAt
```

### Check 2: Script Loaded?
```javascript
// In console:
typeof window.__tokenRefreshInterval  // Should be: number
window.__tokenRefreshInterval > 0     // Should be: true
```

### Check 3: Interval Started?
```javascript
// In console - this will show if interval is active
setInterval(() => {
    console.log("✅ Interval check at", new Date().toLocaleTimeString());
}, 5000);
```

### Check 4: Server Logs
```bash
# Check for any errors in Laravel logs
tail -f storage/logs/laravel-*.log | grep -i error

# Check if endpoint exists
curl -X POST http://localhost:8000/refreshTokenProactive \
  -H "Content-Type: application/json" \
  -H "Cookie: StreamKey=[your-token]"
```

---

## Timeline Example

**Assume Login at 10:45:00 AM:**

```
10:45:00 - Login successful
10:45:02 - "Initial token refresh on page load..." appears in console
10:45:03 - Server logs show first refresh attempt
10:50:00 - First periodic refresh should fire (5 min later)
10:50:01 - Console shows "Token refresh (periodic_5min)"
10:50:02 - Server logs show periodic refresh
10:55:00 - Second periodic refresh should fire (5 min later)
10:55:01 - Console shows another "Token refresh (periodic_5min)"
11:00:00 - Third periodic refresh should fire (5 min later)
11:00:01 - Console shows another "Token refresh (periodic_5min)"
```

---

## Success Criteria

**All of these should be true:**

✅ Initial refresh fires on page load  
✅ Periodic refresh fires approximately every 5 minutes  
✅ Console shows refresh messages  
✅ Server logs show refresh attempts  
✅ Timestamps increase by ~5 minutes each time  
✅ Reason changes from `initial_page_load` to `periodic_5min`  
✅ No JavaScript errors in console  

**If all ✅** → Token refresh system is working!

---

## Note for Production

**Important:** Change back to 5 hours before production!

Current code (5 minutes for testing):
```javascript
const refreshInterval = 5 * 60 * 1000; // 5 minutes
```

Change to (5 hours for production):
```javascript
const refreshInterval = 5 * 60 * 60 * 1000; // 5 hours
```

File location:
```
/public/assets/js/token-refresh.js
Line: ~45
```

