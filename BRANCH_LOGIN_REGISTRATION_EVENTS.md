# Branch Events: Login & Registration Parameters

## Overview

Branch tracking for login and registration events requires specific parameters to track user acquisition and engagement.

---

## Event 1: Login Event

### Event Name
```javascript
branch('track', 'login');
```

### Required Parameters

| Parameter | Type | Purpose | Example |
|-----------|------|---------|---------|
| `method` | String | Login method used | `'OTP'`, `'PASSWORD'`, `'TRUECALLER'`, `'GOOGLE'`, `'FACEBOOK'` |
| `user_id` | String | User identifier | `'919999999999'` or `'user@example.com'` |
| `email` | String | User email address | `'user@example.com'` |
| `phone` | String | User phone number | `'919999999999'` |

### Optional Parameters

| Parameter | Type | Purpose | Example |
|-----------|------|---------|---------|
| `country` | String | User country code | `'IN'` |
| `login_status` | String | Login success/failure | `'success'`, `'failed'` |
| `timestamp` | Number | Event timestamp | `1629907200000` |

### Complete Example

```javascript
branch('track', 'login', {
    'method': 'OTP',
    'user_id': '919999999999',
    'email': 'user@example.com',
    'phone': '919999999999',
    'country': 'IN',
    'login_status': 'success'
});
```

---

## Event 2: Registration Event

### Event Name
```javascript
branch('track', 'sign_up');
```

### Required Parameters

| Parameter | Type | Purpose | Example |
|-----------|------|---------|---------|
| `method` | String | Registration method | `'OTP'`, `'EMAIL'`, `'TRUECALLER'`, `'GOOGLE'`, `'FACEBOOK'` |
| `user_id` | String | New user identifier | `'919999999999'` |
| `email` | String | Registered email | `'newuser@example.com'` |
| `phone` | String | Registered phone | `'919999999999'` |

### Optional Parameters

| Parameter | Type | Purpose | Example |
|-----------|------|---------|---------|
| `country` | String | User country | `'IN'` |
| `plan_id` | String | Plan selected (if applicable) | `'epic_in_pl_1'` |
| `source` | String | Registration source | `'web'`, `'app'`, `'social'` |
| `registration_status` | String | Registration result | `'success'`, `'failed'` |

### Complete Example

```javascript
branch('track', 'sign_up', {
    'method': 'OTP',
    'user_id': '919999999999',
    'email': 'newuser@example.com',
    'phone': '919999999999',
    'country': 'IN',
    'source': 'web',
    'registration_status': 'success'
});
```

---

## Implementation: Where to Add Tracking

### File 1: Login JavaScript Handler

**File**: `resources/views/auth/login-reg-js.blade.php`

**Location**: After successful OTP verification

```javascript
// After successful login
$.ajax({
    // ... ajax config
    success: function(res) {
        if(res.success == true) {
            // ✅ Track login event
            if(typeof branch !== 'undefined') {
                branch('track', 'login', {
                    'method': 'OTP',  // or 'PASSWORD' depending on method
                    'user_id': res.user_id || '',
                    'email': res.email || '',
                    'phone': res.phone || '',
                    'country': '{{ getCountryCode() }}',
                    'login_status': 'success'
                });
            }
            
            // Redirect to home
            window.location.href = '/';
        }
    }
});
```

### File 2: Registration JavaScript Handler

**File**: `resources/views/auth/login-reg-js.blade.php`

**Location**: After successful registration

```javascript
// After successful registration
$.ajax({
    // ... ajax config
    success: function(res) {
        if(res.success == true) {
            // ✅ Track sign_up event
            if(typeof branch !== 'undefined') {
                branch('track', 'sign_up', {
                    'method': 'OTP',  // or 'EMAIL' depending on method
                    'user_id': res.user_id || '',
                    'email': res.email || '',
                    'phone': res.phone || '',
                    'country': '{{ getCountryCode() }}',
                    'source': 'web',
                    'registration_status': 'success'
                });
            }
            
            // Show verification or redirect
            showSuccessMessage('Registration successful!');
        }
    }
});
```

---

## Implementation: Social Login

### Google Login

```javascript
// After Google login success
branch('track', 'login', {
    'method': 'GOOGLE',
    'user_id': googleUser.getId(),
    'email': googleUser.getEmail(),
    'country': '{{ getCountryCode() }}',
    'login_status': 'success'
});
```

### Facebook Login

```javascript
// After Facebook login success
branch('track', 'login', {
    'method': 'FACEBOOK',
    'user_id': response.userID,
    'email': response.email,
    'country': '{{ getCountryCode() }}',
    'login_status': 'success'
});
```

### Truecaller Login

```javascript
// After Truecaller login success
branch('track', 'login', {
    'method': 'TRUECALLER',
    'user_id': truecallerUser.phone,
    'phone': truecallerUser.phone,
    'country': '{{ getCountryCode() }}',
    'login_status': 'success'
});
```

---

## Implementation: Password Login

```javascript
// After password-based login success
branch('track', 'login', {
    'method': 'PASSWORD',
    'user_id': userId,
    'email': userEmail,
    'country': '{{ getCountryCode() }}',
    'login_status': 'success'
});
```

