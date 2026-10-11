# Buy Subscription Page - Complete API Flow

## Overview
This document traces all API calls made when a user visits the "Buy Subscription" page and clicks "Buy subscription" button.

---

## Step-by-Step Flow

### Step 1: Page Load - Frontend Route
**URL**: `/subscription` or `/subscription-plans`

**Which Controller**: `SubscriptionController@subscription()`

**What it does**:
```php
public function subscription(Request $request)
{
    // Calls: GET /subscriptions/plans via CurlAPI
    $input = [
        'auth_token' => config('epicconfig.EPICAPI.API_AUTH_TOKEN'),
        'x_country' => @$countrycode,
        'x_continent' => @$countrycode,
    ];
    
    $plandataResult = CurlAPI("subscriptions/plans", "GET", $input, 2);
    
    // Returns: plans data to view
    return view('subscription.subscription', compact('result'));
}
```

**API Called**:
```
GET /subscriptions/plans?auth_token=X&x_country=IN&x_continent=AS
```

**Response**:
```json
{
  "success": true,
  "plans": [
    {
      "id": "epic_in_pl_1",
      "name": "STARTER",
      "plan": "1 Month",
      "actual_price": 199,
      "discounted_price": 199,
      "validity_days": 30,
      "currency": "INR",
      "paymentGateway": "razorpay",
      "benefits": []
    }
  ],
  "promotion_text": "Limited time offer"
}
```

---

### Step 2: Page Display - subscription.blade.php
**File**: `resources/views/subscription/subscription.blade.php`

**What shows**:
- ✅ List of plans with prices
- ✅ Plan features/benefits
- ✅ "Buy subscription" button
- ✅ Coupon code input
- ✅ Promo code text

**Plan Data Variables**:
```php
@foreach($result['plans'] as $key => $val)
    {{$val['id']}}              // Plan ID: epic_in_pl_1
    {{$val['name']}}            // Plan name: STARTER
    {{$val['actual_price']}}    // Price: 199
    {{$val['plan']}}            // Duration: 1 Month
    {{$val['paymentGateway']}}  // Gateway: razorpay
@endforeach
```

---

### Step 3: User Clicks "Buy subscription" Button

**Button Code**:
```html
<button class="fill-btn payment glass__effect--btn mb-2" onclick="click_subscription(this)">
    {{__('Buy subscription')}}
</button>
```

**JavaScript Handler** (`ga_tag.js`):
```javascript
function click_subscription() {
    // 1. Logs GA event (no API call)
    dataLayer.push({ 
        event: "click_subscription", 
        element_text: plan_name,
        event_context: plan_price
    });
    
    // 2. Submits form (see next step)
    $(".paymentForm").submit();
}
```

---

### Step 4: Form Submission - paymentMethod Route

**Form**:
```html
<form method="post" action="{{getUrl('paymentMethod')}}" class="paymentForm">
    @csrf
    <input type="hidden" name="amountid" id="amountid" value="epic_in_pl_1">
    <input type="hidden" name="currency" id="currency" value="INR">
    <input type="hidden" name="coupanstatus" id="coupanstatus" value="No">
    <input type="hidden" name="promocode" id="promocode" value=''>
    <input type="hidden" name="paymentGateway" id="gateway" value="razorpay">
</form>
```

**Frontend Route**:
```
POST /paymentMethod
```

**Backend Route** (routes/web.php):
```php
Route::any('paymentMethod', [SubscriptionController::class, 'setSubscription']);
```

**Which Controller**: `SubscriptionController@setSubscription()`

---

### Step 5: setSubscription() Method

**File**: `app/Http/Controllers/SubscriptionController.php`

**What it does**:

```php
public function setSubscription(Request $request)
{
    if($request->has('amountid')){
        $data = $request->all();
        
        // Get payment gateway from request
        $paymentGateway = $request->input('paymentGateway');
        
        // If Razorpay is enabled in .env, route to RazorpayController
        if($paymentGateway == 'PayU') {
            if (config('razorpay.enabled')) {
                return app()->make('App\Http\Controllers\RazorpayController')
                    ->saveSubscriptionRazorpay($request);
            }
            return self::saveSubscription($request);
        }
        
        // Return payment method selection view
        return view('subscription.payment-method', compact('result', 'data', 'paymentMethods'));
    }
}
```

