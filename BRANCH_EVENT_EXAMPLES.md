# Branch Event Tracking Examples

## Global Helper Function

The global `trackBranchEvent()` function is available everywhere:

```javascript
window.trackBranchEvent(eventName, eventData);
```

---

## Login Event

### Track After Successful Login

**File**: `resources/views/auth/login-reg-js.blade.php` or in controller response

```javascript
// After OTP verification success
function onLoginSuccess(response) {
    console.log('Login successful');
    
    // Track login event
    window.trackBranchEvent('login', {
        'event_description': 'User Login',
        'userId': response.user_id,
        'method': 'phone_otp',  // Could be: email_otp, google, facebook, etc
        'phone': response.phone,
        'email': response.email,
        'timestamp': new Date().toISOString(),
        'device_type': 'web'
    });
    
    // Then redirect or update UI
    location.href = '/';
}
```

### Track Different Login Methods

```javascript
// Phone OTP Login
trackBranchEvent('login', {
    'event_description': 'Phone OTP Login',
    'method': 'phone_otp',
    'country_code': '91',
    'timestamp': new Date().toISOString()
});

// Email Login
trackBranchEvent('login', {
    'event_description': 'Email Login',
    'method': 'email_otp',
    'timestamp': new Date().toISOString()
});

// Google Login
trackBranchEvent('login', {
    'event_description': 'Google Social Login',
    'method': 'google',
    'timestamp': new Date().toISOString()
});

// Facebook Login
trackBranchEvent('login', {
    'event_description': 'Facebook Social Login',
    'method': 'facebook',
    'timestamp': new Date().toISOString()
});

// Truecaller Login
trackBranchEvent('login', {
    'event_description': 'Truecaller Login',
    'method': 'truecaller',
    'timestamp': new Date().toISOString()
});
```

---

## Registration Event

### Track After Successful Registration

```javascript
// After successful signup
function onRegistrationSuccess(response) {
    console.log('Registration successful');
    
    // Track registration event
    window.trackBranchEvent('register', {
        'event_description': 'User Registration',
        'userId': response.user_id,
        'method': 'phone_otp',  // How user registered
        'phone': response.phone,
        'email': response.email,
        'name': response.name,
        'timestamp': new Date().toISOString(),
        'device_type': 'web',
        'country': '91'  // Country code
    });
    
    // Then show success message
    showSuccessMessage('Registration successful!');
}
```

### Track Different Registration Methods

```javascript
// Phone-based Registration
trackBranchEvent('register', {
    'event_description': 'Phone Registration',
    'method': 'phone_otp',
    'timestamp': new Date().toISOString()
});

// Email-based Registration
trackBranchEvent('register', {
    'event_description': 'Email Registration',
    'method': 'email',
    'timestamp': new Date().toISOString()
});

// Social Registration
trackBranchEvent('register', {
    'event_description': 'Google Social Registration',
    'method': 'google',
    'timestamp': new Date().toISOString()
});
```

---

## Subscription Events

### Track Purchase

```javascript
// After successful subscription payment
trackBranchEvent('purchase', {
    'event_description': 'Premium Subscription Purchase',
    'revenue': 199,
    'currency': 'INR',
    'plan_id': 'epic_in_pl_1',
    'plan_name': 'Premium',
    'validity_days': 30,
    'payment_method': 'razorpay',
    'payment_mode': 'UPI',  // or: Debit Card, Credit Card, Netbanking, etc
    'transaction_id': 'pay_xxx',
    'is_recurring': true,
    'timestamp': new Date().toISOString()
});
```

### Track Free Trial Signup

```javascript
trackBranchEvent('start_free_trial', {
    'event_description': 'Free Trial Started',
    'plan_id': 'epic_in_pl_1',
    'plan_name': 'Premium',
    'trial_period_days': 2,
    'discounted_price': 1,
    'original_price': 199,
    'timestamp': new Date().toISOString()
});
```

### Track Subscription Cancel

```javascript
trackBranchEvent('cancel_subscription', {
    'event_description': 'Subscription Cancelled',
    'plan_id': 'epic_in_pl_1',
    'plan_name': 'Premium',
    'reason': 'User request',
    'subscription_duration_days': 30,
    'timestamp': new Date().toISOString()
});
```

---

## Content Events

### Track Content View

```javascript
trackBranchEvent('view_item', {
    'event_description': 'Content Viewed',
    'content_id': 'show_123',
    'content_type': 'tv_show',  // tv_show, movie, short, etc
    'content_name': 'Show Name',
    'category': 'Drama',
    'duration_watched_seconds': 300,
    'total_duration_seconds': 600,
    'timestamp': new Date().toISOString()
});
```

### Track Content Share

```javascript
trackBranchEvent('share', {
    'event_description': 'Content Shared',
    'content_id': 'episode_456',
    'content_type': 'episode',
    'share_channel': 'whatsapp',  // whatsapp, facebook, twitter, etc
    'timestamp': new Date().toISOString()
});
```

### Track Content Search

