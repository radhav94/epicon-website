# API Calls Quick Reference - Buy Subscription Flow

## TL;DR - Which API is Called?

### When User Clicks "Buy Subscription" Button:

```
POST /paymentMethod
  ↓
SubscriptionController@setSubscription()
  ├─ API Call 1: GET /subscriptions/plans
  └─ API Call 2: GET /subscriptions/plans/payment-gateways
  ↓
Return: payment-method.blade.php (payment method selection)
```

---

## After User Selects Payment Method:

```
POST /saveSubscriptionRazorpay (if RAZORPAY_ENABLED=true)
  ↓
RazorpayController@saveSubscriptionRazorpay()
  ├─ API Call 3: GET /subscriptions/plans
  ├─ API Call 4: POST /subscriptions/razorpay-mandate/createRequest ❌ DEPRECATED
  ├─ API Call 5: POST /subscriptions/createorder
  └─ API Call 6: POST https://api.razorpay.com/v1/orders ❌ FORBIDDEN
  ↓
Return: razorpay.blade.php (Razorpay Checkout modal)
```

---

## After Razorpay Callback:

```
POST /razorpay/callback
  ↓
RazorpayController@razorpayCallback()
  ├─ API Call 7: POST /subscriptions/updateOrder
  ↓
Return: subscription/thankyou.blade.php or subscription-fail.blade.php
```

---

## Complete API Endpoint List

| # | Endpoint | Method | Status | Purpose |
|---|----------|--------|--------|---------|
| 1 | `/subscriptions/plans` | GET | ✅ Used | Get all subscription plans with pricing |
| 2 | `/subscriptions/plans/payment-gateways` | GET | ✅ Used | Get available payment methods for a plan |
| 3 | `/subscriptions/razorpay-mandate/createRequest` | POST | ❌ DEPRECATED | Create mandate (OLD METHOD) |
| 4 | `/subscriptions/createorder` | POST | ✅ Used | Create order for subscription |
| 5 | `https://api.razorpay.com/v1/orders` | POST | ❌ FORBIDDEN | Create Razorpay order (NOT ALLOWED) |
| 6 | `/razorpay/callback` | POST | ✅ Used | Receive payment callback |
| 7 | `/subscriptions/updateOrder` | POST | ✅ Used | Update order with payment details |

---

## Frontend Routes & Controllers

| Frontend Route | Method | Controller | Action | Purpose |
|----------------|--------|-----------|--------|---------|
| `/subscription` | GET | SubscriptionController | subscription() | Show plans |
| `/paymentMethod` | POST | SubscriptionController | setSubscription() | Show payment methods |
| `/saveSubscriptionRazorpay` | POST | RazorpayController | saveSubscriptionRazorpay() | Create order & show checkout |
| `/razorpay/callback` | POST | RazorpayController | razorpayCallback() | Handle payment result |
| `/razorpay/failed` | ANY | RazorpayController | razorpayFailed() | Handle payment failure |

---

## Environment Variable Control

### When RAZORPAY_ENABLED=true:
- Routes `/paymentMethod` → `setSubscription()` → Shows payment method selection
- Routes `/saveSubscriptionRazorpay` → `saveSubscriptionRazorpay()` → Razorpay checkout
- Uses Razorpay payment gateway
- Calls Razorpay APIs

### When RAZORPAY_ENABLED=false:
- Routes `/paymentMethod` → `setSubscription()` → Shows payment method selection  
- Routes `/saveSubscription` → `saveSubscription()` → PayU checkout
- Uses PayU payment gateway (legacy)
- Calls PayU APIs

---

## File Locations

### Controllers:
- `app/Http/Controllers/SubscriptionController.php` - Main subscription logic
- `app/Http/Controllers/RazorpayController.php` - Razorpay payment logic

### Views:
- `resources/views/subscription/subscription.blade.php` - Plan selection (Buy Subscription button here)
- `resources/views/subscription/payment-method.blade.php` - Payment method selection
- `resources/views/subscription/razorpay.blade.php` - Razorpay checkout modal
- `resources/views/subscription/thankyou.blade.php` - Success page
- `resources/views/subscription/subscription-fail.blade.php` - Failure page

### Routes:
- `routes/web.php` - All route definitions

### Configuration:
- `config/razorpay.php` - Razorpay config (uses RAZORPAY_ENABLED env var)
- `.env` - Environment variables (RAZORPAY_ENABLED=true)

---

## Step-by-Step What Happens

### 1️⃣ User visits /subscription
```
✅ Calls: GET /subscriptions/plans
✅ Displays: Plan cards with prices
✅ Shows: "Buy subscription" button
```

### 2️⃣ User clicks "Buy subscription"
```
✅ Calls: POST /paymentMethod
✅ Inside: GET /subscriptions/plans (verify pricing)
✅ Inside: GET /subscriptions/plans/payment-gateways
✅ Displays: Payment method selection (Debit Card, Credit Card, UPI, etc.)
```