**Calls INTERNAL API 1**:
```php
$plandataResult = CurlAPI("subscriptions/plans", "GET", $input, 2);
```

**Calls INTERNAL API 2** (for payment gateways):
```php
$response = CurlAPI("subscriptions/plans/payment-gateways", "GET", [
    'plan_name' => $data['amountid'],
    'auth_token' => $auth_token
], 2, true, true);
```

**Returns**: `payment-method.blade.php` view with:
- Selected plan details
- Payment method options (Debit Card, Credit Card, UPI, Netbanking)

---

### Step 6: User Selects Payment Method

**File**: `resources/views/subscription/payment-method.blade.php`

**Form**:
```html
<form name="checkoutsubscriptionform" method="post" id="checkoutsubscriptionid" 
      action="{{ config('razorpay.enabled') ? route('saveSubscriptionRazorpay') : route('saveSubscription') }}">
    @csrf
    <input type="hidden" name="amount" value="199">
    <input type="hidden" name="amountid" value="epic_in_pl_1">
    <input type="hidden" name="payment_type" value="DC">
</form>
```

**Payment Method Buttons**:
```html
<button type="button" class="button-type active" data-attr="DC">Debit Card</button>
<button type="button" class="button-type" data-attr="CC">Credit Card</button>
<button type="button" class="button-type" data-attr="NB">Net Banking</button>
<button type="button" class="button-type" data-attr="UPI">UPI</button>
```

**Continue Pay Button**:
```html
<button class="fill-btn payment glass__effect--btn" type="submit">
    Continue Pay ₹199
</button>
```

---

### Step 7: Form Submission - saveSubscriptionRazorpay Route

**Frontend Route** (if `RAZORPAY_ENABLED=true`):
```
POST /saveSubscriptionRazorpay
```

**Backend Route** (routes/web.php):
```php
Route::post('saveSubscriptionRazorpay', [RazorpayController::class, 'saveSubscriptionRazorpay']);
```

**Which Controller**: `RazorpayController@saveSubscriptionRazorpay()`

---

### Step 8: saveSubscriptionRazorpay() Method

**File**: `app/Http/Controllers/RazorpayController.php`

**What it does**:

#### API Call 1 - Get Plans (for pricing verification):
```php
$plandataResult = CurlAPI("subscriptions/plans", "GET", $input, 2);
```

**Endpoint**:
```
GET /subscriptions/plans?auth_token=X
```

#### API Call 2 - ⚠️ MANDATE API (DEPRECATED - needs fix):
```php
$mandateResponse = CurlAPI("subscriptions/razorpay-mandate/createRequest", 'POST', $mandateData, 2, false, true);
```

**Endpoint**:
```
POST /subscriptions/razorpay-mandate/createRequest
Body: {
  "planCode": "epic_in_pl_1",
  "authType": "netbanking",
  "device": "web",
  "source": "subscription_screen"
}
```

**Status**: ❌ **DEPRECATED - Backend no longer supports this**

#### API Call 3 - Create Order:
```php
$resultData = CurlAPI("subscriptions/createorder", 'POST', $postData, 2, false, true);
```

**Endpoint**:
```
POST /subscriptions/createorder
Body: {
  "user_id": "user@example.com",
  "plan_id": "epic_in_pl_1",
  "order_value": 199,
  "mobile": "9999999999",
  "email": "user@example.com",
  "payment_gateway": "razorpay"
}
```

**Response**:
```json
{
  "success": true,
  "order_data": {
    "order_id": "ORD12345678",
    "plan_id": "epic_in_pl_1",
    "user_id": "user@example.com",
    "order_value": 199,
    "device": "web"
  }
}
```

#### API Call 4 - ⚠️ Create Razorpay Order (SHOULD BE REMOVED):
```php
$razorpayOrder = $this->createRazorpayOrder($txid, $totalAmount, $currency);
```

**Direct Razorpay API Call**:
```
POST https://api.razorpay.com/v1/orders
```

**Status**: ❌ **NOT ALLOWED - Backend contract forbids direct Razorpay calls**

