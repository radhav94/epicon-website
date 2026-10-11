# Razorpay Integration - Notes for Backend Team

## Frontend Expectations from Backend

Based on the frontend implementation, the backend should provide:

---

## 1. Mandate API Response Structure

### Endpoint: `subscriptions/razorpay-mandate/createRequest`
**Method**: POST

**Request Body**:
```json
{
  "planCode": "epic_in_pl_1",
  "authType": "netbanking",
  "device": "web",
  "source": "subscription_screen"
}
```

**Expected Response** ✅ Implemented on Frontend:
```json
{
  "success": true,
  "mandateId": "mandate_1234567890abc",
  "checkout": {
    "customer_id": "cust_1234567890abc",
    "short_url": "https://rzp.io/i/xxxxx",
    "...": "other_checkout_data"
  }
}
```

**Frontend Code** (RazorpayController.php, Line 61-70):
```php
if (@$mandateResponse['success'] === true && 
    !empty(@$mandateResponse['mandateId']) && 
    !empty(@$mandateResponse['checkout'])) {
    $mandateId = $mandateResponse['mandateId'];
    $mandateCheckoutData = $mandateResponse['checkout'];
}
```

---

## 2. Create Order API Response

### Endpoint: `subscriptions/createorder`
**Method**: POST

**Request Body**:
```json
{
  "user_id": "user@example.com",
  "plan_id": "epic_in_pl_1",
  "order_value": 199.00,
  "mobile": "+91XXXXXXXXXX",
  "email": "user@example.com",
  "payment_gateway": "razorpay"
}
```

**Expected Response** ✅ Implemented on Frontend:
```json
{
  "success": true,
  "order_data": {
    "order_id": "ORD12345678",
    "plan_id": "epic_in_pl_1",
    "user_id": "user@example.com",
    "order_value": 199.00,
    "device": "web",
    "plan_name": "1 Month"
  }
}
```

**Frontend Code** (RazorpayController.php, Line 76-92):
```php
$resultData = CurlAPI("subscriptions/createorder", 'POST', $postData, 2, false, true);

if (@$resultData['success'] != true || empty(@$resultData['order_data'])) {
    return response()->view('pages.error.404', [], 404);
}
```

---

## 3. Update Order API Response

### Endpoint: `subscriptions/updateOrder`
**Method**: POST

**Request Body**:
```json
{
  "plan": "epic_in_pl_1",
  "user_id": "user@example.com",
  "order_id": "ORD12345678",
  "order_status": "complete",
  "payment_gateway": "razorpay",
  "bank_ref_no": "pay_1234567890abc",
  "transaction_id": "pay_1234567890abc",
  "authPayuId": "pay_1234567890abc",
  "is_recurring": false,
  "coupon_applied": "NO_COUPON",
  "payment_mode": "razorpay",
  "plan_amount": 199.00,
  "x_country": "IN",
  "x_continent": "AS",
  "mandate_id": "mandate_1234567890abc"
}
```

**Expected Response** ✅ Implemented on Frontend:
```json
{
  "success": true,
  "message": "Order updated successfully"
}
```

**Frontend Code** (RazorpayController.php, Line 215-240):
```php
$updatePayment = CurlAPI("subscriptions/updateOrder", 'POST', $updateOrderData, 2, false, true);

if (@$updatePayment['success']) {
    return view('subscription.thankyou', compact('final_result', 'orderData'));
}
```

---

## 4. Critical Fields for Recurring Charges

### Mandate ID Storage
The frontend **captures and sends** the `mandate_id` in the update order request:
```php
if (!empty($mandateId)) {
    $updateOrderData['mandate_id'] = $mandateId;
}
```

**Backend Responsibility**:
- [ ] Store `mandate_id` in the subscription record
- [ ] Use `mandate_id` for subsequent recurring charges (charge-at-will)
- [ ] Handle mandate expiry/renewal scenarios
- [ ] Track mandate status (active, failed, cancelled)

---

## 5. Payment Gateway Detection

### How Frontend Determines Gateway
1. **From Plan Data**: `data-gateway` attribute on plan buttons
2. **From Payment Method**: Gateway info for each payment type
3. **Fallback**: `config('razorpay.enabled')` environment setting

### Backend Responsibility
- [ ] Return `paymentGateway` field in plan API response
- [ ] Return payment modes with `device: 'web'` filter
- [ ] Support multiple payment methods per gateway:
  - Debit Card
  - Credit Card
  - Net Banking
  - UPI
  - Wallet

---

## 6. Webhook Event Handling

### Razorpay Webhooks Expected
The frontend webhook handler (RazorpayController.php, Line 287) expects:

**Event**: `payment.captured`
```json
{
  "event": "payment.captured",
  "payload": {
    "payment": {
      "entity": {
        "id": "pay_1234567890abc",
        "amount": 19900,
        "currency": "INR",
        "status": "captured"
      }
    }
  }
}
```

**Event**: `payment.failed`
```json
{
  "event": "payment.failed",
  "payload": {
    "payment": {
      "entity": {
        "id": "pay_1234567890abc",
        "error_code": "gateway_error",
        "error_description": "Payment gateway error"
      }
    }
  }
}
```

**Frontend Code** (RazorpayController.php, Line 310-317):
```php
if ($event == 'payment.captured') {
    Log::channel('razorpay_webhook')->info("Payment captured...");
} elseif ($event == 'payment.failed') {
    Log::channel('razorpay_webhook')->info("Payment failed...");
}
```

