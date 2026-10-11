# Local Testing Guide - Token Refresh (5-Hour Strategy)

**Purpose:** Test token refresh without waiting 5 hours  
**Time Required:** 10-15 minutes  
**Tools Needed:** Browser DevTools, Laravel dev server

---

## 🚀 Quick Start (5 Minutes)

### Step 1: Start Your Local Dev Server
```bash
cd /Users/in10/Desktop/projects/epicon-web

# Start PHP development server
php artisan serve

# Or if using a specific port
php artisan serve --port=8000

# Output should show:
# Laravel development server started: http://127.0.0.1:8000
```

### Step 2: Login to Your App
```
1. Open http://localhost:8000 in browser
2. Login with test credentials
3. Open DevTools (F12)
4. Go to Console tab
```

### Step 3: Verify Initial Setup
```
You should see in console:
✅ 🔐 Token refresh system initializing...
✅ 📋 Strategy: Refresh every 5 hours to prevent 24-hour backend expiry
✅ ✅ StreamKey token found - starting refresh cycle
✅ 🔄 Initial token refresh on page load...
✅ 📅 Setting up periodic refresh every 5 hours
✅ ✅ Token refreshed successfully (initial_page_load)
✅ 📅 New expiry: [24 hours from now]
✅ ⏰ Next refresh in 5 hours at: [time]
✅ 💾 Cookies updated - User will stay logged in
```

---

## ⏱️ Testing the 5-Hour Interval (10 Minutes)

### Option A: Speed Up Using Console (Instant)

**Modify refresh interval in console to 10 seconds for testing:**

```javascript
// Paste this in DevTools Console while logged in:

// Stop the current interval first
clearInterval(window.__tokenRefreshInterval);

// Override the 5-hour interval with 10 seconds for testing
window.__tokenRefreshInterval = setInterval(function() {
    console.log("🔄 SIMULATED 5-hour periodic refresh at: " + new Date().toLocaleTimeString());
    // Trigger refresh
    const formData = new FormData();
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    fetch('/refreshTokenProactive', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ reason: 'periodic_5hour_test' })
    }).then(r => r.json()).then(d => {
        console.log("✅ Periodic refresh response:", d);
    });
}, 10 * 1000); // 10 seconds instead of 5 hours

console.log("⚙️ Token refresh interval modified to 10 seconds for testing");
console.log("⏰ Watch console for refreshes every 10 seconds");
```

**What to expect:**
```
Every 10 seconds, you'll see:
🔄 SIMULATED 5-hour periodic refresh at: 10:30:45 AM
✅ Periodic refresh response: { success: true, expires_at: [...], ... }

This simulates what happens every 5 hours in production
```

---

## 🔍 Step-by-Step Manual Testing

### Step 1: Clear Cache & Login Fresh
```bash
# Clear Laravel cache
php artisan cache:clear

# Optional: Clear all cookies
# DevTools → Application → Cookies → Delete All

# Then login fresh
```

### Step 2: Verify Cookie Structure
```
Open DevTools → Application → Cookies → localhost:8000

You should see:
✅ StreamKey
   - Value: [JWT token starting with eyJ...]
   - Path: /
   - HttpOnly: Yes (secure)

✅ TokenExpiresAt  
   - Value: [Unix timestamp, e.g., 1725350400]
   - Path: /
   - Expires: 10 years
```

### Step 3: Monitor Initial Refresh
```
1. After login, console shows:
   🔄 Initial token refresh on page load...
   
2. Wait 2-3 seconds for response:
   ✅ Token refreshed successfully (initial_page_load)
   
3. Verify cookies updated:
   TokenExpiresAt changed to new timestamp
```

### Step 4: Test Tab Visibility Refresh
```
1. While logged in and console open
2. Click another tab (page becomes hidden)
3. Wait 5+ seconds
4. Click back to app tab
5. Look in console for:
   📱 Page became visible - refreshing token
   ✅ Token refreshed successfully (page_visibility)
```

### Step 5: Test Page Unload Refresh
```
1. While logged in and console open
2. Press F5 to refresh page
3. Before page reloads completely, look for:
   👋 Page unloading - refreshing token for next visit
   
4. Page reloads and shows initial refresh again
```

---

## 🧪 Advanced Testing Scenarios

