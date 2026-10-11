# Razorpay Webhook Implementation Guide

## Current Implementation Status

✅ **Webhook Handler**: Already implemented in `RazorpayController.php`
✅ **Event Processing**: Handles `payment.captured` events
✅ **Logging**: All events logged to `storage/logs/razorpay_webhook/`

---

## Webhook Flow

### 1. Razorpay Sends Webhook
```
Razorpay Server
  ↓
POST /razorpay/webhook
Headers:
  - X-Razorpay-Signature: signature_xxx
  - Content-Type: application/json

Body:
{
  "event": "payment.captured",
  "payload": {
    "payment": {
      "entity": {
        "id": "pay_TTzYr2zGkU8WEr",
        "amount": 100,
        "status": "captured",
        "notes": {
          "epicon_order_id": "2846388"
        },
        "token_id": "token_TTzYrUxQYRGWPM"
      }
    }
  }
}
```

### 2. Backend Receives & Processes
```php
public function razorpayWebhook(Request $request)
{
    // Get webhook body
    $webhookBody = $request->getContent();
    
    // Log receipt
    Log::channel('razorpay_webhook')->info("Razorpay webhook received: " . $webhookBody);
    
    // Parse JSON
    $payload = json_decode($webhookBody, true);
    $event = @$payload['event'];
    
    // Log event type
    Log::channel('razorpay_webhook')->info("Razorpay webhook event: " . $event);
    
    // Handle payment captured
    if ($event == 'payment.captured') {
        // Extract payment details
        $paymentEntity = @$payload['payload']['payment']['entity'];
        $paymentId = @$paymentEntity['id'];
        $orderId = @$paymentEntity['notes']['order_id'] ?? '';
        
        // Process subscription
        if (!empty($orderId)) {
            // Update order & subscription
            // Call backend APIs
            // Log results
        }
    }
    
    // Always return 200
    return response()->json(['status' => 'ok'], 200);
}
```

---

## Implementation Details

### File: `RazorpayController.php`
**Method**: `razorpayWebhook()`
**Location**: Line ~255

### Current Features

✅ **Webhook Reception**
- Receives webhook from Razorpay
- Extracts webhook body

✅ **Event Logging**
- Logs all webhook events
- Logs in `storage/logs/razorpay_webhook/`

✅ **Payment Event Processing**
- Handles `payment.captured` event
- Extracts payment details
- Processes recurring subscription

✅ **Order Processing**
- Checks active subscription status
- Updates order if subscription expiring
- Calls backend `updateOrder` API

✅ **Error Handling**
- Null-safe operators (@$)
- Graceful failure handling
- Comprehensive logging

---

## Data Flow

### From Webhook Response

```
Webhook Data:
{
  "event": "payment.captured",
  "payload": {
    "payment": {
      "entity": {
        "id": "pay_TTzYr2zGkU8WEr",          ← paymentId
        "amount": 100,                       ← amount in paise
        "currency": "INR",
        "status": "captured",
        "method": "card",                    ← paymentMode
        "notes": {
          "order_id": "2846388"              ← orderId
        },
        "token_id": "token_TTzYrUxQYRGWPM"  ← tokenId (for recurring)
      }
    }
  }
}

Extracted:
├── paymentId: "pay_TTzYr2zGkU8WEr"
├── orderId: "2846388"
├── paymentMode: "card"
├── subscriptionPaymentMode: "card"
└── tokenId: "token_TTzYrUxQYRGWPM"
```

### Processing Steps

```
1. Receive Webhook
   ↓
2. Log Webhook Body
   ↓
3. Parse JSON
   ↓
4. Extract Event Type
   ↓
5. If payment.captured:
   ├─ Extract Payment Details
   ├─ Check if Recurring
   ├─ Get Order ID
   ├─ Call checkActiveSubscription API
   ├─ Check if Subscription Expiring
   ├─ Call updateOrder API
   └─ Log Results
   ↓
6. Return 200 Response
```

---

## Current Implementation Code

