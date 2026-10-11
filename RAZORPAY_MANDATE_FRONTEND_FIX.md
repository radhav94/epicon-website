# Razorpay Mandate Issue - Frontend Fix Required

## Problem Summary

**Why mandates aren't being created:**

Razorpay payment shows:
- `recurring: null` ← NOT registered as a recurring payment
- `customer_id: null` ← No customer tied to token
- `token_id: "token_TWPWq1d3DLopWs"` ← Token exists but orphaned (no mandate)
- Payment created with **own order_id**, not using our backend order

**Root Cause:** Frontend is NOT passing the required three values to Razorpay Checkout:
1. ❌ `order_id` - NOT using backend order
2. ❌ `customer_id` - NOT included
3. ❌ `recurring: "1"` - NOT set

---

## Current Frontend (razorpay.blade.php) - What's Wrong

```javascript
var options = {
    "key": "{{ $parameters['razorpay_key'] }}",
    "amount": "{{ $parameters['amount'] }}",
    "currency": "{{ $parameters['currency'] }}",
    "name": "{{ $parameters['name'] }}",
    "description": "{{ $parameters['description'] }}",
    "order_id": "{{ $parameters['razorpay_order_id'] }}", // ← Uses backend order ✅
    "recurring": true,  // ❌ WRONG - should be string "1"
    // ❌ MISSING: customer_id
    // ❌ MISSING: token (if using saved card)
};
```

### Issues:

1. **`recurring: true` ❌**
   - Should be: `recurring: "1"` (string, not boolean)
   - Boolean true ≠ Razorpay's "1" string flag
   - Razorpay ignores boolean, treats as regular payment

2. **`customer_id` ❌ MISSING**
   - Must identify which customer owns the token
   - Without this, token is orphaned (no mandate)
   - Backend creates customer but frontend never passes it

3. **`token` ❌ NOT IMPLEMENTED**
   - For saved cards: use customer_id + token
   - For first payment: omit token (Razorpay creates it)
   - Currently neither is passed

4. **notes ❌ NOT PASSED**
   - Frontend should include order metadata
   - Currently backend copies from response (circular)
   - Should be passed from frontend → backend (in callback)

---

## Backend Response Structure (order_data.checkout)

When backend creates order, it returns:

```json
{
    "success": true,
    "order_data": {
        "order_id": "order_ABC123",           // ← OUR order ID
        "order_value": 299,
        "currency": "INR",
        "user_id": "user123",
        "customer_id": "cust_XYZ789",         // ← Customer for mandate
        "token": "token_ABC123",              // ← Saved token (if recurring)
        "checkout": {
            "razorpay_key_id": "rzp_live_...",
            "order_id": "order_ABC123",       // ← SAME as above
            "customer_id": "cust_XYZ789",     // ← For mandate
            "amount": 299,
            "currency": "INR",
            "recurring": "1",                 // ← This enables mandate!
            "prefill": {
                "name": "User Name",
                "email": "user@example.com",
                "contact": "9876543210"
            },
            "notes": {
                "order_id": "order_ABC123",
                "user_id": "user123"
            }
        }
    }
}
```

---

## Required Frontend Fix

### Current (razorpay.blade.php):
```blade.php
<script>
    var options = {
        "key": "{{ $parameters['razorpay_key'] }}",
        "amount": "{{ $parameters['amount'] }}",
        "currency": "{{ $parameters['currency'] }}",
        "order_id": "{{ $parameters['razorpay_order_id'] }}",
        "recurring": true,  // ❌ WRONG
        // ❌ MISSING: customer_id
        // ❌ MISSING: token
        // ❌ MISSING: notes
        "prefill": { ... }
    };
</script>
```

