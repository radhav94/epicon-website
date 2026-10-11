# orderdata Cookie - Complete Reference

## 📍 WHERE IS orderdata SET?

### **1. Location: RazorpayController.php (Line 139)**

```php
// File: app/Http/Controllers/RazorpayController.php
// Function: saveSubscriptionRazorpay()

$resorder = $resultData['order_data'];  // API response data

Cookie::queue(Cookie::make('orderdata', json_encode($resorder), 60));
```

**When:** After successful API call to `subscriptions/createorder`
**Duration:** 60 minutes
**Value:** JSON-encoded response from backend API

---

## 🔍 ORDERDATA COOKIE STRUCTURE

### **What it contains:**

```php
$orderdata = [
    'order_id' => string,           // ✅ Unique order ID
    'plan_id' => string,            // ✅ Subscription plan ID
    'user_id' => string,            // ✅ User email/ID
    'order_value' => float,         // ✅ Amount to pay
    'plan_name' => string,          // ✅ e.g., "Monthly", "6 Months", "1 Year"
    'subscription_end_date' => string,  // ✅ When subscription expires
    'payment_gateway' => 'razorpay',    // ✅ Gateway used
    'device' => string,             // ✅ Device type
    'checkout' => [
        'order_id' => string,       // ✅ Razorpay order ID
        'customer_id' => string,    // ✅ For mandate
    ],
    'token' => string,              // ✅ Saved card token
];
```

---

## 🔑 KEY VALIDATION CHECKS

### **Is the orderdata cookie set?**

```php
// ✅ Check if cookie exists and is valid
$orderData = !empty(Cookie::get('orderdata') ?? '') ? json_decode(Cookie::get('orderdata'), true) : null;

// ✅ Validate key existence
if (!$orderData) {
    echo "orderdata cookie NOT set or empty";
}
```

### **Where is it validated?**

**File:** `app/Http/Controllers/RazorpayController.php`
**Function:** `razorpayCallback()` (Line 199-204)

```php
// Get order data from cookies
$orderData = !empty(Cookie::get('orderdata') ?? '') ? json_decode(Cookie::get('orderdata'), true) : null;
$orderValue = !empty(Cookie::get('create_order') ?? '') ? json_decode(Cookie::get('create_order'), true) : null;

$final_result = ['message' => 'The transaction has been declined.'];

// ✅ VALIDATION: Both cookies must exist
if (!isUserLoggedIn() || !$orderData || !$orderValue) {
    return redirect('login');
}
```

---

## 📋 REQUIRED KEYS IN orderdata

When validating, check for these **essential keys**:

```php
// ✅ In razorpayCallback() - checks for these:
if (!isUserLoggedIn() || !$orderData || !$orderValue) {
    // ❌ FAIL: Missing either cookie
}

// ✅ In thankyou.blade.php - checks for:
if(!empty($orderData) && isset($orderData['plan_id'])){
    $planId = $orderData['plan_id'];  // ✅ REQUIRED
}

if(isset($orderData['subscription_end_date'])){
    $enddate = date('jS F, Y h:i A', strtotime($orderData['subscription_end_date']));
}
```

**Essential keys to validate:**
- ✅ `$orderData` (not null, not empty)
- ✅ `$orderData['plan_id']` - Must exist
- ✅ `$orderData['order_id']` - Must exist
- ✅ `$orderData['subscription_end_date']` - Should exist
- ✅ `$orderData['order_value']` - Must exist

---

## 🗑️ WHERE IS orderdata CLEARED?

### **Location 1: After successful payment**
```php
// File: RazorpayController.php - razorpayCallback() (Line 246)
if (@$updatePayment['success']) {
    $this->razorpayEventPush('success');
    Cookie::queue(Cookie::make('orderdata', '', -1));  // ✅ CLEARED
    Cookie::queue(Cookie::make('create_order', '', -1));
}
```

### **Location 2: After payment failure**
```php
// File: RazorpayController.php - razorpayCallback() (Line 254)
} else {
    Cookie::queue(Cookie::make('orderdata', '', -1));  // ✅ CLEARED
    Cookie::queue(Cookie::make('create_order', '', -1));
}
```

