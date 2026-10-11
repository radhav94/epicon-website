# Testing Domain-Based Loading for Branch & Clarity

## Quick Test Checklist

### Test 1: Production Domain (www.epicon.in)

```
Access: https://www.epicon.in
Open Browser Console: F12 or Cmd+Option+I
Expected Output:
  ✅ ✅ Branch initialized successfully
  ✅ Branch session data: {...}
  ✅ window.branch object exists
```

**Verify:**
```javascript
// In browser console, run:
typeof window.branch  // Should return "object"
typeof window.trackBranchEvent  // Should return "function"
typeof window.clarity  // May return "object" or "undefined" (Clarity is async)
```

---

### Test 2: Production Domain (epicon.in)

```
Access: https://epicon.in
Open Browser Console: F12 or Cmd+Option+I
Expected Output:
  ✅ ✅ Branch initialized successfully
  ✅ Branch session data: {...}
  ✅ window.branch object exists
```

**Verify:**
```javascript
typeof window.branch  // Should return "object"
```

---

### Test 3: Staging Domain (Non-Production)

```
Access: https://contentapistg-njsapi.epicon.in
       or any staging/dev URL
Open Browser Console: F12 or Cmd+Option+I
Expected Output:
  ⚠️ ⚠️ Branch SDK skipped - not on production domain
  ⚠️ ⚠️ Clarity script skipped - not on production domain
```

**Verify:**
```javascript
typeof window.branch  // Should return "undefined"
typeof window.clarity  // Should return "undefined"
typeof window.trackBranchEvent  // Should return "function" (fallback)
```

---

### Test 4: Local Development (localhost:8000)

```
Access: http://localhost:8000
Open Browser Console: F12 or Cmd+Option+I
Expected Output:
  ⚠️ ⚠️ Branch SDK skipped - not on production domain
  ⚠️ ⚠️ Clarity script skipped - not on production domain
```

**Verify:**
```javascript
typeof window.branch  // Should return "undefined"
typeof window.trackBranchEvent  // Should return "function" (fallback)
```

---

## Manual Event Tracking Test

### Test on Production Domain Only

1. Go to `https://www.epicon.in`
2. Open browser console (F12)
3. Run test event:

```javascript
// Test Branch event
window.trackBranchEvent('test_event', {
    test: true,
    timestamp: new Date().toISOString()
});
```

**Expected Console Output:**
```
📤 Branch event called: test_event {test: true, timestamp: "..."}
✅ Branch event sent: test_event
```

---

## Network Test (Check API Calls)

### On Production Domain

1. Open Network tab: F12 → Network
2. Filter by "clarity" and "branch"
3. Reload page

**Expected Network Requests:**
```
✅ clarity.ms/tag/xs44u7gvsp
✅ cdn.branch.io/branch-latest.min.js
```

### On Staging Domain

1. Open Network tab: F12 → Network
2. Filter by "clarity" and "branch"
3. Reload page

**Expected Network Requests:**
```
❌ No requests to clarity.ms
❌ No requests to cdn.branch.io
```

---

## Console Filter View

### Filter Branch Messages

In browser console, type:
```
Branch
```

This will show only Branch-related logs.

---

## Cookie Test

### Check if Branch Sets Cookies

**On Production Domain:**
```javascript
// Check for Branch cookie
document.cookie  // Should include branch-related cookies
```

**On Staging Domain:**
```javascript
// Check for Branch cookie
document.cookie  // Should NOT include branch-related cookies
```

---

## Script Loading Test

### Check if Scripts Are Loaded

**On Production Domain:**
```javascript
// In console, run:
var scripts = document.getElementsByTagName('script');
for (var i = 0; i < scripts.length; i++) {
    if (scripts[i].src.includes('branch') || scripts[i].src.includes('clarity')) {
        console.log('Found:', scripts[i].src);
    }
}
```

**Expected:**
```
Found: https://cdn.branch.io/branch-latest.min.js
Found: https://www.clarity.ms/tag/xs44u7gvsp
```

**On Staging Domain:**
```
(No output - scripts not loaded)
```

---

## Functional Test Scenarios

### Scenario 1: Login Event on Production

**Steps:**
1. Go to `https://www.epicon.in`
2. Open Console
3. Click Login
4. Look for console message:
   ```
   📤 Branch event called: user_login {...}
   ✅ Branch event sent: user_login
   ```

---

### Scenario 2: Subscription Purchase on Production