#### Returns:
`resources/views/subscription/razorpay.blade.php` with checkout parameters

---

### Step 9: Razorpay Checkout Opens

**File**: `resources/views/subscription/razorpay.blade.php`

**JavaScript**:
```javascript
var options = {
    "key": "{{ $parameters['razorpay_key'] }}",
    "order_id": "{{ $parameters['razorpay_order_id'] }}",
    "amount": "{{ $parameters['amount'] }}",
    "currency": "{{ $parameters['currency'] }}",
    "handler": function(response) {
        // Send to razorpay.callback
    }
};

var rzp = new Razorpay(options);
rzp.open();
```

**User authorizes payment** → **Razorpay returns response**

---

### Step 10: Payment Callback

**Frontend Route**:
```
POST /razorpay/callback
```

**Backend Route** (routes/web.php):
```php
Route::post('/razorpay/callback', [RazorpayController::class, 'razorpayCallback']);
```

**Which Controller**: `RazorpayController@razorpayCallback()`

**What it does**:

#### API Call - Update Order:
```php
$updatePayment = CurlAPI("subscriptions/updateOrder", 'POST', $updateOrderData, 2, false, true);
```

**Endpoint**:
```
POST /subscriptions/updateOrder
Body: {
  "plan": "epic_in_pl_1",
  "user_id": "user@example.com",
  "order_id": "ORD12345678",
  "order_status": "complete",
  "payment_gateway": "razorpay",
  "bank_ref_no": "pay_XXXXX",
  "transaction_id": "pay_XXXXX",
  "is_recurring": false,
  "payment_mode": "razorpay",
  "mandate_id": "mandate_XXXXX"
}
```

**Response**:
```json
{
  "success": true,
  "message": "Order updated successfully"
}
```

#### Shows:
- ✅ `subscription/thankyou.blade.php` - Success page
- ❌ `subscription/subscription-fail.blade.php` - Failure page

---

## API Summary Table

### All APIs Called in Order:

| Step | API Endpoint | Method | Purpose | Controller |
|------|--------------|--------|---------|-----------|
| 1 | `/subscriptions/plans` | GET | Load plans | SubscriptionController |
| 2 | `/subscriptions/plans/payment-gateways` | GET | Get payment methods | SubscriptionController |
| 3 | `/subscriptions/razorpay-mandate/createRequest` | POST | ❌ Create mandate (DEPRECATED) | RazorpayController |
| 4 | `/subscriptions/createorder` | POST | Create order | RazorpayController |
| 5 | `https://api.razorpay.com/v1/orders` | POST | ❌ Create Razorpay order (FORBIDDEN) | RazorpayController |
| 6 | *Razorpay Checkout Modal* | - | User authorizes payment | Razorpay |
| 7 | `/razorpay/callback` | POST | Verify payment | RazorpayController |
| 8 | `/subscriptions/updateOrder` | POST | Update subscription | RazorpayController |

---

## Data Flow Diagram

