# Implementation Guide: Missing GA4 & Branch Events

## Status

✅ **GA4 Event Functions Added** to `public/assets/js/ga_tag.js`
✅ **Branch Event Helper** Already in `resources/views/layouts/default.blade.php`

Ready to integrate into controllers and views!

---

## Quick Integration Steps

### Step 1: PURCHASE Event (RazorpayController.php)

**Location**: After successful payment verification

**Add this code**:
```php
// In RazorpayController.php, after payment success
$razorpayScript = <<<'JS'
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // GA4 Event
        purchase_event('{{ $result['id'] }}', '{{ $result['name'] }}', {{ $result['actual_price'] }}, 'INR');
        
        // Branch Event
        trackBranchEvent('PURCHASE', {
            'user_id': '{{ $userData['user_id'] }}',
            'plan_id': '{{ $result['id'] }}',
            'plan_name': '{{ $result['name'] }}',
            'amount': {{ $result['actual_price'] }},
            'currency': 'INR',
            'payment_gateway': 'razorpay',
            'recurring': true
        });
    });
</script>
JS;
echo $razorpayScript;
```

---

### Step 2: BEGIN_CHECKOUT Event (payment-method.blade.php)

**Location**: On form submit (Continue Pay button)

**Update form tag**:
```html
<form name="checkoutsubscriptionform" 
      method="post" 
      id="checkoutsubscriptionid" 
      action="{{ config('razorpay.enabled') ? route('saveSubscriptionRazorpay') : route('saveSubscription') }}"
      onsubmit="handleCheckoutSubmit(event)">
      @csrf
      <!-- rest of form -->
</form>

<script>
function handleCheckoutSubmit(event) {
    var cardType = $("#card_type").val();
    var planName = $(".planid.active h6 p").text();
    var planPrice = $(".planid.active h3").text();
    var planId = $("[name='amountid']").val();
    
    // GA4 Event
    begin_checkout_event(planId, planName.trim(), parseFloat(planPrice.replace(/[^0-9.]/g, '')), cardType);
    
    // Branch Event
    trackBranchEvent('BEGIN_CHECKOUT', {
        'plan_id': planId,
        'plan_name': planName.trim(),
        'amount': parseFloat(planPrice.replace(/[^0-9.]/g, '')),
        'payment_method': cardType
    });
    
    // Continue with form submission
    return true;
}
</script>
```

---

### Step 3: ADD_TO_CART Event (subscription.blade.php)

**Location**: When user clicks on a plan

**Update plan selection**:
```html
<button onclick="handlePlanSelect(this)" 
        data-plan-id="{{ $plan['id'] }}" 
        data-plan-name="{{ $plan['name'] }}" 
        data-plan-price="{{ $plan['actual_price'] }}"
        class="plan-card">
    Buy Plan
</button>

<script>
function handlePlanSelect(element) {
    var planId = $(element).data('plan-id');
    var planName = $(element).data('plan-name');
    var planPrice = $(element).data('plan-price');
    
    // GA4 Event
    add_to_cart_event(planId, planName, planPrice);
    
    // Branch Event
    trackBranchEvent('ADD_TO_CART', {
        'plan_id': planId,
        'plan_name': planName,
        'price': planPrice
    });
}
</script>
```

---

### Step 4: PAYMENT_FAILED Event (RazorpayController.php)

**Location**: When payment fails

**Add this code**:
```php
// In RazorpayController.php, in razorpayCallback() when payment fails
if (!$isValid) {
    $plan = $result['id'];
    $planName = $result['name'];
    $failureScript = <<<'JS'
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // GA4 Event
            payment_failed_event('{{ $plan }}', '{{ $planName }}', 'razorpay', 'Invalid signature');
            
            // Branch Event
            trackBranchEvent('PAYMENT_FAILED', {
                'plan_id': '{{ $plan }}',
                'plan_name': '{{ $planName }}',
                'payment_gateway': 'razorpay',
                'error_reason': 'Invalid signature'
            });
        });
    </script>
    JS;
    echo $failureScript;
}
```

---

### Step 5: WATCH_START Event (PlayerController.php or Video JS)

**Location**: When video player loads and user starts watching

**Add to your video player JavaScript**:
```javascript
// When video starts playing
player.on('play', function() {
    var contentId = '{{ $content['id'] }}';
    var contentName = '{{ $content['title'] }}';
    var contentType = '{{ $content['type'] }}'; // 'episode', 'series', 'movie'
    
    // GA4 Event
    watch_start_event(contentId, contentName, contentType);
    
    // Branch Event
    trackBranchEvent('WATCH_START', {
        'content_id': contentId,
        'content_name': contentName,
        'content_type': contentType
    });
});
```

---

### Step 6: WATCH_COMPLETE Event (PlayerController.php or Video JS)

**Location**: When video finishes playing

**Add to your video player JavaScript**:
```javascript
// When video completes
player.on('ended', function() {
    var contentId = '{{ $content['id'] }}';
    var contentName = '{{ $content['title'] }}';
    var watchDuration = Math.round(player.currentTime());
    
    // GA4 Event
    watch_complete_event(contentId, contentName, watchDuration);
    
    // Branch Event
    trackBranchEvent('WATCH_COMPLETE', {
        'content_id': contentId,
        'content_name': contentName,
        'watch_duration': watchDuration,
        'completion_percent': 100
    });
});
```

---

### Step 7: SELECT_ITEM Event (subscription.blade.php)

**Location**: When user selects a plan from list