---

## 7. Error Response Handling

### Mandate API Errors
**Frontend Behavior**:
```php
if (@$mandateResponse['success'] !== true) {
    // Show 404 error page
    return response()->view('pages.error.404', [], 404);
}
```

**Backend Should**:
- [ ] Return `success: false` if mandate creation fails
- [ ] Include error description in response
- [ ] Log error for debugging

### Order API Errors
**Frontend Behavior**:
```php
if (@$resultData['success'] != true || empty(@$resultData['order_data'])) {
    return response()->view('pages.error.404', [], 404);
}
```

---

## 8. Test User Handling

### Development Amount
When `DEV_AMT=true` in .env, test users get ₹1 charge:

**Test User IDs** (Frontend checks):
```php
$userid == '123test123@mailinator.com' ||
$userid == '11test1@mailinator.com' ||
$userid == 'epicontest31@gmail.com' ||
$userid == '8169554956' ||
$userid == '9819208025' ||
// ... and more
```

**Backend Responsibility**:
- [ ] Accept ₹1 charges for test users in test environment
- [ ] Process but mark as test transaction
- [ ] Don't count test transactions in metrics

---

## 9. Currency Conversion

### Current Implementation
Frontend converts USD to INR:
```php
if (strtoupper($currency) == 'USD') {
    $rate = getConvertedPrice('USD', 'INR');
    $totalAmount = $rate * $totalAmount;
    $currency = 'INR';
}
```

**Fallback Rate**: `env('INR_TO_USD_RATE', 83)`

**Backend Responsibility**:
- [ ] Ensure plan data includes `currency` field
- [ ] Support INR and USD in response
- [ ] Provide real-time conversion rate (optional)

---

## 10. Coupon/Promo Code Support

### Coupon Request
When promo code is applied, frontend calls:
```
POST /getCouponAjax
```

### Expected Response
```json
{
  "success": true,
  "message": "Coupon applied",
  "plans": [
    {
      "id": "epic_in_pl_1",
      "discounted_price": 149.00,
      "discount_percentage_value": "25%",
      "actual_price": 199.00
    }
  ]
}
```

**Frontend Behavior**: Updates plan display with discount info

---

## 11. OTP Verification

### For INR Currency
If user missing email/mobile during INR payment:
1. Show update profile modal
2. Collect email or mobile
3. Send OTP via SMS/Email
4. Verify OTP
5. Update profile
6. Proceed with payment

**Endpoints Expected**:
- POST `/sendOtpAjax` - Send OTP
- POST `/verifyOtpAjax` - Verify OTP

---

## 12. Session/Cookie Management

### Order Data Storage
Frontend stores order in cookies (60 min expiry):
```php
Cookie::queue(Cookie::make('orderdata', json_encode($resorder), 60));
Cookie::queue(Cookie::make('create_order', json_encode($orderPostData), 60));
```

**Contains**:
- `order_id`
- `plan_id`
- `user_id`
- `order_value`
- `plan_name`
- `device`

**Backend Consideration**: Order confirmation should reference same order_id

---

## 13. Logging

### Frontend Logs Razorpay operations to:
```
storage/logs/razorpay/razorpay.log
storage/logs/razorpay_webhook/razorpay.log
```

**Sample Log Entry**:
```
--TxId-ORD12345678-- Razorpay Callback Received
[{"razorpay_order_id":"ORD12345678","razorpay_payment_id":"pay_xxx",...}]
```

**Backend Should**:
- [ ] Correlate webhook logs with order IDs
- [ ] Monitor both log files for failures
- [ ] Alert on signature verification failures

---

## 14. Recurring Charge Flow (Charge-at-Will)

### On Initial Payment:
1. Mandate created via API
2. `mandate_id` stored in order
3. Payment processed
4. Subscription activated

### On Subsequent Charges:
1. Backend initiates charge using `mandate_id`
2. Razorpay processes without user interaction
3. Webhook confirms capture/failure
4. Update subscription status

**Frontend Expectation**: Backend handles all recurring charge logic

---

## 15. Performance & Timeout Considerations

### API Call Timeouts
Frontend uses 30-second timeout:
```php
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
```

**Backend Should**:
- [ ] Respond within 30 seconds for all APIs
- [ ] Handle mandate creation (might take longer)
- [ ] Return partial success if mandate fails but order succeeds

---

## Checklist for Backend Implementation

- [ ] Implement Mandate Creation API
- [ ] Implement Order Creation API
- [ ] Implement Order Update API
- [ ] Store mandate_id in subscription
- [ ] Implement recurring charge using mandate
- [ ] Configure Razorpay webhooks
- [ ] Handle webhook signature verification
- [ ] Implement payment gateway selection logic
- [ ] Support test user handling (DEV_AMT)
- [ ] Implement currency conversion (USD to INR)
- [ ] Implement coupon API
- [ ] Implement OTP send/verify APIs
- [ ] Test complete flow end-to-end
- [ ] Test webhook deliveries
- [ ] Monitor logs for errors
- [ ] Document mandate expiry handling
- [ ] Document failure scenarios
- [ ] Implement retry logic for failed payments

---

## Contact & Support

For any frontend implementation questions, refer to:
- Frontend Controller: `app/Http/Controllers/RazorpayController.php`
- Frontend Views: `resources/views/subscription/`
- Configuration: `config/razorpay.php`

Frontend is **ready for production** when backend APIs are implemented.