### Handler Reception
```php
public function razorpayWebhook(Request $request)
{
    $webhookBody = $request->getContent();
    
    Log::channel('razorpay_webhook')->info("Razorpay webhook received: " . $webhookBody);
    
    $payload = json_decode($webhookBody, true);
    $event = @$payload['event'];
    
    Log::channel('razorpay_webhook')->info("Razorpay webhook event: " . $event);
    
    // Handle payment captured event
    if ($event == 'payment.captured') {
        // ... processing logic
    }
    
    return response()->json(['status' => 'ok'], 200);
}
```

### Payment Details Extraction
```php
$paymentEntity = @$payload['payload']['payment']['entity'];

if (!empty($paymentEntity)) {
    $paymentId = @$paymentEntity['id'];
    $userId = @$paymentEntity['notes']['user_id'] ?? '';
    $orderId = @$paymentEntity['notes']['order_id'] ?? '';
    $planId = @$paymentEntity['notes']['plan_id'] ?? '';
    
    // Log extracted details
    $this->razorpayLog('Payment Captured Details', false, [
        'payment_id' => $paymentId,
        'user_id' => $userId,
        'order_id' => $orderId,
    ]);
}
```

### Subscription Update
```php
// Call checkActiveSubscription
$newParamRecur = [
    'subscriptionId' => $subscriptionId,
    'razorpay_payment_id' => $paymentId,
];

$resultRecur = CurlAPI("subscriptions/checkActiveSubscription", 'POST', $newParamRecur, 2, false, true);

// If subscription expiring, update order
if (@$resultRecur['status'] == false || $this->isSubscriptionExpiring($orderData)) {
    // Extract payment mode
    $paymentMode = @$paymentEntity['method'];
    $subscriptionPaymentMode = strtolower($paymentMode);
    
    // Call updateOrder
    $updateOrderData = [
        'user_id' => @$orderData['user_id'] ?? $userId,
        'order_id' => @$orderData['order_id'] ?? $orderId,
        'order_status' => 'complete',
        'payment_gateway' => 'razorpay',
        'transaction_id' => $paymentId,
        'razorpay_payment_id' => $paymentId,
        'razorpay_subscription_id' => $subscriptionId,
        'payment_mode' => ucfirst($paymentMode),
        'subscriptionPaymentMode' => $subscriptionPaymentMode,
        'is_recurring' => true,
    ];
    
    $updateOrder = CurlAPI("subscriptions/updateOrder", 'POST', $updateOrderData, 2, false, true);
}
```

---

## Signature Verification (Currently Commented)

**Status**: Signature verification is currently commented out

### Uncomment to Enable

```php
// Get signature from header
$webhookSignature = $request->header('X-Razorpay-Signature');

// Calculate expected signature
$expectedSignature = hash_hmac(
    'sha256',
    $webhookBody,
    config('razorpay.key_secret')  // key_secret from config
);

// Verify using timing-safe comparison
if (!hash_equals($expectedSignature, $webhookSignature ?? '')) {
    Log::channel('razorpay_webhook')->error("Razorpay webhook signature mismatch");
    return response()->json(['status' => 'invalid_signature'], 400);
}
```

### Why Enable Signature Verification
✅ **Security**: Proves webhook came from Razorpay
✅ **Integrity**: Proves webhook data wasn't modified
✅ **Authentication**: Only Razorpay knows the key_secret

---

## Route Configuration

**File**: `routes/web.php`

The webhook route should be:

```php
Route::post('/razorpay/webhook', [RazorpayController::class, 'razorpayWebhook']);
```

Or check existing routes for endpoint path.

---

## Logging

### Log Location
```
storage/logs/razorpay_webhook/razorpay-YYYY-MM-DD.log
```

### Example Log Entry
```
[2026-08-25 10:30:45] razorpay_webhook.INFO: Razorpay webhook received: {"event":"payment.captured","payload":{...}}
[2026-08-25 10:30:45] razorpay_webhook.INFO: Razorpay webhook event: payment.captured
[2026-08-25 10:30:45] razorpay_webhook.INFO: Payment Captured Event: {"event":"payment.captured",...}
[2026-08-25 10:30:45] razorpay_webhook.INFO: Payment Captured Details: {"payment_id":"pay_TTzYr2zGkU8WEr","user_id":"...","order_id":"2846388"}
[2026-08-25 10:30:45] razorpay_webhook.INFO: Check Active Subscription Response: {"url":"subscriptions/checkActiveSubscription",...}
[2026-08-25 10:30:45] razorpay_webhook.INFO: Calling updateOrder API: {"request":{...}}
[2026-08-25 10:30:45] razorpay_webhook.INFO: Update Order Response: {"url":"subscriptions/updateOrder",...}
```