**Add to plan selection**:
```html
<div class="plan-item" onclick="selectPlan(this)">
    <p>{{ $plan['name'] }}</p>
    <h3>{{ $plan['actual_price'] }}</h3>
</div>

<script>
function selectPlan(element) {
    var planId = $(element).data('plan-id');
    var planName = $(element).data('plan-name');
    
    // GA4 Event
    select_item_event(planId, planName, 'subscription_plans');
    
    // Branch Event
    trackBranchEvent('SELECT_ITEM', {
        'plan_id': planId,
        'plan_name': planName,
        'list_id': 'subscription_plans'
    });
}
</script>
```

---

### Step 8: SUBSCRIPTION_CANCELLED Event (SubscriptionController.php)

**Location**: When user cancels subscription

**Add this code**:
```php
// In SubscriptionController.php, in cancelSubscription() method
public function cancelSubscription($subscriptionId, $reason) {
    // Cancel subscription logic...
    
    $cancellationScript = <<<'JS'
    <script>
        trackBranchEvent('SUBSCRIPTION_CANCELLED', {
            'user_id': '{{ $userData['user_id'] }}',
            'plan_id': '{{ $subscription['plan_id'] }}',
            'cancellation_reason': '{{ $reason }}',
            'plan_price': {{ $subscription['price'] }}
        });
    </script>
    JS;
    echo $cancellationScript;
}
```

---

### Step 9: SUBSCRIPTION_RENEWAL Event (Webhook or Cron)

**Location**: When subscription auto-renews

**Add this code**:
```php
// In webhook handler or cron job
public function handleSubscriptionRenewal($userId, $planId, $amount) {
    $renewalScript = <<<'JS'
    <script>
        trackBranchEvent('SUBSCRIPTION_RENEWAL', {
            'user_id': '{{ $userId }}',
            'plan_id': '{{ $planId }}',
            'renewal_amount': {{ $amount }},
            'renewal_date': '{{ date('Y-m-d') }}'
        });
    </script>
    JS;
    echo $renewalScript;
}
```

---

### Step 10: REFUND Event (SubscriptionController.php)

**Location**: When refund is processed

**Add this code**:
```php
// In SubscriptionController.php, in refundSubscription() method
public function refundSubscription($orderId, $amount, $reason) {
    // Refund logic...
    
    $refundScript = <<<'JS'
    <script>
        // GA4 Event
        refund_event('{{ $orderId }}', {{ $amount }}, '{{ $reason }}');
        
        // Branch Event
        trackBranchEvent('REFUND', {
            'order_id': '{{ $orderId }}',
            'amount': {{ $amount }},
            'currency': 'INR',
            'reason': '{{ $reason }}'
        });
    </script>
    JS;
    echo $refundScript;
}
```

---

## Testing Checklist

### Test Each Event

- [ ] **PURCHASE**: Complete a payment, check GA4 & Branch console
- [ ] **BEGIN_CHECKOUT**: Click "Continue Pay", check console
- [ ] **ADD_TO_CART**: Click on a plan, check console
- [ ] **PAYMENT_FAILED**: Try invalid payment, check console
- [ ] **WATCH_START**: Play a video, check console
- [ ] **WATCH_COMPLETE**: Let video finish, check console
- [ ] **SELECT_ITEM**: Select a plan, check console
- [ ] **SUBSCRIPTION_CANCELLED**: Cancel subscription, check console
- [ ] **SUBSCRIPTION_RENEWAL**: Check webhook/cron logs
- [ ] **REFUND**: Process refund, check console

### Console Verification

Open DevTools (F12) → Console tab

**You should see**:
```
✓ GA4 event pushed successfully
📊 Tracking Branch Event: {eventName: 'PURCHASE', eventData: {...}}
✓ Event tracked successfully: PURCHASE
```

---

## Files to Update

| File | Events | Priority |
|------|--------|----------|
| `RazorpayController.php` | PURCHASE, PAYMENT_FAILED | HIGH |
| `payment-method.blade.php` | BEGIN_CHECKOUT | HIGH |
| `subscription.blade.php` | ADD_TO_CART, SELECT_ITEM | MEDIUM |
| `PlayerController.php` or Video JS | WATCH_START, WATCH_COMPLETE | MEDIUM |
| `SubscriptionController.php` | SUBSCRIPTION_CANCELLED, REFUND | LOW |
| Webhook/Cron | SUBSCRIPTION_RENEWAL | LOW |

---

## GA4 Event Functions Available

All functions below are now available in `public/assets/js/ga_tag.js`:

✅ `purchase_event(plan_id, plan_name, price, currency)`
✅ `add_to_cart_event(item_id, item_name, price)`
✅ `begin_checkout_event(plan_id, plan_name, price, payment_method)`
✅ `payment_failed_event(plan_id, plan_name, payment_method, error_reason)`
✅ `refund_event(order_id, amount, reason)`
✅ `select_item_event(item_id, item_name, item_list_id)`
✅ `watch_start_event(content_id, content_name, content_type)`
✅ `watch_complete_event(content_id, content_name, watch_duration)`

## Branch Event Function Available

✅ `trackBranchEvent(eventName, eventData)` - Already in default.blade.php

---

## Next Steps

1. **Immediate**: Implement PURCHASE & BEGIN_CHECKOUT (HIGH priority)
2. **This Week**: Implement ADD_TO_CART, PAYMENT_FAILED, WATCH events (MEDIUM)
3. **Next Week**: Implement remaining events (LOW priority)
4. **Test**: Verify each event in GA4 Dashboard & Branch Dashboard
5. **Monitor**: Check console logs for any errors

---

## References

- GA4 Events: https://support.google.com/analytics/answer/9322688
- Branch Events: https://branch.io/resources/
- Implemented Events: See `MISSING_GA4_BRANCH_EVENTS.md`

✅ Ready to implement!
