# Missing GA4 & Branch Events Analysis

## Summary

Based on your GA4 events table and current implementation, here are the **MISSING events** that need to be added:

---

## Missing GA4 Events (from table)

### Automatically Collected (Should be present)
✅ **page_view** - Already handled by GA4
✅ **session_start** - Already handled by GA4
✅ **first_visit** - Already handled by GA4
✅ **user_engagement** - Already handled by GA4
✅ **scroll** - Already handled by GA4
✅ **click** - Already handled by GA4

### Enhanced Measurement (Need to add)
❌ **file_download** - IMPLEMENTED in ga_tag.js (function exists)
✅ **video_start** - IMPLEMENTED (video_play function)
✅ **video_progress** - IMPLEMENTED (video_seek function)
✅ **video_complete** - IMPLEMENTED (video_ended function)
✅ **search** - IMPLEMENTED (searchEvent function)
✅ **view_search_results** - IMPLEMENTED (click_search_results function)

### Recommended (Need to add)
❌ **login** - PARTIALLY (login_start, login_success, login_failed)
❌ **sign_up** - PARTIALLY (registration_start, registration_success, registration_failed)
❌ **begin_checkout** - MISSING ⚠️
❌ **add_to_cart** - MISSING ⚠️
❌ **purchase** - MISSING ⚠️
❌ **refund** - MISSING ⚠️
❌ **view_item** - IMPLEMENTED (view_item function exists implicitly in tile/carousel clicks)
❌ **select_item** - MISSING ⚠️
❌ **select_promotion** - IMPLEMENTED (select_promotion function exists)

---

## Missing Branch Events

### Currently Implemented ✅
- LOGIN
- SIGN_UP

### Missing ❌
- **PURCHASE** - When user buys subscription
- **SUBSCRIPTION_CANCELLED** - When subscription cancelled
- **WATCH_START** - When video starts
- **WATCH_COMPLETE** - When video finishes
- **SUBSCRIPTION_RENEWAL** - When subscription renews
- **PAYMENT_FAILED** - When payment fails

---

## Critical Missing Events to Add

### 1. PURCHASE Event (GA4 + Branch)

**Location**: `RazorpayController.php` (after successful payment)

**GA4 Code**:
```javascript
function purchase_event(plan_id, plan_name, price, currency) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset();
        datalayers();
        dataLayer.push({
            event: "purchase",
            transaction_id: new Date().getTime(),
            value: price,
            currency: currency,
            items: [{
                item_id: plan_id,
                item_name: plan_name,
                price: price,
                quantity: 1
            }]
        });
    } catch (error) {
        console.error('GA4 Purchase Event Error:', error);
    }
}
```

**Branch Code**:
```javascript
function trackBranchEvent('PURCHASE', {
    'user_id': userData['user_id'],
    'plan_id': result['id'],
    'plan_name': result['name'],
    'amount': result['actual_price'],
    'currency': 'INR',
    'payment_gateway': 'razorpay',
    'recurring': true
});
```

---

### 2. ADD_TO_CART Event (GA4 + Branch)

**Location**: `subscription.blade.php` (when user adds plan to cart)

**GA4 Code**:
```javascript
function add_to_cart_event(item_id, item_name, price) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset();
        datalayers();
        dataLayer.push({
            event: "add_to_cart",
            items: [{
                item_id: item_id,
                item_name: item_name,
                price: price,
                quantity: 1
            }]
        });
    } catch (error) {
        console.error('GA4 Add to Cart Error:', error);
    }
}
```

**Branch Code**:
```javascript
trackBranchEvent('ADD_TO_CART', {
    'plan_id': item_id,
    'plan_name': item_name,
    'price': price
});
```

**HTML**:
```html
<button onclick="add_to_cart_event('epic_in_pl_1', 'Premium', 199)">
    Add to Cart
</button>
```

---

### 3. BEGIN_CHECKOUT Event (GA4 + Branch)

**Location**: `payment-method.blade.php` (when user clicks "Continue Pay")