### Fixed (razorpay.blade.php):
```blade.php
<script>
    var options = {
        "key": "{{ $parameters['razorpay_key'] }}",
        "amount": "{{ $parameters['amount'] }}",
        "currency": "{{ $parameters['currency'] }}",
        "name": "{{ $parameters['name'] }}",
        "description": "{{ $parameters['description'] }}",
        "order_id": "{{ $parameters['razorpay_order_id'] }}",        // ✅ OUR order
        "customer_id": "{{ $parameters['customer_id'] }}",           // ✅ NEW - token owner
        "recurring": "1",                                             // ✅ FIXED - string not boolean
        @if($parameters['token'] ?? false)
        "token": "{{ $parameters['token'] }}",                       // ✅ NEW - for saved card
        @endif
        "prefill": {
            "name": "{{ $parameters['prefill_name'] }}",
            "email": "{{ $parameters['prefill_email'] }}",
            "contact": "{{ $parameters['prefill_contact'] }}"
        },
        "notes": {
            "order_id": "{{ $parameters['order_id'] }}",             // ✅ NEW - metadata
            "user_id": "{{ $parameters['user_id'] }}"                // ✅ NEW - metadata
        },
        "theme": {
            "color": "#1a1a2e"
        },
        "modal": {
            "ondismiss": function() {
                window.location.href = "{{ route('razorpay.failed') }}?error_description=Payment cancelled by user";
            }
        },
        "handler": function(response) {
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;
            document.razorpayform.submit();
        }
    };

    var rzp = new Razorpay(options);
    rzp.on('payment.failed', function(response) {
        window.location.href = "{{ route('razorpay.failed') }}?error_description=" +
            encodeURIComponent(response.error.description) +
            "&error_code=" + encodeURIComponent(response.error.code);
    });
    rzp.open();
</script>
```

---

## Backend Changes Required (Already Deployed or Ready)

### 1. RazorpayController.saveSubscriptionRazorpay()

**Pass additional parameters to view:**

```php
$parameters = [
    'razorpay_key' => config('epicconfig.RAZORPAY.RAZORPAY_KEY'),
    'razorpay_order_id' => $razorpayOrder['id'],
    'amount' => $totalAmount * 100,
    'currency' => strtoupper($currency),
    'name' => 'Epicon',
    'description' => 'Epicon Subscription - ' . @$result['name'],
    'order_id' => $txid,                           // ✅ NEW
    'user_id' => @$userData['user_id'] ?? '',     // ✅ NEW
    'customer_id' => @$resorder['customer_id'],   // ✅ NEW
    'token' => @$resorder['token'] ?? '',         // ✅ NEW
    'prefill_name' => @$userData['name'] ?? '',
    'prefill_email' => @$userData['email'] ?? '',
    'prefill_contact' => @$userData['mobile'] ?? '',
    'callback_url' => route('razorpay.callback'),
];
```

### 2. Backend Order Creation

Backend **MUST return** these in `order_data`:
- ✅ `order_id` - your internal order ID
- ✅ `customer_id` - Razorpay customer tied to mandate
- ✅ `token` - saved card token (for recurring use)
- ✅ `checkout` - fully prepared checkout config

---

## Why This Matters

### Without `customer_id`:
```
Token created but orphaned
  ↓
No customer ties token to mandate
  ↓
/payments/create/recurring can't find token
  ↓
Mandate never created
```

### Without `recurring: "1"`:
```
Razorpay receives boolean true
  ↓
Ignores it (expects string "1")
  ↓
Treats payment as one-time
  ↓
No mandate registered
```

### With All Three (Fixed):
```
recurring: "1" + customer_id + order_id
  ↓
Razorpay creates mandate
  ↓
Payment captured AND mandate activated
  ↓
next_charge_at set
  ↓
Webhook fires with success
  ↓
Subscription active ✅
```

---

## Testing the Fix

### Test 1: TV Token (Hosted Registration) ✅
- Uses Razorpay's hosted registration flow
- Mandate created by backend (no frontend involvement)
- Isolates web/PHP integration issues
- **Status:** Token `21FPJnnvuwqoJISSlLVMDSLX4Lnnlj70` works perfectly

### Test 2: Web Checkout (After Frontend Fix)
- Frontend passes all three values
- Razorpay creates mandate via checkout
- Should match TV token behavior
- **Status:** Currently broken, needs frontend fix

### Test 3: Saved Card Recurring
- User saves card on first payment
- Next payment uses token + customer_id
- Mandate auto-used
- **Status:** Depends on Test 2 passing

---

## Implementation Checklist

### Frontend (razorpay.blade.php):
- [ ] Change `"recurring": true` → `"recurring": "1"`
- [ ] Add `"customer_id": "{{ $parameters['customer_id'] }}"`
- [ ] Add conditional token: `"token": "{{ $parameters['token'] }}"`
- [ ] Add notes metadata
- [ ] Verify all values passed from backend

### Backend (RazorpayController.php):
- [ ] Pass `customer_id` to view
- [ ] Pass `token` to view
- [ ] Pass `user_id` to view
- [ ] Pass `order_id` to view
- [ ] Ensure order_data includes all fields

### Backend (Order Creation API):
- [ ] Return `customer_id` in order_data
- [ ] Return `token` in order_data (if recurring)
- [ ] Return `checkout` config ready for frontend
- [ ] Already deployed (commits b797cee, d2cdd2f)