```javascript
trackBranchEvent('search', {
    'event_description': 'Content Search',
    'search_query': 'romantic comedy',
    'search_results_count': 12,
    'selected_result': 'show_789',
    'timestamp': new Date().toISOString()
});
```

### Track Content Add to Wishlist

```javascript
trackBranchEvent('add_to_wishlist', {
    'event_description': 'Content Added to Wishlist',
    'content_id': 'show_999',
    'content_type': 'tv_show',
    'wishlist_count': 5,
    'timestamp': new Date().toISOString()
});
```

---

## Implementation in Controllers

### In PHP Controller (Laravel)

After user action, send response that triggers JavaScript tracking:

```php
// SubscriptionController.php
public function buySubscription(Request $request)
{
    // ... process subscription ...
    
    return response()->json([
        'success' => true,
        'message' => 'Subscription purchased',
        'data' => [
            'plan_id' => $planId,
            'amount' => $amount,
            'transaction_id' => $txnId,
        ],
        'track_event' => [
            'name' => 'purchase',
            'data' => [
                'revenue' => $amount,
                'currency' => 'INR',
                'plan_name' => $planName,
                'payment_method' => 'razorpay'
            ]
        ]
    ]);
}
```

### In JavaScript (Track Response)

```javascript
// After receiving response from server
$.ajax({
    url: '/subscription/buy',
    method: 'POST',
    data: formData,
    success: function(response) {
        if (response.track_event) {
            // Track the event
            window.trackBranchEvent(
                response.track_event.name,
                response.track_event.data
            );
        }
        
        // Handle success
        showSuccessMessage(response.message);
    }
});
```

---

## Complete Login Form Example

```html
<!-- Login Form HTML -->
<form id="loginForm">
    <input type="tel" name="phone" placeholder="Enter phone">
    <button type="submit">Send OTP</button>
</form>

<script>
$('#loginForm').submit(function(e) {
    e.preventDefault();
    
    var phone = $('input[name="phone"]').val();
    
    $.ajax({
        url: '{{ route("sendotp") }}',
        method: 'POST',
        data: { phone: phone },
        success: function(response) {
            console.log('OTP sent');
            
            // Track OTP sent
            trackBranchEvent('login_otp_sent', {
                'phone': phone,
                'timestamp': new Date().toISOString()
            });
            
            // Show OTP input
            showOTPInput();
        }
    });
});

// After OTP verification
function verifyOTP() {
    var otp = $('input[name="otp"]').val();
    
    $.ajax({
        url: '{{ route("verifyotp") }}',
        method: 'POST',
        data: { otp: otp },
        success: function(response) {
            // Track successful login
            trackBranchEvent('login', {
                'event_description': 'User Login',
                'userId': response.user_id,
                'method': 'phone_otp',
                'timestamp': new Date().toISOString()
            });
            
            // Redirect to home
            window.location.href = '/';
        }
    });
}
</script>
```

---

## Complete Registration Form Example

```html
<!-- Registration Form HTML -->
<form id="registerForm">
    <input type="tel" name="phone" placeholder="Enter phone">
    <input type="text" name="name" placeholder="Enter name">
    <button type="submit">Register</button>
</form>

<script>
$('#registerForm').submit(function(e) {
    e.preventDefault();
    
    var formData = {
        phone: $('input[name="phone"]').val(),
        name: $('input[name="name"]').val()
    };
    
    $.ajax({
        url: '{{ route("register") }}',
        method: 'POST',
        data: formData,
        success: function(response) {
            // Track registration
            trackBranchEvent('register', {
                'event_description': 'User Registration',
                'userId': response.user_id,
                'phone': formData.phone,
                'name': formData.name,
                'method': 'phone_otp',
                'timestamp': new Date().toISOString()
            });
            
            showSuccessMessage('Registration successful!');
            redirectToDashboard();
        }
    });
});
</script>
```

---

## Standard Event Data Format

All events should include:

```javascript
{
    'event_description': 'Descriptive title',  // Required
    'timestamp': new Date().toISOString(),       // Recommended
    'userId': userIdIfLoggedIn,                  // Optional
    'device_type': 'web',                        // Optional
    'country': 'IN',                             // Optional
    // ... event-specific fields ...
}
```

---

## Testing Events

### Option 1: Browser Console
```javascript
// Test by running directly in console
trackBranchEvent('test_login', {
    'userId': '123',
    'method': 'phone_otp'
});
```

### Option 2: Check Network Tab
1. Open DevTools (F12)
2. Go to Network tab
3. Trigger event
4. Look for requests to Branch API
5. Verify event data in request payload

### Option 3: Check Branch Dashboard
1. Go to Branch Dashboard
2. Check "Recent Events" section
3. Verify events appear in real-time

---

## Summary

✅ Use `trackBranchEvent(name, data)` globally  
✅ Track login after OTP/social verification  
✅ Track registration after signup  
✅ Track purchase after subscription  
✅ Include descriptive names and timestamps  
✅ Add user context when available  

Events will be automatically sent to Branch for analytics and attribution!