**GA4 Code**:
```javascript
function begin_checkout_event(plan_id, plan_name, price, payment_method) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset();
        datalayers();
        dataLayer.push({
            event: "begin_checkout",
            items: [{
                item_id: plan_id,
                item_name: plan_name,
                price: price,
                quantity: 1
            }],
            payment_type: payment_method
        });
    } catch (error) {
        console.error('GA4 Begin Checkout Error:', error);
    }
}
```

**Branch Code**:
```javascript
trackBranchEvent('BEGIN_CHECKOUT', {
    'plan_id': plan_id,
    'plan_name': plan_name,
    'amount': price,
    'payment_method': payment_method
});
```

**HTML**:
```html
<form onsubmit="begin_checkout_event('epic_in_pl_1', 'Premium', 199, 'Debit Card')">
    <button type="submit">Continue Pay</button>
</form>
```

---

### 4. WATCH_START Event (GA4 + Branch)

**Location**: `PlayerController.php` (when video starts)

**GA4 Code**:
```javascript
function watch_start_event(content_id, content_name, content_type) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset();
        datalayers();
        dataLayer.push({
            event: "view_item",
            items: [{
                item_id: content_id,
                item_name: content_name,
                item_category: content_type
            }]
        });
    } catch (error) {
        console.error('GA4 Watch Start Error:', error);
    }
}
```

**Branch Code**:
```javascript
trackBranchEvent('WATCH_START', {
    'content_id': content_id,
    'content_name': content_name,
    'content_type': content_type,
    'duration': total_duration
});
```

---

### 5. WATCH_COMPLETE Event (GA4 + Branch)

**Location**: `PlayerController.php` (when video completes)

**GA4 Code**:
```javascript
function watch_complete_event(content_id, content_name, watch_duration) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset();
        datalayers();
        dataLayer.push({
            event: "video_complete",
            items: [{
                item_id: content_id,
                item_name: content_name
            }],
            watch_duration: watch_duration,
            watch_percent: 100
        });
    } catch (error) {
        console.error('GA4 Watch Complete Error:', error);
    }
}
```

**Branch Code**:
```javascript
trackBranchEvent('WATCH_COMPLETE', {
    'content_id': content_id,
    'content_name': content_name,
    'watch_duration': watch_duration,
    'completion_percent': 100
});
```

---

### 6. PAYMENT_FAILED Event (GA4 + Branch)

**Location**: `RazorpayController.php` (when payment fails)

**GA4 Code**:
```javascript
function payment_failed_event(plan_id, plan_name, payment_method, error_reason) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset();
        datalayers();
        dataLayer.push({
            event: "purchase_error", // GA4 doesn't have payment_failed, use this
            transaction_id: new Date().getTime(),
            items: [{
                item_id: plan_id,
                item_name: plan_name
            }],
            payment_type: payment_method,
            error_description: error_reason
        });
    } catch (error) {
        console.error('GA4 Payment Failed Error:', error);
    }
}
```

**Branch Code**:
```javascript
trackBranchEvent('PAYMENT_FAILED', {
    'plan_id': plan_id,
    'plan_name': plan_name,
    'payment_gateway': 'razorpay',
    'error_reason': error_reason
});
```

---

### 7. REFUND Event (GA4 + Branch)

**Location**: `SubscriptionController.php` (when refund processed)

**GA4 Code**:
```javascript
function refund_event(order_id, amount, reason) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset();
        datalayers();
        dataLayer.push({
            event: "refund",
            transaction_id: order_id,
            value: amount,
            currency: "INR",
            refund_reason: reason
        });
    } catch (error) {
        console.error('GA4 Refund Error:', error);
    }
}
```

**Branch Code**:
```javascript
trackBranchEvent('REFUND', {
    'order_id': order_id,
    'amount': amount,
    'currency': 'INR',
    'reason': reason
});
```

---

### 8. SELECT_ITEM Event (GA4 + Branch)

**Location**: `subscription.blade.php` (when user selects a plan)