### **Location 3: Payment error handler**
```php
// File: RazorpayController.php - handlePaymentError() (Line 270)
public function handlePaymentError() {
    Cookie::queue(Cookie::make('orderdata', '', -1));  // ✅ CLEARED
    Cookie::queue(Cookie::make('create_order', '', -1));
}
```

### **Location 4: Logout function**
```php
// File: app/Helpers/helpers.php (Line 2306)
function logout_user() {
    Cookie::queue(Cookie::make('orderdata', '', -1));  // ✅ CLEARED on logout
}
```

---

## 🧪 HOW TO TEST / VERIFY

### **Test 1: Check if cookie is set during checkout**

```php
// In your controller:
$orderData = Cookie::get('orderdata');
dd($orderData);  // Should show JSON object
```

### **Test 2: Check in browser DevTools**

1. Open DevTools (F12)
2. Go to **Storage > Cookies**
3. Look for `orderdata`
4. It should contain JSON like:
```json
{
    "order_id": "ORD123456",
    "plan_id": "plan_monthly",
    "user_id": "user@email.com",
    "order_value": 199,
    "subscription_end_date": "2026-10-09 00:00:00"
}
```

### **Test 3: Check if it gets cleared after payment**

```php
// After payment callback
$orderData = Cookie::get('orderdata');
// Should be NULL or empty
```

---

## ✅ VALIDATION CHECKLIST

| Check | Where | Status |
|-------|-------|--------|
| Cookie set after order creation | RazorpayController::saveSubscriptionRazorpay() | ✅ Line 139 |
| Cookie validated before payment | RazorpayController::razorpayCallback() | ✅ Line 199-204 |
| Requires plan_id key | thankyou.blade.php | ✅ Line 12 |
| Requires order_id key | RazorpayController::razorpayCallback() | ✅ Line 217 |
| Cleared after success | RazorpayController::razorpayCallback() | ✅ Line 246 |
| Cleared after failure | RazorpayController::razorpayCallback() | ✅ Line 254 |
| Cleared on logout | helpers.php::logout_user() | ✅ Line 2306 |

---

## 🚨 COMMON ISSUES

### **Issue 1: orderdata cookie not found**
**Cause:** Order creation failed before reaching Line 139
**Fix:** Check API response in logs
```
Log file: storage/logs/razorpay/razorpay-*.log
```

### **Issue 2: orderdata is empty**
**Cause:** JSON encoding/decoding failed
**Fix:** 
```php
$orderData = json_decode(Cookie::get('orderdata'), true, JSON_THROW_ON_ERROR);
```

### **Issue 3: Missing required key**
**Cause:** API returned incomplete data
**Fix:** Validate all required fields exist:
```php
$required = ['order_id', 'plan_id', 'user_id', 'order_value'];
foreach ($required as $key) {
    if (!isset($orderData[$key])) {
        throw new Exception("Missing key: $key");
    }
}
```

### **Issue 4: Cookie expired before callback**
**Cause:** Takes > 60 minutes between order creation and payment
**Fix:** Increase cookie duration in Line 139:
```php
Cookie::queue(Cookie::make('orderdata', json_encode($resorder), 120));  // 2 hours
```

---

## 📚 RELATED COOKIES

| Cookie | Set | Cleared | Purpose |
|--------|-----|---------|---------|
| `orderdata` | Line 139 | Line 246, 254, 270 | Order details |
| `create_order` | Line 139 | Line 248, 256, 272 | Plan selection |
| `subscriptioPurchases` | - | Line 194 | Purchase tracking |
| `listLanguage` | - | logout_user() | User language |

---

## 🔗 RELATED FILES

- `/app/Http/Controllers/RazorpayController.php` - Main cookie setter/validator
- `/app/Helpers/helpers.php` - Cookie clearer
- `/resources/views/subscription/thankyou.blade.php` - Cookie consumer
- `/storage/logs/razorpay/` - Debug logs