### 3️⃣ User selects payment method & clicks "Continue Pay"
```
✅ Calls: POST /saveSubscriptionRazorpay
✅ Inside: GET /subscriptions/plans
✅ ❌ Inside: POST /subscriptions/razorpay-mandate/createRequest (DEPRECATED)
✅ Inside: POST /subscriptions/createorder
✅ ❌ Inside: POST https://api.razorpay.com/v1/orders (FORBIDDEN)
✅ Displays: Razorpay Checkout modal
```

### 4️⃣ User completes payment in Razorpay modal
```
✅ Razorpay returns: Payment ID, Signature
✅ Calls: POST /razorpay/callback (automatically)
✅ Inside: POST /subscriptions/updateOrder
✅ Displays: Success page OR Failure page
```

---

## Key Points

✅ **Main API when clicking "Buy subscription"**:
- Frontend: `POST /paymentMethod`
- Backend: `SubscriptionController@setSubscription()`

✅ **APIs called during payment**:
- `/subscriptions/plans` - Pricing verification
- `/subscriptions/plans/payment-gateways` - Payment options
- `/subscriptions/createorder` - Create order
- `/subscriptions/updateOrder` - Update subscription

❌ **APIs NOT to call (per backend contract)**:
- `POST /subscriptions/razorpay-mandate/createRequest` - DEPRECATED
- `POST https://api.razorpay.com/v1/orders` - FORBIDDEN (direct Razorpay)

---

## What Needs to Change

Based on backend contract:

| Item | Current | Change | Reason |
|------|---------|--------|--------|
| Mandate API | Used ❌ | Remove ❌ | Backend doesn't support |
| Create Order | ✅ Used | Keep ✅ | Still needed |
| Razorpay Order API | Used ❌ | Remove ❌ | Backend creates orders |
| Checkout params | Wrong ❌ | Fix ✅ | Use subscription_id |
| Free-trial support | Missing ❌ | Add ✅ | Backend provides free_trial flag |
| Payment mode tracking | Missing ❌ | Add ✅ | Backend needs subscriptionPaymentMode |

---

## Where to Find More Info

📄 **Documentation**:
- `RAZORPAY_BACKEND_CONTRACT_COMPLIANCE_REPORT.md` - Full gap analysis
- `RAZORPAY_QUICK_FIX_GUIDE.md` - Exact code changes needed
- `RAZORPAY_INTEGRATION_SUMMARY.md` - Executive summary
- `BUY_SUBSCRIPTION_API_FLOW.md` - Complete flow diagram

🔧 **To implement fixes**:
1. Start with: `RAZORPAY_QUICK_FIX_GUIDE.md`
2. Use exact code replacements provided
3. Follow implementation timeline

✅ **To verify**:
- Check `BUY_SUBSCRIPTION_API_FLOW.md` for complete data flow
- Review test scenarios in `RAZORPAY_INTEGRATION_SUMMARY.md`

---

## Direct Answers

### Q: Which API is called when user clicks "Buy subscription" button?
**A**: `POST /paymentMethod` → `SubscriptionController@setSubscription()`

### Q: What APIs are called inside setSubscription()?
**A**: 
- `GET /subscriptions/plans`
- `GET /subscriptions/plans/payment-gateways`

### Q: Which API is called after user selects payment method?
**A**: `POST /saveSubscriptionRazorpay` → `RazorpayController@saveSubscriptionRazorpay()`

### Q: What APIs are called inside saveSubscriptionRazorpay()?
**A**:
- `GET /subscriptions/plans`
- `POST /subscriptions/razorpay-mandate/createRequest` ❌ (DEPRECATED)
- `POST /subscriptions/createorder`
- `POST https://api.razorpay.com/v1/orders` ❌ (FORBIDDEN)

### Q: What determines if Razorpay or PayU is used?
**A**: `RAZORPAY_ENABLED` in `.env` file
- `true` = Razorpay
- `false` = PayU

---

## .env Configuration

```bash
# Enable/Disable Razorpay
RAZORPAY_ENABLED=true

# Razorpay Keys (optional, overrides config/epicconfig.php)
RAZORPAY_KEY=rzp_test_YOUR_KEY
RAZORPAY_SECRET=your_secret_key

# Fallback: PayU SI (Subscription Integration)
PAYU_SI=TRUE
```

---

## API Contract Status

✅ **Fully Implemented**:
- Plan fetching
- Order creation

❌ **Needs Refactoring**:
- Mandate API (remove entirely)
- Razorpay order creation (remove, use backend response)
- Checkout parameters (fix names)

⚠️ **Not Yet Implemented**:
- Free-trial support
- Payment mode tracking
- Pending subscription status

See `RAZORPAY_BACKEND_CONTRACT_COMPLIANCE_REPORT.md` for details.
