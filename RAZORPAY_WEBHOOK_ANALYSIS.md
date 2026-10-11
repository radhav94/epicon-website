# Razorpay Webhook Analysis

## Webhook Event Received

**Event Type**: `payment.captured`

```json
{
  "entity": "event",
  "account_id": "acc_RNjTpmJDDvrEM4",
  "event": "payment.captured",
  "contains": ["payment"],
  "payload": {
    "payment": {
      "entity": {
        "id": "pay_TTzYr2zGkU8WEr",
        "entity": "payment",
        "amount": 100,
        "currency": "INR",
        "status": "captured",
        "order_id": "order_TTzYOAk4PA49UV",
        "invoice_id": null,
        "international": false,
        "method": "card",
        "amount_refunded": 0,
        "refund_status": null,
        "captured": true,
        "description": "Epicon Subscription - STARTER",
        "card_id": "card_TTzYrEpZs6ErQy",
        "card": {
          "id": "card_TTzYrEpZs6ErQy",
          "entity": "card",
          "name": "",
          "last4": "4366",
          "network": "Visa",
          "type": "credit",
          "issuer": "UTIB",
          "international": false,
          "emi": true,
          "sub_type": "consumer",
          "token_iin": "471860910"
        },
        "bank": null,
        "wallet": null,
        "vpa": null,
        "email": "epicsub2@yopmail.com",
        "contact": "+919136324994",
        "token_id": "token_TTzYrUxQYRGWPM",
        "notes": {
          "epicon_order_id": "2846388"
        },
        "fee": 3,
        "tax": 0,
        "error_code": null,
        "error_description": null,
        "error_source": null,
        "error_step": null,
        "error_reason": null,
        "acquirer_data": {
          "auth_code": "257655"
        },
        "created_at": 1787658572,
        "reward": null,
        "base_amount": 100
      }
    }
  },
  "created_at": 1787658582
}
```

---

## Key Information Extracted

| Field | Value | Purpose |
|-------|-------|---------|
| `event` | `payment.captured` | Payment successfully captured |
| `payment.id` | `pay_TTzYr2zGkU8WEr` | Razorpay payment ID |
| `payment.amount` | `100` | Amount in paise (₹1.00) |
| `payment.currency` | `INR` | Indian Rupees |
| `payment.status` | `captured` | Payment captured successfully |
| `payment.order_id` | `order_TTzYOAk4PA49UV` | Razorpay order ID |
| `payment.method` | `card` | Payment method (Card) |
| `payment.card.last4` | `4366` | Last 4 digits of card |
| `payment.card.network` | `Visa` | Card network |
| `payment.email` | `epicsub2@yopmail.com` | Customer email |
| `payment.contact` | `+919136324994` | Customer phone |
| `payment.notes.epicon_order_id` | `2846388` | Our internal order ID |
| `payment.token_id` | `token_TTzYrUxQYRGWPM` | Saved card token for recurring |

---

## Flow Analysis

### Step 1: Payment Flow
```
1. Frontend submits Razorpay form
2. Razorpay opens modal
3. User completes card payment
4. Razorpay captures payment
5. Razorpay sends webhook: payment.captured
6. Backend receives webhook
7. Backend verifies & processes
```

### Step 2: Webhook Structure
```
Event triggered: payment.captured
├── Contains payment details
├── Payment status: captured
├── Order ID linked to our system
└── Card token saved for recurring
```

### Step 3: Our System Integration
```
Razorpay sends webhook
  ↓
/razorpay/webhook endpoint receives
  ↓
Extract payment ID: pay_TTzYr2zGkU8WEr
Extract order ID: order_TTzYOAk4PA49UV
Extract our order: notes.epicon_order_id: 2846388
Extract token: token_TTzYrUxQYRGWPM
  ↓
Verify signature
  ↓
Update subscription status
  ↓
Store payment details
```

---

## What This Webhook Tells Us

✅ **Payment Status**
- Status: `captured` (Payment successfully processed)
- Amount: 100 paise = ₹1.00 (Free trial charge)

✅ **Customer Information**
- Email: `epicsub2@yopmail.com`
- Phone: `+919136324994`

✅ **Payment Method**
- Method: Credit Card
- Network: Visa
- Last 4: 4366
- Issuer: UTIB (Axis Bank)

✅ **Recurring Payment Setup**
- Token ID: `token_TTzYrUxQYRGWPM`
- Can be used for future charges

✅ **Our Order Tracking**
- Epicon Order ID: `2846388`
- Razorpay Order ID: `order_TTzYOAk4PA49UV`
- Razorpay Payment ID: `pay_TTzYr2zGkU8WEr`

---

