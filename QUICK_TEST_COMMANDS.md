# Quick Test Commands - Paste in DevTools Console

---

## ⚡ One-Liner Tests

### Test 1: Check Current Token Status
```javascript
const exp = parseInt(document.cookie.split('TokenExpiresAt=')[1]?.split(';')[0]); const hrs = (exp - Math.floor(Date.now()/1000)) / 3600; console.log(`✅ Token expires in ${hrs.toFixed(2)} hours at ${new Date(exp*1000).toLocaleTimeString()}`);
```

**Expected Output:**
```
✅ Token expires in 23.98 hours at Sep 2, 2026, 10:30:00 AM
```

---

### Test 2: Manually Trigger Refresh Now
```javascript
fetch('/refreshTokenProactive', {method: 'POST', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'X-Requested-With': 'XMLHttpRequest'}, body: JSON.stringify({reason:'manual_test'})}).then(r => r.json()).then(d => console.log(d.success ? `✅ Refreshed! New expiry: ${new Date(d.expires_at*1000).toLocaleTimeString()}` : `❌ Failed: ${d.message}`));
```

**Expected Output:**
```
✅ Refreshed! New expiry: Sep 2, 2026, 10:30:00 AM
```

---

### Test 3: Simulate Periodic Refresh (Every 6 Seconds)
```javascript
let count = 0; setInterval(() => {const exp = parseInt(document.cookie.split('TokenExpiresAt=')[1]?.split(';')[0]); const hrs = (exp - Math.floor(Date.now()/1000)) / 3600; console.log(`[${++count}] ${new Date().toLocaleTimeString()} - Expires in: ${hrs.toFixed(2)}h`); fetch('/refreshTokenProactive', {method: 'POST', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'X-Requested-With': 'XMLHttpRequest'}, body: JSON.stringify({reason:'periodic_test'})}).then(r => r.json()).then(d => d.success && console.log(`    ✅ Refresh successful`));}, 6000);
```

**Expected Output (repeats every 6 seconds):**
```
[1] 10:30:45 AM - Expires in: 23.98h
    ✅ Refresh successful
[2] 10:30:51 AM - Expires in: 23.98h
    ✅ Refresh successful
[3] 10:30:57 AM - Expires in: 23.98h
    ✅ Refresh successful
```

---

### Test 4: View All Cookies
```javascript
console.log("🍪 ALL COOKIES:"); document.cookie.split('; ').forEach(c => {const [n,v] = c.split('='); console.log(`${n}: ${decodeURIComponent(v).substring(0,30)}${decodeURIComponent(v).length>30 ? '...' : ''}`)});
```

**Expected Output:**
```
🍪 ALL COOKIES:
StreamKey: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...
TokenExpiresAt: 1725350400
XSRF-TOKEN: abc123...
```

---

### Test 5: Monitor Token Expiry (Every 10 Seconds)
```javascript
console.log("⏰ Starting expiry monitor - will log every 10 seconds"); setInterval(() => {const exp = parseInt(document.cookie.split('TokenExpiresAt=')[1]?.split(';')[0]); const sec = exp - Math.floor(Date.now()/1000); console.log(`${new Date().toLocaleTimeString()} - Token expires in: ${Math.floor(sec/3600)}h ${Math.floor((sec%3600)/60)}m`);}, 10000);
```

**Expected Output (repeats):**
```
10:30:45 AM - Token expires in: 23h 59m
10:30:55 AM - Token expires in: 23h 59m
10:31:05 AM - Token expires in: 23h 59m
```

---

## 🎯 Step-by-Step Testing

### Scenario 1: Basic Verification (2 minutes)

**Step 1:** Login and open DevTools Console (F12)

**Step 2:** Run this to verify initial refresh
```javascript
console.clear();
console.log("✅ Checking initial setup...");
console.log("StreamKey:", document.cookie.split('StreamKey=')[1]?.split(';')[0]?.substring(0, 20) + "...");
console.log("TokenExpiresAt:", document.cookie.split('TokenExpiresAt=')[1]?.split(';')[0]);
```

**Step 3:** Scroll up in console to see if you see:
```
✅ 🔐 Token refresh system initializing...
✅ 📋 Strategy: Refresh every 5 hours...
✅ ✅ StreamKey token found...
✅ 🔄 Initial token refresh on page load...
✅ ✅ Token refreshed successfully (initial_page_load)
```

**If YES → ✅ PASS**

---

### Scenario 2: Tab Visibility Test (3 minutes)

**Step 1:** Console should be open and visible