**Steps:**
1. Go to `https://www.epicon.in`
2. Click Subscribe
3. Complete payment
4. Look for console messages:
   ```
   📤 Branch event called: plan_selected {...}
   ✅ Branch event sent: plan_selected
   
   📤 Branch event called: payment_successful {...}
   ✅ Branch event sent: payment_successful
   
   📤 Branch event called: subscription_activated {...}
   ✅ Branch event sent: subscription_activated
   ```

---

### Scenario 3: Login Event on Staging (Should Be Silent)

**Steps:**
1. Go to staging URL
2. Open Console
3. Click Login
4. Look for console - should show only business logic logs
5. Should NOT show Branch event messages

---

## Environment-Specific Testing

### Production Environment

```bash
# Test on production domain
curl -I https://www.epicon.in
# Should show Branch and Clarity loading

curl -I https://epicon.in
# Should show Branch and Clarity loading
```

### Staging Environment

```bash
# Test on staging domain
curl -I https://contentapistg-njsapi.epicon.in
# Should NOT show Branch and Clarity loading
```

---

## Automated Check Script

Save this as a test:

```javascript
// Run in browser console on any domain
console.log("=== Domain-Based Loading Test ===");
console.log("Current Domain:", window.location.hostname);
console.log("");

var host = window.location.hostname;
var isProduction = host === 'www.epicon.in' || host === 'epicon.in';

console.log("Is Production Domain:", isProduction);
console.log("");

console.log("Branch SDK Status:");
console.log("  - window.branch exists:", typeof window.branch !== 'undefined');
console.log("  - trackBranchEvent exists:", typeof window.trackBranchEvent === 'function');
console.log("");

console.log("Clarity Status:");
console.log("  - window.clarity exists:", typeof window.clarity !== 'undefined');
console.log("");

if (isProduction) {
    console.log("✅ Expected: Branch and Clarity should be LOADED");
} else {
    console.log("✅ Expected: Branch and Clarity should be SKIPPED");
}
```

---

## Test Results Template

### Test Date: ___________

| Domain | Expected | Actual | Status |
|--------|----------|--------|--------|
| www.epicon.in | Load | | ☐ Pass ☐ Fail |
| epicon.in | Load | | ☐ Pass ☐ Fail |
| staging | Skip | | ☐ Pass ☐ Fail |
| localhost | Skip | | ☐ Pass ☐ Fail |

**Notes:**
- Branch events: ☐ Working ☐ Not Working
- Clarity: ☐ Loading ☐ Not Loading
- Console errors: ☐ None ☐ Yes (describe)

---

## Troubleshooting Test Failures

### Issue: Branch loads on staging (should be skipped)

**Cause:** Domain check logic not working
**Solution:** 
1. Check browser console for exact domain name
2. Verify domain matches `www.epicon.in` or `epicon.in` exactly
3. Check if port is included (e.g., `localhost:8000` won't match)

### Issue: Branch not loading on production

**Cause:** Could be network, permissions, or SDK error
**Solution:**
1. Check Network tab for failed requests to cdn.branch.io
2. Check for JavaScript errors in console
3. Verify domain is exactly `www.epicon.in` or `epicon.in`
4. Check browser extensions blocking scripts

### Issue: trackBranchEvent not available anywhere

**Cause:** Script error
**Solution:**
1. Hard refresh (Cmd+Shift+R on Mac, Ctrl+Shift+R on Windows)
2. Check for JavaScript errors in console
3. Verify browser supports JavaScript

---

## Performance Check

### Page Load Time Impact

**Production Domain (with Branch & Clarity):**
- Measure: Page Load Time
- Expected impact: < 500ms additional

**Staging Domain (without Branch & Clarity):**
- Measure: Page Load Time
- Expected: Faster than production

**Test Command (Chrome DevTools):**
1. Open DevTools (F12)
2. Go to Performance tab
3. Record page load
4. Look for clarity.ms and branch.io requests in timeline

---

## Compliance Check

- ☐ Branch loads only on production domains
- ☐ Clarity loads only on production domains
- ☐ No tracking on staging/dev environments
- ☐ Console messages are clear and helpful
- ☐ Fallback functions prevent JavaScript errors
- ☐ User privacy respected (no dev tracking)

---

## Sign-Off

| Item | Tested By | Date | Status |
|------|-----------|------|--------|
| Production domain loading | | | ☐ Pass |
| Staging domain skipping | | | ☐ Pass |
| Event tracking | | | ☐ Pass |
| Console messages | | | ☐ Pass |
| Network requests | | | ☐ Pass |

