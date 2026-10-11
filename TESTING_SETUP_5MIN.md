# Testing Setup - 5-Minute Refresh Intervals

**Date:** September 1, 2026  
**Status:** ✅ Ready for Testing

---

## What Changed

### Modified File:
**`/public/assets/js/token-refresh.js`**

**Change:**
```javascript
// BEFORE (5 hours for production):
const refreshInterval = 5 * 60 * 60 * 1000; // 5 hours in milliseconds

// AFTER (5 minutes for testing):
const refreshInterval = 5 * 60 * 1000; // 5 minutes in milliseconds
```

**Why:** To quickly verify the refresh mechanism works without waiting 5 hours

---

## How to Test

### Terminal 1: Start Server
```bash
cd /Users/in10/Desktop/projects/epicon-web
php artisan serve

# Output should show:
# Laravel development server started: http://127.0.0.1:8000
```

### Terminal 2: Login & Keep Page Open
```
1. Open http://localhost:8000 in browser
2. Login with: anike4@yopmail.com / Test@123
3. Open DevTools (F12)
4. Go to Console tab
5. Keep page open - DON'T CLOSE IT
6. Keep browser tab active (don't switch away)
```

### Terminal 3: Watch Logs (Real-Time Monitoring)
```bash
# Watch for refresh attempts
tail -f storage/logs/user/user-*.log | grep -E "(🔄|initiated|periodic)"

# Alternative - see all logs
tail -f storage/logs/user/user-*.log
```

---

## What You'll See

### In Console (DevTools):

**At Login (0:00):**
```
✅ 🔐 Token refresh system initializing...
✅ 📋 Strategy: Refresh every 5 minutes (for testing)
✅ ✅ StreamKey token found - starting refresh cycle
✅ 🔄 Initial token refresh on page load...
🔄 Token refresh (initial_page_load) - Time: 10:45:59 AM
```

**After 5 Minutes (5:00):**
```
🔄 Token refresh (periodic_5min) - Time: 10:50:59 AM
✅ Token refreshed successfully (periodic_5min)
📅 New expiry: [timestamp]
⏰ Next refresh in 5 minutes at: [time]
💾 Cookies updated - User will stay logged in
```

**After 10 Minutes (10:00):**
```
🔄 Token refresh (periodic_5min) - Time: 10:55:59 AM
✅ Token refreshed successfully (periodic_5min)
```

**After 15 Minutes (15:00):**
```
🔄 Token refresh (periodic_5min) - Time: 11:00:59 AM
✅ Token refreshed successfully (periodic_5min)
```

### In Server Logs:

**File:** `storage/logs/user/user-*.log`

```
[2026-09-01 10:45:59] DEV.INFO: 🔄 Proactive token refresh initiated (reason: initial_page_load) - Current token: eyJhbGciOiJIUzI1Ni...
[2026-09-01 10:45:59] DEV.INFO: 📤 Backend response: {"success":false,"message":"Token does not exist"}
[2026-09-01 10:45:59] DEV.WARNING: ❌ Proactive token refresh failed (reason: initial_page_load): Token does not exist

[2026-09-01 10:50:59] DEV.INFO: 🔄 Proactive token refresh initiated (reason: periodic_5min) - Current token: eyJhbGciOiJIUzI1Ni...
[2026-09-01 10:50:59] DEV.INFO: 📤 Backend response: {"success":false,"message":"Token does not exist"}
[2026-09-01 10:50:59] DEV.WARNING: ❌ Proactive token refresh failed (reason: periodic_5min): Token does not exist

[2026-09-01 10:55:59] DEV.INFO: 🔄 Proactive token refresh initiated (reason: periodic_5min) - Current token: eyJhbGciOiJIUzI1Ni...
```

---

## Quick Verification Checklist

### ✅ Refresh System Started?
```javascript
// Paste in DevTools Console
console.log("✅ System status:");
console.log("IS_LOGGED_IN:", window.IS_LOGGED_IN);
console.log("Interval active:", !!window.__tokenRefreshInterval);
console.log("Interval ID:", window.__tokenRefreshInterval);
```

### ✅ After 5 Minutes - Refresh Fired?
```bash
# Check logs for refresh attempt
grep "periodic_5min" storage/logs/user/user-*.log | tail -1

# Should show a log entry ~5 minutes after login
```

### ✅ After 10 Minutes - Second Refresh?
```bash
# Count refresh attempts
grep "periodic_5min" storage/logs/user/user-*.log | wc -l

# Should show at least 2 entries (initial + 2 periodic = 3 total)
```

### ✅ After 15 Minutes - Third Refresh?
```bash
# Count refresh attempts
grep -E "(initial_page_load|periodic_5min)" storage/logs/user/user-*.log | wc -l

# Should show 4 total entries (1 initial + 3 periodic)
```

---

## Expected Timeline

| Time | What Happens | Console | Logs |
|------|--------------|---------|------|
| 0:00 | Login | Initial refresh message | refresh initiated (initial_page_load) |
| 0:02 | First refresh completes | Shows result | Backend response logged |
| 5:00 | First periodic refresh | periodic_5min message | refresh initiated (periodic_5min) |
| 5:02 | First periodic completes | Shows result | Backend response logged |
| 10:00 | Second periodic refresh | periodic_5min message | refresh initiated (periodic_5min) |
| 10:02 | Second periodic completes | Shows result | Backend response logged |
| 15:00 | Third periodic refresh | periodic_5min message | refresh initiated (periodic_5min) |
| 15:02 | Third periodic completes | Shows result | Backend response logged |

---

## Monitoring Commands

### Watch Refresh Attempts in Real-Time
```bash
tail -f storage/logs/user/user-*.log | grep "🔄"
```

### Count Total Refresh Attempts
```bash
grep -c "Proactive token refresh initiated" storage/logs/user/user-*.log
```

### See Only Periodic Refreshes (Skip Initial)
```bash
grep "periodic_5min" storage/logs/user/user-*.log
```

### Get Timestamps of All Refreshes
```bash
grep "🔄 Proactive" storage/logs/user/user-*.log | cut -d' ' -f1-3
```

### Watch with Timestamps
```bash
tail -f storage/logs/user/user-*.log | grep -E "(🔄|initiated)" | while IFS= read -r line; do
  echo "[$(date +'%H:%M:%S')] $line"
done
```

---

## Troubleshooting

### No Refresh Appearing After 5+ Minutes?

**Check 1: Page Still Open?**
```javascript
// In console
window.IS_LOGGED_IN  // Should be: true
document.cookie      // Should have StreamKey
```

**Check 2: Interval Still Active?**
```javascript
// In console
typeof window.__tokenRefreshInterval  // Should be: number
```

**Check 3: Console Errors?**
```
Look for any red error messages
Check if 'token-refresh.js' loaded successfully
```

**Check 4: Server Running?**
```bash
curl http://localhost:8000
# Should return HTML (not connection refused)
```

---

## Important Notes

⚠️ **This is for testing only!**

The refresh interval is set to 5 minutes for quick testing. For production:

```javascript
// Change this line in /public/assets/js/token-refresh.js:
const refreshInterval = 5 * 60 * 60 * 1000; // 5 hours (production)
```

---

## Summary

**Status:** ✅ Ready to test

**What's happening:**
1. Frontend refreshes token every 5 minutes (instead of 5 hours)
2. Each refresh is logged to console and server logs
3. You can verify by watching console and logs
4. Pattern should repeat: Initial refresh → then every 5 minutes

**Next step:** Follow "How to Test" section above

