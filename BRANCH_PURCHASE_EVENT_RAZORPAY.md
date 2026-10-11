# ✅ Branch Purchase Event Integration for Razorpay

## Overview

Added Branch tracking for purchase events when users complete Razorpay payments for EPIC ON subscriptions.

---

## What Was Implemented

### File: `resources/views/subscription/razorpay.blade.php`

**Location**: Inside Razorpay payment handler callback (lines ~29-45)

**Code Added**:
```javascript
// ✅ Track purchase event in Branch
if (typeof branch !== 'undefined') {
    branch.track('Purchase', {
        "transactionID": response.razorpay_payment_id,
        "currency": "{{ $parameters['currency'] }}",
        "revenue": {{ $parameters['amount'] }},
        "description": "Subscription Purchase - EPIC ON",
        "razorpay_payment_id": response.razorpay_payment_id,
        "razorpay_subscription_id": response.razorpay_subscription_id,
        "razorpay_signature": response.razorpay_signature
    });
}
```

---

## Event Details

### Event Name
`Purchase`

### Event Properties

| Property | Value | Example |
|----------|-------|---------|
| `transactionID` | Razorpay Payment ID | `pay_xxx123456` |
| `currency` | Transaction currency | `INR` |
| `revenue` | Amount paid | `199` |
| `description` | Purchase description | `Subscription Purchase - EPIC ON` |
| `razorpay_payment_id` | Payment ID | `pay_xxx123456` |
| `razorpay_subscription_id` | Subscription ID | `sub_xxx789` |
| `razorpay_signature` | Payment signature | `signature_xxx` |

---

## Event Flow

### 1. User Initiates Payment
```
User clicks "Continue Pay"
↓
Razorpay modal opens
↓
User completes payment
```

### 2. Razorpay Success
```
Razorpay returns response with:
- razorpay_payment_id
- razorpay_subscription_id
- razorpay_signature
```

### 3. Branch Tracking
```javascript
handler: function (response) {
    // ✅ Track in Branch
    branch.track('Purchase', { ... });
    
    // Populate form and submit
    document.razorpayform.submit();
}
```

### 4. Backend Processing
```
Form submits to /callback
↓
Backend receives all payment data
↓
Backend verifies and activates subscription
```

---

## Tracked Data

### What Gets Tracked
✅ Razorpay payment ID  
✅ Subscription ID  
✅ Amount paid  
✅ Currency  
✅ Payment signature  
✅ Custom description  

### Benefits
✅ Track conversion funnel  
✅ Measure subscription purchases  
✅ Attribution modeling  
✅ ROI analysis  
✅ User journey tracking  

---

## Testing

### Browser Console
```javascript
// 1. Open DevTools (F12)
// 2. Go to Console tab
// 3. Complete a Razorpay payment
// 4. Watch for Branch tracking calls
// 5. Look for: branch.track('Purchase', {...})
```

### Branch Dashboard
1. Login to Branch Dashboard
2. Go to Analytics → Events
3. Filter by: `Purchase`
4. Should see events with transaction ID and revenue

---

## Summary

✅ **Implemented**: Purchase event tracking for Razorpay payments  
✅ **Location**: razorpay.blade.php handler  
✅ **Data Tracked**: Payment ID, subscription ID, amount, signature  
✅ **Benefits**: Revenue tracking, conversion funnel, ROI measurement  

**Status**: Ready for testing and deployment
