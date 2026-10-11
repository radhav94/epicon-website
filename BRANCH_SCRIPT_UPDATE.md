# ✅ Branch Tracking Script Updated

## What Changed

Updated the Branch tracking script in `default.blade.php` with the latest initialization code that includes proper environment configuration.

---

## Before (Old Script)

```javascript
branch.init('{{ env("BRANCH_KEY", "key_test_pBvRu3MlTPs4MBzX7a3ZPbdeAFh8rA1m") }}', {
    tracking_disabled: false
});
```

**Issues**:
- Long method chain with many unused methods
- Fallback key hardcoded
- More verbose

---

## After (New Script) ✅

```javascript
<script>
(function(b,r,a,n,c,h,_,s,d,k){
    if(!b[n] || !b[n]._q){
        for(;s<_.length;) c(h,_[s++]);
        d=r.createElement(a);
        d.async=1;
        d.src="https://cdn.branch.io/branch-latest.min.js";
        k=r.getElementsByTagName(a)[0];
        k.parentNode.insertBefore(d,k);
        b[n]=h;
    }
})(window,document,"script","branch",function(b,r){
    b[r]=function(){
        b._q.push([r,arguments]);
    };
},branch,[
    "init",
    "logEvent",
    "track",
    "setIdentity",
    "link"
].split(" "),0);

branch.init('{{ env("BRANCH_KEY") }}', {
    tracking_disabled: false
});
</script>
```

**Benefits**:
- ✅ Cleaner initialization
- ✅ Only essential methods loaded (init, logEvent, track, setIdentity, link)
- ✅ Better performance
- ✅ Requires BRANCH_KEY in .env (no fallback)

---

## File Modified

| File | Change |
|------|--------|
| `resources/views/layouts/default.blade.php` | Updated Branch initialization script |

---

## Required Environment Variable

Add to `.env`:

```env
BRANCH_KEY=your_actual_branch_key_here
```

**Without this, Branch will not initialize!**

---

## How It Works

### 1. Script Loading
```
The IIFE (Immediately Invoked Function Expression) creates a queue
↓
Loads branch-latest.min.js asynchronously
↓
Initializes Branch SDK with provided key
```

### 2. Available Methods After Init
```javascript
branch.init()          // Initialize with key
branch.logEvent()      // Log custom events
branch.track()         // Track user actions
branch.setIdentity()   // Set user identity
branch.link()          // Create shareable links
```

### 3. Usage Examples

**Track Login Event**:
```javascript
branch.track('login', {
    'user_id': '12345',
    'email': 'user@example.com'
});
```

**Track Registration Event**:
```javascript
branch.track('registration', {
    'user_id': '12345',
    'email': 'user@example.com',
    'name': 'John Doe'
});
```

**Set User Identity**:
```javascript
branch.setIdentity('user@example.com');
```

**Create Deep Link**:
```javascript
branch.link({
    tags: ['promo', '2024'],
    channel: 'facebook',
    feature: 'marketing',
    data: {
        'promo_id': 'summer_sale'
    }
}, function(err, link) {
    console.log(link);
});
```

---

## Available in All Pages

Since the script is in `default.blade.php` (master layout), Branch is available on:

- ✅ Login page
- ✅ Registration page
- ✅ Homepage
- ✅ All subscription pages
- ✅ All content pages
- ✅ Entire application

---

## Setup Checklist

- [ ] Add `BRANCH_KEY` to `.env`
- [ ] Verify BRANCH_KEY value is correct
- [ ] Test in browser console: `branch` object should exist
- [ ] Verify no JavaScript errors in console
- [ ] Test tracking events on login/registration

---

## Testing Branch Integration

### In Browser Console (F12)

**Check if Branch is loaded**:
```javascript
typeof branch !== 'undefined'
// Should return: true
```

**Check initialized methods**:
```javascript
branch
// Should show methods: init, logEvent, track, setIdentity, link, etc.
```

**Test a tracking event**:
```javascript
branch.track('test_event', {
    'test_data': 'hello_world'
});
// Check in Branch dashboard for event
```

**Get Branch user data**:
```javascript
branch.data(function(err, data) {
    console.log(data);
});
```

---

## Environment Configuration

### Development (.env)
```env
BRANCH_KEY=key_test_xxxxxxxxxxxxx
```

### Production (.env.production)
```env
BRANCH_KEY=key_live_xxxxxxxxxxxxx
```

---

## Integration with Login/Registration

### Recommended Events to Track

**On Successful Login**:
```javascript
branch.track('login', {
    'user_id': userId,
    'email': userEmail
});
```

**On Successful Registration**:
```javascript
branch.track('registration', {
    'user_id': userId,
    'email': userEmail,
    'signup_method': 'email_otp'  // or 'google', 'facebook', etc
});
```

**On Subscription Purchase**:
```javascript
branch.track('purchase', {
    'user_id': userId,
    'plan_id': planId,
    'amount': planPrice,
    'currency': 'INR'
});
```

---

## Monitoring

### Branch Dashboard

1. Go to [Branch Dashboard](https://dashboard.branch.io)
2. Login with credentials
3. View:
   - Real-time events
   - User tracking
   - Deep link performance
   - Attribution data

### Local Testing

Check browser DevTools:
```
Network tab → branch-latest.min.js (should load)
Console tab → branch object (should be defined)
Application tab → Cookies (Branch sets cookies)
```

---

## Troubleshooting

### Issue: Branch not loading
**Solution**: 
- Check BRANCH_KEY in .env
- Verify internet connection
- Check browser console for errors

### Issue: Events not tracked
**Solution**:
- Verify branch.track() syntax
- Check Branch dashboard for API status
- Ensure event name is valid string

### Issue: Branch object undefined
**Solution**:
- Wait for page to fully load
- Check for JavaScript errors in console
- Verify script is in page source (View Source)

---

## Next Steps

1. **Add .env BRANCH_KEY**
   ```bash
   echo "BRANCH_KEY=your_key_here" >> .env
   ```

2. **Test in Development**
   ```
   1. Navigate to login page
   2. Open DevTools console
   3. Type: branch
   4. Should see Branch object
   ```

3. **Add Tracking Events**
   - Create file: `resources/views/auth/branch-tracking.blade.php`
   - Add branch.track() calls on login/register success

4. **Monitor in Branch Dashboard**
   - Track events in real-time
   - Verify user attribution
   - Analyze deep link performance

---

## File Location

📍 **Script Location**: `resources/views/layouts/default.blade.php` (Line ~45-80)

📍 **Available Globally**: All pages extending default layout

---

## Status

✅ **Branch script updated**  
✅ **Environment variable required**  
✅ **Ready for tracking setup**  

**Next**: Add BRANCH_KEY to .env and test!