---

## Error Tracking

### Failed Login

```javascript
branch('track', 'login', {
    'method': 'OTP',
    'user_id': enteredPhoneOrEmail,
    'country': '{{ getCountryCode() }}',
    'login_status': 'failed',
    'error_message': 'Invalid OTP'
});
```

### Failed Registration

```javascript
branch('track', 'sign_up', {
    'method': 'OTP',
    'email': enteredEmail,
    'country': '{{ getCountryCode() }}',
    'registration_status': 'failed',
    'error_message': 'Email already registered'
});
```

---

## Sharing Parameters

For social sharing features, use the `share` event:

### Share Event

```javascript
branch('track', 'share', {
    'share_type': 'email',  // 'email', 'sms', 'social', 'link'
    'shared_content': 'video',  // 'video', 'episode', 'link'
    'content_id': 'video_123',
    'recipient_count': 1
});
```

### Share Parameters

| Parameter | Type | Purpose | Example |
|-----------|------|---------|---------|
| `share_type` | String | How content was shared | `'email'`, `'sms'`, `'whatsapp'`, `'facebook'` |
| `shared_content` | String | What was shared | `'video'`, `'episode'`, `'profile'` |
| `content_id` | String | ID of shared content | `'video_123'` |
| `recipient_count` | Number | Number of recipients | `1`, `5`, etc |
| `referral_code` | String | If referral link | `'EPIC123'` |

---

## Complete Implementation Checklist

### Login Flow

- [ ] Track login with `method` parameter
- [ ] Include `user_id`, `email`, `phone`
- [ ] Add `country` from server
- [ ] Set `login_status` (success/failed)
- [ ] Track for all login methods (OTP, Password, Social)
- [ ] Log errors on failed login

### Registration Flow

- [ ] Track sign_up with `method` parameter
- [ ] Include `user_id`, `email`, `phone`
- [ ] Add `country` from server
- [ ] Set `source` as 'web'
- [ ] Set `registration_status` (success/failed)
- [ ] Track for all registration methods
- [ ] Log errors on failed registration

### Sharing Flow (Optional)

- [ ] Track share events
- [ ] Include share type and method
- [ ] Track shared content ID
- [ ] Track recipient count if applicable

---

## Default.blade.php Setup

**File**: `resources/views/layouts/default.blade.php`

Add this in the `<head>` section:

```html
<!-- Branch SDK -->
<script>
(function(b,r,a,n,c,h,_){
    if(!b[n]){
        b[n]=function(){b[n].q.push(arguments)};
        b[n].q=[];
    }
    h=r.createElement('script');
    h.async=1;
    h.src=a;
    _=r.getElementsByTagName('script')[0];
    _.parentNode.insertBefore(h,_);
})(window,document,'https://cdn.branch.io/branch-latest.min.js','branch');

branch('init', 'YOUR_BRANCH_KEY');  // Replace with your actual key

// Optional: Set user data if already logged in
@if(isUserLoggedIn())
var userData = {!! json_encode(userData()) !!};
if(typeof branch !== 'undefined' && userData) {
    branch('setIdentity', {
        'user_id': userData.user_id,
        'email': userData.email,
        'phone': userData.mobile
    });
}
@endif
</script>
```

---

## Testing Branch Events

### Console Testing

Open browser console and test:

```javascript
// Test login event
branch('track', 'login', {
    'method': 'OTP',
    'user_id': '919999999999',
    'email': 'test@example.com',
    'phone': '919999999999',
    'country': 'IN',
    'login_status': 'success'
});

// Check if event was tracked
console.log('Branch event tracked');
```

### Branch Dashboard

1. Go to Branch Dashboard
2. Analytics → Events
3. Should see `login` and `sign_up` events
4. Filter by user_id or email to verify tracking

---

## Next Steps

1. **Get Branch Key**: From Branch Dashboard (Settings → Account)
2. **Replace 'YOUR_BRANCH_KEY'** in default.blade.php
3. **Add tracking calls** in login-reg-js.blade.php
4. **Test in browser** - Open console and verify events
5. **Check Branch Dashboard** - Verify events appear within 5 minutes
6. **Deploy to production** - Once verified

---

## Common Issues

### Issue: Branch events not tracking

**Cause**: Branch key not set or script not loaded
**Fix**: 
- Verify `YOUR_BRANCH_KEY` replaced with actual key
- Check Network tab - should see `branch-latest.min.js` loaded
- Open Console - check for errors

### Issue: User data not captured

**Cause**: User not logged in or data not passed
**Fix**:
- Ensure user_id, email, phone passed in event
- Verify data available in response
- Check console for undefined values

### Issue: Events appear in dashboard but no user data

**Cause**: Parameters not included in track call
**Fix**:
- Add all required parameters
- Verify parameter names exact match (case-sensitive)
- Check data types (string vs number)

---

## Summary

**Add Branch script** to `default.blade.php`  
**Track login events** with method, user_id, email, phone  
**Track registration** with same parameters  
**Test in console** before deploying  
**Verify in Branch Dashboard** within 5 minutes  

Ready to implement! 🚀
