# ✅ Updated: Razorpay Webhook Logging

## Change Summary

Replaced all `$this->razorpayLog()` calls in the `razorpayWebhook()` function with `Log::channel('razorpay_webhook')->info()` for consistency.

---

## What Changed

### Function: `razorpayWebhook()` in RazorpayController.php

**Before** (Old logging):
```php
$this->razorpayLog('Payment Captured Event', false, ['event' => $event, 'payload' => $payload]);
```

**After** (New logging):
```php
Log::channel('razorpay_webhook')->info("Payment Captured Event: " . json_encode(['event' => $event, 'payload' => $payload]));
```

---

## All Logging Calls Updated

| Line | Event | Old Call | New Call |
|------|-------|----------|----------|
| 275 | Payment Captured | `$this->razorpayLog('Payment Captured Event', ...)` | `Log::channel('razorpay_webhook')->info(...)` |
| 289 | Payment Details | `$this->razorpayLog('Payment Captured Details', ...)` | `Log::channel('razorpay_webhook')->info(...)` |
| 299 | Recurring Subscription | `$this->razorpayLog('Processing Recurring Subscription', ...)` | `Log::channel('razorpay_webhook')->info(...)` |
| 309 | Active Subscription | `$this->razorpayLog('Check Active Subscription Response', ...)` | `Log::channel('razorpay_webhook')->info(...)` |
| 320 | Subscription Expiring | `$this->razorpayLog('Subscription Expiring - Processing Update', ...)` | `Log::channel('razorpay_webhook')->info(...)` |
| 340 | Update Order API | `$this->razorpayLog('Calling updateOrder API', ...)` | `Log::channel('razorpay_webhook')->info(...)` |
| 344 | Update Response | `$this->razorpayLog('Update Order Response', ...)` | `Log::channel('razorpay_webhook')->info(...)` |
| 357 | Non-Recurring | `$this->razorpayLog('Not a Recurring Subscription Payment', ...)` | `Log::channel('razorpay_webhook')->info(...)` |
| 365 | Payment Failed | `$this->razorpayLog('Payment Failed Event', ...)` | `Log::channel('razorpay_webhook')->info(...)` |

---

## Why This Change

✅ **Consistency**: Uses Laravel's native Log facade with channel  
✅ **Simplicity**: Direct logging without helper function  
✅ **Clarity**: All webhook logs go to `razorpay_webhook` channel  
✅ **JSON Format**: Data is JSON-encoded for better readability  

---

## Log Channel

All webhook logs are written to:
```
storage/logs/razorpay_webhook/razorpay-YYYY-MM-DD.log
```

---

## Example Log Output

```
[2026-08-25 10:30:45] local.INFO: Payment Captured Event: {"event":"payment.captured","payload":{...}}
[2026-08-25 10:30:45] local.INFO: Payment Captured Details: {"payment_id":"pay_xxx","user_id":"919999999999","order_id":"12345"}
[2026-08-25 10:30:45] local.INFO: Processing Recurring Subscription: {"Order id":"12345"}
[2026-08-25 10:30:45] local.INFO: Check Active Subscription Response: {"url":"subscriptions/checkActiveSubscription","request":{...},"response":{...}}
```

---

## Monitoring Webhook Logs

### Real-time monitoring:
```bash
tail -f storage/logs/razorpay_webhook/razorpay-*.log
```

### Search for specific events:
```bash
grep "Payment Captured" storage/logs/razorpay_webhook/razorpay-*.log
grep "Payment Failed" storage/logs/razorpay_webhook/razorpay-*.log
```

---

## Affected Function

**File**: `app/Http/Controllers/RazorpayController.php`
**Function**: `razorpayWebhook(Request $request)` (Lines ~255-367)
**Status**: ✅ **Updated**

---

## Testing

### Verify Webhook Logs

1. **Trigger a payment.captured event**:
   - Make a payment through Razorpay
   - Razorpay sends webhook to `/razorpay-webhook`

2. **Check logs**:
```bash
tail -f storage/logs/razorpay_webhook/razorpay-*.log
```

3. **Expected output**:
```
Payment Captured Event: {...}
Payment Captured Details: {...}
Processing Recurring Subscription: {...}
Check Active Subscription Response: {...}
Calling updateOrder API: {...}
Update Order Response: {...}
```

---

## Note

**Important**: The `razorpayLog()` helper function is still used in other parts of RazorpayController for non-webhook operations. Only the `razorpayWebhook()` function was updated to use the standard Log channel.

---

## Related Files

- **RazorpayController.php**: Updated `razorpayWebhook()` method
- **Log Channel**: `config/logging.php` (razorpay_webhook channel)
- **Logs Location**: `storage/logs/razorpay_webhook/`

---

## Summary

✅ All webhook logging in `razorpayWebhook()` now uses `Log::channel('razorpay_webhook')->info()`  
✅ Consistent logging format with JSON encoding  
✅ Logs written to dedicated `razorpay_webhook` channel  
✅ Ready for production monitoring  

**Status**: ✅ **COMPLETE**
