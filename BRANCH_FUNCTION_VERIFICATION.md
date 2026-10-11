# ✅ Branch Tracking Function Verification

## Status: ✅ VERIFIED - Function is Callable

The `window.trackBranchEvent()` function is **properly available globally** from `default.blade.php` and can be called from any page.

---

## Confirmation: Function Setup

### ✅ Location in default.blade.php (Lines 99-130)

```javascript
/*
 * Global function for Branch custom events
 */
window.trackBranchEvent = function(eventName, eventData) {
    console.log("📤 Branch event called:", eventName, eventData);

    if (typeof window.branch === 'undefined') {
        console.warn("⚠️ Branch SDK not available:", eventName);
        return;
    }

    branch.logEvent(
        eventName,
        eventData || {},
        function(err) {
            if (err) {
                console.error("❌ Branch event failed:", eventName, err);
            } else {
                console.log("✅ Branch event sent:", eventName);
            }
        }
    );
};
```

---

## Why It's Callable

| Aspect | Status | Reason |
|--------|--------|--------|
| **Global Scope** | ✅ | `window.trackBranchEvent` on window object |
| **Defined Before Use** | ✅ | Script runs in head before page content |
| **Available Globally** | ✅ | Defined on `window`, not in function scope |
| **Error Handling** | ✅ | Checks if branch exists before calling |
| **All Pages** | ✅ | Every page extends default.blade.php |

---

## How to Call It

### From Any JavaScript File

```javascript
// Simple event
window.trackBranchEvent('Login', {
    user_id: 'user123',
    email: 'user@example.com'
});

// With full data
window.trackBranchEvent('Register', {
    user_id: 'user456',
    email: 'newuser@example.com',
    phone: '919999999999',
    signup_method: 'email_otp'
});
```

### From Inline Script

```html
<script>
window.addEventListener('load', function() {
    window.trackBranchEvent('PageView', {
        page: 'subscription',
        plan_id: 'epic_in_pl_1'
    });
});
</script>
```

### From Login/Register Form

```javascript
// In login-reg-js.blade.php after successful login
if (res.success) {
    window.trackBranchEvent('Login', {
        user_id: res.user_id,
        email: res.email,
        login_method: 'email'
    });
    
    // Then redirect
    window.location = res.redirect_url;
}
```

---

## Verify It Works in Console

Open DevTools (F12) and run:

```javascript
// Check if function exists
typeof window.trackBranchEvent
// Output: "function" ✅

// Call the function
window.trackBranchEvent('TestEvent', { test: true });
// Console shows:
// 📤 Branch event called: TestEvent {test: true}
// ✅ Branch event sent: TestEvent
```

---

## Console Output Example

When function is called successfully:

```
📤 Branch event called: Login {user_id: "user123", ...}
✅ Branch event sent: Login
```

If Branch SDK not loaded:

```
⚠️ Branch SDK not available: Login
```

If error occurs:

```
❌ Branch event failed: Login Error: ...
```

---

## Summary

✅ **Function is PROPERLY SET UP**
- ✅ Defined globally on `window` object
- ✅ Loaded in default.blade.php head
- ✅ Available before page renders
- ✅ Has error handling
- ✅ Can be called from any JavaScript

**You can call this function from login.js or any other script on your site!**