**Step 2:** Click another browser tab (page hidden)

**Step 3:** Wait 5 seconds

**Step 4:** Click back to app tab

**Step 5:** Look in console for:
```
📱 Page became visible - refreshing token
✅ Token refreshed successfully (page_visibility)
```

**If YES → ✅ PASS**

---

### Scenario 3: Periodic Refresh Test (5 minutes)

**Step 1:** Paste and run this in console:
```javascript
let refreshCount = 0;
setInterval(() => {
    fetch('/refreshTokenProactive', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({reason: 'periodic_test'})
    }).then(r => r.json()).then(d => {
        if (d.success) {
            refreshCount++;
            console.log(`[Refresh #${refreshCount}] ✅ Success - Expires at: ${new Date(d.expires_at * 1000).toLocaleTimeString()}`);
        }
    });
}, 6000);
console.log("⏱️ Testing periodic refresh every 6 seconds...");
```

**Step 2:** Wait 30 seconds, you should see ~5 successful refreshes

**Expected output:**
```
⏱️ Testing periodic refresh every 6 seconds...
[Refresh #1] ✅ Success - Expires at: 10:30:51 AM
[Refresh #2] ✅ Success - Expires at: 10:30:57 AM
[Refresh #3] ✅ Success - Expires at: 10:31:03 AM
[Refresh #4] ✅ Success - Expires at: 10:31:09 AM
[Refresh #5] ✅ Success - Expires at: 10:31:15 AM
```

**If YES → ✅ PASS**

---

## 🔍 Debugging Commands

### See Full Token Response
```javascript
fetch('/refreshTokenProactive', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'X-Requested-With': 'XMLHttpRequest'
    },
    body: JSON.stringify({reason: 'debug'})
}).then(r => r.json()).then(d => console.log(JSON.stringify(d, null, 2)));
```

---

### Check If Refresh is Working
```javascript
const before = document.cookie.split('TokenExpiresAt=')[1]?.split(';')[0];
fetch('/refreshTokenProactive', {
    method: 'POST',
    headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'X-Requested-With': 'XMLHttpRequest'},
    body: JSON.stringify({reason: 'check'})
}).then(r => r.json()).then(d => {
    const after = d.expires_at;
    console.log(`Before: ${before}\nAfter:  ${after}\nUpdated: ${after > before ? '✅ YES' : '❌ NO'}`);
});
```

---

### Test Refresh 10 Times (1 minute)
```javascript
(async function() {
    for(let i = 1; i <= 10; i++) {
        console.log(`Refresh attempt ${i}...`);
        const r = await fetch('/refreshTokenProactive', {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'X-Requested-With': 'XMLHttpRequest'},
            body: JSON.stringify({reason: 'test_' + i})
        });
        const d = await r.json();
        console.log(d.success ? `✅ Success` : `❌ Failed: ${d.message}`);
        await new Promise(r => setTimeout(r, 2000));
    }
    console.log("✅ All 10 refresh attempts completed");
})();
```

---

## 📋 Success Checklist

Run each test and verify:

- [ ] **Test 1:** Token status shows ~24 hours
- [ ] **Test 2:** Manual refresh returns success
- [ ] **Test 3:** Periodic refresh works every 6 seconds
- [ ] **Test 4:** Both StreamKey and TokenExpiresAt cookies exist
- [ ] **Test 5:** Token expiry monitor shows consistent time
- [ ] **Tab test:** Visibility refresh fires
- [ ] **Periodic test:** Multiple refreshes succeed

**If ALL ✅ → Token refresh is working perfectly!**

---

## 🚨 Common Issues

### Issue: "StreamKey cookie not found"
```javascript
// Check if user is logged in
console.log("Logged in:", window.IS_LOGGED_IN);
// Should show: true

// Check cookies
console.log(document.cookie);
// Should include StreamKey=
```

### Issue: Refresh returns 401
```javascript
// Check CSRF token
const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
console.log("CSRF Token:", csrf);
// Should not be empty

// Try logging in again
// Then retry refresh test
```

### Issue: Refresh returns 500
```bash
# Check server logs
tail -f storage/logs/laravel-*.log
tail -f storage/logs/error/error-*.log

# Error should show what went wrong
```

---

## 💡 Tips

- **Keep console open** while testing
- **Use Ctrl+Shift+K** to clear console between tests
- **Copy-paste entire commands** - they're designed to work as-is
- **For long tests**, use a stopwatch to track time
- **Check network tab** for actual API calls (Network tab → Filter "refreshTokenProactive")
- **Server must be running**: `php artisan serve`