**GA4 Code**:
```javascript
function select_item_event(item_id, item_name, item_list_id) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset();
        datalayers();
        dataLayer.push({
            event: "select_item",
            items: [{
                item_id: item_id,
                item_name: item_name,
                item_list_id: item_list_id
            }]
        });
    } catch (error) {
        console.error('GA4 Select Item Error:', error);
    }
}
```

**Branch Code**:
```javascript
trackBranchEvent('SELECT_ITEM', {
    'plan_id': item_id,
    'plan_name': item_name,
    'list_id': item_list_id
});
```

---

### 9. SUBSCRIPTION_CANCELLED Event (Branch Only)

**Location**: `SubscriptionController.php` (when subscription cancelled)

**Branch Code**:
```javascript
trackBranchEvent('SUBSCRIPTION_CANCELLED', {
    'user_id': user_id,
    'plan_id': plan_id,
    'cancellation_reason': reason,
    'plan_price': price
});
```

---

### 10. SUBSCRIPTION_RENEWAL Event (Branch Only)

**Location**: Webhook/Cron job (when subscription auto-renews)

**Branch Code**:
```javascript
trackBranchEvent('SUBSCRIPTION_RENEWAL', {
    'user_id': user_id,
    'plan_id': plan_id,
    'renewal_amount': amount,
    'renewal_date': date
});
```

---

## Implementation Priority

### High Priority (Do First)
1. ✅ PURCHASE - Critical for revenue tracking
2. ✅ BEGIN_CHECKOUT - Critical for funnel analysis
3. ✅ PAYMENT_FAILED - Critical for troubleshooting

### Medium Priority (Do Next)
4. ⚠️ ADD_TO_CART - Important for shopping behavior
5. ⚠️ WATCH_START - Important for content usage
6. ⚠️ WATCH_COMPLETE - Important for engagement

### Low Priority (Do Later)
7. ℹ️ REFUND - Important for finance
8. ℹ️ SELECT_ITEM - Nice to have
9. ℹ️ SUBSCRIPTION_CANCELLED - Important for retention
10. ℹ️ SUBSCRIPTION_RENEWAL - Important for recurring revenue

---

## Implementation Checklist

### Phase 1 (This Sprint)
- [ ] Add PURCHASE event to RazorpayController
- [ ] Add BEGIN_CHECKOUT event to payment-method.blade.php
- [ ] Add PAYMENT_FAILED event to RazorpayController
- [ ] Test all 3 events in browser console

### Phase 2 (Next Sprint)
- [ ] Add ADD_TO_CART event to subscription.blade.php
- [ ] Add WATCH_START event to PlayerController
- [ ] Add WATCH_COMPLETE event to PlayerController
- [ ] Test all 3 events

### Phase 3 (Later)
- [ ] Add REFUND event
- [ ] Add SELECT_ITEM event
- [ ] Add SUBSCRIPTION_CANCELLED event
- [ ] Add SUBSCRIPTION_RENEWAL event

---

## Files That Need Updates

| File | Events to Add |
|------|--------------|
| `ga_tag.js` | add_to_cart, purchase, begin_checkout, watch_complete, payment_failed, refund, select_item |
| `default.blade.php` | trackBranchEvent helper (already exists) |
| `RazorpayController.php` | PURCHASE, PAYMENT_FAILED (JavaScript calls) |
| `payment-method.blade.php` | BEGIN_CHECKOUT event |
| `subscription.blade.php` | ADD_TO_CART, SELECT_ITEM events |
| `PlayerController.php` | WATCH_START, WATCH_COMPLETE events |
| `SubscriptionController.php` | SUBSCRIPTION_CANCELLED, REFUND events |

---

## Summary

**Total Missing Events**: 10
- **GA4**: 7 events
- **Branch**: 10 events

**Critical**: 3 (PURCHASE, BEGIN_CHECKOUT, PAYMENT_FAILED)
**Important**: 4 (ADD_TO_CART, WATCH_START, WATCH_COMPLETE, SUBSCRIPTION_CANCELLED)
**Nice-to-have**: 3 (REFUND, SELECT_ITEM, SUBSCRIPTION_RENEWAL)

All code samples provided above. Ready to implement!