### Scenario 1: Simulate 5-Hour Wait (Fast Forward)
```javascript
// In DevTools Console:

// Modify token-refresh.js to use shorter intervals
// 1 minute = 60,000 ms, use 6 seconds for demo

// Add this debug function:
window.testTokenRefresh = function(intervalSeconds = 6) {
    console.log("⚙️ Starting fast-track token refresh test");
    console.log("🔄 Refresh will happen every " + intervalSeconds + " seconds");
    
    setInterval(function() {
        console.log("🔄 SIMULATED periodic refresh at " + new Date().toLocaleTimeString());
        
        fetch('/refreshTokenProactive', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ reason: 'test_periodic' })
        })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                console.log("✅ Refresh successful");
                console.log("📅 New expiry: " + new Date(d.expires_at * 1000).toLocaleTimeString());
                
                // Update cookie display
                const oldCookie = document.cookie.split('TokenExpiresAt=')[1].split(';')[0];
                console.log("🔄 TokenExpiresAt updated: " + oldCookie + " → " + d.expires_at);
            }
        });
    }, intervalSeconds * 1000);
};

// Call it:
window.testTokenRefresh(6);  // Refresh every 6 seconds
```

**Expected Output:**
```
Every 6 seconds you'll see:
🔄 SIMULATED periodic refresh at 10:30:45 AM
✅ Refresh successful
📅 New expiry: 10:30:51 AM
🔄 TokenExpiresAt updated: 1725350445 → 1725350451
```

### Scenario 2: Verify Token Expiration Never Happens
```javascript
// In DevTools Console:

// Monitor TokenExpiresAt continuously
window.monitorTokenExpiry = function() {
    setInterval(function() {
        const expiresAt = parseInt(document.cookie.split('TokenExpiresAt=')[1].split(';')[0]);
        const now = Math.floor(Date.now() / 1000);
        const hoursUntilExpiry = (expiresAt - now) / 3600;
        
        console.log("⏰ Token expires in: " + hoursUntilExpiry.toFixed(2) + " hours");
        
        if (hoursUntilExpiry < 0) {
            console.error("❌ TOKEN EXPIRED!");
        }
    }, 10000);  // Check every 10 seconds
};

window.monitorTokenExpiry();
```

### Scenario 3: Check Refresh Reason Tracking
```javascript
// In DevTools Console:

// Filter logs to see only token refresh messages
console.log("🔍 Filtering console for token refresh messages...");
console.log("🔄 Token refresh reasons seen so far:");

// Run this in console to see patterns
console.table([
    { reason: 'initial_page_load', when: 'On login/page load' },
    { reason: 'periodic_5hour', when: 'Every 5 hours' },
    { reason: 'page_visibility', when: 'When user returns to tab' },
    { reason: 'test_periodic', when: 'When you manually trigger' }
]);
```

---

## 📊 Testing Checklist

### Basic Tests (5 min):
- [ ] Login succeeds
- [ ] Console shows "Token refresh system initializing..."
- [ ] Initial refresh happens automatically
- [ ] TokenExpiresAt cookie created with Unix timestamp
- [ ] StreamKey cookie contains JWT token
- [ ] No JavaScript errors in console

### Medium Tests (10 min):
- [ ] Switch to another tab
- [ ] Switch back to app tab
- [ ] Console shows "Page became visible - refreshing token"
- [ ] TokenExpiresAt cookie updated to new timestamp
- [ ] Refresh response shows "success: true"

### Advanced Tests (15 min):
- [ ] Use test interval (6 seconds) to simulate periodic refresh
- [ ] Verify TokenExpiresAt updates after each refresh
- [ ] Monitor token expiry time stays ~24 hours
- [ ] Token never expires while monitoring
- [ ] Check server logs for refresh attempts

---

## 🔧 Debugging Console Commands

### Check Current Token Status:
```javascript
// Paste in DevTools Console:

const streamKey = document.cookie.split('StreamKey=')[1]?.split(';')[0];
const expiresAt = parseInt(document.cookie.split('TokenExpiresAt=')[1]?.split(';')[0]);
const now = Math.floor(Date.now() / 1000);
const expiresIn = expiresAt - now;

console.log("📊 TOKEN STATUS:");
console.log("Token (first 20 chars): " + streamKey?.substring(0, 20) + "...");
console.log("Expires at (Unix): " + expiresAt);
console.log("Expires in: " + (expiresIn / 3600).toFixed(2) + " hours");
console.log("Expires at (local): " + new Date(expiresAt * 1000).toLocaleString());
```

### Manually Trigger Refresh:
```javascript
// In DevTools Console:

fetch('/refreshTokenProactive', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'X-Requested-With': 'XMLHttpRequest'
    },
    body: JSON.stringify({ reason: 'manual_test' })
})
.then(r => r.json())
.then(d => {
    console.log("🔄 MANUAL REFRESH RESPONSE:");
    console.log(d);
    if (d.success) {
        console.log("✅ Success! New token expires at: " + new Date(d.expires_at * 1000).toLocaleString());
    }
});
```

### View All Cookies:
```javascript
// In DevTools Console:

console.log("🍪 ALL COOKIES:");
document.cookie.split('; ').forEach(c => {
    const [name, value] = c.split('=');
    console.log(name + ": " + decodeURIComponent(value).substring(0, 50) + (decodeURIComponent(value).length > 50 ? "..." : ""));
});
```

