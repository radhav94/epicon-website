# My Account Page - Data Flow

## 📍 Route
**File:** `/routes/web.php` (Line 274-276)
```php
Route::get('account-settings', function() {
    return view('pages.account-settings');
})->name('account-settings');
```

**Note:** No explicit controller - route directly renders view

---

## 🎯 View
**File:** `/resources/views/pages/account-settings.blade.php`

Uses helper functions to get data:
```php
@php
    $userData = userData();              // Gets user subscription + profile data
    $profiles = $userData['profiles'];   // List of profiles
    $subplan = checkSubscription();      // Current subscription status
    $isSubscribed = @$subplan['status'] == 'active';
    $activeTab = request()->get('tab') ?? 'manage-profile';
@endphp
```

---

## 🔌 Data Sources

### 1. **userData()** - Main User Data
**File:** `/app/Helpers/helpers.php` (Line 2254)
```php
function userData()
{
    global $user_data;
    return !empty($user_data) ? $user_data : [];
}
```

- Returns global `$user_data` variable
- Populated by `setUserData($user)` (Line 2246)
- Contains: profiles, subscriptions, user details

---

### 2. **checkSubscription()** - Subscription Status
**File:** `/app/Helpers/helpers.php` (Line 1195)
```php
function checkSubscription()
{
    $userDetail = userData();
    $sub_plan = $userDetail['subscriptions'] ?? [];
    $subscription_end_date = $sub_plan['subscription_end_date'] ?? '';
    $result['status'] = !empty($subscription_end_date) && 
                       $subscription_end_date > date("Y-m-d") ? 'active' : '';
    return $result;
}
```

- Checks if `subscription_end_date` is after today
- Returns `['status' => 'active']` or `['status' => '']`

---

## 🔄 How User Data Gets Loaded

### Step 1: Middleware - `CheckUserAuthToken`
**File:** `/app/Http/Middleware/CheckUserAuthToken.php` (Line 21)

```php
if (isUserLoggedIn()) {
    if ($segment != "assets" && !$request->ajax()) {
        $response = update_user_session();  // ← LOADS USER DATA HERE
        if (!$response) {
            clearCookie();
            return redirect(...);
        }
    }
}
```

---

### Step 2: `update_user_session()` - API Call
**File:** `/app/Helpers/helpers.php` (Line 1407)

```php
function update_user_session()
{
    global $user_data, $max_device_reached;
    
    // 1️⃣ FIRST TRY: Call API with current token
    $profile_detail = CurlAPI("users/viewProfile", "POST", [], 2, true, true);
    
    if (@$profile_detail['success'] == true) {
        $user_data = $profile_detail['user_data'] ?? [];  // ← SET GLOBAL
        $max_device_reached = $profile_detail['max_device_reached'] ?? false;
        return true;
    } 
    else {
        // 2️⃣ TOKEN EXPIRED: Try to refresh
        $refreshToken = CurlAPI("refreshToken", "POST", [], 2, true, true);
        
        if (@$refreshToken['success'] == true) {
            setToken($refreshToken['token']);  // Update token in cookie
            
            // 3️⃣ RETRY: Call API again with new token
            $profile_detail = CurlAPI(
                "users/viewProfile", 
                "POST", 
                ['token' => $token], 
                2, true, true
            );
            
            if (@$profile_detail['success'] == true) {
                $user_data = $profile_detail['user_data'] ?? [];  // ← SET GLOBAL
                return true;
            }
        }
    }
    return false;
}
```

---

## 📡 API Endpoints Called

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `users/viewProfile` | POST | Get current user's profile + subscription data |
| `refreshToken` | POST | Refresh expired auth token |

---

## 🗂️ Data Structure

### `$userData` contains:
```php
[
    'profiles' => [
        ['id' => 1, 'name' => 'Profile 1', ...],
        ['id' => 2, 'name' => 'Profile 2', ...],
    ],
    'subscriptions' => [
        'subscription_end_date' => '2026-09-11',
        'plan_name' => 'STARTER',
        'plan_amount' => '₹1',
        ...
    ],
    'user_id' => '123',
    'email' => 'user@example.com',
    ...
]
```

### `$subplan` (from checkSubscription):
```php
[
    'status' => 'active',  // or ''
    'subscription_end_date' => '2026-09-11',
    'plan_name' => 'STARTER',
    ...
]
```

---

## 🔐 Authentication

- Token stored in cookie: `StreamKey`
- Token expiration tracked in: `TokenExpiresAt` cookie
- Automatically refreshed by `update_user_session()`
- If refresh fails, user logged out

---

## 📊 Display in View

**File:** `/resources/views/pages/account-settings-partials/my-account.blade.php`

Displays subscription info:
```blade.php
<div class="subscription-card">
    <h2>{{ $subplan['plan_name'] ?? 'NO PLAN' }}</h2>
    <p>{{ $subplan['subscription_end_date'] ?? 'Inactive' }}</p>
    <span class="status {{ $isSubscribed ? 'active' : 'inactive' }}">
        {{ $isSubscribed ? 'ACTIVE' : 'INACTIVE' }}
    </span>
</div>
```

---

## 🎯 Summary

| Component | File | Purpose |
|-----------|------|---------|
| **Route** | `routes/web.php` | Maps `/account-settings` to view |
| **View** | `resources/views/pages/account-settings.blade.php` | Displays subscription + profile data |
| **Middleware** | `app/Http/Middleware/CheckUserAuthToken.php` | Loads user data via `update_user_session()` |
| **Helper** | `app/Helpers/helpers.php` | `userData()`, `checkSubscription()`, `update_user_session()` |
| **API** | External Backend | `users/viewProfile`, `refreshToken` |

---

## 🚀 To Modify Subscription Display

Edit: `/resources/views/pages/account-settings-partials/my-account.blade.php`

Example - to show subscription end date:
```blade.php
@if($isSubscribed)
    <p>Active until: {{ date('d M Y', strtotime($subplan['subscription_end_date'])) }}</p>
@else
    <p>No active subscription</p>
@endif
```

The data automatically updates from the API via `update_user_session()` on every page load!