```
┌─────────────────────────────────────────────────────────────┐
│  User visits: /subscription                                 │
│  Frontend: subscription.blade.php                           │
└─────────────────────────────────────────────────────────────┘
                         │
                         ↓
        ┌────────────────────────────────────┐
        │ API 1: GET /subscriptions/plans     │
        │ Returns: All subscription plans     │
        └────────────────────────────────────┘
                         │
                         ↓
     ┌──────────────────────────────────────────┐
     │ Display: Plan cards with prices          │
     │ User sees: "Buy subscription" button      │
     └──────────────────────────────────────────┘
                         │
                         ↓
          ┌──────────────────────────────┐
          │ User clicks: "Buy subscription"│
          │ Form: POST /paymentMethod      │
          └──────────────────────────────┘
                         │
                         ↓
        ┌────────────────────────────────────┐
        │ SubscriptionController@setSubscription
        │ API 2: GET /subscriptions/plans     │
        │ API 3: GET /subscriptions/plans/    │
        │        payment-gateways            │
        └────────────────────────────────────┘
                         │
                         ↓
     ┌──────────────────────────────────────────┐
     │ Display: Payment method selection view    │
     │ User sees: DC, CC, UPI, NB buttons        │
     └──────────────────────────────────────────┘
                         │
                         ↓
          ┌──────────────────────────────┐
          │ User selects payment method   │
          │ Clicks: "Continue Pay ₹199"   │
          │ Form: POST /saveSubscriptionRazorpay
          └──────────────────────────────┘
                         │
                         ↓
        ┌────────────────────────────────────┐
        │ RazorpayController@saveSubscriptionRazorpay
        │ API 4: GET /subscriptions/plans     │
        │ API 5: POST /subscriptions/         │
        │        razorpay-mandate/createRequest (❌ DEPRECATED)
        │ API 6: POST /subscriptions/createorder
        │ API 7: POST https://api.razorpay... (❌ FORBIDDEN)
        └────────────────────────────────────┘
                         │
                         ↓
     ┌──────────────────────────────────────────┐
     │ Open: Razorpay Checkout Modal            │
     │ User authorizes: Mandate/Payment          │
     └──────────────────────────────────────────┘
                         │
                         ↓
          ┌──────────────────────────────┐
          │ Razorpay returns response     │
          │ User redirected to callback   │
          │ Form: POST /razorpay/callback │
          └──────────────────────────────┘
                         │
                         ↓
        ┌────────────────────────────────────┐
        │ RazorpayController@razorpayCallback
        │ API 8: POST /subscriptions/         │
        │        updateOrder                  │
        └────────────────────────────────────┘
                         │
                         ↓
     ┌──────────────────────────────────────────┐
     │ Show: Success page or Failure page        │
     │ Subscription: Active or Failed            │
     └──────────────────────────────────────────┘
```

---

## Which APIs Are Called When User Clicks "Buy Subscription"?

### Direct Answer:

When user clicks "Buy subscription" button on `/subscription` page:

1. **Form submits to**: `POST /paymentMethod`
   - Calls: `SubscriptionController@setSubscription()`

2. **Inside setSubscription()**:
   - API: `GET /subscriptions/plans` - Verify plan pricing
   - API: `GET /subscriptions/plans/payment-gateways` - Get payment options
   - Returns: Payment method selection view

3. **User selects payment method and clicks "Continue Pay"**:
   - Form submits to: `POST /saveSubscriptionRazorpay` (if Razorpay enabled)
   - Calls: `RazorpayController@saveSubscriptionRazorpay()`

4. **Inside saveSubscriptionRazorpay()**:
   - API: `GET /subscriptions/plans` - Get pricing again
   - API: `POST /subscriptions/razorpay-mandate/createRequest` - ❌ DEPRECATED
   - API: `POST /subscriptions/createorder` - Create order
   - API: `POST https://api.razorpay.com/v1/orders` - ❌ FORBIDDEN (direct Razorpay)
   - Returns: Razorpay checkout page

---

## Environment Variable Control

**When `RAZORPAY_ENABLED=true` (.env)**:
- Routes to: `RazorpayController@saveSubscriptionRazorpay()`
- Uses Razorpay payment gateway

**When `RAZORPAY_ENABLED=false`**:
- Routes to: `SubscriptionController@saveSubscription()` (PayU)
- Uses PayU payment gateway

---

## Issues Found (Per Backend Contract)

| Issue | Current | Required | Fix |
|-------|---------|----------|-----|
| Mandate API | Used | Removed | Remove API call |
| Create Order | ✅ Called | ✅ Called | No change |
| Direct Razorpay API | Used | Forbidden | Remove method |
| Checkout structure | Wrong | Correct | Update params |
| Free-trial support | ❌ Missing | ✅ Required | Add support |
| Payment mode tracking | ❌ Missing | ✅ Required | Add tracking |

---

## Conclusion

**Main API called when clicking "Buy subscription"**: 
- **Route**: `POST /paymentMethod`
- **Controller**: `SubscriptionController@setSubscription()`
- **External APIs**: 
  - `GET /subscriptions/plans`
  - `GET /subscriptions/plans/payment-gateways`

**Then user selects payment method and gets**:
- **Route**: `POST /saveSubscriptionRazorpay`
- **Controller**: `RazorpayController@saveSubscriptionRazorpay()`
- **External APIs**: Multiple (see issues above)

For the backend contract update, follow the **RAZORPAY_QUICK_FIX_GUIDE.md**.
