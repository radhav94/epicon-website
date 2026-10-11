# 🚀 Branch Events - Quick Reference

## All 26 Tracking Functions

### Core Function
```javascript
trackBranchEvent(eventName, eventData)  // Base function
```

### User Events (3)
```javascript
trackLoginEvent(loginMethod, additionalData)
trackRegistrationEvent(email, phone, method, additionalData)
trackSignUp(method, additionalData)
```

### Subscription Events (7)
```javascript
trackPlanSelected(planId, planName, price, currency, additionalData)
trackPaymentMethodSelected(paymentMethod, gateway, additionalData)
trackPaymentSuccess(orderId, paymentId, amount, currency, additionalData)
trackPaymentFailed(orderId, reason, additionalData)
trackSubscriptionActivated(subscriptionId, planId, name, validityDays, additionalData)
trackCouponApplied(couponCode, discount, finalPrice, additionalData)
trackSubscriptionRenewal(subscriptionId, planId, renewalAmount, currency, additionalData)
```

### Order Events (2)
```javascript
trackOrderCreated(orderId, planId, value, currency, additionalData)
trackPurchase(transactionId, value, currency, items, additionalData)
```

### Payment Events (3)
```javascript
trackPaymentMethodSelected(paymentMethod, gateway, additionalData)
trackPaymentSuccess(orderId, paymentId, amount, currency, additionalData)
trackPaymentFailed(orderId, reason, additionalData)
```

### Error Events (2)
```javascript
trackLoginFailed(reason, additionalData)
trackRegistrationFailed(reason, additionalData)
```

### Checkout Events (2)
```javascript
trackViewSubscriptionPlans(totalPlans, freeTrialAvailable, additionalData)
trackBeginCheckout(items, additionalData)
```

### Content Events (5)
```javascript
trackSearch(searchTerm, additionalData)
trackViewItem(items, additionalData)
trackSelectContent(contentType, contentId, additionalData)
trackVideoProgress(videoTitle, videoUrl, percent, additionalData)
trackPageView(pageTitle, pageReferrer, pageUrl, additionalData)
```

### Commerce Events (2)
```javascript
trackAddToCart(items, additionalData)
trackGenerateLead(currency, value, pageLocation, additionalData)
```

### Razorpay Events (1)
```javascript
trackRazorpayCheckoutOpened(orderId, amount, currency, additionalData)
```

### File Events (1)
```javascript
trackFileDownload(fileName, additionalData)
```

---

## Common Usage Patterns

### After Login Success
```javascript
trackLoginEvent('otp');
```

### After Registration Success
```javascript
trackSignUp('otp');
trackRegistrationEvent('user@example.com', '919999999999', 'otp');
```

### Subscription Purchase Flow
```javascript
// Step 1: View plans
trackViewSubscriptionPlans(3, true);  // 3 plans, free trial available

// Step 2: Select plan
trackPlanSelected('epic_in_pl_1', 'Premium', 199, 'INR');

// Step 3: Select payment method
trackPaymentMethodSelected('UPI', 'razorpay');

// Step 4: Begin checkout
trackBeginCheckout([{item_id: 'epic_in_pl_1', item_name: 'Premium', price: 199}]);

// Step 5: Open Razorpay
trackRazorpayCheckoutOpened('ORD_12345', 199, 'INR');

// Step 6: Payment success
trackPaymentSuccess('ORD_12345', 'pay_abc123', 199, 'INR');

// Step 7: Subscription activated
trackSubscriptionActivated('sub_xyz789', 'epic_in_pl_1', 'Premium', 30);
```

### Content Viewing
```javascript
// View plans/items
trackViewItem([{item_id: 'show_123', item_name: 'Stranger Things'}]);

// Select content
trackSelectContent('episode', 'ep_456');

// Track playback
trackVideoProgress('Episode 1', '/video/ep1', 25);   // 25%
trackVideoProgress('Episode 1', '/video/ep1', 50);   // 50%
trackVideoProgress('Episode 1', '/video/ep1', 100);  // 100% completed
```

### Search
```javascript
trackSearch('Marvel');
```

### Error Handling
```javascript
trackLoginFailed('invalid_otp');
trackPaymentFailed('ORD_12345', 'payment_declined');
```

---

## File Location
`/public/assets/js/branch-tracking.js` (345 lines)

## Integration
- ✅ Automatically included in all pages
- ✅ Global availability
- ✅ GA4 integration included
- ✅ Console logging enabled
- ✅ Ready to use

---

## Debugging

### Enable Logging
```javascript
// Events are logged to console automatically
// Open DevTools → Console tab
// Should see: "🔵 Branch: Tracking event: [event_name]"
```

### Check Branch Dashboard
```
Branch.io Dashboard → Analytics → Events
Look for your events in real-time
```

---

## Event Parameters

All events include automatically:
- ✅ `timestamp` - ISO format timestamp
- ✅ `device_type` - Always 'web'
- ✅ GA4 integration - Sent to gtag automatically

---

Ready to track! 🚀