### View Logs
```bash
# Watch in real-time
tail -f storage/logs/razorpay_webhook/razorpay-*.log

# Filter specific events
grep "Payment Captured Details" storage/logs/razorpay_webhook/razorpay-*.log

# Check for errors
grep "ERROR" storage/logs/razorpay_webhook/razorpay-*.log
```

---

## Testing Webhook

### 1. Local Testing with ngrok

```bash
# Start ngrok
ngrok http 8000

# Configure Razorpay to send to
https://your-ngrok-url.ngrok.io/razorpay/webhook

# Trigger test payment
# Complete payment flow in your app

# Monitor logs
tail -f storage/logs/razorpay_webhook/razorpay-*.log
```

### 2. Sandbox Testing

```
1. Use Razorpay Sandbox Account
2. Create test payment
3. Check logs for webhook receipt
4. Verify subscription status updated
```

### 3. Manual Testing

```bash
# Simulate webhook locally
curl -X POST http://localhost:8000/razorpay/webhook \
  -H "Content-Type: application/json" \
  -H "X-Razorpay-Signature: test_signature" \
  -d '{
    "event": "payment.captured",
    "payload": {
      "payment": {
        "entity": {
          "id": "pay_TTzYr2zGkU8WEr",
          "amount": 100,
          "notes": {
            "order_id": "2846388"
          }
        }
      }
    }
  }'

# Check logs
tail -f storage/logs/razorpay_webhook/razorpay-*.log
```

---

## Key Methods

### `razorpayWebhook()`
- **Purpose**: Main webhook handler
- **Input**: HTTP request with webhook data
- **Output**: 200 JSON response
- **Location**: `RazorpayController.php` Line ~255

### `razorpayLog()`
- **Purpose**: Log webhook events
- **Location**: Helper method in `RazorpayController`
- **Usage**: `$this->razorpayLog('Event Name', $txid, $data);`

### `isSubscriptionExpiring()`
- **Purpose**: Check if subscription needs renewal
- **Logic**: Compare validity dates
- **Usage**: Internal method

---

## Important Notes

### Webhook Reliability

⚠️ **Razorpay sends webhooks best-effort**
- Razorpay may send webhook multiple times
- Implement idempotency checks
- Check if order already processed

✅ **Best Practice Implementation**
```php
// Check if already processed
$existingOrder = Order::where('razorpay_payment_id', $paymentId)->first();
if ($existingOrder) {
    // Already processed, return success
    return response()->json(['status' => 'ok'], 200);
}

// Process new order
// ...
```

### Security

✅ **Enable Signature Verification**
- Uncomment signature check code
- Use correct key_secret from config
- Always verify before processing

✅ **Never Trust Input**
- Use null-safe operators (@$)
- Validate all data from webhook
- Sanitize before DB operations

### Recurring Payments

✅ **Token Storage**
- Razorpay returns `token_id` in webhook
- Store token for future charges
- Use for recurring payments

✅ **Subscription Status**
- Update subscription status in DB
- Set next billing date
- Enable auto-renewal flag

---

## Summary

**Current Status**: ✅ Webhook handler fully implemented

**Features**:
- ✅ Receives payment.captured events
- ✅ Extracts payment details
- ✅ Processes recurring subscriptions
- ✅ Updates order status
- ✅ Comprehensive logging

**Next Steps**:
1. Enable signature verification (uncomment code)
2. Test with sandbox account
3. Verify subscription updates in logs
4. Deploy to production
5. Monitor webhook logs daily

**Endpoint**: `/razorpay/webhook`

**Method**: POST

**Success Response**: `{"status": "ok"}` HTTP 200