## Expected Webhook Handler Response

The webhook handler should:

1. **Receive webhook**
```php
POST /razorpay/webhook
Headers: {
  "X-Razorpay-Signature": "signature_xxx"
}
Body: {
  "event": "payment.captured",
  "payload": { ... }
}
```

2. **Verify Signature**
```php
// Backend uses key_secret to verify
HMAC_SHA256(webhook_body, key_secret) == signature
```

3. **Process Payment**
```php
// Extract from webhook
$paymentId = $payload['payment']['entity']['id'];
$amount = $payload['payment']['entity']['amount'];
$status = $payload['payment']['entity']['status'];
$epicOrderId = $payload['payment']['entity']['notes']['epicon_order_id'];
$tokenId = $payload['payment']['entity']['token_id'];

// Update order in DB
UPDATE orders SET payment_status = 'captured' WHERE order_id = $epicOrderId;

// Update subscription
UPDATE subscriptions SET 
  razorpay_token_id = $tokenId,
  recurring_enabled = true
WHERE order_id = $epicOrderId;
```

4. **Return Response**
```php
// Always return 200 to acknowledge receipt
return response()->json(['success' => true], 200);
```

---

## Next Steps

### 1. Create Webhook Endpoint
**File**: `routes/web.php`
```php
Route::post('/razorpay/webhook', [RazorpayController::class, 'handleWebhook']);
```

### 2. Implement Webhook Handler
**File**: `RazorpayController.php`
```php
public function handleWebhook(Request $request)
{
    // Get webhook data
    $data = $request->all();
    
    // Verify signature
    if (!$this->verifyWebhookSignature($data)) {
        return response()->json(['error' => 'Invalid signature'], 401);
    }
    
    // Process payment
    if ($data['event'] == 'payment.captured') {
        $this->processPaymentCaptured($data);
    }
    
    // Always return 200
    return response()->json(['success' => true], 200);
}
```

### 3. Process Payment Captured
```php
private function processPaymentCaptured($data)
{
    $payment = $data['payload']['payment']['entity'];
    
    // Extract details
    $paymentId = $payment['id'];
    $amount = $payment['amount'] / 100;  // Convert paise to rupees
    $epicOrderId = $payment['notes']['epicon_order_id'];
    $tokenId = $payment['token_id'];
    
    // Update order
    DB::table('orders')->where('order_id', $epicOrderId)->update([
        'razorpay_payment_id' => $paymentId,
        'payment_status' => 'captured',
    ]);
    
    // Update subscription
    DB::table('subscriptions')->where('order_id', $epicOrderId)->update([
        'razorpay_token_id' => $tokenId,
        'subscription_status' => 'active',
    ]);
    
    Log::info('Payment captured', ['payment_id' => $paymentId, 'amount' => $amount]);
}
```

### 4. Verify Webhook Signature
```php
private function verifyWebhookSignature($data)
{
    $signature = request()->header('X-Razorpay-Signature');
    $secret = config('razorpay.key_secret');
    
    $body = file_get_contents('php://input');
    $generated = hash_hmac('sha256', $body, $secret);
    
    return hash_equals($generated, $signature);
}
```

---

## Important Notes

### Webhook Security
- ✅ Always verify signature before processing
- ✅ Use `key_secret` (keep private)
- ✅ Compare signatures with timing-safe functions (`hash_equals`)

### Idempotency
- Webhook might be called multiple times
- Always check if order already processed
- Use `payment_status` to skip duplicates

### Logging
- Log all webhook events
- Include payment ID and amount
- Track processing time

### Token Storage
- Store `token_id` from webhook
- Use for recurring payments
- Don't expose token to frontend

---

## Testing Webhook

### Local Testing (ngrok)
```bash
# Start ngrok
ngrok http 8000

# Use ngrok URL in Razorpay settings
https://your-ngrok-url.ngrok.io/razorpay/webhook

# Send test webhook
curl -X POST https://your-ngrok-url.ngrok.io/razorpay/webhook \
  -H "Content-Type: application/json" \
  -H "X-Razorpay-Signature: test_signature" \
  -d @webhook-payload.json
```

### Production Testing
- Use Razorpay sandbox first
- Test with small amount (₹1)
- Verify order status updates
- Check subscription activated
- Monitor logs for errors

---

## Summary

This webhook indicates:
- ✅ Payment successfully captured
- ✅ Card token saved for recurring
- ✅ Free trial charge processed (₹1.00)
- ✅ Ready for next renewal charge

Backend should:
1. Verify webhook signature
2. Extract payment details
3. Update order status
4. Activate subscription
5. Store token for recurring

Ready to implement webhook handler!
