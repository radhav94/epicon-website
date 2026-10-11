# ✅ Branch Setup Verification Checklist

## Pre-Flight Checks

- [x] Branch SDK script added to `default.blade.php`
- [x] Branch initialized with test key
- [x] Global `trackBranchEvent()` function created
- [x] Tracking functions added to `login-reg-js.blade.php`
- [x] Console logging enabled for debugging

---

## Verification Steps

### 1️⃣ Check Branch Initialization

**In Browser Console**, run:
```javascript
typeof window.branch !== 'undefined'
```

**Expected Output**: `true`

**If false**:
- Refresh page
- Wait 2-3 seconds
- Check for errors in console

---

### 2️⃣ Check Tracking Function

**In Browser Console**, run:
```javascript
typeof window.trackBranchEvent
```

**Expected Output**: `"function"`

**If "undefined"**:
- Refresh page
- Check if ad-blocker is enabled
- Check network for failed script loads

---

### 3️⃣ Test Manual Event

**In Browser Console**, run:
```javascript
window.trackBranchEvent('test_event', { test: true })
```

**Expected Console Output**:
```
📤 Branch event called: test_event {test: true}
✅ Branch event sent: test_event
```

**If error**:
- Check Branch key is correct
- Check network connection
- Check no errors above in console

---

### 4️⃣ Check Network Requests

**Steps**:
1. Open DevTools (F12)
2. Go to Network tab
3. Run test event again
4. Look for request to `api.branch.io`

**Expected**: Request should appear

**If not appearing**:
- Check if ad-blocker is enabled
- Check if network is blocked
- Check CORS settings

---

### 5️⃣ Test Real Login

**Steps**:
1. Open console (F12)
2. Click Login button
3. Enter phone/email + OTP
4. Click Verify
5. Watch console

**Expected Messages**:
```
🔵 Tracking Branch Login: 919999999999 otp_mobile
📤 Branch event called: login
✅ Branch event sent: login
```

**If not showing**:
- Check Step 1-3 above
- Verify `trackBranchLogin()` function exists
- Check if login was successful

---

### 6️⃣ Verify in Branch Dashboard

**Steps**:
1. Go to: https://dashboard.branch.io
2. Login with your Branch account
3. Go to: Liveview → Events
4. Should see "login" event

**Expected**:
- Event name: "login"
- Event data shows: user_id, method, timestamp

**If not showing**:
- Wait 1-2 minutes for data to sync
- Check if key is correct
- Check if events are firing (Step 5)

---

## Debug Commands

Copy-paste these into browser console:

### Check Everything
```javascript
console.log('Branch loaded:', typeof window.branch !== 'undefined');
console.log('Track function:', typeof window.trackBranchEvent);
console.log('Branch key:', window.branch ? 'Initialized' : 'Not initialized');
```

### Test Event (Copy-paste ready)
```javascript
window.trackBranchEvent('test', {
  user_id: 'test_user_' + Date.now(),
  method: 'test_method'
});
```

### Check All Tracking Functions
```javascript
console.log('trackBranchLogin:', typeof window.trackBranchLogin);
console.log('trackBranchRegistration:', typeof window.trackBranchRegistration);
```

---

## Common Issues & Solutions

| Issue | Symptom | Solution |
|-------|---------|----------|
| Branch not loading | "undefined" in step 1 | Refresh, wait 3s, check network |
| Key wrong | "error" in event | Check key in default.blade.php line ~75 |
| Events not firing | No console messages in step 5 | Verify login was successful |
| Network blocked | No api.branch.io request | Disable ad-blocker, check firewall |
| Delayed sync | Events not in dashboard | Wait 2-3 minutes, refresh dashboard |

---

## Final Confirmation

Once all checks pass:

✅ **Branch Events are now tracking**
✅ **Login events will be captured**
✅ **Registration events will be captured**
✅ **Data flows to Branch Dashboard**
✅ **Ready for analytics**

---

## What's Being Tracked

### On Every Login
- User ID (phone/email)
- Login method (OTP mobile/email, password)
- Timestamp
- Platform (web)

### On Every Registration
- User ID (phone/email)
- User name
- Timestamp
- Platform (web)

---

## Files With Branch Code

1. **`resources/views/layouts/default.blade.php`** (Lines ~40-110)
   - Branch SDK initialization
   - Global trackBranchEvent function

2. **`resources/views/auth/login-reg-js.blade.php`** (End of file)
   - trackBranchLogin function
   - trackBranchRegistration function
   - Integration with success callbacks

---

## Deployment Checklist

Before deploying to production:

- [ ] Branch events working on dev (verified steps 1-6)
- [ ] All tracking functions present
- [ ] Console logging working
- [ ] Events showing in test dashboard
- [ ] Get production Branch key
- [ ] Update key in default.blade.php
- [ ] Test on staging environment
- [ ] Verify events in production dashboard
- [ ] Deploy to production

---

## Support & Next Steps

### If Events Still Not Showing
1. Run all debug commands above
2. Screenshot console output
3. Check Branch Dashboard Liveview
4. Contact support with screenshots

### Enhancements (Future)
- Add subscription event tracking
- Add content view tracking
- Add search tracking
- Custom user properties
- Revenue tracking

### More Info
- Branch Documentation: https://branch.io/developers/
- Test Dashboard: https://dashboard.branch.io
- Support: https://support.branch.io

---

## Status: ✅ READY FOR TESTING

Branch is fully integrated and ready to track user events!