---

## Why Backend Changes Are Not Enough

Even though backend:
- ✅ Creates customer correctly
- ✅ Creates order with customer_id
- ✅ Returns everything via API response

Frontend MUST:
- ✅ Extract these values from response
- ✅ Pass them to Razorpay Checkout (not create own order)
- ✅ Use exact string `"1"` for recurring

**If frontend doesn't pass these values:**
- Razorpay Checkout creates its own order (doesn't use backend order)
- No customer_id sent
- No mandate created
- Payment succeeds but subscription fails

---

## Evidence (Current Broken State)

**Razorpay API shows:**
```json
{
  "id": "pay_TWPWpUSTxzkDuS",
  "order_id": "order_TWPWZzxfp3dKtm",  // ← Not our order_ABC123
  "recurring": null,                     // ← Should be mandate
  "customer_id": null,                   // ← Should be cust_XYZ789
  "token_id": "token_TWPWq1d3DLopWs"   // ← Orphaned (no customer)
}
```

**After Frontend Fix, Should Show:**
```json
{
  "id": "pay_ABC123DEF456",
  "order_id": "order_ABC123",            // ← Our order used ✅
  "recurring": "1",                      // ← Mandate registered ✅
  "customer_id": "cust_XYZ789",          // ← Customer tied ✅
  "token_id": "token_ABC123",            // ← Token owned by customer ✅
  "status": "captured",
  "amount": 299
}
```

---

## Summary Table

| Component | Current | Required | Status |
|-----------|---------|----------|--------|
| `recurring` | `true` (boolean) | `"1"` (string) | ❌ WRONG |
| `customer_id` | ❌ Missing | `cust_XYZ789` | ❌ MISSING |
| `token` | ❌ Missing | `token_ABC123` | ❌ MISSING |
| `order_id` | ✅ Passed | ✅ Passed | ✅ OK |
| `notes` | ❌ Missing | ✅ Metadata | ❌ MISSING |
| Backend support | ⚠️ Partial | ✅ Ready | ⏳ Deploy |

---

## Implementation Steps

### Step 1: Backend (if not done)
```php
// In RazorpayController.saveSubscriptionRazorpay()
$parameters = [
    // ... existing ...
    'customer_id' => @$resorder['customer_id'],
    'token' => @$resorder['token'] ?? '',
    'user_id' => @$userData['user_id'] ?? '',
    // ... rest ...
];
```

### Step 2: Frontend (razorpay.blade.php)
```blade.php
var options = {
    // ... existing ...
    "order_id": "{{ $parameters['razorpay_order_id'] }}",
    "customer_id": "{{ $parameters['customer_id'] }}",  // ← ADD
    "recurring": "1",                                    // ← CHANGE from true
    @if($parameters['token'] ?? false)
    "token": "{{ $parameters['token'] }}",              // ← ADD
    @endif
    "notes": {                                           // ← ADD
        "order_id": "{{ $parameters['order_id'] }}",
        "user_id": "{{ $parameters['user_id'] }}"
    },
    // ... rest ...
};
```

### Step 3: Test
- [ ] Submit payment with fixed frontend
- [ ] Check Razorpay dashboard: `recurring`, `customer_id` should be set
- [ ] Verify mandate created
- [ ] Test auto-charge on next billing cycle

---

## Why This Was Missed

1. **No validation in frontend** - Razorpay accepts anything, doesn't error
2. **Notes are metadata** - copying them doesn't create mandate (they thought it would)
3. **Boolean true ≠ string "1"** - JavaScript doesn't error, Razorpay silently ignores
4. **customer_id invisible to notes** - they didn't know it was needed separately
5. **No webhook testing** - mandate webhook never fired (because never created)

---

## Next: After Frontend Fix

Once this is implemented:
- Payment will create mandate on first charge
- Webhook will activate subscription
- Subsequent charges will auto-deduct
- Token will be reusable for future payments
- Customer portal will show recurring status

All backend hooks are ready. Frontend is the blocker.

---

## Files to Modify

1. **`resources/views/subscription/razorpay.blade.php`**
   - Change `recurring: true` to `recurring: "1"`
   - Add `customer_id` parameter
   - Add `token` parameter (conditional)
   - Add `notes` object with metadata

2. **`app/Http/Controllers/RazorpayController.php`** (if not done)
   - Pass `customer_id` to view
   - Pass `token` to view
   - Pass `user_id` to view
   - Pass `order_id` to view

That's it. Everything else is ready.