### Monitor Refresh Events:
```javascript
// In DevTools Console:

// Clear previous logs
console.clear();

// Start monitoring
console.log("🔍 Monitoring token refresh events...");

// Filter console to show only refresh messages
const originalLog = console.log;
const originalError = console.error;
const refreshLogs = [];

console.log = function(...args) {
    const msg = args.join(' ');
    if (msg.includes('🔄') || msg.includes('✅') || msg.includes('token')) {
        refreshLogs.push({
            time: new Date().toLocaleTimeString(),
            message: msg
        });
    }
    originalLog.apply(console, args);
};

// View collected logs
window.viewRefreshLogs = function() {
    console.table(refreshLogs);
};

console.log("✅ Monitoring started. Call window.viewRefreshLogs() to see events");
```

---

## 📈 Expected Behavior

### Perfect Behavior (All Green):
```
✅ Initial refresh on page load (0 seconds)
✅ Periodic refresh every 6 seconds (in test mode)
✅ Tab visibility refresh when switching tabs
✅ Page unload refresh when leaving
✅ TokenExpiresAt always updates to ~24 hours from now
✅ No errors in console
✅ No unexpected logouts
```

### Issues to Watch For:

**Issue: No initial refresh**
```
❌ Console shows "TokenExpiresAt cookie not found"
✅ Solution: Make sure user is fully logged in
✅ Solution: Check StreamKey cookie exists
✅ Solution: Reload page
```

**Issue: Refresh returns 401**
```
❌ Console shows "Unauthorized (401)"
✅ Solution: Session expired on backend
✅ Solution: Login again
✅ Solution: Check backend API is working
```

**Issue: Refresh returns 500**
```
❌ Console shows "Token refresh error: HTTP 500"
✅ Solution: Check Laravel logs: storage/logs/laravel-*.log
✅ Solution: Check refreshToken API endpoint
✅ Solution: Verify backend is running
```

---

## 🔗 Server-Side Logging

### View Refresh Attempts in Logs:
```bash
# Watch user activity logs in real-time:
tail -f storage/logs/user/user-*.log

# You should see:
✅ Token set. Expires at: 2026-09-02 10:30:00 (Unix: 1725350400)
✅ Token refreshed proactively. New expiry: 2026-09-02 15:30:00 (reason: initial_page_load)
✅ Token refreshed proactively. New expiry: 2026-09-02 20:30:00 (reason: periodic_5hour)

# Watch error logs:
tail -f storage/logs/error/error-*.log
```

### Check Refresh Endpoint Response:
```bash
# Test the refresh endpoint directly:
curl -X POST http://localhost:8000/refreshTokenProactive \
  -H "X-CSRF-TOKEN: your-csrf-token" \
  -H "Content-Type: application/json" \
  -H "Cookie: StreamKey=your-jwt-token" \
  -d '{"reason":"test"}'

# Expected response:
{
  "success": true,
  "token": "eyJ...",
  "expires_at": 1725350400,
  "timestamp": "2026-09-02 10:30:00",
  "reason": "test"
}
```

---

## ⚡ Quick Test Commands (Copy-Paste Ready)

### Test 1: Check Status
```javascript
// Show current token status
const exp = parseInt(document.cookie.split('TokenExpiresAt=')[1]?.split(';')[0]);
const hrs = (exp - Math.floor(Date.now()/1000)) / 3600;
console.log(`Token expires in ${hrs.toFixed(2)} hours (${new Date(exp*1000).toLocaleString()})`);
```

### Test 2: Simulate 5-Hour Cycle (Every 6 Seconds)
```javascript
// Start fast-track refresh testing
setInterval(() => {
    fetch('/refreshTokenProactive', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({reason: 'test_periodic'})
    }).then(r => r.json()).then(d => {
        if (d.success) console.log(`✅ Refresh #${Math.floor(Date.now()/1000) % 100} - Expires: ${new Date(d.expires_at*1000).toLocaleTimeString()}`);
    });
}, 6000);
```

### Test 3: Monitor Expiry
```javascript
// Watch token expiry time every 10 seconds
setInterval(() => {
    const exp = parseInt(document.cookie.split('TokenExpiresAt=')[1]?.split(';')[0]);
    const hrs = (exp - Math.floor(Date.now()/1000)) / 3600;
    console.log(`⏰ ${new Date().toLocaleTimeString()} - Token expires in: ${hrs.toFixed(2)}h`);
}, 10000);
```

---

## ✅ Success Criteria

Your testing is successful when:

✅ Token refreshes immediately on page load  
✅ Periodic refresh fires (every 6 seconds in test mode)  
✅ Tab visibility refresh works  
✅ TokenExpiresAt always shows ~24 hours until expiry  
✅ No 401/500 errors  
✅ Console shows success messages  
✅ User never logs out unexpectedly  

**If all ✅ → Token refresh system is working correctly!**

